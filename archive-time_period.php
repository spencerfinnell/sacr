<?php
/**
 *
 */

global $wp_locale;

$prev_post_date    		= null;
$prev_post_month  		= null;
$distance_multiplier	= 20;
$i                      = 0;

get_header(); ?>

	<div class="container">
		<h1 class="page-title"><?php _e( 'Timeline', 'sacr' ); ?></h1>

		<div class="timeline">
		<?php
			$dates = new WP_Query( array(
				'post_type' => 'time_period',
				'orderby'   => 'meta_value',
				'meta_key'  => '_date'
			) );
		?>

		<?php while ( $dates->have_posts() ) : $dates->the_post(); ?>
			
			<?php
				$post_date  = sacr_item_meta( '_date' );
				$post_month = mysql2date( 'n', $post_date, false );

				if ( ! is_null( $prev_post_date ) && $prev_post_month == $post_month ) {
					$dates_diff  =  ( mysql2date( 'z', $prev_post_date, false ) - mysql2date( 'z', $post_date, false ) ) * $distance_multiplier;
				}
				else {
					$dates_diff  =  0;
				}
			?>

			<?php if ( is_null( $prev_post_month ) ) : ?>
			<h3 id="<?php echo strtolower( $wp_locale->get_month_abbrev( $wp_locale->get_month( $post_month ) ) ); ?>" class="timeline-month-title"><?php echo $wp_locale->get_month( $post_month ) ?></h3>
			<ul class="timeline-month-list">
			<?php elseif ( $prev_post_month != $post_month ) : ?>
			</ul>
				<?php
					$working_month  =  $prev_post_month;
		
					while ( $working_month > $post_month ) :
						$working_month--;
				?>
					<h3 id="<?php echo strtolower( $wp_locale->get_month_abbrev( $wp_locale->get_month( $working_month ) ) ); ?>" class="timeline-month-title"><?php echo $wp_locale->get_month( $working_month ); ?></h3>
				<?php $i = 0; endwhile; ?>

				<ul class="timeline-month-list">
			<?php endif; ?>
				<li data-day="<?php echo mysql2date( 'd', $post_date, false ); ?>" style="margin-top: <?php echo $dates_diff; ?>px" <?php post_class( array( 'timeline-item' ) ); ?>>
					<div class="timeline-item-date">
						<span class="day"><?php printf( __( '%s the %s<sup>%s</sup>', 'sacr' ), mysql2date( 'l', $post_date, false ), mysql2date( 'd', $post_date, false ), mysql2date( 'S', $post_date, false ) ); ?></span>
						<!--<span class="month-year">
							<?php echo mysql2date( 'F', $post_date, false ); ?> <br />
							<?php echo mysql2date( 'Y', $post_date, false ); ?>
						</span>-->
					</div>
					
					<h3 class="timeline-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

					<div class="timeline-item-content">
						<?php the_post_thumbnail( 'timeline' ); ?>

						<?php the_content(); ?>
					</div>
				</li>
			<?php
				$prev_post_date  =  $post_date;
				$prev_post_month =  $post_month;
				$i++;
		endwhile;
		?>
	
		<?php if ( ! is_null( $prev_post_date ) ) : ?>
		</ul>
		<?php endif; ?>
		</div>

	</div>

<?php get_footer(); ?>