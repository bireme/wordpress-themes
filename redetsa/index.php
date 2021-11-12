<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/banners') ?>
<?php
$home = new WP_Query(['post_type' => 'home',]);
while($home->have_posts()) : $home->the_post();
  $text_brisa = get_field('text_brisa');
endwhile; 
?>
<section class="padding1 color2">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <?=$text_brisa; ?>
      </div>
      <div class="col-md-6" id="rssHome">
        <?php dynamic_sidebar( 'rss_home' ); ?>
      </div>
    </div>
  </div>
</section>

<section class="padding1">
  <div class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php
      while($home->have_posts()) : $home->the_post();
        if( have_rows('group_1') ): ?>
          <?php while( have_rows('group_1') ): the_row(); $row = get_row(); $count = count($row)/5; $loop = 0; ?>
            <?php while ($count > $loop) : $loop++; ?>
              <?php
              $image = get_sub_field('image_'.$loop);
              $title = get_sub_field('title_'.$loop);
              $text = get_sub_field('text_'.$loop);
              $link = get_sub_field('link_'.$loop);
              $window = get_sub_field('window_'.$loop);
              ?>
              <?php if ( $title ) : ?>
                <article class="col col-md-6">
                  <div class="card h-100">
                    <img src="<?php echo esc_url($image['url']); ?>" class="card-img-top" alt="<?php echo esc_url($image['alt']); ?>">
                    <div class="card-body">
                      <a href="<?php echo $link; ?>" target="<?php echo $window; ?>">
                        <h5 class="card-title"><?php echo $title; ?></h5>
                        <p class="card-text"><?php echo $text; ?></p>
                      </a>
                    </div>
                  </div>
                </article>
              <?php endif; ?>
            <?php endwhile; ?>
          <?php endwhile; ?>
        <?php endif; ?>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php get_template_part('includes/noticias') ?>
<?php get_footer(); ?>