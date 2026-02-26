<?php
/**
 * Home Hero - 3 Coleções Aleatórias
 * CPT: colecoes
 */
$hero_query = new WP_Query([
    'post_type'      => 'colecoes',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'orderby'        => 'rand',
    'no_found_rows'  => true,
]);

$hero_posts = [];

if ($hero_query->have_posts()) {
    while ($hero_query->have_posts()) {
        $hero_query->the_post();

        $post_id = get_the_ID();

        $hero_posts[] = [
            'id'      => $post_id,
            'title'   => get_the_title(),
            'link'    => get_permalink(),
            'excerpt' => get_the_excerpt(),
            'thumb'   => get_the_post_thumbnail_url($post_id, 'large'),
        ];
    }
}

wp_reset_postdata();

// Se não tiver 3 coleções ainda, não exibe a seção (evita layout quebrado)
if (count($hero_posts) === 3) :

    // Função helper local para limitar texto
    $trim_text = function($text, $words = 18) {
        $text = wp_strip_all_tags((string) $text);
        return wp_trim_words($text, $words, '…');
    };

    // Item grande = 0
    $big = $hero_posts[0];

    // Itens pequenos = 1 e 2
    $small1 = $hero_posts[1];
    $small2 = $hero_posts[2];
?>

<section id="home-hero" class="colecoes py-4">
  <div class="container">
    <div class="row g-3 align-items-stretch">

      <!-- COLUNA ESQUERDA (card grande) -->
      <div class="col-lg-7">
        <a href="<?php echo esc_url($big['link']); ?>" class="card overlay-card big text-white h-100">
          <img src="<?php echo esc_url($big['thumb']); ?>" class="card-img" alt="<?php echo esc_attr($big['title']); ?>">
          <div class="card-img-overlay d-flex flex-column justify-content-end">
            <p class="eyebrow mb-1"><?php echo esc_html($big['title']); ?></p>
            <h5 class="mb-0">
              <?php echo esc_html($trim_text($big['excerpt'], 14)); ?>
            </h5>
          </div>
        </a>
      </div>

      <!-- COLUNA DIREITA (dois cards) -->
      <div class="col-lg-5 d-flex flex-column gap-3">

        <a href="<?php echo esc_url($small1['link']); ?>" class="card overlay-card text-white flex-fill">
          <img src="<?php echo esc_url($small1['thumb']); ?>" class="card-img" alt="<?php echo esc_attr($small1['title']); ?>">
          <div class="card-img-overlay d-flex flex-column justify-content-end">
            <p class="eyebrow mb-1"><?php echo esc_html($small1['title']); ?></p>
            <h6 class="mb-0">
              <?php echo esc_html($trim_text($small1['excerpt'], 18)); ?>
            </h6>
          </div>
        </a>

        <a href="<?php echo esc_url($small2['link']); ?>" class="card overlay-card text-white flex-fill">
          <img src="<?php echo esc_url($small2['thumb']); ?>" class="card-img" alt="<?php echo esc_attr($small2['title']); ?>">
          <div class="card-img-overlay d-flex flex-column justify-content-end">
            <p class="eyebrow mb-1"><?php echo esc_html($small2['title']); ?></p>
            <h6 class="mb-0">
              <?php echo esc_html($trim_text($small2['excerpt'], 18)); ?>
            </h6>
          </div>
        </a>

      </div>
    </div>

    <div class="mt-3 text-center mt-5 mb-5">
      <a href="<?php echo esc_url(get_post_type_archive_link('colecoes')); ?>" class="btn btn-primary">
        Ver todas
      </a>
    </div>
  </div>
</section>

<?php endif; ?>
