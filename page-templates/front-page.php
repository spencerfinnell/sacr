<?php
/**
 * Template Name: Front Page
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */

global $sacr_options;

get_header(); ?>

	<section class="feature feature-intro">
		<div class="container">
			<div class="feature-description">
				<h1>The <a href="<?php echo get_post_type_archive_link( 'person' ); ?>">People</a>, <a href="<?php echo get_post_type_archive_link( 'map_point' ); ?>">Places</a>, and <a href="<?php echo get_post_type_archive_link( 'time_period' ); ?>">Events</a> of the St. Augustine Civil Rights Movement</h1>
			</div>
		</div>
	</section>

	<section class="hero-slider">
		<div class="home-slider">
			<ul class="rslides">
				<?php
					$features = new WP_Query( array(
						'post_type'              => 'feature',
						'post_status'            => 'any',
						'posts_per_page'         => 10,
						'no_found_rows'          => true,
						'cache_results'          => false,
						'update_post_meta_cache' => false,
						'update_post_term_cache' => false
					) );

					if ( $features->have_posts() ) : while ( $features->have_posts() ) : $features->the_post();
				?>
				<li <?php post_class(); ?>>
					<a href="<?php echo sacr_item_meta( 'link' ); ?>" class="read-more button secondary">Learn More</a>
					<a href="<?php echo sacr_item_meta( 'link' ); ?>"><?php the_post_thumbnail( 'fullsize' ); ?></a>
				</li>
				<?php endwhile; endif; ?>
			</ul>
		</div>
	</section>

	<section class="feature feature-map">
		<div class="container">
			<div class="feature-graphic">
				<a href="<?php echo get_post_type_archive_link( 'map_point' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/display/map@2x.png" alt="" width="450" height="240" /></a>
			</div>

			<div class="feature-description">
				<h2><?php _e( 'Hotspots in the<br />local movement.', 'sacr' ); ?></h2>
				<p class="feature-cta"><a href="<?php echo get_post_type_archive_link( 'map_point' ); ?>" class="button tertiary"><?php _e( 'Interactive Map', 'sacr' ); ?></a></p>
			</div>
		</div>
	</section><!-- .feature-map -->

	<section class="feature feature-timeline left divider before">
		<div class="container">
			<div class="feature-description">
				<h2><?php _e( 'When equality truly became equal.', 'sacr' ); ?></h2>
				<p class="feature-cta"><a href="<?php echo get_post_type_archive_link( 'time_period' ); ?>" class="button secondary"><?php _e( 'View the Timeline', 'sacr' ); ?></a></p>
			</div>

			<div class="feature-graphic">
				<a href="<?php echo get_post_type_archive_link( 'time_period' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/display/timeline@2x.png" alt="" width="450" height="240" /></a>
			</div>
		</div>
	</section><!-- .feature-timeline -->

	<section class="feature feature-people divider before">
		<div class="container">
			<div class="clearfix">
				<div class="feature-graphic">
					<a href="<?php echo get_post_type_archive_link( 'person' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/display/people.png" alt="" width="450" height="240" /></a>
				</div>

				<div class="feature-description">
					<h2><?php _e( 'The<br />"Magnificent Drama"', 'sacr' ); ?></h2>
					<p class="feature-cta"><a href="<?php echo get_post_type_archive_link( 'person' ); ?>" class="button"><?php _e( 'The Cast', 'sacr' ); ?></a></p>
				</div>
			</div>

			<blockquote>Dr. Martin Luther King, Jr., speaking in St. Augustine, referred to the movement as a "magnificent drama taking place on the stage of American history".</blockquote>
		</div>
	</section><!-- .feature-people -->

	<?php get_template_part( 'content-further-research', 'home' ); ?>

<?php get_footer(); ?>