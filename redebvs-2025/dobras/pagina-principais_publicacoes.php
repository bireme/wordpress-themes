<?php
/**
 * Dobra: Principais Publicações
 * Slug esperado: pagina-principais_publicacoes
 *
 * Usa o layout "principais_publicacoes" do Flexible Content "layout"
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$titulo_secao = get_sub_field( 'titulo' );
$banner_url   = get_sub_field( 'banner' ); // URL da imagem do lado direito

// Monta array de publicações
$publicacoes = array();
if ( have_rows( 'publicacoes' ) ) {
    while ( have_rows( 'publicacoes' ) ) {
        the_row();
        $publicacoes[] = array(
            'titulo'   => get_sub_field( 'titulo' ),
            'descricao'=> get_sub_field( 'descricao_publi' ),
            'link'     => get_sub_field( 'link' ),
        );
    }
}

// Se não tiver nada, não quebra a página
if ( empty( $publicacoes ) && empty( $banner_url ) ) {
    return;
}
?>

<style>
/* --------------------------------------------- */
/* PRINCIPAIS PUBLICAÇÕES – GUIA DA BVS          */
/* Layout baseado no print enviado               */
/* --------------------------------------------- */

.bvs-princ-pubs {
    padding: 32px 0 40px;
    background: #f8fafc;
}

.bvs-princ-pubs-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

/* Título da seção */

.bvs-princ-pubs-title {
    font-size: 26px;
    font-weight: 700;
    color: #233a8b;
    margin-bottom: 16px;
}

/* Grid principal: cards à esquerda + banner à direita */

.bvs-princ-pubs-layout {
    display: grid;
    grid-template-columns: minmax(0, 6fr) minmax(0, 1.8fr);
    gap: 16px;
    align-items: stretch;
}

/* Column esquerda – cards */

.bvs-princ-pubs-cards {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
}

/* Card base */

.bvs-princ-pubs-card {
    background: #ffffff;
    border-radius: 10px;
    padding: 10px 12px;
    box-shadow: 0 0 0 1px #e2e8f0;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.bvs-princ-pubs-card-title {
    font-size: 18px;
    font-weight: 700;
    color:#233a8b;
}

.bvs-princ-pubs-card-desc {
    font-size: 16px;
    line-height: 1.45;
    color: #233a8b;
}

/* Card grande (4º) ocupando toda a linha */

.bvs-princ-pubs-card--full {
    grid-column: 1 / span 3;
}

/* Column direita – banner + botão "Ver todos" */

.bvs-princ-pubs-side {
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: stretch;
}

.bvs-princ-pubs-banner {
    flex: 1;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
}

.bvs-princ-pubs-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
        border-radius: 10px 60px 10px 10px;
}

/* Botão "Ver todos" */

.bvs-princ-pubs-footer {
    display: flex;
    justify-content: flex-end;
}

.bvs-princ-pubs-more {
    display: inline-block;
    padding: 8px 45px;
    background: #233a8b;
    color: #fff;
    border-radius: 999px;
    text-decoration: none;
    font-size: 13px;
}

.bvs-princ-pubs-more:hover {
    background: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 14px 24px rgba(37, 99, 235, 0.4);
}

/* Responsivo */

@media (max-width: 1024px) {
    .bvs-princ-pubs-layout {
        grid-template-columns: minmax(0, 1.4fr) minmax(0, 1.3fr);
    }
}

@media (max-width: 768px) {
    .bvs-princ-pubs-layout {
        grid-template-columns: minmax(0, 1fr);
    }

    .bvs-princ-pubs-side {
        order: -1; /* banner sobe no mobile, se quiser pode remover */
    }

    .bvs-princ-pubs-cards {
        grid-template-columns: minmax(0, 1fr);
    }

    .bvs-princ-pubs-card--full {
        grid-column: auto;
    }

    .bvs-princ-pubs-more {
        width: 100%;
        justify-content: center;
    }
}
</style>

<section class="bvs-princ-pubs">
    <div class="bvs-princ-pubs-inner">

        <h2 class="bvs-princ-pubs-title">
            <?php
            if ( ! empty( $titulo_secao ) ) {
                echo esc_html( $titulo_secao );
            } else {
                echo esc_html__( 'Principais publicações', 'rede-bvs' );
            }
            ?>
        </h2>

        <div class="bvs-princ-pubs-layout">

            <!-- Coluna dos cards -->
            <div class="bvs-princ-pubs-cards">
                <?php
                if ( ! empty( $publicacoes ) ) :
                    foreach ( $publicacoes as $index => $pub ) :
                        if ( empty( $pub['titulo'] ) && empty( $pub['descricao'] ) ) {
                            continue;
                        }

                        // 4º item vira card grande igual ao print
                        $card_classes = 'bvs-princ-pubs-card';
                        if ( $index === 3 ) {
                            $card_classes .= ' bvs-princ-pubs-card--full';
                        }
                        ?>
                        <article class="<?php echo esc_attr( $card_classes ); ?>">
                            <?php if ( ! empty( $pub['titulo'] ) ) : ?>
                                <h3 class="bvs-princ-pubs-card-title">
                                    <?php echo esc_html( $pub['titulo'] ); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ( ! empty( $pub['descricao'] ) ) : ?>
                                <p class="bvs-princ-pubs-card-desc">
                                    <?php echo esc_html( $pub['descricao'] ); ?>
                                </p>
                            <?php endif; ?>

                            <?php if ( ! empty( $pub['link'] ) ) : ?>
                                <a href="<?php echo esc_url( $pub['link'] ); ?>"
                                   target="_blank" rel="noopener"
                                   style="margin-top:4px;font-size:10px;color:#2563eb;text-decoration:underline;">
                                    <?php esc_html_e( 'Acessar publicação', 'rede-bvs' ); ?>
                                </a>
                            <?php endif; ?>
                        </article>
                        <?php
                    endforeach;
                endif;
                ?>
            </div><!-- .bvs-princ-pubs-cards -->

            <!-- Coluna do banner + botão -->
            <div class="bvs-princ-pubs-side">
                <?php if ( ! empty( $banner_url ) ) : ?>
                    <div class="bvs-princ-pubs-banner">
                        <img src="<?php echo esc_url( $banner_url ); ?>"
                             alt="<?php echo esc_attr( $titulo_secao ? $titulo_secao : __( 'Principais publicações', 'rede-bvs' ) ); ?>">
                    </div>
                <?php endif; ?>

                <div class="bvs-princ-pubs-footer">
                    <!-- Ajuste o href conforme a página de listagem completa -->
                    <a href="#"
                       class="bvs-princ-pubs-more">
                        <?php esc_html_e( 'Ver todos', 'rede-bvs' ); ?>
                    </a>
                </div>
            </div><!-- .bvs-princ-pubs-side -->

        </div><!-- .bvs-princ-pubs-layout -->

    </div>
</section>
