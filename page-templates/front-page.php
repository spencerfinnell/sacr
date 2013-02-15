<?php
/**
 * Template Name: Front Page
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */

global $sacr_options;

get_header(); ?>

	<section class="hero-slider">
		<div class="container">
			<div id="home-slider">
				<ul>
					<!--<?php
						$features = new WP_Query( array(
							'post_type'              => 'feature',
							'posts_per_page'         => 5,
							'no_found_rows'          => true,
							'cache_results'          => false,
							'update_post_meta_cache' => false,
							'update_post_term_cache' => false
						) );

						if ( $features->have_posts() ) : while ( $features->have_posts() ) : $features->the_post();
					?>
					<li <?php post_class(); ?>>
						<?php the_post_thumbnail( 'hero' ); ?>
					</li>
					<?php endwhile; endif; ?>-->

					<li>
						<div class="slider-title"><span>The <a href="#">Events</a>, <a href="#">People</a>, and <a href="#">Places</a> of the St. Augustine Civil Rights Movement</span></div>
					</li>
				</ul>
			</div>

			<!--<div class="slider-partners left">
				<h4 class="partner-title">Sponsored By:</h4>

				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/display/logos/wordpress.png" alt="" /></a>
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/display/logos/wordpress.png" alt="" /></a>
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/display/logos/wordpress.png" alt="" /></a>
			</div>-->
		</div>
	</section>

	<section class="feature feature-map">
		<div class="container">
			<div class="feature-graphic">
				<a href="<?php echo get_permalink( sacr_get_theme_option( 'map' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/display/map.png" alt="" /></a>
			</div>

			<div class="feature-description">
				<h2>Where the action really took place.</h2>
				<p class="feature-cta"><a href="<?php echo get_permalink( sacr_get_theme_option( 'map' ) ); ?>" class="button">View the Map</a></p>
			</div>
		</div>
	</section><!-- .feature-map -->

	<section class="feature left feature-timeline">
		<div class="container">
			<div class="feature-description">
				<h2>When equality truly became equal.</h2>
				<p class="feature-cta"><a href="#" class="button">View the Timeline</a></p>
			</div>

			<div class="feature-graphic">
				<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/display/timeline.png" alt="" /></a>
			</div>
		</div>
	</section><!-- .feature-timeline -->

	<section class="feature feature-people">
		<div class="container">
			<div class="feature-graphic">
				<img src="<?php echo get_template_directory_uri(); ?>/images/display/people.png" alt="" />
			</div>

			<div class="feature-description">
				<h2>The heros behind the movement.</h2>
				<p class="feature-cta"><a href="<?php echo get_post_type_archive_link( 'person' ); ?>" class="button">Meet the People</a></p>
			</div>
		</div>
	</section><!-- .feature-people -->

	<?php get_template_part( 'content-further-research', 'home' ); ?>

<?php get_footer(); ?>