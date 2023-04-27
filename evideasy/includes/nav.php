<section class="clearfix">
	<div class="container">
		<nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'main-nav',
					'container' => false,
					'menu_class' => 'nav-item',
					'fallback_cb' => '__return_false',
					'items_wrap' => '<ul id="%1$s" class="navbar-nav mr-auto">%3$s</ul>',
						#'depth' => 2,
						#'walker' => new bootstrap_5_wp_nav_menu_walker()
				));
				?>
			</div>
		</nav>
	</div>
</section>