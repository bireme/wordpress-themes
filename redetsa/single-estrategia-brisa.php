<?php $language = pll_current_language(); ?>
<?php get_header('brisa');?>
<?php get_template_part('includes/search-brisa') ?>
<main id="main_container" class="padding1">
  <div class="container page-brisa">
    <h1 class="title1"><?php the_title(); ?></h1>

    <?php the_content(); ?>
    
  </div>
</main>
<section class="padding1 sectionPageBrisa" style="background: #eee;">
  <div class="container">
    <h4 class="title1"><?php pll_e('Explore the BRISA database by category'); ?></h4> <br>
    <div class="row row-cols-2 row-cols-md-4 g-4">
      <?php 
      $estrategia = new WP_Query(array(
        'post_type' => 'estrategia-brisa',
        'posts_per_page' => '-1'
      ));
      while($estrategia->have_posts()) : $estrategia->the_post();?>
        <div class="col">
          <a href="<?php permalink_link(); ?>">
            <div class="card h-100">
              <?php
              if ( has_post_thumbnail()) {
                the_post_thumbnail('servico',['class' => 'img-fluid']);
              }else{ ?>
                <img src="<?php bloginfo( 'template_directory')?>/img/brisa2.jpg" class="img-fluid" alt="">
              <?php }  ?>
              <div class="card-body">
                <h5 class="card-title"><?php the_title(); ?></h5>
              </div>
            </div>
          </a>
        </div>
        <?php
      endwhile;
      ?>
    </div>
  </div>
</section>
<?php get_footer('brisa'); ?>