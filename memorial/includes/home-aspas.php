<?php
/**
* Bloco: Aspas Slider
*/

// Segurança: se não veio do ACF, sai
if (! isset($block) || empty($block)) {
    return;
}

// Verifica se o bloco está ativo no painel
if (get_option('memorial_aspas_slider_ativo', '1') !== '1') {
    if (is_admin()) {
        echo '<p style="padding:20px;color:#c00;text-align:center;background:#fff3f3;border:1px solid #c00;border-radius:8px;">⚠ O bloco <strong>Aspas Slider</strong> está desativado nas configurações (Ajustes &gt; Memorial Tainacan).</p>';
    }
    return;
}

$block_id = 'aspas-slider-' . $block['id'];
$classes  = 'block-aspas-slider';

if (! empty($block['className'])) {
    $classes .= ' ' . $block['className'];
}

if (! empty($block['align'])) {
    $classes .= ' align' . $block['align'];
}

// Tenta ler as aspas selecionadas no campo do bloco
$selected = function_exists('get_field') ? get_field('aspas_selecionadas') : null;
$cor_aspas = function_exists('get_field') ? get_field('cor_aspas') : '';
if (empty($cor_aspas)) $cor_aspas = '#4e9a51';

if (! empty($selected) && is_array($selected)) {
    $post_ids = array_map(function ($p) {
        return is_object($p) ? $p->ID : (int) $p;
    }, $selected);

    $query = new WP_Query([
        'post_type'           => 'aspas',
        'post_status'         => 'publish',
        'post__in'            => $post_ids,
        'orderby'             => 'post__in',
        'posts_per_page'      => count($post_ids),
        'ignore_sticky_posts' => true,
    ]);
} else {
    $query = new WP_Query([
        'post_type'           => 'aspas',
        'post_status'         => 'publish',
        'posts_per_page'      => 6,
        'orderby'             => 'rand',
        'ignore_sticky_posts' => true,
    ]);
}

if (! $query->have_posts()) {
    echo '<p style="padding:20px;color:#999;text-align:center;">Nenhuma aspa encontrada.</p>';
    return;
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?> pb-5">
    <div class="container pt-5">
        <h2 class="title text-center">Vozes da Pandemia</h2>
        <div class="aspas-slider-wrap js-aspas-slider">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                $autor   = get_field('autor',get_the_ID());
                $colecao =  get_field('colecao',get_the_ID());
                $url     = get_field('link_da_colecao',get_the_ID());

                $raw_content = get_post_field('post_content', get_the_ID());
                $rendered    = apply_filters('the_content', $raw_content);
                $clean       = wp_strip_all_tags($rendered);
                $clean       = trim(preg_replace('/\s+/', ' ', $clean));
                $text        = wp_trim_words($clean, 35, '...');
                ?>
                <div class="aspas-slide">
                    <article class="aspas-card">
                        <div class="aspas-card-img">
                            <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid w-100']); ?>
                        </div>
                        <div class="aspas-card-body">
                            <div class="aspas-card-quote-icon">
                                <svg width="48" height="38" viewBox="0 0 48 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 38V22.8C0 18.7 0.72 14.9 2.16 11.4C3.68 7.82 5.92 4.4 8.88 1.16L16.08 5.92C13.84 8.38 12.08 10.84 10.8 13.3C9.6 15.68 8.96 18.14 8.88 20.68H19.2V38H0ZM28.8 38V22.8C28.8 18.7 29.52 14.9 30.96 11.4C32.48 7.82 34.72 4.4 37.68 1.16L44.88 5.92C42.64 8.38 40.88 10.84 39.6 13.3C38.4 15.68 37.76 18.14 37.68 20.68H48V38H28.8Z" fill="<?php echo esc_attr($cor_aspas); ?>"/>
                                </svg>
                            </div>
                            <p class="aspas-card-text"><?php echo esc_html($text); ?><span class="aspas-card-quote-close"><svg width="20" height="16" viewBox="0 0 48 38" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M48 0V15.2C48 19.3 47.28 23.1 45.84 26.6C44.32 30.18 42.08 33.6 39.12 36.84L31.92 32.08C34.16 29.62 35.92 27.16 37.2 24.7C38.4 22.32 39.04 19.86 39.12 17.32H28.8V0H48ZM19.2 0V15.2C19.2 19.3 18.48 23.1 17.04 26.6C15.52 30.18 13.28 33.6 10.32 36.84L3.12 32.08C5.36 29.62 7.12 27.16 8.4 24.7C9.6 22.32 10.24 19.86 10.32 17.32H0V0H19.2Z" fill="<?php echo esc_attr($cor_aspas); ?>"/></svg></span></p>
                            <?php if ($autor) : ?>
                                <p class="aspas-card-author"><?php echo esc_html($autor); ?></p>
                            <?php endif; ?>
                            <?php if ($colecao) : ?>
                                <?php if ($url) : ?>
                                    <a href="<?php echo esc_url($url); ?>" class="aspas-card-link">
                                        <?php echo esc_html($colecao); ?>
                                    </a>
                                <?php else : ?>
                                    <span class="aspas-card-link aspas-card-link--static">
                                        <?php echo esc_html($colecao); ?>
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="row mt-5">
            <div class="col-md-8 offset-md-2 text-center">
                <p>
                    O <b>Memorial Digital da Pandemia de COVID-19</b> reúne depoimentos de cidadãos, profissionais de saúde e familiares sobre suas experiências, memórias e vivências durante a pandemia, preservando histórias e reflexões sobre esse período marcante da história.
                </p>
                <a href="<?php echo esc_url( $blog_url ); ?>/vozes-da-pandemia" class="btn btn-primary">
                    Ver todas
                </a>
            </div>
        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>

<script>
jQuery(function ($) {
    $('.js-aspas-slider').each(function () {
        var $slider = $(this);
        if ($slider.hasClass('slick-initialized')) return;
        $slider.slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            dots: true,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 5000,
            speed: 500,
            responsive: [
                { breakpoint: 992, settings: { slidesToShow: 2 } },
                { breakpoint: 576, settings: { slidesToShow: 1 } }
            ]
        });
    });
});
</script>