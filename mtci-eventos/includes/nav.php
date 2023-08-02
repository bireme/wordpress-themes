<?php while(have_posts()) : the_post();
  $menu       = get_field('menu');
endwhile;
?>
<nav id="nav" class="navbar navbar-dark navbar-expand-lg bg-light sticky-top">
  <div class="container">
    <?php echo $menu; ?>
  </div>
</nav>