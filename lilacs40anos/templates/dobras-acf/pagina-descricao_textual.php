<?php
/**
 * Dobra: Descrição Textual
 * Slug esperado: pagina-descricao_textual
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Campos do layout "descricao_textual"
$titulo    = get_sub_field( 'titulo_da_dobra' );
$texto     = get_sub_field( 'texto' );
$cor_fundo = get_sub_field( 'cor_fundo' ); // Campo ACF (color picker)
$cor_titulo = get_sub_field( 'cor_titulo' ); // Campo ACF (color picker)

// Se não tiver nada, não renderiza
if ( empty( $titulo ) && empty( $texto ) ) {
    return;
}

$uid = 'lilacs-desc-txt-' . get_the_ID() . '-' . get_row_index();

// Estilo inline para o background da seção (100% largura)
$bg_style = $cor_fundo ? ' style="background:' . esc_attr( $cor_fundo ) . ';"' : '';
?>

<style>
/* ----------------------------- */
/* WRAPPER GERAL DA SESSÃO       */
/* ----------------------------- */
#<?php echo esc_attr( $uid ); ?> {
    padding: 40px 16px 30px;
}

/* Wrapper interno com largura máxima */
#<?php echo esc_attr( $uid ); ?> .desc-text-inner {
    max-width: 1180px;
    margin: 0 auto;
}

/* Card único de texto */
#<?php echo esc_attr( $uid ); ?> .desc-text-card {
    border-radius: 16px;
    padding: 0;
}

/* Título da dobra */
#<?php echo esc_attr( $uid ); ?> .desc-text-title {
    font-size: 30px;
    font-weight: 700;
    color: <?=$cor_titulo?>;
    margin: 0 0 16px;
}

/* Conteúdo vindo do WYSIWYG */
#<?php echo esc_attr( $uid ); ?> .desc-text-content {
    font-size: 15px;
    line-height: 1.7;
    color: #111827;
}

/* Mantém cores dos headings, mas não mexe em alinhamento/bold/etc do editor */
#<?php echo esc_attr( $uid ); ?> .desc-text-content h2,
#<?php echo esc_attr( $uid ); ?> .desc-text-content h3,
#<?php echo esc_attr( $uid ); ?> .desc-text-content h4 {
    color: #0b2c68;
    margin-top: 18px;
    margin-bottom: 8px;
}

#<?php echo esc_attr( $uid ); ?> .desc-text-content p {
    margin-bottom: 12px;
}

/* Links */
#<?php echo esc_attr( $uid ); ?> .desc-text-content a {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
}

#<?php echo esc_attr( $uid ); ?> .desc-text-content a:hover {
    text-decoration: underline;
}

/* Listas */
#<?php echo esc_attr( $uid ); ?> .desc-text-content ul,
#<?php echo esc_attr( $uid ); ?> .desc-text-content ol {
    padding-left: 20px;
    margin-bottom: 12px;
}

#<?php echo esc_attr( $uid ); ?> .desc-text-content li {
    margin-bottom: 4px;
}

/* ----------------------------- */
/* SUPORTE AOS ESTILOS DO EDITOR */
/* ----------------------------- */

/* Imagens responsivas dentro do conteúdo */
#<?php echo esc_attr( $uid ); ?> .desc-text-content img {
    max-width: 100%;
    height: auto;
}

/* Classes padrão do WordPress para alinhamento */
#<?php echo esc_attr( $uid ); ?> .desc-text-content .alignleft {
    float: left;
    margin: 0 1.5em 1em 0;
}

#<?php echo esc_attr( $uid ); ?> .desc-text-content .alignright {
    float: right;
    margin: 0 0 1em 1.5em;
}

#<?php echo esc_attr( $uid ); ?> .desc-text-content .aligncenter {
    display: block;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
}

/* Se o editor aplicar text-align via inline style, não sobrescrevemos */
#<?php echo esc_attr( $uid ); ?> .desc-text-content [style*="text-align:center"] {
    text-align: center;
}
#<?php echo esc_attr( $uid ); ?> .desc-text-content [style*="text-align:right"] {
    text-align: right;
}
#<?php echo esc_attr( $uid ); ?> .desc-text-content [style*="text-align:left"] {
    text-align: left;
}

/* Responsivo */
@media (max-width: 900px) {
    #<?php echo esc_attr( $uid ); ?> .desc-text-card {
        padding: 22px 20px;
    }

    #<?php echo esc_attr( $uid ); ?> .desc-text-title {
        font-size: 20px;
    }
}
</style>

<section id="<?php echo esc_attr( $uid ); ?>" class="lilacs-descricao-textual"<?php echo $bg_style; ?>>
    <div class="desc-text-inner">
        <article class="desc-text-card">
            <?php if ( $titulo ) : ?>
                <h2 class="desc-text-title">
                    <?php echo esc_html( $titulo ); ?>
                </h2>
            <?php endif; ?>

            <?php if ( $texto ) : ?>
                <div class="desc-text-content">
                    <?php
                    // Mantém formatação / shortcodes do WYSIWYG
                    echo apply_filters( 'the_content', $texto );
                    ?>
                </div>
            <?php endif; ?>
        </article>
    </div>
</section>
