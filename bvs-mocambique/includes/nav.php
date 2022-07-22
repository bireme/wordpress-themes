<nav  id="nav" class="navbar navbar-expand-lg navbar-dark bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <?php
      wp_nav_menu(array(
        'theme_location'  => 'Primary Menu',
        'container'       => false,
        'menu_class'      => 'navbar-nav me-auto mb-2 mb-lg-0',
        'fallback_cb'     => '__return_false',
        'items_wrap'      => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
        'depth'           => 2,
        'walker'          => new bootstrap_5_wp_nav_menu_walker()
      ));
      ?>
    </div>
  </div>
</nav>