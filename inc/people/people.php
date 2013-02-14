<?php


function sacr_post_type_person() {
	$person = new SACR_Post_Type( 'Person', array( 
		'plural'  => __( 'People', 'sacr' ),
		'rewrite' => array( 'slug' => 'people' ) 
	) );
	
	$person->post_type_meta = array( 'contentdm' );
	$person->register_taxonomy( 'Tag' );
}
add_action( 'init', 'sacr_post_type_person' );