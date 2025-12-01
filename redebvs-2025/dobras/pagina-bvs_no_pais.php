<?php
/**
 * Dobra "BVS no País" - flexible layout: bvs_no_pais
 * Campos:
 *  - titulo (texto)
 *  - nacional (repeater)
 *      - adicione_um_campo_para_a_pilula (texto)
 *      - link (url)
 *  - tematicas (repeater)
 *      - nome_da_tematica (texto)
 *      - link (texto/url)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$bvs_titulo   = get_sub_field( 'titulo' );
$nacional_rep = get_sub_field( 'nacional' );
$tematicas_rep = get_sub_field( 'tematicas' );
?>

<style>
/* --------------------- BVS NO PAÍS --------------------- */

.pais-bvs-section{
    margin: 32px auto 0;
    max-width: 1180px;
    padding: 0 16px;
}

.pais-bvs-box{
    border-radius: 4px;
    overflow: hidden;
    background: #ffffff;
}

/* faixa de título */

.pais-bvs-header{
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

/* corpo */

.pais-bvs-body{
    padding: 16px 18px 18px;
    font-size: 14px;
}

.pais-bvs-group{
    margin-bottom: 16px;
}

.pais-bvs-group:last-child{
    margin-bottom: 0;
}

.pais-bvs-group-label{
    font-weight: 700;
    color: #111827;
    margin-bottom: 6px;
}

/* pílulas */

.pais-bvs-pills{
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.pais-bvs-pill{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px 14px;
    border-radius: 999px;
    border: 1px solid #2f74c0;
    background: #ffffff;
    font-size: 13px;
    line-height: 1.3;
    color: #1f2937;
    text-decoration: none;
    white-space: nowrap;
}

.pais-bvs-pill:hover{
    background: #e5f1ff;
}

/* se não tiver link, só span */

.pais-bvs-pill--nolink{
    cursor: default;
}

/* responsivo */

@media (max-width: 640px){
    .pais-bvs-body{
        padding: 12px 12px 14px;
    }
    .pais-bvs-pill{
        padding: 5px 12px;
        font-size: 12px;
    }
}
</style>

<section class="pais-bvs-section">
    <div class="pais-bvs-box">

        <div class="pais-bvs-header">
            <?php echo esc_html( $bvs_titulo ?: __( 'BVS no país', 'bvs' ) ); ?>
        </div>

        <div class="pais-bvs-body">

            <?php if ( ! empty( $nacional_rep ) ) : ?>
                <div class="pais-bvs-group pais-bvs-group--nacional">
                    <div class="pais-bvs-group-label"><?php esc_html_e( 'Nacional', 'bvs' ); ?></div>
                    <div class="pais-bvs-pills">
                        <?php foreach ( $nacional_rep as $row ) :
                            $texto = isset( $row['adicione_um_campo_para_a_pilula'] ) ? trim( $row['adicione_um_campo_para_a_pilula'] ) : '';
                            $link  = isset( $row['link'] ) ? trim( $row['link'] ) : '';
                            if ( ! $texto ) {
                                continue;
                            }
                            ?>
                            <?php if ( $link ) : ?>
                                <a class="pais-bvs-pill" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener">
                                    <?php echo esc_html( $texto ); ?>
                                </a>
                            <?php else : ?>
                                <span class="pais-bvs-pill pais-bvs-pill--nolink">
                                    <?php echo esc_html( $texto ); ?>
                                </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $tematicas_rep ) ) : ?>
                <div class="pais-bvs-group pais-bvs-group--tematicas">
                    <div class="pais-bvs-group-label"><?php esc_html_e( 'Temáticas', 'bvs' ); ?></div>
                    <div class="pais-bvs-pills">
                        <?php foreach ( $tematicas_rep as $row ) :
                            $texto = isset( $row['nome_da_tematica'] ) ? trim( $row['nome_da_tematica'] ) : '';
                            $link  = isset( $row['link'] ) ? trim( $row['link'] ) : '';
                            if ( ! $texto ) {
                                continue;
                            }
                            ?>
                            <?php if ( $link ) : ?>
                                <a class="pais-bvs-pill" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener">
                                    <?php echo esc_html( $texto ); ?>
                                </a>
                            <?php else : ?>
                                <span class="pais-bvs-pill pais-bvs-pill--nolink">
                                    <?php echo esc_html( $texto ); ?>
                                </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            /**
             * Se depois você criar um repeater "institucionais" no ACF,
             * basta repetir o bloco acima mudando os nomes dos campos e o label
             * para "Institucionais".
             */
            ?>

        </div>
    </div>
</section>
