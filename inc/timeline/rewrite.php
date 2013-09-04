<?php

function sacr_timeline_query_vars( $vars ) {
	$vars[] = 'timeline_year';

	return $vars;
}
add_filter( 'query_vars', 'sacr_timeline_query_vars' );

function sacr_timeline_rewrites_init() {
	add_rewrite_rule( 'timeline/year/([^/]+)/?$', 'index.php?timeline_year=$matches[1]&post_type=time_period', 'top' );
}
add_action( 'init', 'sacr_timeline_rewrites_init' );

function sacr_timline_year_term_link( $link, $term, $taxonomy ) {
	if ( 'time_period-year' != $taxonomy )
		return $link;

	return esc_url( get_post_type_archive_link( 'time_period' ) . 'year/' . $term->slug );
}
add_filter( 'term_link', 'sacr_timline_year_term_link', 1, 3 );

function sacr_timeline_post_link( $link, $post, $leavename ) {
	if ( 'time_period' != $post->post_type )
		return $link;
	
	$base = get_post_type_archive_link( 'time_period' );
	$year = sacr_item_year( 'time_period-year' );

	$link = trailingslashit( $base . 'year' ) . trailingslashit( $year ) . '#' . $post->post_name;

	return esc_url( $link );
}
add_filter( 'post_type_link', 'sacr_timeline_post_link', 1, 3 );