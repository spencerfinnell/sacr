<?php

function sacr_post_type_feature() {
	$features = new SACR_Post_Type( 'Feature', array( 
		'has_archive' => false
	) );
}
add_action( 'init', 'sacr_post_type_feature' );