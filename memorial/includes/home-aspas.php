<?php
/**
 * Bloco: Aspas Slider
 */

$block_id = 'aspas-slider-' . $block['id'];
$classes = 'block-aspas-slider';

if (! empty($block['className'])) {
    $classes .= ' ' . $block['className'];
}

if (! empty($block['align'])) {
    $classes .= ' align' . $block['align'];
}

$query = new WP_Query([
    'post_type'           => 'aspas',
    'post_status'         => 'publish',
    'posts_per_page'      => 3,
    'orderby'             => 'menu_order',
    'orderby'             => 'rand',
    'ignore_sticky_posts' => true,
]);

if (! $query->have_posts()) {
    return;
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?> pb-5">
    <div class="container pt-5">
        <h2 class="title text-center">Vozes da Pandemia</h2>
        <div class="row g-4" id="colecoes">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                $autor = get_field('autor');
                $url   = get_field('link_da_colecao');
                ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card h-100 shadow-sm">

                        <div class="card-body d-flex flex-column text-center">
                            <h2 class="h5 card-title">
                                <a href="<?php echo esc_url($url); ?>" class="text-decoration-none">
                                    <?php the_title(); ?>
                                    <hr>
                                </a>
                            </h2>

                            <p class="card-text text-muted">
                                <?php the_content(); ?>
                                <?php echo esc_html($autor); ?>
                            </p>
                            <div class="mt-auto">
                                <a href="<?php echo esc_url($url); ?>" class="btn btn-primary mb-3">
                                 Coleção:  <i><?php echo esc_html($colecao); ?></i>
                             </a>
                         </div>
                     </div>
                 </article>
             </div>
         <?php endwhile; ?>
     </div>
     <div class="row mt-5">
        <div class="col-md-8 offset-md-2 text-center">
            
            O <b>Memorial Digital da Pandemia de COVID-19</b> reúne depoimentos de cidadãos, profissionais de saúde e familiares sobre suas experiências, memórias e vivências durante a pandemia, preservando histórias e reflexões sobre esse período marcante da história.
        </p>
        <h4 class="text-center mt-5">
        </div>
    </div>
</div>
</section>

<?php wp_reset_postdata(); ?>


<style>
    .container-aspas{
        width: 772px;
        margin: auto;
    }
    .block-aspas-slider {
        margin: 40px 0;
    }
    .aspas-slider__item {
        padding: 0 12px;
        box-sizing: border-box;
        width: 50%;
    }
    .aspa-card {
        padding: 32px;
        text-align: center;
    }
    .aspa-card__content {
        font-size: 1.125rem;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .aspa-card__autor {
        font-weight: 700;
        margin: 0 0 20px;
    }
    .aspa-card__actions {
        margin-top: 20px;
    }
    blockquote::after {
        content: "”";
        position: absolute;
        bottom: -2rem;
        right: -0.5rem;
        font-size: 4rem;
        font-weight: bold;
        line-height: 1;
        font-family: none;
    }
</style>

<script>
    jQuery(function ($) {
        $('.js-aspas-slider').each(function () {
            var $slider = $(this);
            if ($slider.hasClass('slick-initialized')) {
                return;
            }
            $slider.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                dots: true,
                infinite: true,
                adaptiveHeight: true,
                autoplay: false,
                speed: 500
            });
        });
    });
</script>