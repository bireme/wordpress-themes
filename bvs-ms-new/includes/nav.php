<nav id="nav" class="navbar navbar-expand-lg navbar-dark">
	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php
			wp_nav_menu(array(
				'theme_location'    => 'main-nav',
				'depth'             => 2,
				'container'         => 'div',
				'container_class'   => 'collapse navbar-collapse',
				'container_id'      => 'navbarSupportedContent',
				'menu_class'        => 'navbar-nav mr-auto',
				'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
				'walker'            => new WP_Bootstrap_Navwalker())
			);
		?>
	</div>
</nav>