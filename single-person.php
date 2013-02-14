<?php
/**
 * The template for displaying a person.
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */

global $post, $_post, $wp_query;

$_post = $post;

p2p_type( 'person_to_point' )->each_connected( $wp_query, array(), 'places' );
p2p_type( 'person_to_person' )->each_connected( $wp_query, array(), 'people' );

get_header(); ?>

	<div class="container">
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			
		<h1 class="page-title"><?php the_title(); ?></h1>

		<?php
			$sizes  = array( 'fullsize', 'full', 'medium' );

			$images = get_posts( array(
				'post_type'   => 'attachment',
				'post_parent' => $post->ID,
				'fields'      => 'ids'
			) );

			if ( count( $images ) > 3 ) :
		?>
		<div class="person-collage">
			<?php foreach ( $images as $image_id ) : ?>
				<?php // echo wp_get_attachment_image( $image_id, array_rand( $sizes ) ); ?>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<div class="person-bio">
			<div class="person-description clearfix">
				<?php get_template_part( 'content', 'item' ); ?>
			</div>
		</div>

		<?php endwhile; ?>
	</div>

	<?php get_template_part( 'content-further-research', 'person' ); ?>

<?php get_footer(); ?>