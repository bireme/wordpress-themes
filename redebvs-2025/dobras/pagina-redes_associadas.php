<?php
/**
 * Dobra "Redes Associadas" - flexible layout: redes_associadas
 *
 * Campos:
 *  - titulo (text)
 *  - redes_associadas_ (repeater)
 *      - titulo (text)
 *      - link (url)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$redes_titulo = get_sub_field( 'titulo' );
$redes_rep    = get_sub_field( 'redes_associadas_' );
?>

<style>
/* --------------------- REDES ASSOCIADAS --------------------- */

.pais-redes-assoc-section{
    margin: 24px auto 0;
    max-width: 1180px;
    padding: 0 16px;
}

/* caixa segue a largura da coluna do flexible (50%) */
.pais-redes-assoc-box{
    background: transparent;
}

/* faixa de título */

.pais-redes-assoc-header{
    display: inline-block;
    margin-top: 4px;
    padding: 8px 14px;
    border-radius: 8px;
    background: #e5e7eb;
    font-size: 16px;
    width:98%;
    font-weight: 600;
    color: #374151;
}

/* pílulas */

.pais-redes-assoc-body{
    margin-top: 8px;
}

.pais-redes-assoc-pills{
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.pais-redes-assoc-pill{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 14px;
    border-radius: 999px;
    border: 1px solid #2f74c0;
    background: #ffffff;
    font-size: 13px;
    line-height: 1.3;
    color: #1f2937;
    text-decoration: none;
    white-space: nowrap;
}

.pais-redes-assoc-pill:hover{
    background: #e5f1ff;
}

/* sem link */

.pais-redes-assoc-pill--nolink{
    cursor: default;
}

/* responsivo: quando virar 1 coluna só, mantém visual ok */

@media (max-width: 640px){
    .pais-redes-assoc-section{
        padding: 0 12px;
    }
    .pais-redes-assoc-header{
        font-size: 13px;
    }
    .pais-redes-assoc-pill{
        padding: 4px 12px;
        font-size: 12px;
    }
}
</style>

<section class="pais-redes-assoc-section">
    <div class="pais-redes-assoc-box">

        <div class="pais-redes-assoc-header">
            <?php echo esc_html( $redes_titulo ?: __( 'Redes Associadas', 'bvs' ) ); ?>
        </div>

        <?php if ( ! empty( $redes_rep ) ) : ?>
            <div class="pais-redes-assoc-body">
                <div class="pais-redes-assoc-pills">
                    <?php foreach ( $redes_rep as $row ) :
                        $texto = isset( $row['titulo'] ) ? trim( $row['titulo'] ) : '';
                        $link  = isset( $row['link'] ) ? trim( $row['link'] ) : '';
                        if ( ! $texto ) {
                            continue;
                        }
                        ?>
                        <?php if ( $link ) : ?>
                            <a class="pais-redes-assoc-pill" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener">
                                <?php echo esc_html( $texto ); ?>
                            </a>
                        <?php else : ?>
                            <span class="pais-redes-assoc-pill pais-redes-assoc-pill--nolink">
                                <?php echo esc_html( $texto ); ?>
                            </span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
