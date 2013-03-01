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

					<?php foreach ( $children as $post ) : setup_postdata(); $this_letter = strtoupper(substr($post->post_title,0,1)); ?>
					
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
				</div>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile; ?>

<?php get_footer(); ?>