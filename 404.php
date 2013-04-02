<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */

get_header(); ?>

	<div class="container">
		<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'sacr' ); ?></h1>

		<div class="person-bio">
			<div class="person-description clearfix">
				<article id="post-0" class="post error404 not-found">
					
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'sacr' ); ?></p>

					<?php get_search_form(); ?>

				</article><!-- #post-0 .post .error404 .not-found -->
			</div>
		</div>

	</div>

	<?php get_template_part( 'content-further-research', 'person' ); ?>

<?php get_footer(); ?>