<?php
/**
 * Dobra: Página – Veja também
 * Slug esperado: pagina-veja_tambem
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$titulo = get_sub_field( 'titulo' );
$itens  = get_sub_field( 'itens' );

if ( ! $itens || ! is_array( $itens ) ) {
    return;
}
?>

<section class="bvs-veja-tambem">
    <div class="bvs-veja-tambem-inner">

        <?php if ( $titulo ) : ?>
            <h2 class="bvs-veja-tambem-title">
                <?php echo esc_html( $titulo ); ?>
            </h2>
        <?php endif; ?>

        <div class="bvs-veja-tambem-grid">
            <?php foreach ( $itens as $item ) :
                $label = isset( $item['titulo_do_item'] ) ? $item['titulo_do_item'] : '';
                $url   = isset( $item['link_do_item'] ) ? $item['link_do_item'] : '';

                if ( ! $label ) {
                    continue;
                }

                $classes = 'bvs-veja-tambem-item';
                ?>
                <?php if ( $url ) : ?>
                    <a class="<?php echo esc_attr( $classes ); ?>"
                       href="<?php echo esc_url( $url ); ?>">
                        <span><?php echo esc_html( $label ); ?></span>
                    </a>
                <?php else : ?>
                    <div class="<?php echo esc_attr( $classes ); ?>">
                        <span><?php echo esc_html( $label ); ?></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<style>
/* ------------------------------ */
/* BVS – Veja também (dobra)      */
/* ------------------------------ */

.bvs-veja-tambem {
    margin: 32px 0 24px;
}

.bvs-veja-tambem-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

.bvs-veja-tambem-title {
    font-size: 26px;
    margin: 0 0 10px;
    color: #233a8b;
    font-weight: 600;
}

/* GRID DOS BOTÕES – sempre preenchendo a largura */
.bvs-veja-tambem-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 12px 16px;
}

/* ITEM BASE – cinza, ocupa sempre o máximo da coluna */
.bvs-veja-tambem-item {
    display: flex;
    align-items: center;
    padding: 14px 20px;
    text-decoration: none;
    font-size: 18px;
    font-weight: 500;
    color: #ffffff;
    background: #A2A2A2;
    border-radius: 16px 60px 16px 16px;
    box-shadow: 0 4px 10px rgba(15, 23, 42, 0.12);
    transition: transform 0.15s 
ease, box-shadow 0.15s 
ease, background 0.15s 
ease, color 0.15s 
ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 49px;
}

.bvs-veja-tambem-item span {
    display: inline-block;
}

/* HOVER / FOCO – fica azul #28367D somente ao passar o mouse */
.bvs-veja-tambem-item:hover,
.bvs-veja-tambem-item:focus-visible {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(15, 23, 42, 0.20);
    outline: none;
    background: #28367D;
    color: #ffffff;
}

/* Mobile */
@media (max-width: 640px) {
    .bvs-veja-tambem-grid {
        grid-template-columns: 1fr;
    }

    .bvs-veja-tambem-item {
        border-radius: 14px 40px 14px 14px;
    }
}
</style>
