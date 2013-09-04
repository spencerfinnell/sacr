<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function sacr_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'sacr_page_menu_args' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since St. Augustine Civil Rights Library 1.1
 */
function sacr_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'sacr' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'sacr_wp_title', 10, 2 );

function sacr_sponsors( $limit = null) {
	$sponsors = array(891, 890, 889, 888, 887, 886, 885, 884, 883, 882, 881, 880, 879, 878);

	shuffle( $sponsors );

	if ( $limit )
		return array_slice( $sponsors, 0, $limit );

	return $sponsors;
}