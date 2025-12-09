<?php
/**
 * Dobra: Página – Modelos de documentos
 * Slug esperado: pagina-modelos_de_documentos
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Campo título
$titulo = get_sub_field( 'titulo' );

// Repeater (sem name, então usamos a KEY do campo)
$modelos = get_sub_field( 'modelos' );

if ( ! $modelos || ! is_array( $modelos ) ) {
    return;
}
?>

<section class="bvs-modelos-documentos">
    <div class="bvs-modelos-documentos-inner">

        <?php if ( $titulo ) : ?>
            <h2 class="bvs-modelos-documentos-title">
                <?php echo esc_html( $titulo ); ?>
            </h2>
        <?php endif; ?>

        <div class="bvs-modelos-documentos-grid">
            <?php foreach ( $modelos as $modelo ) :

                $label = isset( $modelo['titulo_do_modelo'] ) ? $modelo['titulo_do_modelo'] : '';
                $url   = isset( $modelo['link_do_modelo'] ) ? $modelo['link_do_modelo'] : '';

                if ( ! $label ) {
                    continue;
                }

                ?>
                <?php if ( $url ) : ?>
                    <a class="bvs-modelos-documentos-item"
                       href="<?php echo esc_url( $url ); ?>">
                        <span><?php echo esc_html( $label ); ?></span>
                    </a>
                <?php else : ?>
                    <div class="bvs-modelos-documentos-item">
                        <span><?php echo esc_html( $label ); ?></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<style>
/* ---------------------------------------- */
/* BVS – Modelos de Documentos (dobra)      */
/* ---------------------------------------- */

.bvs-modelos-documentos {
    margin: 32px 0 24px;
}

.bvs-modelos-documentos-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

.bvs-modelos-documentos-title {
    font-size: 26px;
    margin: 0 0 12px;
    color: #233a8b;
    font-weight: 600;
}

/* GRID – linha de cards preenchendo largura */
.bvs-modelos-documentos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px 16px;
}

/* CARD – como na referência */
.bvs-modelos-documentos-item {
    background: #F2F2F2;          /* cinza claro */
    border-radius: 12px;
    padding: 18px 20px;
    text-align: center;
    text-decoration: none;
    color: #28367D;               /* azul do texto */
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 72px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.08);
    transition: background 0.15s ease,
                box-shadow 0.15s ease,
                transform 0.15s ease;
}

.bvs-modelos-documentos-item span {
    display: inline-block;
    line-height: 1.3;
    text-align: left;
}

/* Hover / foco – sutis, mantendo o look institucional */
.bvs-modelos-documentos-item:hover,
.bvs-modelos-documentos-item:focus-visible {
    background: #e5e7eb;
    box-shadow: 0 4px 10px rgba(15, 23, 42, 0.16);
    transform: translateY(-1px);
    outline: none;
}

/* Mobile */
@media (max-width: 640px) {
    .bvs-modelos-documentos-grid {
        grid-template-columns: 1fr 1fr;
    }

    @media (max-width: 420px) {
        .bvs-modelos-documentos-grid {
            grid-template-columns: 1fr;
        }
    }
}
</style>
