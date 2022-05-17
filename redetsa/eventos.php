<?php
/***
Template Name: Eventos
***/
?>
<?php
$counts = 0;

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
      </div>
      <div class="col-md-4 col-lg-3 order-md-first">
        <div class="accordion sticky-top" id="accordionExample">
          <?php if ($events->have_posts()): while ($events->have_posts()) : $events->the_post(); $counts++; ?>
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading<?php echo $counts; ?>">
                <button class="accordion-button <?php if ( $counts > 1 ) { echo 'collapsed'; } ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $counts; ?>" aria-expanded="<?php echo ( $counts == 1 ) ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $counts; ?>">
                  <?php the_title(); ?>
                </button>
              </h2>
              <div id="collapse<?php echo $counts; ?>" class="accordion-collapse collapse <?php if ( $counts == 1 ) { echo 'show'; } ?>" aria-labelledby="heading<?php echo $counts; ?>" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <ul>
                    <?php
                    $section  = 0;
                    $first    = true;
                    $fields = get_fields();
                    $count = count($fields);

                    $groups   = array();
                    for ($i=1; $i <= $count; $i++) { 
                      $groups[] = get_field('grupo_'.$i);
                    }
                    ?>
                    <?php foreach ($groups as $group) : $section++; ?>
                      <?php if ( $group['title'] ) : ?>
                        <?php
                        if ( $first ) {
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