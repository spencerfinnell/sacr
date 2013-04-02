<?php
/**
 *
 */

function sacr_admin_general() {
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_init', 'sacr_admin_general' );

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function sacr_admin_add_meta_box() {
	foreach ( array( 'map_point', 'person', 'time_period' ) as $cpt ) {
		add_meta_box( 'sacr-contentdm', __( 'ContentDM Links', 'sacr' ), '_sacr_maps_meta_box_contentdm', $cpt, 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'sacr_admin_add_meta_box' );

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function _sacr_maps_meta_box_contentdm() {
	global $post;

	$contentdm = sacr_item_meta( 'contentdm' );
?>
	<div>
		<textarea name="contentdm" id="contentdm" class="widefat" rows="4"><?php echo $contentdm; ?></textarea>
		<p class="description">A permanent link to any ContentDM articles, search results, etc. Separate multiple by new lines.</p>
	</div>
<?php
}