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

$prev_letter = null;

get_header(); ?>

	<div class="container">
		<h1 class="page-title"><?php _e( 'Meet the People', 'sacr' ); ?></h1>

		<p class="people-filter">
			<?php foreach ( range( 'A', 'Z' ) as $char ) : ?>
			<a href="#<?php echo ucfirst( $char ); ?>" class="button"><?php echo $char; ?></a>
			<?php endforeach; ?>
		</p>
	</div>

	<div class="people-archive-wrap divider before">
		<div class="container">

			<?php while ( have_posts() ) : the_post(); $this_letter = strtoupper(substr($post->post_title,0,1)); ?>
				
				<?php if ( ! $prev_letter ) : $prev_letter = $this_letter; ?>
				<h3 id="<?php echo $this_letter; ?>" class="people-archive-title"><?php echo $this_letter; ?></h3>
				
				<ul class="people-archive">
				<?php elseif ( $this_letter != $prev_letter ) :$prev_letter = $this_letter;  ?>
				</ul>

				<h3 id="<?php echo $this_letter; ?>" class="people-archive-title"><?php echo $this_letter; ?></h3>
				<ul class="people-archive">
				<?php endif; ?>

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
	</div>

<?php get_footer(); ?>