<?php return; ?>

<section class="further divider before">
	<div class="container">
		<div class="span-two-thirds alignleft">
			<h2 class="section-title">Further Research</h2>

			<div class="row clearfix">
				<div class="span-one-third alignleft">
					<h3 class="sub-section">People</h3>
					
					<?php
						wp_nav_menu( array(
							'theme_location' => 'people',
							'menu_class' => 'research-list',
							'depth' => 1
						) ); 
					?>
				</div>

				<div class="span-one-third alignleft">
					<h3 class="sub-section">Places</h3>
					
					<?php
						wp_nav_menu( array(
							'theme_location' => 'places',
							'menu_class' => 'research-list',
							'depth' => 1
						) ); 
					?>
				</div>

				<div class="span-one-third alignleft">
					<h3 class="sub-section">Events</h3>
					
					<?php
						wp_nav_menu( array(
							'theme_location' => 'events',
							'menu_class' => 'research-list',
							'depth' => 1
						) ); 
					?>
				</div>
			</div>
		</div>

		<div class="sponsors span-one-third alignright">
			<h2 class="section-title">Flagler College...</h2>
			
		</div>
	</div>
</section><!-- .further -->