<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<div class="container">  
<br>  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Error 404 - Page not found!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>

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

<section class="padding1">
  <div class="container">
    <div class="row">
      <?php
      while($home->have_posts()) : $home->the_post();
        if( have_rows('group_2') ): ?>
          <?php while( have_rows('group_2') ): the_row(); $row = get_row(); $count = count($row)/5; $loop = 0; ?>
            <?php while ($count > $loop) : $loop++; ?>
              <?php
              $image = get_sub_field('image_'.$loop);
              $title = get_sub_field('title_'.$loop);
              $text = get_sub_field('text_'.$loop);
              ?>
              <div class="col-md-6">
                <div class="card mb-3">
                  <div class="row">
                    <div class="col-md-4" style='overflow: hidden;'>
                      <img src="<?php echo esc_url($image['url']); ?>" class="cardA" alt="<?php echo esc_url($image['alt']); ?>">
                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $title; ?></h5>
                        <p class="card-text">
                          <a href="reunioes.php"><?php echo $text; ?></a>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php endwhile; ?>
        <?php endif; ?>
      <?php endwhile; ?>
    </div> 
  </div>
</section>

<section class="padding1 color1">
  <div class="container">
    <h2 class="title1 marginB1"><?php pll_e('Know RedETSA'); ?></h2>

    <div id="boxConheca">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <?php if( have_rows('group_3') ): ?>
            <?php while( have_rows('group_3') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
              <?php while ($count > $loop) : $loop++; ?>
                <?php
                $title = get_sub_field('title_'.$loop);
                ?>
                <?php if ( $title ) : ?>
                  <a class="nav-link  <?=$loop=='1'?'active':''; ?>" id="nav-<?=$loop; ?>-tab" data-bs-toggle="tab" href="#nav-<?=$loop ?>" role="tab" aria-controls="nav-<?=$loop; ?>" aria-selected="true"><?=$title; ?></a>
                <?php endif; ?>
              <?php endwhile; ?>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <?php if( have_rows('group_3') ): ?>
          <?php while( have_rows('group_3') ): the_row(); $row = get_row(); $count = count($row); $loop = 0; ?>
            <?php while ($count > $loop) : $loop++; ?>
              <?php
              $title = get_sub_field('title_'.$loop);
              $text = get_sub_field('text_'.$loop);
              ?>
              <?php if ( $text ) : ?>
                <div class="tab-pane fade <?=$loop=='1'?'show active':''; ?>" id="nav-<?=$loop ?>" role="tabpanel" aria-labelledby="nav-<?=$loop ?>-tab">
                  <?=$text; ?>
                </div>
              <?php endif; ?>
            <?php endwhile; ?>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>