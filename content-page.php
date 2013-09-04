<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'container' ); ?>>
	<header class="entry-header container">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="person-bio">
		<div class="person-description clearfix">

		<?php if ( '' != $post->post_excerpt ) : ?>
			<div class="clearfix">
				<div class="span-two-thirds alignleft">
		<?php endif; ?>

		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'sacr' ), 'after' => '</div>' ) ); ?>
		<?php comments_template( '', true ); ?>

		<?php if ( '' != $post->post_excerpt ) : ?>
				</div>

				<div class="page-excerpt span-one-third alignright">
					<?php the_excerpt(); ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
