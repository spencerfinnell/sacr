<?php


function sacr_post_type_map_point() {
	$map = get_page( sacr_get_theme_option( 'map' ) );

	$maps = new SACR_Post_Type( 'Map Point', array( 
		'rewrite'  => array( 'slug' => $map->post_name ),
		'supports' => array( 'title', 'editor' ),
		'has_archive' => false
	) );

	$maps->register_taxonomy( 'Year', array( 'hierarchical' => true ) );
	$maps->post_type_meta = array( 'latlong', 'video', 'contentdm' );
}
add_action( 'init', 'sacr_post_type_map_point' );

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

	if ( get_query_var( 'point' ) ) {
		$point = get_query_var( 'point' );
		$point = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s", $point ) );
		$point = get_post( $point );

		$title = sprintf( '%1$s - %3$s %2$s %4$s', $point->post_title, $sep, $post->post_title, get_bloginfo( 'name' ) );
	} else if ( get_query_var( 'map_year' ) ) {
		$title = sprintf( '%1$s - %3$s %2$s %4$s', get_query_var( 'map_year' ), $sep, $post->post_title, get_bloginfo( 'name' ) );
	}

	return $title;
}
add_filter( 'wp_title', 'noteboard_wp_title', 20, 2 );

function sacr_page_after_map() {
	global $post;

	if ( ! is_page( sacr_get_theme_option( 'map' ) ) )
		return;

	$time_periods = get_terms( array( 'map_point-year' ), array( 'hide_empty' => 0, 'orderby' => 'id' ) );
	$singled      = false;
	$year         = get_query_var( 'map_year' );

	if ( $year && in_array( $year, wp_list_pluck( $time_periods, 'slug' ) ) )
		$singled = get_query_var( 'map_year' );
?>
	<section class="historic-map">
		<div class="container">
			<div class="map-control">
				<h3 class="area-title">Filter by Time Period</h3>
				<ul>
					<?php foreach ( $time_periods as $term ) : ?>
					<li class="map-filter"><label><input class="filter-time-period" type="checkbox" <?php $singled ? checked($term->slug, $singled ) : checked(0,0); ?> value="<?php echo $term->slug; ?>" /> <?php echo $term->name; ?></label></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div id="map-canvas"></div>
	</section><!-- .feature-map -->
<?php
}
add_action( 'sacr_page_after', 'sacr_page_after_map', 10 );

function sacr_map_point_modals() {
	global $post, $_post, $wp_embed, $points_query;

	if ( ! is_page( sacr_get_theme_option( 'map' ) ) )
		return;

	p2p_type( 'person_to_point' )->each_connected( $points_query, array(), 'people' );
	p2p_type( 'point_to_point' )->each_connected( $points_query, array(), 'places' );

	while ( $points_query->have_posts() ) : $points_query->the_post();
		$_post = $post; // Save ourselves
?>
		<div id="<?php echo esc_attr( get_post()->post_name ); ?>" class="point-modal">
			<div class="video-container">
				<?php echo $wp_embed->run_shortcode( '[embed]' . sacr_item_meta( 'video' ) . '[/embed]' ); ?>
			</div>

			<div class="point-modal-content clearfix">
				<?php get_template_part( 'content', 'item' ); ?>
			</div>
		</div>
<?php
	endwhile;

	wp_reset_postdata();
}
add_action( 'wp_footer', 'sacr_map_point_modals' );

function sacr_map_points() {
	if ( ! is_page( sacr_get_theme_option( 'map' ) ) )
		return false;

	global $points_query;

	$args = array(
		'points' => array(),
		'center' => array(0, 0),
		'pin'    => get_template_directory_uri() . '/images/display/pin-'
	);

	$points_query = new WP_Query( array(
		'post_type'              => array( 'map_point' ),
		'posts_per_page'         => 200,
		'no_found_rows'          => true,
		'cache_results'          => true
	) );
	$total  = $points_query->post_count;

	while ( $points_query->have_posts() ) {
		$points_query->the_post();
		
		$position = sacr_item_meta( 'latlong', get_post()->ID );
		$position = explode( ',', $position );

		$year = sacr_item_year( 'map_point-year', get_post()->ID );

		$args['points'][] = array(
			'id'       => get_post()->post_name,
			'title'    => get_post()->post_title,
			'position' => array( trim( $position[0] ), trim( $position[1] ) ),
			'category' => array($year)
		);

		$args[ 'center' ][0] = $args[ 'center' ][0] + $position[0];
		$args[ 'center' ][1] = $args[ 'center' ][1] + $position[1];
	}

	$args[ 'center' ][0] = $total == 0 ? $args[ 'center' ][0] : ( $args[ 'center' ][0] / $total );
	$args[ 'center' ][1] = $total == 0 ? $args[ 'center' ][1] : ( $args[ 'center' ][1] / $total );

	wp_localize_script( 'sacr-script', 'SACRMap', $args );
}
add_action( 'wp_enqueue_scripts', 'sacr_map_points' );