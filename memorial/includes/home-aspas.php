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
    'posts_per_page'      => 10,
    'orderby'             => 'menu_order',
    'order'               => 'ASC',
    'ignore_sticky_posts' => true,
]);

if (! $query->have_posts()) {
    return;
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?> pb-5">
    <div class="container-aspas">
        <div class="aspas-slider js-aspas-slider">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                $autor = get_field('autor');
                $url   = get_field('link_da_colecao');
                ?>
                <div class="aspas-slider__item">
                    <article class="aspa-card">
                        <blockquote class="aspa-card__content">
                            <?php the_content(); ?>
                        </blockquote>

                        <?php if ($autor) : ?>
                            <cite>
                                <?php echo esc_html($autor); ?>
                            </cite>
                        <?php endif; ?>

                        <?php if ($url) : ?>
                            <div class="mt-3">
                                <a class="btn btn-primary" href="<?php echo esc_url($url); ?>">
                                    Ver coleção
                                </a>
                            </div>
                        <?php endif; ?>
                    </article>
                </div>
            <?php endwhile; ?>
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