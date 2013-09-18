<?php

function sacr_post_type_feature() {
	$features = new SACR_Post_Type( 'Feature', array( 
		'has_archive' => false,
		'hierarchical' => true,
		'supports'    => array( 'title', 'thumbnail', 'page-attributes' )
	) );

	$features->post_type_meta = array( 'link' );
}
add_action( 'init', 'sacr_post_type_feature' );