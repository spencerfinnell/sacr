<?php
/**
 *
 */

global $post, $_post, $wp_embed;
$_post = $post; // Save ourselves
?>

<div id="<?php echo $_post->post_name; ?>" class="point-modal">
	<div class="video-container">
		<?php echo $wp_embed->run_shortcode( '[embed]' . sacr_item_meta( 'video' ) . '[/embed]' ); ?>
	</div>

	<div class="point-modal-content clearfix">
		<?php get_template_part( 'content', 'item' ); ?>
	</div>
</div>