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
			'container_id'      => 'navbarNavDropdown',
			'menu_class'        => 'navbar-nav mr-auto',
			'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
			'walker'            => new WP_Bootstrap_Navwalker())
		);	?>
		<form id="formHome" class="form-inline"  method="get" action="<?php bloginfo('home'); ?>" >
			<input type="text" id="fieldSearch" class="form-control mr-sm-2" autocomplete="off" name="s" value="<?php echo get_search_query(); ?>">
			<a id="speakBtn" href="#"><i class="fas fa-microphone-alt"></i></a>
			<button class="btn btn-success my-2 my-sm-0" type="submit"  id="submitHome"><i class="fas fa-search"></i></button>
		</form>
	</div>
</nav>