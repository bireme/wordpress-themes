<?php
/***
Template Name: Webinars
***/
?>
<?php get_header(); ?>
<?php get_template_part('includes/nav'); ?>
<?php $site_language = strtolower(get_bloginfo('language')); ?>
<?php $lang = substr($site_language,0,2); ?>
<?php $ofsearch = ( $_GET['ofsearch'] ) ? sanitize_text_field($_GET['ofsearch']) : ''; ?>
<?php $ofcategory = ( $_GET['category_name'] ) ? sanitize_text_field($_GET['category_name']) : 'webinar-pt, webinar-es, webinar-en'; ?>
<main id="main_container" class="padding1">
  <div class="container">
    <h1 class="title1"><?php the_title(); ?></h1>

    <?php
      get_template_part(
        'searchform',
        null,
        array(
          'lang'       => $lang,
          'ofsearch'   => $ofsearch,
          'ofcategory' => $ofcategory
        )
      );
    ?>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4" id="loopNews">
      <?php
      $posts = new WP_Query([
        'post_type'      => 'post',
        's'              => $ofsearch,
        'category_name'  => $ofcategory,
        'posts_per_page' => '-1'
      ]);
      if ($posts->have_posts()): while ($posts->have_posts()) : $posts->the_post(); ?>
        <div class="col">
          <div class="card h-100">
            <?php if ( has_post_thumbnail()) {
              the_post_thumbnail('bannerMobile',['class' => 'img-fluid']);
            }else{ ?>
              <img src="<?php bloginfo( 'template_directory')?>/img/indisponivel.jpg" class="img-fluid" alt="">
            <?php } ?>
            <div class="card-body">
              <a href="<?php permalink_link(); ?>">
                <h5 class="card-title"><?php the_title(); ?></h5>
                <p class="card-text"><?php the_excerpt(); ?></p>
              </a>
            </div>
            <div class="card-footer d-none">
              <small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> <?php pll_e("ago"); ?></small>
            </div>
          </div>
        </div>
      <?php endwhile; endif; ?>
    </div>
  </div>
</main>
<?php get_footer(); ?>