<?php
/**
 *
 */

global $post, $_post, $wp_embed;
$_post = $post; // Save ourselves
echo sacr_item_meta( 'video' );
?>

<div id="<?php echo $_post->post_name; ?>" class="point-modal">
	<?php the_post_thumbnail( array( 665, 300 ) ); ?>
	
	<div class="point-modal-content clearfix">
		<?php get_template_part( 'content', 'item' ); ?>
	</div>
</div>