<?php
/**
 *
 */

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function sacr_maps_add_meta_box() {
	add_meta_box( 'map-latlong', __( 'Location', 'sacr' ), '_sacr_maps_meta_box_longlat', 'map_point', 'normal', 'high' );
	add_meta_box( 'map-video', __( 'Video', 'sacr' ), '_sacr_maps_meta_box_video', 'map_point', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'sacr_maps_add_meta_box' );

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function _sacr_maps_meta_box_longlat() {
	global $post;

	$position = sacr_item_meta( 'latlong' );
?>
	<div>
		<input type="text" name="latlong" id="latlong" value="<?php echo $position; ?>" class="widefat" />
		<p class="description">Latitude and Longitude. Find this via Google Maps. <code>ex. 29.927465,-81.356967</code></p>
	</div>
<?php
}

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function _sacr_maps_meta_box_video() {
	global $post;

	$video = sacr_item_meta( 'video' );
?>
	<div>
		<textarea name="video" id="video" class="widefat" rows="2"><?php echo $video; ?></textarea>
		<p class="description">Vimeo video embed code. <code>ex. &lt;iframe&gt;...&lt;/iframe&gt;</code>. If there is no video, please <a href="#" class="insert-media add_media">upload an image</a>.</p>
	</div>
<?php
}