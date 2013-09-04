<?php

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function sacr_features_add_meta_box() {
	add_meta_box( 'feature-link', __( 'Link', 'sacr' ), '_sacr_maps_meta_box_link', 'feature', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'sacr_features_add_meta_box' );

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function _sacr_maps_meta_box_link() {
	global $post;

	$link = sacr_item_meta( 'link' );
?>
	<div>
		<input type="text" name="link" id="link" class="widefat" value="<?php echo $link; ?>" />
		<p class="description">The URL this slide should point to.</p>
	</div>
<?php
}