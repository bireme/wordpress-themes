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

// Título do bloco (fallback para "A Rede em ação")
$titulo_bloco = get_sub_field( 'titulo_do_bloco' );
if ( empty( $titulo_bloco ) ) {
    $titulo_bloco = 'A Rede em ação';
}

// Modo de listagem
$modo = get_sub_field( 'modo_de_listagem' );

$eventos = array();

if ( $modo === 'Via categorias' ) {
    // Busca automática por categorias selecionadas
    $cat_ids = get_sub_field( 'escolha_as_categorias' );
    if ( ! empty( $cat_ids ) ) {
        $cat_query = new WP_Query( array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 6,
            'category__in'   => (array) $cat_ids,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );
        if ( $cat_query->have_posts() ) {
            $eventos = $cat_query->posts;
        }
        wp_reset_postdata();
    }
} else {
    // Escolha manual
    $manual = get_sub_field( 'escolha_os_eventos' );
    if ( ! empty( $manual ) ) {
        $eventos = $manual;
    }
}

if ( empty( $eventos ) ) {
    return;
}
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
    margin-top: 4px;
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

/* botão "Mostrar mais" */

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

<section class="rede-acao-section">
    <div class="rede-acao-box">

        <div class="rede-acao-header">
            <?php echo esc_html( $titulo_bloco ); ?>
        </div>

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

            <div class="rede-acao-footer">
                <?php
                $archive_link = get_post_type_archive_link( 'acontece-na-rede' );
                if ( $archive_link ) :
                ?>
                    <a class="rede-acao-more" href="<?php echo esc_url( $archive_link ); ?>">
                        <?php esc_html_e( 'Mostrar mais', 'bvs' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>
