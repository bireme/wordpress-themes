<?php 
/**
 * Dobra: Banner Centro Cooperantes
 * Slug esperado: pagina-banner
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Campos ACF da dobra
$titulo_banner  = get_sub_field( 'titulo_banner' );
$fundo_banner   = get_sub_field( 'fundo_banner' ); // url
$descricao      = get_sub_field( 'descricao_banner' );
$texto_barra    = get_sub_field( 'texto_complementar_descricao_banner' );
$posicaoHigh    = get_sub_field('posicao_do_highlight');

$overlay = get_sub_field('desativar_overlay');
$cor_titulo = get_sub_field('cor_da_fonte_do_titulo');
$cor_desc = get_sub_field('cor_da_fonte_da_descricao');

// ID único para permitir background diferente por dobra
$section_id = 'lilacs-centro-banner-' . get_the_ID() . '-' . get_row_index();

$bg_style = '';
if ( $fundo_banner && $overlay == "nao") {
    $bg_style = sprintf(
        "background-image: linear-gradient(90deg, rgba(0,0,0,0.80) 0%%, rgba(0,0,0,0.70) 45%%, rgba(0,0,0,0.40) 60%%, rgba(0,0,0,0.10) 100%%), url('%s');",
        esc_url( $fundo_banner )
    );
} else {
    $bg_style = sprintf(
        "background-image: url('%s');",
        esc_url( $fundo_banner )
    );
}

if(!$cor_titulo){
    $cor_titulo = '#f97316';
}
if(!$cor_desc){
    $cor_desc = '#e5e7eb';
}

// Breadcrumb (Home / Página atual) — estilo igual referência
$current_title = get_the_title();
$home_label    = 'Home';
$home_url      = home_url('/');
?>

<style>
/* --------------------------------------------------------- */
/* Breadcrumb (igual referência: simples, topo, "Home / X")   */
/* --------------------------------------------------------- */
.lilacs-centro-breadcrumb{
    background:#ffffff;
    border-bottom: 1px solid rgba(15,23,42,0.10);
}
.lilacs-centro-breadcrumb .lilacs-centro-breadcrumb-inner{
    max-width: 1180px;
    margin: 0 auto;
    padding: 10px 16px;
    display:flex;
    align-items:center;
    gap: 6px;
    flex-wrap: wrap;
    font-family: "Noto Sans", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    font-size: 14px;
    line-height: 1.3;
}
.lilacs-centro-breadcrumb a,
.lilacs-centro-breadcrumb span{
    color:#1d4ed8; /* azul padrão referência */
    text-decoration:none;
    font-weight: 500;
}
.lilacs-centro-breadcrumb a:hover{
    text-decoration: underline;
}
.lilacs-centro-breadcrumb .sep{
    color:#1d4ed8;
    opacity:.9;
}

/* --------------------------------------------------------- */
/* Banner – Centros Cooperantes LILACS                       */
/* --------------------------------------------------------- */
#<?php echo esc_attr( $section_id ); ?> {
    position: relative;
    overflow: hidden;
    background-color: #111827; /* fallback */
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    color: #f9fafb;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 104px 16px;
    display: grid;
    grid-template-columns: minmax(0, 1.9fr) minmax(0, 1fr);
    gap: 32px;
    align-items: center;
}

/* Coluna esquerda – textos */
#<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-copy {
    max-width: 760px;
}
p,span,a,div{
    font-family: "Noto Sans", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-title {
    font-size: 45px;
    font-family: "Poppins";
    line-height: 1.25;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: <?=$cor_titulo; ?>;
    margin-bottom: 16px;
}

@media (min-width: 960px) {
    #<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-title {
        font-family: "Poppins";
        font-size: 45px;
    }
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-desc {
    font-size: 20px;
    line-height: 1.7;
    color: <?=$cor_desc?>;
    margin-bottom: 20px;
}

/* Barra laranja com texto complementar */
#<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-highlight {
    display: inline-flex;
    align-items: center;
    background-color: #f97316;
    color: #fff;
    padding: 10px 16px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 18px;
    line-height: 1.4;
    box-shadow: 0 8px 20px rgba(0,0,0,0.35);
    margin-bottom:30px;
}

/* Coluna direita – ilustração “rede” */
#<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-visual {
    justify-self: end;
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-visual-blob {
    position: relative;
    width: 260px;
    height: 260px;
    border-radius: 999px;
    border: 1px solid rgba(249,250,251,0.08);
    background: radial-gradient(circle at 30% 20%, rgba(249,115,22,0.35), transparent 55%),
                radial-gradient(circle at 70% 80%, rgba(249,250,251,0.10), transparent 55%);
    box-shadow: 0 22px 60px rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* “Nós” conectados em volta */
#<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-node {
    position: absolute;
    width: 32px;
    height: 32px;
    border-radius: 999px;
    background: #111827;
    border: 2px solid #f97316;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.6);
}

#<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-node::before {
    content: "";
    width: 18px;
    height: 18px;
    border-radius: 999px;
    background: #f9fafb;
}

/* Posições aproximadas dos “contatos” */
#<?php echo esc_attr( $section_id ); ?> .node-top-left    { top: 14%; left: 8%;  }
#<?php echo esc_attr( $section_id ); ?> .node-top-right   { top: 6%;  right: 10%; }
#<?php echo esc_attr( $section_id ); ?> .node-middle-left { top: 45%; left: -4%; }
#<?php echo esc_attr( $section_id ); ?> .node-middle-right{ top: 48%; right: -6%;}
#<?php echo esc_attr( $section_id ); ?> .node-bottom-left { bottom: 8%; left: 14%;}
#<?php echo esc_attr( $section_id ); ?> .node-bottom-right{ bottom: 3%; right: 18%;}

/* Linhas conectando os nós ao centro */
#<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-line {
    position: absolute;
    border-top: 1px solid rgba(249,250,251,0.28);
    transform-origin: left center;
}

/* Responsivo */
@media (max-width: 900px) {
    #<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-inner {
        grid-template-columns: 1fr;
        gap: 28px;
        padding: 32px 16px 40px;
    }

    #<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-visual {
        justify-self: flex-start;
    }

    #<?php echo esc_attr( $section_id ); ?> .lilacs-centro-banner-visual-blob {
        width: 220px;
        height: 220px;
    }
}
</style>

<section id="<?php echo esc_attr( $section_id ); ?>" class="lilacs-centro-banner" style="<?php echo esc_attr( $bg_style ); ?>">
    <div class="lilacs-centro-banner-inner">

        <div class="lilacs-centro-banner-copy">
            <?php if ( $titulo_banner ) : ?>
                <h1 class="lilacs-centro-banner-title">
                    <?php echo esc_html( $titulo_banner ); ?>
                </h1>
            <?php endif; ?>
            
            <?php if ( $posicaoHigh == "titulo") : ?>
                <?php if ( $texto_barra ) : ?>
                    <div class="lilacs-centro-banner-highlight">
                        <?php echo esc_html( $texto_barra ); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ( $descricao ) : ?>
                <div class="lilacs-centro-banner-desc">
                    <?php echo wp_kses_post( nl2br( $descricao ) ); ?>
                </div>
            <?php endif; ?>

            <?php if ( $posicaoHigh == "descricao") : ?>
                <?php if ( $texto_barra ) : ?>
                    <div class="lilacs-centro-banner-highlight">
                        <?php echo esc_html( $texto_barra ); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="lilacs-centro-banner-visual" aria-hidden="true"></div>

    </div>
</section>
