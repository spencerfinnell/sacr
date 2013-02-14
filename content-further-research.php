<section class="further container">
	<div class="span-half alignleft">
		<h2 class="section-title">Further Research</h2>

		<div class="clearfix">
			<div class="span-one-third alignleft">
				<h3 class="sub-section">People</h3>
				<ul class="research-list">
					<?php
						$people = get_posts( array(
							'post_type'              => 'person',
							'posts_per_page'         => 10,
							'nopaging'               => true,
							'no_found_rows'          => true,
							'cache_results'          => false,
							'update_post_meta_cache' => false,
							'update_post_term_cache' => false
						) );

						foreach ( $people as $person ) :
					?>
					<li><a href="<?php echo get_permalink( $person->ID ); ?>"><?php echo get_the_title( $person->ID ); ?></a></li>
					<?php endforeach; ?>

					<li class="more"><a href="#">View More &rarr;</a></li>
				</ul>
			</div>

			<div class="span-one-third alignleft">
				<h3 class="sub-section">Places</h3>
				<ul class="research-list">
					<li><a href="#">Robert Hayling</a></li>
					<li><a href="#">Lionel Bordelon</a></li>
					<li><a href="#">Dot Maslowski</a></li>
					<li><a href="#">Darline Kuder</a></li>
					<li><a href="#">Phyllis Arreola</a></li>
					<li><a href="#">Margaretta Dollar</a></li>
					<li><a href="#">Andreas Friberg</a></li>
					<li><a href="#">Ardath Pascarella</a></li>
					<li><a href="#">Ardath Pascarella</a></li>

					<li class="more"><a href="#">View More &rarr;</a></li>
				</ul>
			</div>

			<div class="span-one-third alignleft">
				<h3 class="sub-section">Events</h3>
				<ul class="research-list">
					<li><a href="#">Robert Hayling</a></li>
					<li><a href="#">Lionel Bordelon</a></li>
					<li><a href="#">Dot Maslowski</a></li>
					<li><a href="#">Darline Kuder</a></li>
					<li><a href="#">Phyllis Arreola</a></li>
					<li><a href="#">Margaretta Dollar</a></li>
					<li><a href="#">Andreas Friberg</a></li>
					<li><a href="#">Ardath Pascarella</a></li>
					<li><a href="#">Ardath Pascarella</a></li>

					<li class="more"><a href="#">View More &rarr;</a></li>
				</ul>
			</div>
		</div>

		<p class="further-cta"><a href="#" class="button tertiary">Research Database</a></p>
	</div>

	<div class="span-half alignright">
		<?php if ( is_front_page() ) : ?>

		<?php else : ?>
		<a href="#" class="further-graphic"><img src="<?php echo get_template_directory_uri(); ?>/images/display/timeline.png" alt="" /></a>

		<p class="further-cta"><a href="#" class="button secondary alignright">See the Timeline</a></p>
		<?php endif; ?>
	</div>
</section><!-- .further -->