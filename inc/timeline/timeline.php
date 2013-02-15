<?php

function sacr_post_type_time_period() {
	$time_period = new SACR_Post_Type( 'Time Period' );
	$time_period->post_type_meta = array( 'contentdm' );
}
add_action( 'init', 'sacr_post_type_time_period' );

function sacr_timeline() {
	if ( ! is_page( sacr_get_theme_option( 'timeline' ) ) )
		return;
?>
	<div id="timeline">
		<!-- Timeline.js will genereate the markup here -->
	</div>
<?php
}
add_action( 'sacr_page_after', 'sacr_timeline' );