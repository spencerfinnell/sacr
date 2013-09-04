<?php
/**
 *
 */

global $wp_locale;

$prev_post_date  = null;
$prev_post_date_ts = null;
$prev_post_month = null;
$i               = 0;
$query_year      = get_query_var( 'timeline_year' ) ? get_query_var( 'timeline_year' ) : 1963;

$dates           = new WP_Query( array(
	'post_type' => 'time_period',
	'orderby'   => 'meta_value',
	'nopaging'  => true,
	'order'     => 'ASC',
	'meta_key'  => '_date',
	'tax_query' => array(
		array(
			'taxonomy' => 'time_period-year',
			'field'    => 'slug',
			'terms'    => $query_year
		)
	)
) );

get_header(); ?>


	<div class="container">
		<h1 class="page-title"><?php _e( 'Timeline', 'sacr' ); ?></h1>
		
		<p class="timeline-filter">
		<?php 
			$years = get_terms( 'time_period-year', array( 'hide_empty' => 0, 'orderby' => 'id' ) );
			foreach ( $years as $year ) : 
		?>
		<a href="<?php echo get_term_link( $year ); ?>" class="button<?php echo $query_year == $year->slug ? ' active tertiary' : ''; ?>"><?php echo $year->name; ?></a>
		<?php endforeach; ?>
		</p>

		<p class="timeline-legend">
			<span class="local">Local</span>
			<span class="regional">Regional</span>
		</p>
	</div>

	<div class="timeline-wrap divider before">
		<div class="container">

			<div class="timeline">
				<?php 
					while ( $dates->have_posts() ) : $dates->the_post(); 
						$post_date    = sacr_item_meta( '_date' );
						$post_month   = mysql2date( 'n', $post_date, false );
						$post_date_ts = mysql2date( 'U', $post_date, false );
				?>
			
				<?php
				/**
				 * This looks janky, and it kind of is, but it isn't. 
				 * 
				 * Check if there is no current month set (the first timeline item), and get its date. 
				 * Create a title, and start a new sublist.
				 *
				 * If there is, create a title for each month until the month equals the month
				 * of the current timeline item. (so there are no gaps). Start a new sublist.
				 */
				?>

				<?php if ( is_null( $prev_post_month ) ) : /** no month yet, start everything */ ?>
					<h3 id="<?php echo strtolower( $wp_locale->get_month_abbrev( $wp_locale->get_month( $post_month ) ) ); ?>" class="timeline-month-title"><?php echo $wp_locale->get_month( $post_month ) ?></h3>
					
					<ul class="timeline-month-list">
				<?php elseif ( $prev_post_month != $post_month ) : /** we have a new month, end one, and start again */ ?>
					</ul>
					<?php
						$working_month = $prev_post_month;

						while ( $working_month < $post_month ) : $working_month++;
					?>
						<h3 id="<?php echo strtolower( $wp_locale->get_month_abbrev( $wp_locale->get_month( $working_month ) ) ); ?>" class="timeline-month-title"><?php echo $wp_locale->get_month( $working_month ); ?></h3>
					<?php endwhile; ?>

					<ul class="timeline-month-list">
				<?php endif; ?>
						<?php
							/* Compute difference in days */
							if ( ! is_null( $prev_post_date ) && $prev_post_month == $post_month ) {
								$dates_diff = ( date( 'z', $post_date_ts ) - date( 'z', $prev_post_date_ts ) ) * 9;
							}
							else {
								$dates_diff = 0;
							}
						?>
						<li id="<?php echo esc_attr( $post->post_name ); ?>" style="margin-top: <?php echo $dates_diff; ?>px" <?php post_class( array( 'timeline-item', sacr_item_single_term( 'time_period-location', $post->ID ) ) ); ?>>
							<div class="timeline-item-date">
								<?php echo mysql2date( 'F j, Y', $post_date, false ); ?>
								<small><?php echo mysql2date( 'l', $post_date, false ); ?></small>
							</div>
							
							<h3 class="timeline-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

							<div class="timeline-item-content <?php echo sacr_item_single_term( 'time_period-location', $post->ID ); ?>">
								<?php the_post_thumbnail( 'timeline' ); ?>

								<?php the_content(); ?>
							</div>
						</li>
				<?php 
							$prev_post_month   = $post_month;
							$prev_post_date    = $post_date;
							$prev_post_date_ts = $post_date_ts;
						endwhile; 
				?>

				<?php if ( ! is_null( $prev_post_date ) ) : ?>
					</ul>
				<?php endif; ?>

			</div><!-- .timeline -->
		</div><!-- .container -->
	</div><!-- .timeline-wrap -->

<?php get_footer(); ?>