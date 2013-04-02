<?php
/**
 *
 */

function sacr_connection_types() {
	p2p_register_connection_type( array(
		'name'         => 'person_to_point',
		'from'         => 'person',
		'to'           => 'map_point',
		'admin_column' => 'any'
	) );

	p2p_register_connection_type( array( 
		'name'         => 'point_to_point',
		'from'         => 'map_point',
		'to'           => 'map_point',
		'reciprocal'   => true,
		'admin_column' => 'any'
	) );

	p2p_register_connection_type( array( 
		'name'         => 'person_to_person',
		'from'         => 'person',
		'to'           => 'person',
		'reciprocal'   => true,
		'admin_column' => 'any'
	) );
}
add_action( 'p2p_init', 'sacr_connection_types' );