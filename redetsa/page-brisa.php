<?php
/***
Template Name: Page Brisa
***/
?>
<?php $language = pll_current_language(); ?>
<?php get_header('brisa');?>
<?php get_template_part('includes/search-brisa') ?>


<main id="main_container" class="padding1 sectionPageBrisa">
  <div class="container">
    <?php the_content(); ?>
  </div>
</main>


<section class="padding1 sectionPageBrisa d-none">
  <div class="container">
    <h2 class="title1">COVID-19</h2>
    <div class="row row-cols-2 row-cols-md-4 g-4">
      <?php 
      $atual = get_the_title();
      $estrategia = new WP_Query(array(
        'post_type' => 'covid-brisa',
        'posts_per_page' => '-1'
      ));
      while($estrategia->have_posts()) : $estrategia->the_post();
        if(get_the_title()==$atual){continue;}
        ?>
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
        $i++;
      endwhile;
      ?>
    </div>
  </div>
</section>

<section class="padding1 sectionPageBrisa">
  <div class="container">
    <h3><?php pll_e('Explore the BRISA database by category'); ?></h3> <br>
    <div class="row row-cols-2 row-cols-md-4 g-4">
      <?php 
      $atual = get_the_title();
      $estrategia = new WP_Query(array(
        'post_type' => 'estrategia-brisa',
        'posts_per_page' => '-1'
      ));
      while($estrategia->have_posts()) : $estrategia->the_post();
        if(get_the_title()==$atual){continue;}
        ?>
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
        $i++;
      endwhile;
      ?>
    </div>
  </div>
</section>



<section class="padding1 sectionPageBrisa">
  <div class="container">
    <div class="row row-cols-2 row-cols-md-4 g-4">
      <?php 
      $atual = get_the_title();
      $estrategia = new WP_Query(array(
        'post_type' => 'estrategia-rebrats',
        'posts_per_page' => '-1'
      ));
      while($estrategia->have_posts()) : $estrategia->the_post();
        if(get_the_title()==$atual){continue;}
        ?>
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
        $i++;
      endwhile;
      ?>
    </div>
  </div>
</section>





<?php get_footer('brisa'); ?>