<?php

function sacr_post_type_time_period() {
	$time_period = new SACR_Post_Type( 'Time Period' );
	$time_period->post_type_meta = array( 'contentdm' );
}
add_action( 'init', 'sacr_post_type_time_period' );

/**
 * Timeline Permalink
 *
 * Create a permalink for querying the timeline JSON
 * data. This is so we can set a JSON source in the TimelineJS
 * plugin. 
 *
 * @since BHX 1.0
 *
 * @return void
 */
function bhx_timeline_rewrite() {
	add_rewrite_rule( 'timeline.json', 'index.php?timeline-json=true', 'top' );
}
add_action( 'init', 'bhx_timeline_rewrite' );

/**
 * Timeline query variable
 *
 * Register a query variable so we can use the appropriate
 * functions later when checking if we are on the corretct page.
 *
 * @since BHX 1.0
 *
 * @param array $query_vars The array of reigstered query variables
 * @return array $query_vars The updated query variables
 */
function bhx_timeline_query_vars( $query_vars ) {
    $query_vars[] = 'timeline-json';

    return $query_vars;
}
add_filter( 'query_vars', 'bhx_timeline_query_vars' );

/**
 * Timeline JSON
 *
 * If we are on the correct page, query all timeline posts
 * and output just the data we need in JSON format. This
 * is fed to the TmielineJS plugin.
 *
 * @since BHX 1.0
 *
 * @return void
 */
function bhx_timeline_json() {
	if ( ! get_query_var( 'timeline-json' ) )
		return;

	$timeline_args = array(
		'post_type'      => array( 'time_period' ),
		'posts_per_page' => -1
	);

	$count = 0;
	$dates = $output = array();
	$times = new WP_Query( $timeline_args );
	
	while ( $times->have_posts() ) : $times->the_post();
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		//$date  = get_post_meta( get_the_ID(), 'bhx-time-period', true );

		//if ( ! $date )
		//	continue;

		$content = get_the_excerpt();
		$content .= '<p><a href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read More &rarr;', 'bhx' ) . '</a></p>';
		
		$dates[$count][ 'startDate' ] = get_the_date();
		$dates[$count][ 'endDate' ]   = get_the_date();
		$dates[$count][ 'headline' ]  = get_the_title();
		$dates[$count][ 'text' ]      = $content;
		$dates[$count][ 'asset' ]     = array(
			'media' => $image[0]
		);

		$count++;
	endwhile;

	$output = array(
		'timeline' => array(
			'type'           => 'default',
			'startDate'      => $times->posts[0]->post_date,
			'start_at_slide' => 0,
			'date'           => $dates
		)
	);

	if ( isset ( $_GET[ 'array' ] ) )
		print_r( $output );
	else
		echo json_encode( $output );

	die();
}
add_action( 'template_redirect', 'bhx_timeline_json' );

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