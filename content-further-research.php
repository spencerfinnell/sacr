<section class="further divider before">
	<div class="container">
		<div class="span-half alignleft">
			<h2 class="section-title">Further Research</h2>

			<div class="clearfix">
				<div class="span-one-third alignleft">
					<h3 class="sub-section">People</h3>
					<ul class="research-list">
						<?php
							$people = get_posts( array(
								'post_type'              => 'person',
								'posts_per_page'         => 10,
								'nopaging'               => true,
								'no_found_rows'          => true,
								'cache_results'          => false,
								'update_post_meta_cache' => false,
								'update_post_term_cache' => false
							) );

							foreach ( $people as $person ) :
						?>
						<li><a href="<?php echo get_permalink( $person->ID ); ?>"><?php echo get_the_title( $person->ID ); ?></a></li>
						<?php endforeach; ?>

						<li class="more"><a href="<?php echo get_post_type_archive_link( 'person' ); ?>"><?php _e( 'View More &rarr;', 'sacr' ); ?></a></li>
					</ul>
				</div>

				<div class="span-one-third alignleft">
					<h3 class="sub-section">Places</h3>
					<ul class="research-list">
						<?php
							$places = get_posts( array(
								'post_type'              => 'map_point',
								'posts_per_page'         => 10,
								'nopaging'               => true,
								'no_found_rows'          => true,
								'cache_results'          => false,
								'update_post_meta_cache' => false,
								'update_post_term_cache' => false
							) );

							foreach ( $places as $place ) :
						?>
						<li><a href="<?php echo get_permalink( $place->ID ); ?>"><?php echo get_the_title( $place->ID ); ?></a></li>
						<?php endforeach; ?>

						<li class="more"><a href="<?php echo get_permalink( sacr_get_theme_option( 'map' ) ); ?>"><?php _e( 'View More &rarr;', 'sacr' ); ?></a></li>
					</ul>
				</div>

				<div class="span-one-third alignleft">
					<h3 class="sub-section">Events</h3>
					<ul class="research-list">
						<?php
							$events = get_posts( array(
								'post_type'              => 'time_period',
								'posts_per_page'         => 10,
								'nopaging'               => true,
								'no_found_rows'          => true,
								'cache_results'          => false,
								'update_post_meta_cache' => false,
								'update_post_term_cache' => false
							) );

							foreach ( $events as $event ) :
						?>
						<li><a href="<?php echo get_permalink( $event->ID ); ?>"><?php echo get_the_title( $event->ID ); ?></a></li>
						<?php endforeach; ?>

						<li class="more"><a href="<?php echo get_permalink( sacr_get_theme_option( 'timeline' ) ); ?>"><?php _e( 'View More &rarr;', 'sacr' ); ?></a></li>
					</ul>
				</div>
			</div>

			<p class="further-cta"><a href="<?php echo esc_url( sacr_get_theme_option( 'contentdm' ) ); ?>" class="button tertiary"><?php _e( 'Research Database', 'sacr' ); ?></a></p>
		</div>

		<div class="span-half alignright">
			<?php if ( is_front_page() ) : ?>

			<?php else : ?>
			<a href="#" class="further-graphic"><img src="<?php echo get_template_directory_uri(); ?>/images/display/timeline.png" alt="" /></a>

			<p class="further-cta"><a href="#" class="button alignright">See the Timeline</a></p>
			<?php endif; ?>
		</div>
	</div>
</section><!-- .further -->