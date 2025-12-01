<?php
/**
 * Dobra: Guia BVS
 * Slug esperado no flexible: pagina-guia_bvs
 *
 * Layout conforme print enviado.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Campos ACF
$titulo_principal      = get_sub_field( 'titulo' );
$descricao_principal   = get_sub_field( 'descricao' );
$titulo_destino        = get_sub_field( 'titulo__a_quem_se_destina' );
$descricao_destino     = get_sub_field( 'descricao__a_quem_se_destina' );
$imagem_banner_url     = trim( (string) get_sub_field( 'imagem_banner' ) );

// Repeater guias
$guias = array();
if ( have_rows( 'guias' ) ) {
    while ( have_rows( 'guias' ) ) {
        the_row();
        $guias[] = array(
            'titulo' => get_sub_field( 'titulo' ),
            'link'   => get_sub_field( 'link' ),
        );
    }
}

// Fallbacks
if ( ! $titulo_principal ) {
    $titulo_principal = __( 'Guia da BVS', 'rede-bvs' );
}
?>

<style>
/* -------------------------------------------------- */
/* GUIA DA BVS – DOBRA PRINCIPAL                      */
/* -------------------------------------------------- */

.bvs-guia-bvs-wrap {
    padding: 24px 0 32px;
    background: #dfe5f7; /* faixa externa lilás suave */
}

.bvs-guia-bvs-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

/* Cartão interno (fundo lilás claro) */

.bvs-guia-bvs-card {

    padding: 22px 26px 22px;

}

/* TOPO: imagem à esquerda + texto à direita */

.bvs-guia-bvs-top {
    display: grid;
    grid-template-columns: minmax(0, 1.5fr) minmax(0, 2.2fr);
    gap: 30px;
    align-items: center;
}

/* Imagem com canto superior direito mais arredondado */

.bvs-guia-bvs-figure {
    background: #ffffff;
    border-radius: 20px 90px 20px 20px;
    overflow: hidden;
}

.bvs-guia-bvs-figure img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Texto principal */

.bvs-guia-bvs-text-main h2 {
    font-size: 22px;
    font-weight: 700;
    color: #28367D;
    margin: 0 0 8px;
}

.bvs-guia-bvs-text-main p {
    font-size: 16px;
    line-height: 1.55;
    color: #28367D;
    margin: 0;
}

/* Bloco "A quem se destina" */

.bvs-guia-bvs-destino {
    margin-top: 16px;
}

.bvs-guia-bvs-destino-title {
    font-size: 22px;
    font-weight: 700;
    color: #28367D;
    margin: 0 0 4px;
}

.bvs-guia-bvs-destino-text {
    font-size: 16px;
    line-height: 1.55;
    color: #28367D;
    margin: 0;
}

/* Linha de guias */

.bvs-guia-bvs-guias {
    margin-top: 22px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

/* Primeiro guia – destaque azul arredondado (igual print) */

.bvs-guia-bvs-guia {
    min-height: 54px;
    padding: 0 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    height: 80px;
    border-radius: 10px 60px 10px 10px !important;
    font-size: 16px;
    text-decoration: none;
    border: 0;
    cursor: pointer;
    white-space: nowrap;
}

.bvs-guia-bvs-guia--primary {
    background: #1c3389;
    color: #ffffff;
    border-radius: 16px 40px 30px 16px;
    box-shadow: 0 14px 26px rgba(15, 23, 42, 0.35);
}

/* Demais guias – cinza com topo arredondado tipo “aba” */

.bvs-guia-bvs-guia--secondary {
    background: #c4c7d3;
    color: #111827;
    border-radius: 40px 40px 16px 16px;
}

/* -------------------------------------------------- */
/* RESPONSIVO                                         */
/* -------------------------------------------------- */

@media (max-width: 1024px) {
    .bvs-guia-bvs-top {
        grid-template-columns: minmax(0, 1.2fr) minmax(0, 1.8fr);
        gap: 22px;
    }
}

@media (max-width: 768px) {
    .bvs-guia-bvs-wrap {
        padding: 18px 0 26px;
    }

    .bvs-guia-bvs-card {
        padding: 18px 16px 18px;
    }

    .bvs-guia-bvs-top {
        grid-template-columns: minmax(0, 1fr);
        gap: 14px;
    }

    .bvs-guia-bvs-guias {
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .bvs-guia-bvs-guia {
        flex: 1 1 calc(50% - 10px);
        min-width: 150px;
        text-align: center;
        padding: 10px 16px;
        white-space: normal;
    }
}
</style>

<section class="bvs-guia-bvs-wrap">
    <div class="bvs-guia-bvs-inner">

        <div class="bvs-guia-bvs-card">

            <!-- Topo: banner + texto do guia -->
            <div class="bvs-guia-bvs-top">
                <figure class="bvs-guia-bvs-figure">
                    <?php if ( $imagem_banner_url ) : ?>
                        <img src="<?php echo esc_url( $imagem_banner_url ); ?>"
                             alt="<?php echo esc_attr( $titulo_principal ); ?>">
                    <?php else : ?>
                        <!-- Fallback vazio/placeholder -->
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/guia-bvs-placeholder.jpg' ); ?>"
                             alt="<?php echo esc_attr( $titulo_principal ); ?>">
                    <?php endif; ?>
                </figure>

                <div class="bvs-guia-bvs-text-main">
                    <h2><?php echo esc_html( $titulo_principal ); ?></h2>

                    <?php if ( ! empty( $descricao_principal ) ) : ?>
                        <p><?php echo nl2br( esc_html( $descricao_principal ) ); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- A quem se destina -->
            <div class="bvs-guia-bvs-destino">
                <?php if ( $titulo_destino ) : ?>
                    <h3 class="bvs-guia-bvs-destino-title">
                        <?php echo esc_html( $titulo_destino ); ?>
                    </h3>
                <?php endif; ?>

                <?php if ( $descricao_destino ) : ?>
                    <p class="bvs-guia-bvs-destino-text">
                        <?php echo esc_html( $descricao_destino ); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Botões de guias -->
            <?php if ( ! empty( $guias ) ) : ?>
                <div class="bvs-guia-bvs-guias">
                    <?php foreach ( $guias as $index => $guia ) :

                        if ( empty( $guia['titulo'] ) ) {
                            continue;
                        }

                        $classes = 'bvs-guia-bvs-guia';
                        $classes .= ( $index === 0 )
                            ? ' bvs-guia-bvs-guia--primary'
                            : ' bvs-guia-bvs-guia--secondary';

                        $tag   = ! empty( $guia['link'] ) ? 'a' : 'span';
                        $attrs = 'class="' . esc_attr( $classes ) . '"';

                        if ( $tag === 'a' ) {
                            $attrs .= ' href="' . esc_url( $guia['link'] ) . '" target="_blank" rel="noopener"';
                        }
                        ?>
                        <<?php echo $tag . ' ' . $attrs; ?>>
                            <?php echo esc_html( $guia['titulo'] ); ?>
                        </<?php echo $tag; ?>>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div><!-- /.bvs-guia-bvs-card -->

    </div>
</section>
