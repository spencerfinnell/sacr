<section class="further divider before">
	<div class="container">
		<div class="span-two-thirds alignleft">
			<h2 class="section-title">Further Research</h2>

			<div class="row clearfix">
				<div class="span-one-third alignleft">
					<h3 class="sub-section">People</h3>
					
					<?php
						wp_nav_menu( array(
							'location' => 'people',
							'menu_class' => 'research_list'
						) ); 
					?>
				</div>

				<div class="span-one-third alignleft">
					<h3 class="sub-section">Places</h3>
					<ul class="research-list">
						<?php
							$places = get_posts( array(
								'post_type'              => 'map_point',
								'orderby'                => 'rand',
								'posts_per_page'         => 10,
								'no_found_rows'          => true,
								'cache_results'          => false,
								'update_post_term_cache' => false
							) );

							foreach ( $places as $post ) : setup_postdata( $post );
						?>
						<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
						<?php endforeach; wp_reset_postdata(); ?>

						<li class="more"><a href="<?php echo get_post_type_archive_link( 'map_point' ); ?>"><?php _e( 'View More &rarr;', 'sacr' ); ?></a></li>
					</ul>
				</div>

				<div class="span-one-third alignleft">
					<h3 class="sub-section">Events</h3>
					<ul class="research-list">
						<?php
							$events = get_posts( array(
								'post_type'              => 'time_period',
								'orderby'                => 'rand',
								'posts_per_page'         => 10,
								'no_found_rows'          => true,
								'cache_results'          => false,
								'update_post_term_cache' => false
							) );

							foreach ( $events as $post ) : setup_postdata( $post );
						?>
						<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
						<?php endforeach; wp_reset_postdata(); ?>

						<li class="more"><a href="<?php echo get_post_type_archive_link( 'time_period' ); ?>"><?php _e( 'View More &rarr;', 'sacr' ); ?></a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="sponsors span-one-third alignright">
			<h2 class="section-title">Browse the Collections</h2>

			<p class="further-cta"><a href="<?php echo esc_url( sacr_get_theme_option( 'contentdm' ) ); ?>" class="button tertiary"><?php _e( 'Research Archives', 'sacr' ); ?></a></p>
		</div>
	</div>
</section><!-- .further -->