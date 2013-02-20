<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( is_page( sacr_get_theme_option( 'timeline' ) ) ? '' : 'container' ); ?>>
	<header class="entry-header container">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<?php if ( '' != $post->post_content ) : ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'sacr' ), 'after' => '</div>' ) ); ?>
		<?php comments_template( '', true ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
