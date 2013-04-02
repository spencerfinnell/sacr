<?php
/**
 * Map Archive
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */

$time_periods = get_terms( array( 'map_point-year' ), array( 'hide_empty' => 0, 'orderby' => 'id' ) );
$singled      = false;
$year         = get_query_var( 'map_year' );

if ( $year && in_array( $year, wp_list_pluck( $time_periods, 'slug' ) ) )
	$singled = get_query_var( 'map_year' );

get_header(); ?>

	<section class="historic-map">
		<div class="container">
			<header class="entry-header container">
				<h1 class="page-title"><?php _e( 'Historic Map', 'sacr' ); ?></h1>
			</header><!-- .entry-header -->

			<div class="map-control">
				<h3 class="area-title">Filter by Time Period</h3>
				<ul>
					<?php foreach ( $time_periods as $term ) : ?>
					<li class="map-filter"><label> <span class="map-legend map-color-<?php echo $term->slug; ?>"></span> <input class="filter-time-period" type="checkbox" <?php $singled ? checked($term->slug, $singled) : checked(0,0); ?> value="<?php echo $term->slug; ?>" /> <?php echo $term->name; ?></label></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div id="map-canvas"></div>
	</section><!-- .feature-map -->

	<?php get_template_part( 'content-further-research', 'map_point-archive' ); ?>

<?php get_footer(); ?>