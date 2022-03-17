<?php
    $count = 0;
    $post_id = get_the_ID();

    $args = array(
        'post_type' => 'eventos',
        'post_status' => 'publish',
        'posts_per_page' => -1
    );

    $events = new WP_Query( $args );
?>
<?php get_header(); ?>
<?php get_template_part('includes/nav'); ?>
<main id="main_container" class="padding1">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-lg-9 order-md-last">
        <h1 class="title1"><?php the_title(); ?></h1>
        <?php while(have_posts()) : the_post(); ?>
          <?php the_post_thumbnail('large',['class' => 'img-fluid']); ?>
          <?php the_content(); ?>
        <?php endwhile; ?>

        <?php if( have_rows('grupo_1') ): ?>
          <?php while( have_rows('grupo_1') ): the_row(); 
            $title = get_sub_field('title');
            $contents = get_sub_field('contents');
          ?>
            <?php if ( $title ) : ?>
              <div id="section1">
                <div class="content">
                  <h2 class="title1"><?php echo $title; ?></h2>
                  <?php echo $contents; ?>
                </div>
              </div>
            <?php endif; ?>
          <?php endwhile; ?>
        <?php endif; ?>

        <?php if( have_rows('grupo_2') ): ?>
          <?php while( have_rows('grupo_2') ): the_row(); 
            $title = get_sub_field('title');
            $contents = get_sub_field('contents');
          ?>
            <?php if ( $title ) : ?>
              <div id="section2">
                <div class="content">
                  <h2 class="title1"><?php echo $title; ?></h2>
                  <?php echo $contents; ?>
                </div>
              </div>
            <?php endif; ?>
          <?php endwhile; ?>
        <?php endif; ?>

        <?php if( have_rows('grupo_3') ): ?>
          <?php while( have_rows('grupo_3') ): the_row(); 
            $title = get_sub_field('title');
            $contents = get_sub_field('contents');
          ?>
            <?php if ( $title ) : ?>
              <div id="section3">
                <div class="content">
                  <h2 class="title1"><?php echo $title; ?></h2>
                  <?php echo $contents; ?>
                </div>
              </div>
            <?php endif; ?>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
      <div class="col-md-4 col-lg-3 order-md-first">
        <div class="accordion" id="accordionExample">
          <?php if ($events->have_posts()): while ($events->have_posts()) : $events->the_post(); $count++; ?>
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading<?php echo $count; ?>">
                <button class="accordion-button <?php if ( $post_id != get_the_ID() ) { echo 'collapsed'; } ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $count; ?>" aria-expanded="<?php echo ( $post_id == get_the_ID() ) ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $count; ?>">
                  <?php the_title(); ?>
                </button>
              </h2>
              <div id="collapse<?php echo $count; ?>" class="accordion-collapse collapse <?php if ( $post_id == get_the_ID() ) { echo 'show'; } ?>" aria-labelledby="heading<?php echo $count; ?>" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <ul>
                    <?php
                      $section  = 0;
                      $first    = true;

                      $groups   = array();
                      $groups[] = get_field('grupo_1');
                      $groups[] = get_field('grupo_2');
                      $groups[] = get_field('grupo_3');
                    ?>
                    <?php foreach ($groups as $group) : $section++; ?>
                      <?php if ( $group['title'] ) : ?>
                        <?php
                          if ( $first && $post_id != get_the_ID() ) {
                            $hash = '';
                            $first = false;
                          } else {
                            $hash = '#section' . $section;
                          }
                        ?>
                        <li><a href="<?php echo get_the_permalink() . $hash; ?>"><?php echo $group['title']; ?></a></li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
    </div>

  </div>
</main>
<?php get_footer(); ?>