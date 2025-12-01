<?php
/**
 * Dobra "Saúde nas Américas" - flexible layout: saude_nas_americas
 *
 * Campos:
 *  - titulo (text)
 *  - saude (repeater)
 *      - titulo (text)
 *      - link (url)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$saude_titulo = get_sub_field( 'titulo' );
$saude_rep    = get_sub_field( 'saude' );
?>

<style>
/* --------------------- SAÚDE NAS AMÉRICAS --------------------- */

.pais-saude-ams-section{
    margin: 24px auto 0;
    max-width: 1180px;
    padding: 0 16px;
}

/* caixa segue a largura da coluna do flexible (50%) */
.pais-saude-ams-box{
    background: transparent;
}

/* faixa de título */

.pais-saude-ams-header{
display: inline-block;
    margin-top: 4px;
    padding: 8px 14px;
    border-radius: 8px;
    background: #e5e7eb;
    font-size: 16px;
    width: 98%;
    font-weight: 600;
    color: #374151;
}

/* pílulas */

.pais-saude-ams-body{
    margin-top: 8px;
}

.pais-saude-ams-pills{
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.pais-saude-ams-pill{
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

.pais-saude-ams-pill:hover{
    background: #e5f1ff;
}

/* sem link */

.pais-saude-ams-pill--nolink{
    cursor: default;
}

/* responsivo */

@media (max-width: 640px){
    .pais-saude-ams-section{
        padding: 0 12px;
    }
    .pais-saude-ams-header{
        font-size: 13px;
    }
    .pais-saude-ams-pill{
        padding: 4px 12px;
        font-size: 12px;
    }
}
</style>

<section class="pais-saude-ams-section">
    <div class="pais-saude-ams-box">

        <div class="pais-saude-ams-header">
            <?php echo esc_html( $saude_titulo ?: __( 'Saúde nas Américas +', 'bvs' ) ); ?>
        </div>

        <?php if ( ! empty( $saude_rep ) ) : ?>
            <div class="pais-saude-ams-body">
                <div class="pais-saude-ams-pills">
                    <?php foreach ( $saude_rep as $row ) :
                        $texto = isset( $row['titulo'] ) ? trim( $row['titulo'] ) : '';
                        $link  = isset( $row['link'] ) ? trim( $row['link'] ) : '';
                        if ( ! $texto ) {
                            continue;
                        }
                        ?>
                        <?php if ( $link ) : ?>
                            <a class="pais-saude-ams-pill" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener">
                                <?php echo esc_html( $texto ); ?>
                            </a>
                        <?php else : ?>
                            <span class="pais-saude-ams-pill pais-saude-ams-pill--nolink">
                                <?php echo esc_html( $texto ); ?>
                            </span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
