<?php
/**
 *
 */

function sacr_admin_general() {
}
add_action( 'admin_menu', 'sacr_admin_general' );

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
		<?php 
			wp_editor( $contentdm, 'contentdm', apply_filters( 'atcf_submit_field_description_editor_args', array(
				'media_buttons' => false,
				'quicktags'     => false,
				'textarea_rows' => 2,
				'editor_css'    => '<style>.wp_themeSkin iframe { background: white; } .wp_themeSkin .mceStatusbar { display: none; }</style>',
				'tinymce'       => array(
					'theme_advanced_path'     => false,
					'theme_advanced_statusbar_location' => false,
					'theme_advanced_buttons1' => 'bullist,link,unlink',
				),
			) ) ); 
		?>
		<p class="description">Add any relevant ContentDM links here. If multiple, create a bulleted list.</p>
	</div>
<?php
}

/**
 * Taxonomy Sorting
 *
 * A helper function for adding taxonomy select boxes to custom
 * post types filter options.
 *
 * @since BHX 1.0
 *
 * @return void;
 */
function sacr_post_type_taxonomy_sort( $taxonomies ) {
	foreach ( $taxonomies as $tax_slug ) {
		$tax_obj  = get_taxonomy( $tax_slug );
		$tax_name = $tax_obj->labels->name;
		$terms    = get_terms( $tax_slug );
		
		if ( count( $terms ) <= 0 )
			continue;

		echo '<select name="' . $tax_slug . '" id="' . $tax_slug. '" class="postform">';
		echo '<option value="">' . sprintf( __( 'Show All %s', 'bhx' ), $tax_name ) . '</option>';
		foreach ( $terms as $term ) {
			echo '<option value="' . $term->slug . '"' . selected( $_GET[$tax_slug], $term->slug, false ) . '">' . $term->name . ' (' . $term->count . ')</option>';
		}
		echo '</select>';
	}
}