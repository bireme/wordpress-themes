<?php
/**
 * Template de resultados de busca
 * Estrutura baseada em "Notícias da Rede" com cards e sidebar de categorias.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<style>
/* ---------------- BANNER ---------------- */

.sobre-banner {
    padding: 0;
    background: #ffffff;
}

.sobre-banner-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

.sobre-banner-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 10px 90px 10px 10px;
    background-color: #e4e7f0;
}

.sobre-banner-image {
    width: 100%;
    height: 285px;
    background-size: cover;
    background-position: center center;
}

/* Fade escuro para legibilidade */
.sobre-banner-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 140px;
    background: linear-gradient(to top, rgba(0,0,0,0.55), rgba(0,0,0,0));
}

.sobre-banner-text {
    color: #ffffff !important;
    max-width: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-start !important;
    background: #29367dc2 !important;
    padding: 0 !important;
    margin: 0 !important;
    width: 100% !important;
    position: absolute;
    left: 0 !important;
    bottom: 0 !important;
    color: #fff;
    height: 100% !important;
    top: 50% !important;
    padding-left: 20px !important;
    padding-top: 22px !important;
}

.sobre-banner-text h1 {
    font-size: 42px;
    font-weight: 700;
    margin: 0;
}

.sobre-banner-breadcrumb {
    margin-bottom: 14px;
}

body{
    background:#F1F1F1 !important;
}
.sobre-banner {
    padding: 0;
    background: transparent !important;
}

/* Mobile */
@media(max-width: 768px){
    .sobre-banner-wrapper { border-radius: 10px 90px 10px 10px; }
    .sobre-banner-image { height: 220px; }
    .sobre-banner-overlay { height: 120px; }
    .sobre-banner-text { left: 20px; bottom: 20px; }
    .sobre-banner-text h1 { font-size: 22px; }
}

/* ---------- LAYOUT ---------- */
.bvs-archive-wrapper{
    max-width: 1180px;
    margin: 60px auto;
    padding: 0 20px;
    display: flex;
    gap: 40px;
}

/* ---------- LISTA DE POSTS ---------- */
.bvs-posts-list{
    flex: 1;
}

/* CARD */
.bvs-post-card{
    display: flex;
    gap: 18px;
    background: #fff;
    padding: 18px;
    border-radius: 14px;
    margin-bottom: 20px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    transition: .2s;
    position: relative; /* para posicionar o badge */
}

.bvs-post-card:hover{
    transform: translateY(-3px);
}

/* Badge do tipo de link */
.bvs-post-badge{
    position: absolute;
    top: 12px;
    right: 12px; /* badge na direita do card */
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: .02em;
    text-transform: uppercase;
    background: #0056A6; /* cor padrão do fundo */
    color: #ffffff;
    box-shadow: 0 3px 6px rgba(0,0,0,0.12);
}

/* Mantidos para semântica, mas mesma cor base */
.bvs-post-badge--external{
    background: #0056A6;
}
.bvs-post-badge--internal{
    background: #0056A6;
}

.bvs-post-thumb img{
    width: 180px;
    height: 120px;
    border-radius: 10px;
    object-fit: cover;
}

.bvs-post-info h2{
    font-size: 18px;
    margin-bottom: 6px;
}

.bvs-post-info h2 a{
    text-decoration: none;
    color: #002C71;
}

.bvs-post-meta{
    font-size: 13px;
    color: #666;
    margin-bottom: 8px;
}

.bvs-post-cats a{
    font-size: 13px;
    margin-right: 5px;
    color: #0056A6;
}

/* ---------- SIDEBAR ---------- */
.bvs-sidebar{
    width: 280px;
}

.bvs-sidebar-box{
    background: #F7F9FC;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.05);
    margin-bottom:10px;
}

.bvs-sidebar-title{
    font-size: 20px;
    margin-bottom: 16px;
    font-weight: 700;
    color: #002C71;
}

.bvs-sidebar ul{
    list-style: none;
    margin: 0;
    padding: 0;
}

.bvs-sidebar ul li{
    margin-bottom: 10px;
}

.bvs-sidebar ul li a{
    text-decoration: none;
    font-size: 15px;
    color: #0056A6;
}

/* ---------- PAGINAÇÃO PREMIUM ---------- */

.bvs-pagination{
    margin-top: 40px;
    text-align: center;
}

.bvs-pagination .page-numbers{
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

.bvs-pagination .page-numbers:hover{
    background: #dce4f3;
    color: #003c80;
    transform: translateY(-2px);
}

.bvs-pagination .current{
    background: #0056A6;
    color: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.13);
}

.bvs-pagination .prev,
.bvs-pagination .next{
    font-size: 14px;
}

/* RESPONSIVO */
@media(max-width: 900px){
    .bvs-archive-wrapper{ flex-direction: column; }
    .bvs-sidebar{ width: 100%; }
    .bvs-post-card{ flex-direction: column; }
    .bvs-post-thumb img{ width: 100%; height: 180px; }
}
</style>

<?php
// ------------------- SEARCH HEADER / BANNER -------------------
include('dobras/resultado-banner.php');
?>

<main class="bvs-archive-wrapper">

    <!-- Lista de Posts -->
    <section class="bvs-posts-list">

        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <?php
                // Meta do plugin Page Links To
                $custom_link = get_post_meta( get_the_ID(), '_links_to', true );

                // Host do site
                $home_host  = parse_url( home_url(), PHP_URL_HOST );
                // Host do destino (se tiver link personalizado)
                $link_host  = $custom_link ? parse_url( $custom_link, PHP_URL_HOST ) : '';

                // Considera externo se tiver link personalizado e o host for diferente
                $is_external_custom = $custom_link && $link_host && $link_host !== $home_host;
                ?>

                <article class="bvs-post-card">

                    <?php if ( $custom_link ) : ?>
                        <span class="bvs-post-badge <?php echo $is_external_custom ? 'bvs-post-badge--external' : 'bvs-post-badge--internal'; ?>">
                            <?php echo $is_external_custom ? 'Link externo' : 'Link interno'; ?>
                        </span>
                    <?php endif; ?>

                    <div class="bvs-post-thumb">
                        <a href="<?php the_permalink(); ?>">
                            <?php 
                          if ( has_post_thumbnail() ) {
    the_post_thumbnail('medium');
} else {
    echo '<img src="' . get_template_directory_uri() . '/assets/post-default.png" alt="Imagem padrão">';
}

                            ?>
                        </a>
                    </div>

                    <div class="bvs-post-info">
                        
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                        <?php if(get_post_type() != "produtos"){ ?>
                         <div class="bvs-post-meta">
                                  <?php echo get_the_date(); ?> · <?php the_author(); ?>
                         </div>
                        <?php  }  ?>


                        <div class="bvs-post-cats">
                            <?php the_category(' '); ?>
                        </div>

                    </div>

                </article>

            <?php endwhile; ?>

            <!-- PAGINAÇÃO PREMIUM -->
            <div class="bvs-pagination">
                <?php 
                global $wp_query;
                $big = 999999999; // número fictício para base
                echo paginate_links( array(
                    'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format'    => '?paged=%#%',
                    'current'   => max( 1, get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ),
                    'total'     => $wp_query->max_num_pages,
                    'prev_text' => '← Anterior',
                    'next_text' => 'Próximo →',
                ) );
                ?>
            </div>

        <?php else : ?>

            <p><?php esc_html_e( 'Nenhum resultado encontrado para a sua busca.', 'bvs' ); ?></p>

        <?php endif; ?>

    </section>

    <!-- Sidebar -->
   <!-- Sidebar -->
<aside class="bvs-sidebar">

    <!-- Categorias -->
    <div class="bvs-sidebar-box">
        <h3 class="bvs-sidebar-title"><?php esc_html_e( 'Categorias', 'bvs' ); ?></h3>
        <ul>
            <?php 
            wp_list_categories( array(
                'title_li'   => '',
                'orderby'    => 'name',
                'order'      => 'ASC',
                'hide_empty' => 0, // MOSTRA CATEGORIAS MESMO SEM POSTS
                'number'     => 15
            ) ); 
            ?>
        </ul>
    </div>

    <!-- Filtro por Ano -->
    <div class="bvs-sidebar-box">
        <h3 class="bvs-sidebar-title"><?php esc_html_e( 'Arquivos por Ano', 'bvs' ); ?></h3>
        <ul>
            <?php
            wp_get_archives( array(
                'type'            => 'yearly',
                'limit'           => 10, // quantidade de anos
                'show_post_count' => true
            ) );
            ?>
        </ul>
    </div>

</aside>


</main>

<?php get_footer(); ?>
