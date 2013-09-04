<?php

/**
 * 
 */  
function sacr_map_query_vars( $vars ) {
	$vars[] = 'map_year';
	$vars[] = 'point';

	return $vars;
}
add_filter( 'query_vars', 'sacr_map_query_vars' );

function sacr_map_rewrites_init() {
	add_rewrite_rule( 'map/([^/]+)/?$', 'index.php?point=$matches[1]&post_type=map_point', 'top' );
	add_rewrite_rule( 'map/year/([^/]+)/?$', 'index.php?map_year=$matches[1]&post_type=map_point', 'top' );
}
add_action( 'init', 'sacr_map_rewrites_init' );

function sacr_map_year_term_link( $link, $term, $taxonomy ) {
	if ( 'map_point-year' != $taxonomy )
		return $link;

	return esc_url( get_permalink( sacr_get_theme_option( 'map' ) ) . 'year/' . $term->slug );
}
add_filter( 'term_link', 'sacr_map_year_term_link', 1, 3 );