<?php
/**
 * Archive: Vozes da Rede (CPT voz-da-rede)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$banner_img = get_template_directory_uri() . '/assets/post-default.png';

// Filtro por taxonomia
$filtro_slug = isset( $_GET['categoria'] ) ? sanitize_text_field( wp_unslash( $_GET['categoria'] ) ) : '';
$sort        = isset( $_GET['sort'] ) ? sanitize_text_field( wp_unslash( $_GET['sort'] ) ) : 'recent';
$paged       = max( 1, (int) get_query_var( 'paged' ) );

$query_args = array(
    'post_type'      => 'voz-da-rede',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'paged'          => $paged,
);

// Ordenação
if ( $sort === 'az' ) {
    $query_args['orderby'] = 'title';
    $query_args['order']   = 'ASC';
} elseif ( $sort === 'za' ) {
    $query_args['orderby'] = 'title';
    $query_args['order']   = 'DESC';
} else {
    $query_args['orderby'] = 'date';
    $query_args['order']   = 'DESC';
}

if ( $filtro_slug ) {
    $query_args['tax_query'] = array(
        array(
            'taxonomy' => 'categorias-vozes-da-rede',
            'field'    => 'slug',
            'terms'    => $filtro_slug,
        ),
    );
}

$vozes_query = new WP_Query( $query_args );

// Termos disponíveis para o filtro
$vozes_terms = get_terms( array(
    'taxonomy'   => 'categorias-vozes-da-rede',
    'hide_empty' => true,
) );
if ( is_wp_error( $vozes_terms ) ) {
    $vozes_terms = array();
}
?>

<style>
/* ==================== BANNER ==================== */

.vozes-archive-banner {
    padding: 0;
    background: transparent;
}

.vozes-archive-banner-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

.vozes-archive-banner-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 10px 90px 10px 10px;
    background-color: #e4e7f0;
}

.vozes-archive-banner-image {
    width: 100%;
    height: 285px;
    background-size: cover;
    background-position: center center;
}

.vozes-archive-banner-text {
    color: #ffffff;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    background: #29367dc2;
    position: absolute;
    inset: 0;
    padding: 22px 20px 0;
}

.vozes-archive-banner-text h1 {
    font-size: 36px;
    font-weight: 700;
    margin: 0;
}

.vozes-archive-breadcrumb {
    margin-bottom: 14px;
}

/* ==================== GRID ==================== */

.vozes-archive-wrap {
    max-width: 1180px;
    margin: 48px auto;
    padding: 0 16px;
}

.vozes-archive-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

/* ==================== CARD ==================== */

.vozes-archive-card {
    background: #F5F5F5;
    border-radius: 10px 60px 10px 10px;
    padding: 28px 26px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    transition: transform .2s, box-shadow .2s;
}

.vozes-archive-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
}

/* Header: avatar + info */
.vozes-card-header {
    display: flex;
    align-items: center;
    gap: 14px;
}

.vozes-card-avatar img {
    width: 64px;
    height: 64px;
    object-fit: cover;
    border-radius: 50%;
}

.vozes-card-avatar-placeholder {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #dde1ea;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8892a8;
    font-size: 24px;
}

.vozes-card-author strong {
    display: block;
    color: #233a8b;
    font-size: 15px;
    line-height: 1.3;
}

.vozes-card-author span {
    font-size: 13px;
    color: #777;
}

/* Texto do depoimento */
.vozes-card-texto {
    font-size: 14px;
    color: #444;
    line-height: 1.65;
}

.vozes-card-texto p:first-child {
    margin-top: 0;
}

.vozes-card-texto p:last-child {
    margin-bottom: 0;
}

/* ==================== PAGINAÇÃO ==================== */

.vozes-archive-pagination {
    margin-top: 40px;
    text-align: center;
}

.vozes-archive-pagination .page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 16px;
    margin: 0 4px;
    background: #F0F3FA;
    border-radius: 10px;
    text-decoration: none;
    font-size: 15px;
    color: #0056A6;
    font-weight: 600;
    transition: all .2s ease;
}

.vozes-archive-pagination .page-numbers:hover {
    background: #dce4f3;
    color: #003c80;
    transform: translateY(-2px);
}

.vozes-archive-pagination .current {
    background: #0056A6;
    color: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,.13);
}

/* Vazio */
.vozes-archive-empty {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
    font-size: 16px;
}

/* ==================== FILTRO / CONTROLES ==================== */

.vozes-archive-controls {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
    margin-bottom: 28px;
}

.vozes-archive-select {
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    background: #fff;
    cursor: pointer;
    min-width: 180px;
    appearance: auto;
}

.vozes-archive-select:focus {
    outline: none;
    border-color: #0056A6;
}

/* ==================== CARD LINK ==================== */

.vozes-card-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    gap: 16px;
    height: 100%;
}

.vozes-card-link:hover .vozes-card-author strong {
    color: #0056A6;
}

/* ==================== RESPONSIVO ==================== */

@media (max-width: 768px) {
    .vozes-archive-grid {
        grid-template-columns: 1fr;
    }
    .vozes-archive-banner-text h1 {
        font-size: 22px;
    }
    .vozes-archive-banner-image {
        height: 220px;
    }
    .vozes-archive-controls {
        gap: 8px;
    }
    .vozes-archive-select {
        font-size: 12px;
        min-width: 140px;
    }
}
</style>

<!-- BANNER -->
<section class="vozes-archive-banner">
    <div class="vozes-archive-banner-inner">

        <div class="vozes-archive-breadcrumb">
            <?php
            if ( function_exists( 'rede_bvs_breadcrumb' ) ) {
                rede_bvs_breadcrumb( array(
                    array( 'label' => rede_bvs_pll( 'Rede BVS' ), 'url' => home_url( '/' ) ),
                    array( 'label' => rede_bvs_pll( 'Vozes da Rede' ) ),
                ) );
            }
            ?>
        </div>

        <div class="vozes-archive-banner-wrapper">
            <div class="vozes-archive-banner-image" style="background-image:url('<?php echo esc_url( $banner_img ); ?>');">
                <div class="vozes-archive-banner-text">
                    <h1><?php echo esc_html( rede_bvs_pll( 'Vozes da Rede' ) ); ?></h1>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- LISTAGEM -->
<main class="vozes-archive-wrap">

    <?php
    $archive_base = get_post_type_archive_link( 'voz-da-rede' );
    ?>
    <form class="vozes-archive-controls" method="get">
        <select class="vozes-archive-select" name="categoria" onchange="this.form.submit()">
            <option value=""><?php echo esc_html( rede_bvs_pll( 'Todos' ) ); ?></option>
            <?php if ( ! empty( $vozes_terms ) ) : ?>
                <?php foreach ( $vozes_terms as $term ) : ?>
                    <option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $filtro_slug, $term->slug ); ?>>
                        <?php echo esc_html( $term->name ); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <select class="vozes-archive-select" name="sort" onchange="this.form.submit()">
            <option value="recent" <?php selected( $sort, 'recent' ); ?>><?php echo esc_html( rede_bvs_pll( 'Mais recentes' ) ); ?></option>
            <option value="az" <?php selected( $sort, 'az' ); ?>>A &ndash; Z</option>
            <option value="za" <?php selected( $sort, 'za' ); ?>>Z &ndash; A</option>
        </select>
    </form>

    <?php if ( $vozes_query->have_posts() ) : ?>

        <div class="vozes-archive-grid">

            <?php while ( $vozes_query->have_posts() ) : $vozes_query->the_post();

                $id = get_the_ID();

                // Campos ACF do CPT "voz-da-rede"
                $nome  = function_exists( 'get_field' ) ? get_field( 'nome_do_depoimento', $id ) : '';
                $extra = function_exists( 'get_field' ) ? get_field( 'texto_complementar_cargopais', $id ) : '';
                $texto = function_exists( 'get_field' ) ? get_field( 'depoimento_completo', $id ) : '';
                $foto  = function_exists( 'get_field' ) ? get_field( 'foto_do_autor_depoimento', $id ) : '';

                // Fallbacks
                if ( empty( $nome ) ) {
                    $nome = get_the_title( $id );
                }
                if ( empty( $texto ) ) {
                    $texto = wp_trim_words( wp_strip_all_tags( get_the_content() ), 60 );
                }

                $foto_url = is_array( $foto ) && ! empty( $foto['url'] ) ? $foto['url'] : '';
            ?>

                <article class="vozes-archive-card">
                    <a class="vozes-card-link" href="<?php the_permalink(); ?>">

                    <div class="vozes-card-header">
                        <div class="vozes-card-avatar">
                            <?php if ( $foto_url ) : ?>
                                <img src="<?php echo esc_url( $foto_url ); ?>" alt="<?php echo esc_attr( $nome ); ?>">
                            <?php else : ?>
                                <div class="vozes-card-avatar-placeholder"></div>
                            <?php endif; ?>
                        </div>

                        <div class="vozes-card-author">
                            <strong><?php echo esc_html( $nome ); ?></strong>
                            <?php if ( $extra ) : ?>
                                <span><?php echo esc_html( $extra ); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="vozes-card-texto">
                        <?php echo wp_kses_post( nl2br( $texto ) ); ?>
                    </div>

                    </a>
                </article>

            <?php endwhile; ?>

        </div>

        <!-- PAGINAÇÃO -->
        <div class="vozes-archive-pagination">
            <?php
            $pagination_args = array(
                'total'     => $vozes_query->max_num_pages,
                'current'   => $paged,
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
            );
            $add_args = array();
            if ( $filtro_slug ) $add_args['categoria'] = $filtro_slug;
            if ( $sort && $sort !== 'recent' ) $add_args['sort'] = $sort;
            if ( ! empty( $add_args ) ) $pagination_args['add_args'] = $add_args;
            echo paginate_links( $pagination_args );
            ?>
        </div>

    <?php else : ?>

        <p class="vozes-archive-empty"><?php echo esc_html( rede_bvs_pll( 'Nenhuma voz encontrada.' ) ); ?></p>

    <?php endif; wp_reset_postdata(); ?>

</main>

<?php get_footer(); ?>
