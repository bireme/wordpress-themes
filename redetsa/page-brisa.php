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
    <h2 class="title1">Acerca de</h2>
    <div class="accordion" id="accordionExample">
      
      <?php while (have_rows('grupo_1') ) : the_row(); $titulo = get_sub_field('titulo_1'); endwhile; ?>

      <?php if( have_rows('grupo_1') ): ?>
        <?php while( have_rows('grupo_1') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
          <?php while ($count > $loop) : $loop++; ?>
            <?php
            $titulo = get_sub_field('titulo_'.$loop);
            $texto = get_sub_field('texto_'.$loop);
            ?>
            <?php if ( $titulo ) : ?>

              <div class="accordion-item">
                <h2 class="accordion-header" id="<?=$loop; ?>">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$loop; ?>" aria-expanded="true" aria-controls="collapse<?=$loop; ?>">
                    <b><?php echo $titulo;  ?></b>
                  </button>
                </h2>
                <div id="collapse<?=$loop; ?>" class="accordion-collapse collapse <?=($loop == 1 ? "show": "" ); ?>" aria-labelledby="<?=$loop; ?>" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <div class="row">
                      <div class="col-md-12">
                       <?php echo $texto;  ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            <?php endif; ?>
          <?php endwhile; ?>
        <?php endwhile; ?>
      <?php endif; ?>


    </div>
  </div>
</main>


<section class="padding1 sectionPageBrisa">
  <div class="container">
    <h2 class="title1">COVID-19</h2>
    <div class="row row-cols-2 row-cols-md-3 g-4">
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
<?php get_footer('brisa'); ?>