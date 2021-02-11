<nav class="navbar navbar-expand-lg navbar-dark" id="nav">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
 

        <?php
		wp_nav_menu(array(
			'theme_location'    => 'main-nav',
			'depth'             => 2,
			'container'         => 'div',
			'container_class'   => 'collapse navbar-collapse',
			'container_id'      => 'navbarTogglerDemo02',
			'menu_class'        => 'navbar-nav mr-auto',
			'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
			'walker'            => new WP_Bootstrap_Navwalker())
		);	?>

     <!--  <form class="d-flex" id="formHome" method="get" action="<?php bloginfo('home'); ?>" >
        <div class="input-group mb-3">
			  <input type="text" id="fieldSearch" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2"autocomplete="off" name="s" value="<?php echo get_search_query(); ?>">
			  <a id="speakBtn" href="#"><i class="fas fa-microphone-alt"></i></a>
			  <button class="btn btn-secondary" type="submit" id="submitHome"><i class="fas fa-search"></i></button>
			</div>
      </form> -->
    </div>
  </div>
</nav>