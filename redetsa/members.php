<?php
/***
Template Name: Members
***/
?>
<?php $language = pll_current_language(); ?>
<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
  <div class="container">
    <h1 class="title1"><?php the_title(); ?></h1>
    <div class="row">
      <div class="col-md-7">
        <?php while(have_posts()) : the_post(); ?>
          <?php the_content(); ?>  
        <?php endwhile; ?>
      </div>
      <div class="col-md-5">
        <div style="position:sticky; top: 0;">
          <img src="<?php bloginfo('template_directory'); ?>/img/mapa_redetsa_<?php echo $language; ?>.svg" alt="" class="img-fluid imgBlack"></a>
        </div>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>