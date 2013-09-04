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

	<p><a href="<?php echo sacr_get_theme_option( 'contentdm' ); ?>" class="button on-light"><?php _e( 'Research Archives &rarr;', 'sacr' ); ?></a></p>
</div>

<div class="span-one-third alignright">
	<?php if ( is_singular( 'person' ) ) : ?>
		<p><?php the_post_thumbnail( 'biography' ); ?></p>

		<?php if ( '' != $post->post_excerpt ) : ?>
		<h3 class="area-title"><?php _e( 'Biographical Information', 'sacr' ); ?></h3>

		<table class="person-atts" width="100%" cellspacing="0" cellpadding="0" border="0">
			<?php 
				$atts = $post->post_excerpt;
				$atts = explode( "\n", $atts );

				foreach ( $atts as $att ) :
					$info  = explode( ":", $att );
					$key   = $info[0];
					$value = $info[1];
			?>
				<tr>
					<td class="person-att-key"><strong><?php echo $key; ?></strong></td>
					<td><?php echo $value; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( isset ( $_post->people ) && ! empty( $_post->people ) ) : ?>
	<h3 class="area-title"><?php _e( 'Related Individuals', 'sacr' ); ?></h3>

	<ul class="related">
		<?php sort( $_post->people ); foreach ( $_post->people as $post ) : setup_postdata( $post ); ?>
			<li class="related-item">
				<div class="related-preview">
					<?php the_post_thumbnail(); ?>
				</div>

				<div class="related-description">
					<a href="<?php the_permalink(); ?>" class="related-title"><?php the_title(); ?></a>
					<small><a href="<?php the_permalink(); ?>"><?php _e( 'Read More &rarr;', 'sacr' ); ?></a></small>
				</div>
			</li>
		<?php endforeach;?>
	</ul>	
	<?php endif ;?>

	<?php if ( isset ( $_post->places ) && ! empty( $_post->places ) ) : ?>
	<h3 class="area-title"><?php _e( 'Related Places', 'sacr' ); ?></h3>
	
	<ul class="related">
		<?php sort( $_post->places ); foreach ( $_post->places as $post ) : setup_postdata( $post ); ?>
			<li class="related-item">
				<div class="related-preview">
					<img src="<?php echo get_template_directory_uri(); ?>/images/display/pin-<?php echo sacr_item_year(); ?>.png" />
				</div>

				<div class="related-description">
					<a href="<?php the_permalink(); ?>" class="related-title related-point" data-point="#<?php echo $post->post_name; ?>"><?php the_title(); ?></a>
					<small>
						<strong><?php echo get_the_term_list( $post->ID, 'map_point-year', '', ', ', '' ); ?></strong>
					</small>
				</div>
			</li>
		<?php endforeach;?>
	</ul>
	<?php endif; ?>

	<?php if ( is_singular( 'person' ) ) : ?>
	<?php
		$images = get_posts( array(
			'post_type'              => 'attachment',
			'post_parent'            => $_post->ID,
			'fields'                 => 'ids',
			'post__not_in'           => array( get_post_thumbnail_id() ),
			'no_found_rows'          => true,
			'cache_results'          => false,
			'update_post_term_cache' => false
		) );

		if ( ! empty( $images ) ) :
	?>
	<h3 class="area-title"><?php _e( 'Additional Images', 'sacr' ); ?></h3>

	<div class="person-collage">
		<?php foreach ( $images as $image_id ) : ?>
			<a href="<?php echo wp_get_attachment_url( $image_id ); ?>"><?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?></a>
		<?php endforeach; ?>
	</div>
	<?php endif; endif; ?>
</div>