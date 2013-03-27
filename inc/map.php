<?php

function sacr_map_post_type_link( $link, $post = 0 ) {
	if ( $post->post_type != 'map_point' )
		return $link;

	return get_permalink( sacr_get_theme_option( 'map' ) ) . $post->post_name;
}
//add_filter( 'post_type_link', 'sacr_map_post_type_link', 1, 3 );

/**
 * Returns the <title> tag based on what is being viewed.
 *
 * @since 
 *
 * @param string $title The current page title
 * @param string $sep The separatating character
 * @return string $title The newly filtered title
 */
function noteboard_wp_title( $title, $sep ) {
	global $paged, $page, $wp_query, $post, $wpdb;

	$title .= get_bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	if ( get_query_var( 'point' ) ) {
		$point = get_query_var( 'point' );
		$point = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s", $point ) );
		$point = get_post( $point );

		$title = sprintf( '%1$s - %3$s %2$s %4$s', $point->post_title, $sep, $post->post_title, get_bloginfo( 'name' ) );
	}

	return $title;
}
add_filter( 'wp_title', 'noteboard_wp_title', 20, 2 );

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
	$vars[] = 'point';

	return $vars;
}
add_filter( 'query_vars', 'noteboard_add_query_vars' );

function sacr_map_rewrites_init() {
	$map = get_page( sacr_get_theme_option( 'map' ) );
	
	add_rewrite_rule( $map->post_name . '/([^/]+)/?$', 'index.php?point=$matches[1]&page_id=' . $map->ID, 'top' );
}
add_action( 'init', 'sacr_map_rewrites_init' );

function sacr_page_after_map() {
	global $post;

	if ( ! is_page( sacr_get_theme_option( 'map' ) ) )
		return;
?>
	<section class="historic-map">
		<div class="container">
			<div class="map-control">
				<h3 class="area-title">Filter by Time Period</h3>
				<?php $time_periods = get_terms( array( 'map_point-year' ), array( 'hide_empty' => 0, 'orderby' => 'id' ) ); ?>
				<ul>
					<?php foreach ( $time_periods as $term ) : ?>
					<li class="map-filter"><label><input class="filter-time-period" type="checkbox" checked="checked" value="<?php echo $term->slug; ?>" /> <?php echo $term->name; ?></label></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div id="map-canvas"></div>
	</section><!-- .feature-map -->
<?php
}
add_action( 'sacr_page_after', 'sacr_page_after_map', 10 );

function sacr_map_points() {
	if ( ! is_page( sacr_get_theme_option( 'map' ) ) )
		return false;

	$args = array();

	$point_args = array(
		'post_type'      => array( 'map_point' ),
		'posts_per_page' => -1,
		'nopaging'       => true
	);

	$points = get_posts( $point_args );
	
	foreach ( $points as $point ) {
		$position = sacr_item_meta( 'latlong', $point->ID );
		$position = explode( ',', $position );

		$category = wp_list_pluck( get_the_terms( $point->ID, 'map_point-year' ), 'slug' );

		foreach ( $category as $key => $cat ) {
			$_category = array( $cat );
		}

		$args[] = array(
			'id'       => $point->post_name,
			'position' => array( trim( $position[0] ), trim( $position[1] ) ),
			'category' => $_category
		);
	}

	wp_localize_script( 'sacr-script', 'points', $args );
}
add_action( 'wp_enqueue_scripts', 'sacr_map_points' );

function sacr_map_point_modals() {
	global $post;

	if ( ! is_page( sacr_get_theme_option( 'map' ) ) )
		return;

	$points = new WP_Query( array(
		'post_type'      => array( 'map_point' ),
		'posts_per_page' => -1,
	) );

	p2p_type( 'person_to_point' )->each_connected( $points, array(), 'people' );
	p2p_type( 'point_to_point' )->each_connected( $points, array(), 'places' );

	while ( $points->have_posts() ) {
		$points->the_post();
		get_template_part( 'content', 'map-point' );
	}

	wp_reset_postdata();
}
add_action( 'wp_footer', 'sacr_map_point_modals' );