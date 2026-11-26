
<?php
/**
 * Memorial Digital da Pandemia de COVID-19
 * Componente compartilhado de cards de notícias.
 */

$idioma = function_exists('pll_current_language')
    ? pll_current_language('slug')
    : 'pt';

$traducoes = [
    'pt' => [
        'ler' => 'Ler notícia',
        'categoria' => 'Ver publicações da categoria',
    ],
    'en' => [
        'ler' => 'Read news',
        'categoria' => 'View posts in category',
    ],
    'es' => [
        'ler' => 'Leer noticia',
        'categoria' => 'Ver publicaciones de la categoría',
    ],
];

$textos = $traducoes[$idioma] ?? $traducoes['pt'];

$post_url = get_permalink();
$post_title = get_the_title();
$categories = get_the_category();

$image_class = !empty($args['fixed_image'])
    ? 'card-img-top card-img-fixed'
    : 'card-img-top';
?>

<article class="col">

    <div class="card h-100 memorial-news-card">

        <!-- Imagem -->
        <a href="<?php echo esc_url($post_url); ?>"
           class="d-block"
           aria-label="<?php echo esc_attr($post_title); ?>">

            <?php if (has_post_thumbnail()) : ?>

                <?php the_post_thumbnail(
                    'medium',
                    ['class' => $image_class]
                ); ?>

            <?php else : ?>

                <img
                    src="<?php echo esc_url(
                        get_template_directory_uri() .
                        '/img/blog-default.jpg'
                    ); ?>"
                    class="<?php echo esc_attr($image_class); ?>"
                    alt="<?php echo esc_attr($post_title); ?>"
                >

            <?php endif; ?>

        </a>

        <div class="card-body home-news-body">

            <!-- Categorias -->
            <?php if (!empty($categories)) : ?>

                <div class="home-news-categories">

                    <?php foreach (
                        array_slice($categories, 0, 3)
                        as $category
                    ) :

                        $category_url = get_category_link(
                            $category->term_id
                        );

                        if (is_wp_error($category_url)) {
                            continue;
                        }
                    ?>

                        <a
                            href="<?php echo esc_url($category_url); ?>"
                            class="home-news-category"
                            aria-label="<?php echo esc_attr(
                                $textos['categoria'] .
                                ' ' .
                                $category->name
                            ); ?>"
                        >
                            <?php echo esc_html($category->name); ?>
                        </a>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

            <!-- Título -->
            <h5 class="card-title mb-2">

                <a
                    href="<?php echo esc_url($post_url); ?>"
                    class="text-decoration-none text-dark"
                >
                    <?php the_title(); ?>
                </a>

            </h5>

            <!-- Resumo -->
            <div class="card-text home-news-excerpt">

                <?php the_excerpt(); ?>

            </div>

            <!-- Rodapé -->
            <div class="home-news-card-footer">

                <a
                    href="<?php echo esc_url($post_url); ?>"
                    class="home-news-arrow"
                    aria-label="<?php echo esc_attr(
                        $textos['ler'] . ': ' . $post_title
                    ); ?>"
                >

                    <img
                        src="<?php echo esc_url(
                            get_template_directory_uri() .
                            '/img/icon-right.svg'
                        ); ?>"
                        class="btn-more"
                        alt=""
                        aria-hidden="true"
                    >

                </a>

            </div>

        </div>

    </div>

</article>
