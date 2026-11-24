<?php
/**
 * Dobra "Rede em ação" - flexible layout: rede_em_acao
 *
 * Campos ACF:
 *  - titulo_do_bloco       (text)        – título personalizado da seção
 *  - modo_de_listagem      (select)      – "Escolha manual" | "Via categorias"
 *  - escolha_os_eventos    (post_object) – posts selecionados manualmente
 *  - escolha_as_categorias (taxonomy)    – IDs de categorias para listagem automática
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! isset( $args ) || ! is_array( $args ) ) {
    $args = array();
}

$lista_completa = ! empty( $args['lista_completa'] ) || ( function_exists( 'rede_bvs_is_rede_acao_todas' ) && rede_bvs_is_rede_acao_todas() );
$na_linha       = function_exists( 'get_row_layout' ) && get_row_layout() === 'rede_em_acao';
$page_id        = (int) get_queried_object_id();

if ( $na_linha && ! $lista_completa ) {
    $titulo_bloco = get_sub_field( 'titulo_do_bloco' );
    $modo         = get_sub_field( 'modo_de_listagem' );
    $cat_ids      = rede_bvs_normalize_ids( get_sub_field( 'escolha_as_categorias' ) );
    $post_ids     = rede_bvs_normalize_ids( get_sub_field( 'escolha_os_eventos' ) );
} elseif ( $lista_completa ) {
    $fonte        = rede_bvs_rede_acao_fonte( $page_id );
    $titulo_bloco = $fonte['titulo'];
    $modo         = $fonte['modo'];
    $cat_ids      = $fonte['cat_ids'];
    $post_ids     = $fonte['post_ids'];
} else {
    return;
}

if ( empty( $titulo_bloco ) ) {
    $titulo_bloco = rede_bvs_t( 'A Rede em ação', 'La red en acción', 'The Network in action' );
}

$per_page = $lista_completa ? 12 : 6;
$paged    = $lista_completa ? rede_bvs_rede_acao_paged() : 1;
$query    = rede_bvs_rede_acao_query( $modo, $cat_ids, $post_ids, $per_page, $paged );
$total    = ( $query instanceof WP_Query ) ? (int) $query->found_posts : 0;
$eventos  = ( $query instanceof WP_Query ) ? $query->posts : array();

if ( $query instanceof WP_Query ) {
    wp_reset_postdata();
}

// Na página do país, a prévia só aparece quando há notícias.
// A listagem completa permanece, para o visitante ver o estado vazio.
if ( ! $lista_completa && empty( $eventos ) ) {
    return;
}

$mostrar_ver_mais = ( ! $lista_completa && $total > 6 );
$more_url         = $mostrar_ver_mais ? rede_bvs_rede_acao_more_url( $page_id ) : '';
$ver_mais_label   = rede_bvs_t( 'Ver mais', 'Ver más', 'See more' );
?>

<style>
/* --------------------- REDE EM AÇÃO --------------------- */

.rede-acao-section{
    margin: 32px auto 0;
    max-width: 1180px;
    padding: 0 16px;
}

.rede-acao-box{
    border-radius: 4px;
    overflow: hidden;
    background: #ffffff;
}

/* faixa de título */

.rede-acao-header{
display: inline-block;
    margin: 4px 0 0;
    padding: 8px 14px;
    border-radius: 8px;
    background: #e5e7eb;
    font-size: 16px;
    width: 100%;
    font-weight: 600;
    color: #374151;
}

/* lista de eventos */

.rede-acao-body{
    padding: 16px 18px 18px;
}

.rede-acao-list{
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
}

/* card */

.rede-acao-item{
    flex: 1 1 320px;
    max-width: 50%;
    display: flex;
    gap: 16px;
}

.rede-acao-thumb{
    flex: 0 0 160px;
    border-radius: 26px 0 0 0;
    overflow: hidden;
    background: transparent;
}

.rede-acao-thumb img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    background: transparent;
    border-radius: 10px 30px 10px 10px;
}

.rede-acao-content{
    flex: 1;
    font-size: 14px;
    color: #111827;
}

.rede-acao-title{
    font-size: 15px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 4px;
}

.rede-acao-title a{
    color: inherit;
    text-decoration: none;
}

.rede-acao-title a:hover{
    text-decoration: underline;
}

.rede-acao-meta{
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 6px;
}

.rede-acao-tags{
    font-size: 12px;
    color: #4b5563;
}

/* botão "Ver mais" */

.rede-acao-breadcrumb{
    margin-bottom: 16px;
}

.rede-acao-footer{
    display: flex;
    justify-content: flex-end;
    margin-top: 12px;
}

.rede-acao-more{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px 18px;
    border-radius: 999px;
    background: #1f3763;
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

.rede-acao-more:hover{
    filter: brightness(1.05);
    color: #ffffff;
}

.rede-acao-empty{
    margin: 0;
    color: #4b5563;
}

.rede-acao-pagination{
    margin-top: 20px;
    text-align: center;
}

.rede-acao-pagination .page-numbers{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 14px;
    margin: 0 4px;
    background: #f0f3fa;
    border-radius: 10px;
    text-decoration: none;
    font-size: 14px;
    color: #0056a6;
    font-weight: 600;
}

.rede-acao-pagination .page-numbers:hover{
    background: #dce4f3;
    color: #003c80;
}

.rede-acao-pagination .current{
    background: #0056a6;
    color: #ffffff;
}

/* responsivo */

@media (max-width: 768px){
    .rede-acao-list{
        flex-direction: column;
    }
    .rede-acao-item{
        max-width: 100%;
    }
}

@media (max-width: 480px){
    .rede-acao-item{
        flex-direction: column;
    }
    .rede-acao-thumb{
        flex: 0 0 auto;
        border-radius: 18px;
    }
}
</style>

<section id="rede-em-acao" class="rede-acao-section<?php echo $lista_completa ? ' rede-acao-section--lista' : ''; ?>">

        <?php if ( $lista_completa && function_exists( 'rede_bvs_breadcrumb' ) ) : ?>
            <?php
            $rede_page_id = 18;
            if ( function_exists( 'pll_get_post' ) ) {
                $rede_traduzida = pll_get_post( 18 );
                if ( $rede_traduzida ) {
                    $rede_page_id = (int) $rede_traduzida;
                }
            }
            ?>
            <div class="rede-acao-breadcrumb">
                <?php
                rede_bvs_breadcrumb( array(
                    array(
                        'label' => get_the_title( $rede_page_id ),
                        'url'   => get_permalink( $rede_page_id ),
                    ),
                    array(
                        'label' => get_the_title( $page_id ),
                        'url'   => get_permalink( $page_id ),
                    ),
                    array(
                        'label' => $titulo_bloco,
                    ),
                ) );
                ?>
            </div>
        <?php endif; ?>

    <div class="rede-acao-box">

        <?php $header_tag = ( $lista_completa ? 'h1' : 'div' ); ?>
        <<?php echo $header_tag; ?> class="rede-acao-header">
            <?php echo esc_html( $titulo_bloco ); ?>
        </<?php echo $header_tag; ?>>

        <div class="rede-acao-body">
            <div class="rede-acao-list">
                <?php
                foreach ( $eventos as $evento ) :
                    if ( ! $evento instanceof WP_Post ) {
                        $evento = get_post( $evento );
                    }
                    if ( ! $evento ) {
                        continue;
                    }

                    $event_id = $evento->ID;
                    $permalink = get_permalink( $event_id );
                    $titulo    = get_the_title( $event_id );

                    // data + hora + autor
                    $data  = get_the_date( 'd/M/Y', $event_id );
                    $hora  = get_the_time( 'H:i', $event_id );
                    $autor = get_the_author_meta( 'display_name', $evento->post_author );

                    // termos (ajuste o slug da taxonomia se necessário)
                    $tags_list = get_the_term_list( $event_id, 'post_tag', '', ', ', '' );

                    // thumb
                    if ( has_post_thumbnail( $event_id ) ) {
                        $thumb = get_the_post_thumbnail( $event_id, 'medium_large' );
                    } else {
                        $thumb = '<div style="width:100%;height:100%;background:#e5e7eb;"></div>';
                    }
                    ?>
                    <article class="rede-acao-item">
                        <div class="rede-acao-thumb">
                            <a href="<?php echo esc_url( $permalink ); ?>">
                                <?php echo $thumb; ?>
                            </a>
                        </div>
                        <div class="rede-acao-content">
                            <h3 class="rede-acao-title">
                                <a href="<?php echo esc_url( $permalink ); ?>">
                                    <?php echo esc_html( $titulo ); ?>
                                </a>
                            </h3>
                            <div class="rede-acao-meta">
                                <?php echo esc_html( "{$data} - {$hora} - {$autor}" ); ?>
                            </div>
                            <?php if ( $tags_list ) : ?>
                                <div class="rede-acao-tags">
                                    <?php echo wp_kses_post( $tags_list ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ( empty( $eventos ) ) : ?>
                <p class="rede-acao-empty">
                    <?php echo esc_html( rede_bvs_t( 'Nenhuma notícia encontrada.', 'No se encontraron noticias.', 'No news found.' ) ); ?>
                </p>
            <?php endif; ?>

            <?php if ( $mostrar_ver_mais && $more_url ) : ?>
                <div class="rede-acao-footer">
                    <a class="rede-acao-more" href="<?php echo esc_url( $more_url ); ?>">
                        <?php echo esc_html( $ver_mais_label ); ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if ( $lista_completa && $query instanceof WP_Query && $query->max_num_pages > 1 ) : ?>
                <div class="rede-acao-pagination">
                    <?php
                    $big  = 999999999;
                    $base = add_query_arg(
                        array(
                            'rede_acao'   => 'todas',
                            'rede_pagina' => $big,
                        ),
                        get_permalink( $page_id )
                    );
                    $base = str_replace( (string) $big, '%#%', $base );

                    echo paginate_links( array(
                        'base'         => $base,
                        'format'       => '',
                        'current'      => $paged,
                        'total'        => (int) $query->max_num_pages,
                        'prev_text'    => '← ' . rede_bvs_t( 'Anterior', 'Anterior', 'Previous' ),
                        'next_text'    => rede_bvs_t( 'Próximo', 'Siguiente', 'Next' ) . ' →',
                        'add_fragment' => '#rede-em-acao',
                    ) );
                    ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>
