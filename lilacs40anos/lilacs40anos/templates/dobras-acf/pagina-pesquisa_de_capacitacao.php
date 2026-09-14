<?php
/**
 * Dobra: Pesquisa
 * Slug esperado: pagina-descricao_textual
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Campos do layout "descricao_textual"
$titulo = get_sub_field( 'insira_o_titulo_da_dobra' );


// Se não tiver nada, não renderiza
if ( empty( $titulo ) ) {
    return;
}

$uid = 'lilacs-desc-txt-' . get_the_ID() . '-' . get_row_index();
?>

<style>
/* ----------------------------- */
/* WRAPPER GERAL                 */
/* ----------------------------- */
#<?php echo esc_attr( $uid ); ?> {
    max-width: 1180px;
    margin: 40px auto 60px;
    padding: 0 16px;
}

/* Card único de texto */
#<?php echo esc_attr( $uid ); ?> .desc-text-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 0;
}

/* Título da dobra */
#<?php echo esc_attr( $uid ); ?> .desc-text-title {
    font-size: 30px;
    font-weight: 700;
    color: #0b2c68;
    margin: 0 0 16px;
}

/* Conteúdo vindo do WYSIWYG */
#<?php echo esc_attr( $uid ); ?> .desc-text-content {
    font-size: 15px;
    line-height: 1.7;
    color: #111827;
}

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

<section id="<?php echo esc_attr( $uid ); ?>" class="lilacs-descricao-textual">
    <article class="desc-text-card">
        <?php if ( $titulo ) : ?>
            <h2 class="desc-text-title">
                <?php echo esc_html( $titulo ); ?>
            </h2>
        <?php endif; ?>


            <div class="desc-text-content">
                                   <?php
                    
                    echo do_shortcode("[lilacs_busca_capacitacao]");
                    
                    ?>
            </div>

    </article>
</section>


