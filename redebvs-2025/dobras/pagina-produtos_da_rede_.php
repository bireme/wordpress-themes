<?php
/**
 * Dobra "Produtos da Rede" - flexible layout: produtos_da_rede_
 *
 * Campos:
 *  - titulo (text)      => título da faixa ("Produtos da Rede")
 *  - descricao (wysiwyg) => conteúdo com lista de produtos
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$prod_titulo    = get_sub_field( 'titulo' );
$prod_descricao = get_sub_field( 'descricao' );
?>

<style>
/* --------------------- PRODUTOS DA REDE --------------------- */

.pais-produtos-section{
    margin: 32px auto 0;
    max-width: 1180px;
    padding: 0 16px;
}

.pais-produtos-box{
    border-radius: 4px;
    overflow: hidden;
    background: #ffffff;
}

/* faixa de título */

.pais-produtos-header{
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

/* corpo com conteúdo rolável */

.pais-produtos-body{
    padding: 14px 18px 18px;
    font-size: 14px;
    line-height: 1.6;
    color: #111827;

    max-height: 380px;       /* ajusta conforme o layout desejado */
    overflow-y: auto;
}

.pais-produtos-body p{
    margin-bottom: 8px;
}

/* títulos internos dos produtos (primeira linha em negrito) */

.pais-produtos-body strong{
    font-weight: 700;
}

/* responsivo */

@media (max-width: 640px){
    .pais-produtos-body{
        padding: 12px 12px 14px;
        font-size: 13px;
    }
}
</style>

<section class="pais-produtos-section">
    <div class="pais-produtos-box">

        <div class="pais-produtos-header">
            <?php echo esc_html( $prod_titulo ?: __( 'Produtos da Rede', 'bvs' ) ); ?>
        </div>

        <div class="pais-produtos-body">
            <?php
            if ( $prod_descricao ) {
                // usa the_content para manter parágrafos, listas etc.
                echo apply_filters( 'the_content', $prod_descricao );
            }
            ?>
        </div>

    </div>
</section>
