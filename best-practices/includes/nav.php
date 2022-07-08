<nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light d-print-none">
	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
			<?php
			wp_nav_menu(array(
				'theme_location' => 'Primary Menu',
				'depth' => 2,
				'container' => false,
				'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0',
				'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
				'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
				'walker'            => new WP_Bootstrap_Navwalker()
			));
			?>
		</div>
	</div>
</nav>