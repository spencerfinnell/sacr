<?php


function sacr_post_type_person() {
	$person = new SACR_Post_Type( 'Person', array( 
		'plural'  => __( 'People', 'sacr' ),
		'rewrite' => array( 'slug' => 'people' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' )
	) );
	
	$person->post_type_meta = array( 'contentdm' );
}
add_action( 'init', 'sacr_post_type_person' );

function sacr_people_order( $query ) {
	if ( is_admin() || ! $query->is_main_query() )
		return;

	if ( is_post_type_archive( 'person' ) ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order',   'ASC'   );
		$query->set( 'posts_per_page', 1000 );
		return;
	}
}
add_action( 'pre_get_posts', 'sacr_people_order', 1 );