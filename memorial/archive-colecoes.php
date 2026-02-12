<?php
/**
 * Template: Archive Coleções
 * CPT: colecoes
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header("interno");

// Monta uma query custom para ordenar:
$paged = (get_query_var('paged')) ? (int) get_query_var('paged') : 1;

// Ordenação:
// - Destaques primeiro (_memorial_destaque_home = 1)
// - Ordem do destaque crescente (_memorial_ordem_destaque)
// - Data desc
$args = [
    'post_type'      => 'colecoes',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'paged'          => $paged,
    'meta_query'     => [
        'relation' => 'OR',
        [
            'key'     => '_memorial_destaque_home',
            'compare' => 'EXISTS',
        ],
        [
            'key'     => '_memorial_destaque_home',
            'compare' => 'NOT EXISTS',
        ],
    ],
    'meta_key'       => '_memorial_destaque_home',
    'orderby'        => [
        'meta_value_num' => 'DESC', // 1 vem antes de 0
        'meta_value'     => 'DESC',
        'date'           => 'DESC',
    ],
];

$query = new WP_Query($args);

?>

<main class="container">
<div class="breadcrumb mt-3">
			<?php if (function_exists('bcn_display')) { bcn_display(); } ?>
		</div>
    <header class="mb-4">
        <h1 class="mb-2"><?php post_type_archive_title(); ?></h1>
        <p class="text-muted mb-0">
            Conheça as coleções do Memorial. Selecione uma coleção para ver o release editorial e os itens do acervo no Tainacan.
        </p>
    </header>

    <?php if ($query->have_posts()) : ?>
        <div class="row g-4">

            <?php while ($query->have_posts()) : $query->the_post();

                $post_id = get_the_ID();

                $is_featured = get_post_meta($post_id, '_memorial_destaque_home', true) === '1';
                $order_featured = get_post_meta($post_id, '_memorial_ordem_destaque', true);

                $thumb = get_the_post_thumbnail_url($post_id, 'large');
                $link  = get_permalink($post_id);

                $excerpt = get_the_excerpt();
                if (empty($excerpt)) {
                    $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 20, '…');
                }

            ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card h-100 shadow-sm">
                        <?php if (!empty($thumb)) : ?>
                            <a href="<?php echo esc_url($link); ?>" class="text-decoration-none">
                                <img
                                    src="<?php echo esc_url($thumb); ?>"
                                    class="card-img-top"
                                    alt="<?php echo esc_attr(get_the_title()); ?>"
                                    loading="lazy"
                                    style="object-fit: cover; height: 220px;"
                                />
                            </a>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h2 class="h5 card-title">
                                <a href="<?php echo esc_url($link); ?>" class="text-decoration-none">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <?php if (!empty($excerpt)) : ?>
                                <p class="card-text text-muted">
                                    <?php echo esc_html($excerpt); ?>
                                </p>
                            <?php endif; ?>
                            <div class="mt-auto">
                                <a href="<?php echo esc_url($link); ?>" class="btn btn-outline-primary">
                                    Ver coleção
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>
        <!-- Paginação -->
        <div class="mt-5">
            <?php
            $pagination = paginate_links([
                'total'   => $query->max_num_pages,
                'current' => $paged,
                'type'    => 'list',
            ]);

            if ($pagination) {
                // Adaptação leve para Bootstrap
                echo '<nav class="d-flex justify-content-center">' . $pagination . '</nav>';
            }
            ?>
        </div>
    <?php else : ?>
        <div class="alert alert-info">
            Nenhuma coleção cadastrada ainda.
        </div>
    <?php endif; ?>
</main>
<?php wp_reset_postdata();
get_footer();
?>