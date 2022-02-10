<?php $language = pll_current_language(); ?>
<?php get_header('brisa');?>
<?php get_template_part('includes/search-brisa') ?>
<main id="main_container" class="padding1">
  <div class="container page-brisa">
    <h1 class="title1"><?php the_title(); ?></h1>

    <?php the_content(); ?>
    
  </div>
</main>
<?php get_footer('brisa'); ?>