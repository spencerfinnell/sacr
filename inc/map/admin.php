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
		<input type="text" name="video" id="video" class="widefat" value="<?php echo $video; ?>" />
		<p class="description">Vimeo video. Simply paste the URL to the video. If there is no video, please <a href="#" class="insert-media add_media">upload an image</a> (or more).</p>
	</div>
<?php
}

function sacr_map_point_columns( $columns ) {
	$columns = array(
		'cb'    => '<input type="checkbox" />',
		'title' => __( 'Point Name', 'sacr' ),
		'year'  => __( 'Year', 'sacr' ),
		'location' => __( 'Location', 'sacr' )
	);

	return $columns;
}
add_filter( 'manage_edit-map_point_columns', 'sacr_map_point_columns', 10 );

function sacr_map_point_manage_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'year' :
			$terms = get_the_terms( $post_id, 'map_point-year' );

			if ( ! empty( $terms ) ) {
				$out = array();

				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'map_point-year' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'map_point-year', 'display' ) )
					);
				}

				echo join( ', ', $out );
			} else {
				_e( 'No year selected', 'sacr' );
			}
			break;
		case 'location' :
			printf( '<a href="https://maps.google.com/maps?q=%1$s" target="_blank" title="%2$s">%1$s</a>', sacr_item_meta( 'latlong' ), __( 'Open in Google Maps', 'sacr' ) );
			break;
		default :
			break;
	}
}
add_action( 'manage_map_point_posts_custom_column', 'sacr_map_point_manage_columns', 10, 2 );

/**
 * Taxonomy Sorting
 *
 * @since BHX 1.0
 *
 * @return void
 */
function bhx_post_type_visit_sort() {
	global $typenow;
 
	if ( $typenow != 'map_point' )
		return;

	sacr_post_type_taxonomy_sort( array( 'map_point-year' ) );
}
add_action( 'restrict_manage_posts', 'bhx_post_type_visit_sort' );