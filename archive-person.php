<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */

get_header(); ?>

	<div class="container">
		<h1 class="page-title"><?php _e( 'Meet the People', 'sacr' ); ?></h1>
	</div>

	<div class="container">

		<ul class="people-archive">
		<?php while ( have_posts() ) : the_post(); ?>
			<li class="person">
				<div class="person-preview">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail(); ?>
					</a>
				</div>
				<div class="person-name">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</div>
			</li>
		<?php endwhile; ?>
		</ul>
	</div>

	<?php get_template_part( 'content-further-research', 'people' ); ?>

<?php get_footer(); ?>