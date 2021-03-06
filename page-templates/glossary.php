<?php
/**
 * Template Name: Glossary
 */

get_header(); ?>


	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'container' ); ?>>
			<header class="entry-header container">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_content(); ?>
				
				<div class="clearfix">
				<?php
					global $sacr_options;

					$children = array(
						'post_parent'    => $post->ID,
						'posts_per_page' => 1000,
						'post_type'      => 'page',
						'orderby'        => 'menu_order',
						'order'          => 'ASC'
					);

					$children = get_posts( $children );

					foreach ( $children as $collection ) : ?>
					<a href="<?php echo esc_url( get_permalink( $collection->ID ) ); ?>" class="contentdm-collection button tertiary on-light"><?php echo get_the_title( $collection->ID ); ?></a>
				<?php endforeach; ?>
				</div>

				<!---<h1>Glossary</h1>
				<div class="glossary">
					<?php
						$prev_letter = null;

						$children = array(
							'post_parent'    => $post->ID,
							'posts_per_page' => 1000,
							'post_type'      => 'page',
							'orderby'        => 'title',
							'order'          => 'ASC'
						);

						$children = get_posts( $children );
					?>

					<?php foreach ( $children as $post ) : setup_postdata( $post ); $this_letter = strtoupper(substr($post->post_title,0,1)); ?>
					
						<?php if ( ! $prev_letter ) : $prev_letter = $this_letter; ?>
						<div class="glossary-archive">
							<h3 id="<?php echo $this_letter; ?>" class="glossary-archive-title"><?php echo $this_letter; ?></h3>
						
							<ul>
						<?php elseif ( $this_letter != $prev_letter ) : $prev_letter = $this_letter;  ?>
							</ul>
						</div>

						<div class="glossary-archive">
							<h3 id="<?php echo $this_letter; ?>" class="glossary-archive-title"><?php echo $this_letter; ?></h3>
							<ul>
						<?php endif; ?>

						<li class="glossary-item">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endforeach; ?>
					</div>
				</div>-->

				<div class="all-content clearfix row">

					<div class="span-one-third alignleft">
						<h1 class="sub-section">People</h1>
						<ul class="research-list-inner">
							<?php
								$people = get_posts( array(
									'post_type'              => 'person',
									'orderby'                => 'title',
									'order'                  => 'ASC',
									'nopaging'               => true,
									'no_found_rows'          => true,
									'cache_results'          => false,
									'update_post_term_cache' => false
								) );

								foreach ( $people as $post ) : setup_postdata( $post );
							?>
							<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
							<?php endforeach; wp_reset_postdata(); ?>
						</ul>
					</div>

					<div class="span-one-third alignleft">
						<h1 class="sub-section">Places</h1>
						<ul class="research-list-inner">
							<?php
								$people = get_posts( array(
									'post_type'              => 'map_point',
									'orderby'                => 'title',
									'order'                  => 'ASC',
									'nopaging'               => true,
									'no_found_rows'          => true,
									'cache_results'          => false,
									'update_post_term_cache' => false
								) );

								foreach ( $people as $post ) : setup_postdata( $post );
									$year = get_term_by( 'slug', sacr_item_single_term( 'map_point-year', get_the_ID() ), 'map_point-year' );
							?>
							<li><a href="<?php the_permalink() ?>"><?php the_title(); ?> (<?php echo $year->name; ?>)</a></li>
							<?php endforeach; wp_reset_postdata(); ?>
						</ul>
					</div>

					<div class="span-one-third alignleft">
						<h1 class="sub-section">Events</h1>
						<ul class="research-list-inner">
							<?php
								$people = get_posts( array(
									'post_type'              => 'time_period',
									'orderby'                => 'title',
									'order'                  => 'ASC',
									'nopaging'               => true,
									'no_found_rows'          => true,
									'cache_results'          => false,
									'update_post_term_cache' => false
								) );

								foreach ( $people as $post ) : setup_postdata( $post );

								if ( '' == $post->post_title )
									continue;
							?>
							<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
							<?php endforeach; wp_reset_postdata(); ?>
						</ul>
					</div>

				</div>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile; ?>

<?php get_footer(); ?>