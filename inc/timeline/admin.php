<?php
/**
 *
 */

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function sacr_timeline_add_meta_box() {
	add_meta_box( 'timeline-date', __( 'Date', 'sacr' ), '_sacr_timeline_meta_box_date', 'time_period', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'sacr_timeline_add_meta_box' );

/**
 * 
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function _sacr_timeline_meta_box_date() {
	global $post;
?>
	<div>
		<input type="text" name="longlat" id="longlat" value="" class="widefat" />
		<p class="description">Date. Format: <?php echo get_option( 'date_format' ); ?></p>
	</div>
<?php
}