<?php
/***
Template Name: News
***/
?>
<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
  <div class="container">
    <h1 class="title1"><?php the_title(); ?></h1>
    <!-- <div class="searchNews">
      <div class="row g-3 align-items-center">
        <div class="col-12">
          <input type="text" id="text" class="form-control" aria-describedby="text" placeholder="Título">
        </div>
        <div class="col-4">
          <select class="form-select" aria-label="Categoría">
            <option selected>Categoría</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
        <div class="col-4">
          <select class="form-select" aria-label="Categoría">
            <option selected>Año</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
        <div class="col-4">
          <div class="d-grid">
            <input type="submit" class="btn btn-primary btn-block" value="Buscar">
          </div>
        </div>
      </div>
    </div> -->
    <div class="row row-cols-1 row-cols-md-3 g-4" id="loopNews">
      <?php
      $posts = new WP_Query([
        'post_type' => 'post',
        'category_name'  => 'ultimas-noticias',
        'posts_per_page' => '-1'
      ]);
      if($posts->have_posts()): while ($posts->have_posts()) : $posts->the_post(); ?>
        <article class="col">
          <div class="card h-100">
            <?php if ( has_post_thumbnail()) {
              the_post_thumbnail('bannerMobile',['class' => 'img-fluid']);
            }else{ ?>
              <img src="<?php bloginfo( 'template_directory')?>/img/indisponivel.jpg" class="img-fluid" alt="">
            <?php }  ?>
            <div class="card-body">
              <a href="<?php permalink_link(); ?>">
                <h5 class="card-title"><?php the_title(); ?></h5>
                <p class="card-text"><?php the_excerpt(); ?></p>
              </a>
            </div>
            <div class="card-footer">
              <small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
            </div>
          </div>
        </article>
      <?php endwhile; else: endif;?>
    </div>
  </div>
</main>
<?php get_footer(); ?>