<?php
/**
 * Dobra: Listagem de Notícias
 * Slug esperado: pagina-listagem_de_noticias
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Ordenação via ACF
$ordenar_mais_recente = get_sub_field('ativar_listagem_de_posts_do_mais_recente_para_mais_antigo');
$order = ($ordenar_mais_recente === 'Não') ? 'ASC' : 'DESC';

// Paginação
$paged = max(1, get_query_var('paged'), get_query_var('page'));

// Posts por página
$posts_per_page = get_option('posts_per_page', 9);

$args = [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
    'orderby'        => 'date',
    'order'          => $order,
    'paged'          => $paged,
];

$query = new WP_Query($args);
?>

<style>
/* ========= LISTAGEM BLOG LILACS – UX/UI ========= */

.lilacs-blog-listagem {
    max-width: 1200px;
    margin: 0 auto 60px;
    padding: 32px 16px;
    font-family: system-ui, sans-serif;
}

.lilacs-blog-listagem-header {
    text-align: center;
    margin-bottom: 32px;
}

.lilacs-blog-listagem-title {
    font-size: 2rem;
    font-weight: 700;
    color: #222;
    margin-bottom: 8px;
}

.lilacs-blog-listagem-subtitle {
    font-size: 1rem;
    color: #555;
}

/* GRID */

.lilacs-blog-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 24px;
}

/* CARD */

.lilacs-blog-card {
    background: #fff;
    border-radius: 12px;
    padding: 22px 20px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    transition: .20s ease;
    display: flex;
    flex-direction: column;
    position: relative;
}

.lilacs-blog-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 26px rgba(0,0,0,0.10);
}

/* DATA — alinhada à direita */

.lilacs-blog-card-date {
    font-size: .78rem;
    color: #666;
    position: absolute;
    top: 16px;
    right: 20px;
    background: #f0f2f6;
    padding: 4px 8px;
    border-radius: 999px;
}

/* TÍTULO */

.lilacs-blog-card-title {
    font-size: 1.15rem;
    font-weight: 600;
    margin: 32px 0 8px; /* sobe por causa da data */
}

.lilacs-blog-card-title a {
    color: #222;
    text-decoration: none;
}

.lilacs-blog-card-title a:hover {
    text-decoration: underline;
}

/* EXCERPT */

.lilacs-blog-card-excerpt {
    color: #555;
    font-size: .95rem;
    margin-bottom: 16px;
    flex: 1;
}

/* BOTÃO — apenas “Ler mais” */

.lilacs-blog-card-readmore {
    background: #005aa7;
    color: #fff;
    text-decoration: none;
    padding: 9px 16px;
    border-radius: 999px;
    font-size: .85rem;
    display: inline-block;
    width: fit-content;
    transition: .18s ease;
}

.lilacs-blog-card-readmore:hover {
    background: #004684;
}

/* PAGINAÇÃO */

.lilacs-blog-pagination {
    margin-top: 32px;
    display: flex;
    justify-content: center;
}

.lilacs-blog-pagination-list {
    list-style: none;
    display: flex;
    gap: 6px;
    padding: 0;
}

.lilacs-blog-pagination-item a,
.lilacs-blog-pagination-item span {
    padding: 6px 12px;
    border-radius: 999px;
    border: 1px solid #ddd;
    font-size: .85rem;
    text-decoration: none;
    color: #444;
}

.lilacs-blog-pagination-item span.current,
.lilacs-blog-pagination-item a:hover {
    background: #005aa7;
    color: #fff;
    border-color: #005aa7;
}

/* RESPONSIVO */

@media (max-width: 768px) {
    .lilacs-blog-card-date {
        right: 16px;
        top: 14px;
    }
}
</style>

<section class="lilacs-blog-listagem">


    <?php if ( $query->have_posts() ) : ?>
        <div class="lilacs-blog-cards-grid">

            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php
                    $post_id = get_the_ID();
                    $permalink = get_permalink();
                    $title = get_the_title();
                    $date = get_the_date();
                    $excerpt = wp_trim_words(get_the_excerpt(), 30, '…');
                ?>
                
                <article class="lilacs-blog-card">

                    <!-- DATA NA DIREITA -->
                    <span class="lilacs-blog-card-date"><?= esc_html($date); ?></span>

                    <h3 class="lilacs-blog-card-title">
                        <a href="<?= esc_url($permalink); ?>"><?= esc_html($title); ?></a>
                    </h3>

                    <p class="lilacs-blog-card-excerpt"><?= esc_html($excerpt); ?></p>

                    <a href="<?= esc_url($permalink); ?>" class="lilacs-blog-card-readmore">
                        Ler mais
                    </a>
                </article>

            <?php endwhile; ?>

        </div>

        <?php
        // paginação
        $big = 999999999;
        $pagination_links = paginate_links([
            'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'    => '?paged=%#%',
            'current'   => $paged,
            'total'     => $query->max_num_pages,
            'prev_text' => '← Anterior',
            'next_text' => 'Próxima →',
            'type'      => 'array',
        ]);
        ?>

        <?php if ( !empty($pagination_links) ) : ?>
            <nav class="lilacs-blog-pagination">
                <ul class="lilacs-blog-pagination-list">
                    <?php foreach ( $pagination_links as $link ) : ?>
                        <li class="lilacs-blog-pagination-item"><?= $link; ?></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>

    <?php else : ?>

        <p style="text-align:center; padding:30px;">Nenhuma notícia encontrada.</p>

    <?php endif; ?>

</section>

<?php wp_reset_postdata(); ?>
