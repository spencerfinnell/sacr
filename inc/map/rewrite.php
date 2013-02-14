<?php

/**
 * Query Vars
 *
 * Properly register query var so they can be called via the
 * WP_Query class, and used correctly and safely.
 *
 * @since Noteboard 1.0
 *
 * @param array $vars Existing query variables
 * @return arrat $vars Updated list of query variables
 */  
function noteboard_add_query_vars( $vars ) {
	$vars[] = 'map_year';
	$vars[] = 'point';

	return $vars;
}
add_filter( 'query_vars', 'noteboard_add_query_vars' );

function sacr_map_rewrites_init() {
	$map = get_page( sacr_get_theme_option( 'map' ) );
	
	add_rewrite_rule( $map->post_name . '/([^/]+)/?$', 'index.php?point=$matches[1]&page_id=' . $map->ID, 'top' );
	add_rewrite_rule( $map->post_name . '/year/([^/]+)/?$', 'index.php?map_year=$matches[1]&page_id=' . $map->ID, 'top' );
}
add_action( 'init', 'sacr_map_rewrites_init' );

function sacr_map_year_term_link( $link, $term, $taxonomy ) {
	if ( 'map_point-year' != $taxonomy )
		return $link;

	return esc_url( get_permalink( sacr_get_theme_option( 'map' ) ) . 'year/' . $term->slug );
}
add_filter( 'term_link', 'sacr_map_year_term_link', 1, 3 );