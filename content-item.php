<?php
/**
 *
 */

global $post, $_post;
?>

<div class="span-two-thirds alignleft">
	<?php if ( 'map_point' == get_post_type() ) : ?>
	<h2 class="point-modal-title"><?php the_title(); ?></h2>
	<?php endif; ?>

	<?php the_content(); ?>

	<?php edit_post_link( __( 'Edit This', 'sacr' ), '<span class="edit-link">', '</span>' ); ?> 

	<?php if ( sacr_item_meta( 'contentdm' ) ) :?>
		<h3 class="point-modal-subtitle"><?php _e( 'Further Research', 'sacr' ); ?></h3>
		<?php echo sacr_item_meta( 'contentdm' ); ?>
	<?php endif; ?>

	<p><a href="<?php echo sacr_get_theme_option( 'contentdm' ); ?>" class="button on-light"><?php _e( 'Research Database &rarr;', 'sacr' ); ?></a></p>
</div>

<div class="span-one-third alignright">
	<?php if ( ! empty( $_post->people ) ) : ?>
	<h3 class="area-title"><?php _e( 'Related Individuals', 'sacr' ); ?></h3>

	<ul class="related">
		<?php foreach ( $_post->people as $post ) : setup_postdata( $post ); ?>
			<li class="related-item">
				<div class="related-preview">
					<?php the_post_thumbnail(); ?>
				</div>

				<div class="related-description">
					<a href="<?php the_permalink(); ?>" class="related-title"><?php the_title(); ?></a>
					<?php echo get_the_term_list( get_the_ID(), 'person-tag', '<small>', ', ', '</small>' ); ?>
				</div>
			</li>
		<?php endforeach;?>
	</ul>	
	<?php endif ;?>

	<?php if ( ! empty( $_post->places ) ) : ?>
	<h3 class="area-title"><?php _e( 'Related Places', 'sacr' ); ?></h3>
	
	<ul class="related">
		<?php foreach ( $_post->places as $post ) : setup_postdata( $post ); ?>
			<li class="related-item">
				<div class="related-preview">
					<img src="<?php echo get_template_directory_uri(); ?>/images/display/pin-<?php echo sacr_item_year(); ?>.png" />
				</div>

				<div class="related-description">
					<a href="<?php the_permalink(); ?>" class="related-title related-point" data-point="#<?php echo $post->post_name; ?>"><?php the_title(); ?></a>
					<small>
						<strong><?php echo get_the_term_list( $post->ID, 'map_point-year', '', ', ', '' ); ?></strong>
						<?php if ( is_singular( 'person' ) ) : ?>
						 <br /> <span class="latlong"><?php echo sacr_item_meta( 'latlong', get_the_ID() ); ?></span>
						<?php endif; ?>
					</small>
				</div>
			</li>
		<?php endforeach;?>
	</ul>
	<?php endif; ?>

	<?php if ( is_singular( 'person' ) ) : ?>
	<h3 class="area-title"><?php _e( 'Pictures', 'sacr' ); ?></h3>
	<?php
		$sizes  = array( 'fullsize', 'full', 'medium' );

		$images = get_posts( array(
			'post_type'   => 'attachment',
			'post_parent' => $_post->ID,
			'fields'      => 'ids'
		) );
	?>
	<div class="person-collage">
		<?php foreach ( $images as $image_id ) : ?>
			<?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>