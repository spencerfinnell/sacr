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
				<h1>The <a href="<?php echo get_post_type_archive_link( 'time_period' ); ?>">Events</a>, <a href="<?php echo get_post_type_archive_link( 'person' ); ?>">People</a>, and <a href="<?php echo get_post_type_archive_link( 'map_point' ); ?>">Places</a> of the <br />St. Augustine Civil Rights Movement</h1>
			</div>
		</div>
	</section>

	<section class="hero-slider">
		<div class="home-slider">
			<ul class="rslides">
				<?php
					$features = new WP_Query( array(
						'post_type'              => 'feature',
						'orderby'                => 'menu_order',
						'order'                  => 'ASC',
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

	<section class="feature clearfix divider before">
		<div class="container clearfix">
			<div class="feature-left">
				<div class="feature-description">
					<h2>Explore the Civil Rights Library</h2>

					<p><a href="<?php echo get_post_type_archive_link( 'time_period' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/display/collections@2x.png" alt="" width="450" height="240" /></a></p>

					<p class="lead">Over a dozen separate collections documenting what Martin Luther King, Jr., described as "a magnificent drama taking place on the stage of American history."</p>

					<p class="feature-cta"><a href="http://civilrightslibrary.com/collections/" class="button"><?php _e( 'View the Collections', 'sacr' ); ?></a></p>
				</div>
			</div>

			<div class="feature-right">
				<div class="feature-description">
					<h2>Travel Through Time</h2>

					<p><a href="<?php echo get_post_type_archive_link( 'time_period' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/display/timeline@2x.png" alt="" width="450" height="240" /></a></p>

					<p class="lead">What happened... when... and why? See just how the Civil Rights movement unfolded, month after month, event after event, on both the local and national stages.</p>

					<p class="feature-cta"><a href="<?php echo get_post_type_archive_link( 'time_period' ); ?>" class="button"><?php _e( 'View the Timeline', 'sacr' ); ?></a></p>
				</div>
			</div>
		</div>
	</section><!-- .feature-people -->

	<section class="feature clearfix divider before">
		<div class="container clearfix">
			<div class="feature-left">
				<div class="feature-description">
					<h2>Follow Their Footsteps</h2>

					<p><a href="<?php echo get_post_type_archive_link( 'map_point' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/display/map@2x.png" alt="" width="450" height="240" /></a></p>

					<p class="lead">In the nation's oldest city, history is everywhere -- but not all landmarks of the Civil Rights are marked.  Here's your guide to hotspots of the St. Augustine movement.</p>

					<p class="feature-cta"><a href="<?php echo get_post_type_archive_link( 'map_point' ); ?>" class="button"><?php _e( 'Interactive Map', 'sacr' ); ?></a></p>
				</div>
			</div>

			<div class="feature-right">
				<div class="feature-description">
					<h2>The "<span class="yellow">Magnificent</span> Drama"</h2>

					<p><a href="<?php echo get_post_type_archive_link( 'person' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/display/people.png" alt="" width="450" height="240" /></a></p>

					<p class="lead">The "cast of characters" in St. Augustine's "magnificent drama" is large, and the Civil Rights Library of St. Augustine contains biographies of many of the players.</p>

					<!--<blockquote>Dr. Martin Luther King, Jr., speaking in St. Augustine, referred to the movement as a "magnificent drama taking place on the stage of American history".</blockquote>-->

					<p class="feature-cta"><a href="<?php echo get_post_type_archive_link( 'person' ); ?>" class="button"><?php _e( 'The Cast', 'sacr' ); ?></a></p>
				</div>
			</div>
		</div>
	</section><!-- .feature-people -->

	<?php // get_template_part( 'content-further-research', 'home' ); ?>

<?php get_footer(); ?>