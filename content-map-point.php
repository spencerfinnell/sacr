<?php
/**
 *
 */

global $post, $_post, $wp_embed;
$_post = $post; // Save ourselves
echo sacr_item_meta( 'video' );
?>

<div id="<?php echo $_post->post_name; ?>" class="point-modal">
	<?php if ( '' != sacr_item_meta( 'video' ) ) : ?>
	<div class="video-container">
		<?php echo $wp_embed->run_shortcode( '[embed]' . sacr_item_meta( 'video' ) . '[/embed]' ); ?>
	</div>
	<?php endif; ?>

	<div class="point-modal-content clearfix">
		<?php get_template_part( 'content', 'item' ); ?>
	</div>
</div>