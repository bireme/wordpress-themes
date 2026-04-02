<?php
/**
 * Memorial - Aspas
 */
add_action('init', 'memorial_register_cpt_aspas');

function memorial_register_cpt_aspas(): void
{
    $labels = [
        'name'                  => 'Aspas',
        'singular_name'         => 'Aspa',
        'menu_name'             => 'Aspas',
        'name_admin_bar'        => 'Aspa',
        'add_new'               => 'Adicionar nova',
        'add_new_item'          => 'Adicionar nova aspa',
        'new_item'              => 'Nova aspa',
        'edit_item'             => 'Editar aspa',
        'view_item'             => 'Ver aspa',
        'all_items'             => 'Todas as aspas',
        'search_items'          => 'Pesquisar aspas',
        'not_found'             => 'Nenhuma aspa encontrada.',
        'not_found_in_trash'    => 'Nenhuma aspa encontrada na lixeira.',
        'featured_image'        => 'Imagem destacada',
        'set_featured_image'    => 'Definir imagem destacada',
        'remove_featured_image' => 'Remover imagem destacada',
        'use_featured_image'    => 'Usar como imagem destacada',
        'archives'              => 'Arquivos de aspas',
        'items_list'            => 'Lista de aspas',
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-format-quote',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'],
        'rewrite'             => [
            'slug'       => 'aspas',
            'with_front' => false,
        ],
        'has_archive'         => true,
        'hierarchical'        => false,
        'show_in_rest'        => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'query_var'           => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
    ];

    register_post_type('aspas', $args);
}

/**
 * Registra o bloco ACF + campo de seleção
 */
add_action('acf/init', 'memorial_register_aspas_block_and_fields');
function memorial_register_aspas_block_and_fields()
{
    // Registra o bloco
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type([
            'name'            => 'aspas-slider',
            'title'           => 'Aspas Slider',
            'description'     => 'Exibe depoimentos (aspas) selecionados.',
            'render_template' => get_stylesheet_directory() . '/includes/home-aspas.php',
            'category'        => 'formatting',
            'icon'            => 'format-quote',
            'keywords'        => ['aspas', 'vozes', 'depoimento', 'slider'],
            'mode'            => 'preview',
            'supports'        => [
                'align' => true,
            ],
            'enqueue_assets'  => function () {
                wp_enqueue_style('bootstrap-block', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
                wp_enqueue_style('memorial-block-style', get_stylesheet_directory_uri() . '/css/style.css', ['bootstrap-block']);
            },
        ]);
    }

    // Registra o campo de seleção de aspas (bloco)
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group([
            'key'      => 'group_aspas_slider_block',
            'title'    => 'Aspas Slider - Configurações',
            'fields'   => [
                [
                    'key'           => 'field_aspas_selecionadas',
                    'label'         => 'Selecionar Aspas',
                    'name'          => 'aspas_selecionadas',
                    'type'          => 'relationship',
                    'instructions'  => 'Escolha quais depoimentos exibir. Se nenhum for selecionado, serão exibidos 3 aleatórios.',
                    'post_type'     => ['aspas'],
                    'filters'       => ['search'],
                    'return_format' => 'object',
                    'min'           => 0,
                    'max'           => '',
                ],
                [
                    'key'           => 'field_aspas_cor_icone',
                    'label'         => 'Cor das Aspas',
                    'name'          => 'cor_aspas',
                    'type'          => 'color_picker',
                    'instructions'  => 'Escolha a cor dos ícones de aspas nos cards.',
                    'default_value' => '#4e9a51',
                    'enable_opacity' => 0,
                ],
            ],
            'location' => [
                [
                    [
                        'param'    => 'block',
                        'operator' => '==',
                        'value'    => 'acf/aspas-slider',
                    ],
                ],
            ],
        ]);


    }
}

/**
 * Shortcode [aspas_slider]
 *
 * Atributos:
 *   ids   = "12,34,56"  (IDs dos posts aspas; se vazio, exibe 6 aleatórios)
 *   cor   = "#4e9a51"   (cor das aspas; padrão verde)
 *   total = "6"         (quantidade quando aleatório)
 */
add_shortcode('aspas_slider', 'memorial_aspas_slider_shortcode');
function memorial_aspas_slider_shortcode($atts)
{
    $atts = shortcode_atts([
        'ids'   => '',
        'cor'   => '#4e9a51',
        'total' => 6,
    ], $atts, 'aspas_slider');

    if (get_option('memorial_aspas_slider_ativo', '1') !== '1') {
        return '';
    }

    $cor_aspas = sanitize_hex_color($atts['cor']) ?: '#4e9a51';

    if (! empty($atts['ids'])) {
        $post_ids = array_map('intval', explode(',', $atts['ids']));
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
            'posts_per_page'      => absint($atts['total']),
            'orderby'             => 'rand',
            'ignore_sticky_posts' => true,
        ]);
    }

    if (! $query->have_posts()) {
        return '';
    }

    $uid = 'aspas-slider-sc-' . wp_unique_id();

    ob_start();
    ?>
    <section id="<?php echo esc_attr($uid); ?>" class="block-aspas-slider pb-5">
        <div class="container pt-5">
            <h2 class="title text-center">Vozes da Pandemia</h2>
            <div class="aspas-slider-wrap js-aspas-slider">
                <?php while ($query->have_posts()) : $query->the_post();
                    $autor   = get_field('autor', get_the_ID());
                    $colecao = get_field('colecao', get_the_ID());
                    $url     = get_field('link_da_colecao', get_the_ID());

                    $raw_content = get_post_field('post_content', get_the_ID());
                    $rendered    = apply_filters('the_content', $raw_content);
                    $clean       = wp_strip_all_tags($rendered);
                    $clean       = trim(preg_replace('/\s+/', ' ', $clean));
                    $text        = wp_trim_words($clean, 35, '...');
                ?>
                    <div class="aspas-slide">
                        <article class="aspas-card">
                            <div class="aspas-card-img">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid w-100']); ?>
                                </a>
                            </div>
                            <div class="aspas-card-body">
                                <div class="aspas-card-quote-icon">
                                    <svg width="48" height="38" viewBox="0 0 48 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 38V22.8C0 18.7 0.72 14.9 2.16 11.4C3.68 7.82 5.92 4.4 8.88 1.16L16.08 5.92C13.84 8.38 12.08 10.84 10.8 13.3C9.6 15.68 8.96 18.14 8.88 20.68H19.2V38H0ZM28.8 38V22.8C28.8 18.7 29.52 14.9 30.96 11.4C32.48 7.82 34.72 4.4 37.68 1.16L44.88 5.92C42.64 8.38 40.88 10.84 39.6 13.3C38.4 15.68 37.76 18.14 37.68 20.68H48V38H28.8Z" fill="<?php echo esc_attr($cor_aspas); ?>"/>
                                    </svg>
                                </div>
                                <p class="aspas-card-text"><a href="<?php the_permalink(); ?>"><?php echo esc_html($text); ?></a><span class="aspas-card-quote-close"><svg width="20" height="16" viewBox="0 0 48 38" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M48 0V15.2C48 19.3 47.28 23.1 45.84 26.6C44.32 30.18 42.08 33.6 39.12 36.84L31.92 32.08C34.16 29.62 35.92 27.16 37.2 24.7C38.4 22.32 39.04 19.86 39.12 17.32H28.8V0H48ZM19.2 0V15.2C19.2 19.3 18.48 23.1 17.04 26.6C15.52 30.18 13.28 33.6 10.32 36.84L3.12 32.08C5.36 29.62 7.12 27.16 8.4 24.7C9.6 22.32 10.24 19.86 10.32 17.32H0V0H19.2Z" fill="<?php echo esc_attr($cor_aspas); ?>"/></svg></span></p>
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
                    <a href="<?php echo esc_url(home_url('/vozes-da-pandemia')); ?>" class="btn btn-primary">
                        Ver todas
                    </a>
                </div>
            </div>
        </div>
    </section>
    <script>
    jQuery(function ($) {
        $('#<?php echo esc_js($uid); ?> .js-aspas-slider').each(function () {
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
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}