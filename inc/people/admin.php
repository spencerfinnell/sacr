<?php

function sacr_people_columns( $columns ) {
	$columns = array(
		'cb'    => '<input type="checkbox" />',
		'title' => __( 'Person', 'sacr' )
	);

	return $columns;
}
//add_filter( 'manage_edit-person_columns', 'sacr_people_columns', 5 );