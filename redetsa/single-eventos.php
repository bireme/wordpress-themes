<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-lg-9 order-md-last">
        <h1 class="title1"><?php the_title(); ?></h1>
        <?php while(have_posts()) : the_post(); ?>
          <?php the_post_thumbnail('large',['class' => 'img-fluid']); ?>
          <?php the_content();
        endwhile;
        ?>

        <?php if( have_rows('grupo_1') ): ?>
          <?php while( have_rows('grupo_1') ): the_row(); 
            $title = get_sub_field('title');
            $contents = get_sub_field('contents');
            ?>
            <div id="sessao1">
              <div class="content">
                <h2 class="title1"><?php echo $title; ?></h2>
                <?php echo $contents; ?>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>


        <?php if( have_rows('grupo_2') ): ?>
          <?php while( have_rows('grupo_2') ): the_row(); 
            $title = get_sub_field('title');
            $contents = get_sub_field('contents');
            ?>
            <div id="sessao2">
              <div class="content">
                <h2 class="title1"><?php echo $title; ?></h2>
                <?php echo $contents; ?>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>


        <?php if( have_rows('grupo_3') ): ?>
          <?php while( have_rows('grupo_3') ): the_row(); 
            $title = get_sub_field('title');
            $contents = get_sub_field('contents');
            ?>
            <div id="sessao3">
              <div class="content">
                <h2 class="title1"><?php echo $title; ?></h2>
                <?php echo $contents; ?>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>

      </div>
      <div class="col-md-4 col-lg-3 order-md-first">
        <div class="accordion sticky-top" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                XII Encuentro Anual 2021
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <ul>
                  <li><a href="#sessao1">Agenda</a></li>
                  <li><a href="#sessao2">Fotos</a></li>
                  <li><a href="#sessao3">Participações</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                XI Encuentro Anual 2020
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <ul>
                  <li><a href="#sessao1">Agenda</a></li>
                  <li><a href="#sessao2">Fotos</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                X Encuentro Anual 2019
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <ul>
                  <li><a href="#sessao1">Agenda</a></li>
                  <li><a href="#sessao2">Fotos</a></li>
                  <li><a href="#sessao3">Videos</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>
<?php get_footer(); ?>