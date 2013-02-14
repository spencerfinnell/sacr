<?php

function sacr_post_type_time_period() {
	$time_period = new SACR_Post_Type( 'Time Period', array( 'rewrite' => array( 'slug' => 'timeline' ) ) );
	$time_period->post_type_meta = array( 'contentdm' );
}
add_action( 'init', 'sacr_post_type_time_period' );

