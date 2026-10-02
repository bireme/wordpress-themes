<?php
/**
 * Conteúdo livre da single encontro-da-rede.
 * Usado quando o campo modo_do_encontro = livre.
 * O cabeçalho (encontros-banner) fica fora deste arquivo.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'rede_bvs_encontro_livre_html' ) ) {
    function rede_bvs_encontro_livre_html( $html ) {
        if ( ! $html ) {
            return;
        }
        echo apply_filters( 'the_content', $html );
    }
}

if ( ! function_exists( 'rede_bvs_encontro_livre_imagem' ) ) {
    function rede_bvs_encontro_livre_imagem( $imagem, $size = 'large' ) {
        if ( empty( $imagem ) || ! is_array( $imagem ) ) {
            return;
        }

        $alt = isset( $imagem['alt'] ) ? $imagem['alt'] : '';

        if ( ! empty( $imagem['ID'] ) ) {
            echo wp_get_attachment_image(
                (int) $imagem['ID'],
                $size,
                false,
                array(
                    'class'   => 'encontro-livre-img',
                    'alt'     => $alt,
                    'loading' => 'lazy',
                )
            );
            return;
        }

        if ( ! empty( $imagem['url'] ) ) {
            echo '<img class="encontro-livre-img" src="' . esc_url( $imagem['url'] ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy">';
        }
    }
}

if ( ! function_exists( 'rede_bvs_encontro_livre_botao' ) ) {
    function rede_bvs_encontro_livre_botao( $link, $class = 'encontro-livre-btn' ) {
        if ( ! is_array( $link ) || empty( $link['url'] ) ) {
            return;
        }

        $target = ! empty( $link['target'] ) ? $link['target'] : '_self';
        $label  = ! empty( $link['title'] ) ? $link['title'] : $link['url'];
        $rel    = ( '_blank' === $target ) ? ' noopener noreferrer' : '';

        echo '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $target ) . '"';
        if ( $rel ) {
            echo ' rel="' . esc_attr( trim( $rel ) ) . '"';
        }
        echo '>' . esc_html( $label ) . '</a>';
    }
}
?>

<style>
.encontro-livre {
    max-width: 1180px;
    margin: 8px auto 72px;
    padding: 0 16px;
}

.encontro-livre-bloco {
    margin-top: 40px;
}

.encontro-livre-bloco h2 {
    margin: 0 0 14px;
    color: #002c71;
    font-size: 28px;
    font-weight: 700;
    line-height: 1.25;
}

.encontro-livre-texto.is-estreita .encontro-livre-texto-inner {
    max-width: 760px;
}

.encontro-livre-richtext {
    color: #1f2937;
    font-size: 16px;
    line-height: 1.7;
}

.encontro-livre-richtext > *:first-child {
    margin-top: 0;
}

.encontro-livre-richtext > *:last-child {
    margin-bottom: 0;
}

.encontro-livre-richtext a {
    color: #0056A6;
}

.encontro-livre-richtext img,
.encontro-livre-richtext video,
.encontro-livre-richtext iframe {
    max-width: 100%;
    height: auto;
}

.encontro-livre-split {
    display: grid;
    grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.2fr);
    gap: 32px;
    align-items: center;
    background: #fff;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 8px 26px rgba(15, 23, 42, 0.08);
}

.encontro-livre-split.is-direita {
    grid-template-columns: minmax(0, 1.2fr) minmax(0, 0.9fr);
}

.encontro-livre-split.is-direita .encontro-livre-split-media {
    order: 2;
}

.encontro-livre-split.is-sem-imagem {
    grid-template-columns: minmax(0, 1fr);
}

.encontro-livre-split-media img,
.encontro-livre-img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 10px 46px 10px 10px;
}

.encontro-livre-cards-grid {
    display: grid;
    gap: 20px;
}

.encontro-livre-cards-grid.is-2 {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}

.encontro-livre-cards-grid.is-3 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}

.encontro-livre-cards-grid.is-4 {
    grid-template-columns: repeat(4, minmax(0, 1fr));
}

.encontro-livre-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 26px rgba(15, 23, 42, 0.08);
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.encontro-livre-card-media img {
    border-radius: 0;
    aspect-ratio: 16 / 10;
    object-fit: cover;
}

.encontro-livre-card-body {
    padding: 18px 18px 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex: 1;
}

.encontro-livre-card-body h3 {
    margin: 0;
    color: #002c71;
    font-size: 18px;
    line-height: 1.3;
}

.encontro-livre-card-body .encontro-livre-richtext {
    font-size: 15px;
}

.encontro-livre-dados {
    display: grid;
    gap: 12px;
    margin: 0;
}

.encontro-livre-dados-item {
    display: grid;
    grid-template-columns: minmax(140px, 220px) minmax(0, 1fr);
    gap: 16px;
    align-items: start;
    background: #fff;
    border-radius: 14px;
    padding: 16px 20px;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);
}

.encontro-livre-dados-item dt {
    margin: 0;
    color: #0056A6;
    font-weight: 700;
}

.encontro-livre-dados-item dd {
    margin: 0;
    color: #1f2937;
    line-height: 1.6;
}

.encontro-livre-destaque {
    border-radius: 18px 72px 18px 18px;
    padding: 32px 36px;
}

.encontro-livre-destaque.is-escuro {
    background: #0b1c52;
    color: #fff;
}

.encontro-livre-destaque.is-claro {
    background: #f4f7fb;
    color: #0b1c52;
    box-shadow: 0 8px 26px rgba(15, 23, 42, 0.06);
}

.encontro-livre-destaque h2 {
    color: inherit;
}

.encontro-livre-destaque.is-escuro .encontro-livre-richtext,
.encontro-livre-destaque.is-escuro .encontro-livre-richtext a {
    color: #fff;
}

.encontro-livre-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-top: 8px;
    padding: 8px 22px;
    border-radius: 999px;
    background: #28367D;
    color: #fff !important;
    font-size: 14px;
    text-decoration: none;
    align-self: flex-start;
}

.encontro-livre-destaque.is-escuro .encontro-livre-btn {
    background: #fff;
    color: #28367D !important;
}

.encontro-livre-btn:hover {
    filter: brightness(1.08);
}

.encontro-livre-midia-frame iframe,
.encontro-livre-midia-frame video,
.encontro-livre-midia-frame embed {
    display: block;
    width: 100%;
    max-width: 100%;
    aspect-ratio: 16 / 9;
    height: auto;
    border: 0;
    border-radius: 16px;
    background: #0b1c52;
}

.encontro-livre-vazio {
    margin-top: 28px;
    padding: 20px 22px;
    border-radius: 14px;
    background: #f4f7fb;
    color: #475569;
}

@media (max-width: 900px) {
    .encontro-livre-split,
    .encontro-livre-split.is-direita,
    .encontro-livre-cards-grid.is-3,
    .encontro-livre-cards-grid.is-4,
    .encontro-livre-dados-item {
        grid-template-columns: minmax(0, 1fr);
    }

    .encontro-livre-split.is-direita .encontro-livre-split-media {
        order: 0;
    }

    .encontro-livre-cards-grid.is-2,
    .encontro-livre-cards-grid.is-3,
    .encontro-livre-cards-grid.is-4 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 640px) {
    .encontro-livre-bloco h2 {
        font-size: 22px;
    }

    .encontro-livre-cards-grid.is-2,
    .encontro-livre-cards-grid.is-3,
    .encontro-livre-cards-grid.is-4 {
        grid-template-columns: minmax(0, 1fr);
    }

    .encontro-livre-destaque {
        border-radius: 18px;
        padding: 22px 18px;
    }
}
</style>

<main class="encontro-livre">
    <?php if ( have_rows( 'blocos_do_encontro' ) ) : ?>
        <?php while ( have_rows( 'blocos_do_encontro' ) ) : the_row(); ?>
            <?php $layout = get_row_layout(); ?>

            <?php if ( 'texto' === $layout ) : ?>
                <?php
                $titulo  = get_sub_field( 'titulo' );
                $conteudo = get_sub_field( 'conteudo' );
                $largura = get_sub_field( 'largura' ) === 'estreita' ? 'is-estreita' : 'is-cheia';
                if ( ! $titulo && ! $conteudo ) {
                    continue;
                }
                ?>
                <section class="encontro-livre-bloco encontro-livre-texto <?php echo esc_attr( $largura ); ?>">
                    <div class="encontro-livre-texto-inner">
                        <?php if ( $titulo ) : ?>
                            <h2><?php echo esc_html( $titulo ); ?></h2>
                        <?php endif; ?>
                        <?php if ( $conteudo ) : ?>
                            <div class="encontro-livre-richtext">
                                <?php rede_bvs_encontro_livre_html( $conteudo ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

            <?php elseif ( 'imagem_texto' === $layout ) : ?>
                <?php
                $imagem   = get_sub_field( 'imagem' );
                $tem_img  = is_array( $imagem ) && ( ! empty( $imagem['ID'] ) || ! empty( $imagem['url'] ) );
                $posicao  = get_sub_field( 'posicao_imagem' ) === 'direita' ? 'is-direita' : 'is-esquerda';
                $titulo   = get_sub_field( 'titulo' );
                $texto    = get_sub_field( 'texto' );
                $link     = get_sub_field( 'link' );
                if ( ! $tem_img && ! $titulo && ! $texto ) {
                    continue;
                }
                ?>
                <section class="encontro-livre-bloco encontro-livre-split <?php echo esc_attr( $tem_img ? $posicao : 'is-sem-imagem' ); ?>">
                    <?php if ( $tem_img ) : ?>
                    <div class="encontro-livre-split-media">
                        <?php rede_bvs_encontro_livre_imagem( $imagem ); ?>
                    </div>
                    <?php endif; ?>
                    <div class="encontro-livre-split-copy">
                        <?php if ( $titulo ) : ?>
                            <h2><?php echo esc_html( $titulo ); ?></h2>
                        <?php endif; ?>
                        <?php if ( $texto ) : ?>
                            <div class="encontro-livre-richtext">
                                <?php rede_bvs_encontro_livre_html( $texto ); ?>
                            </div>
                        <?php endif; ?>
                        <?php rede_bvs_encontro_livre_botao( $link ); ?>
                    </div>
                </section>

            <?php elseif ( 'cards' === $layout ) : ?>
                <?php
                $titulo  = get_sub_field( 'titulo' );
                $colunas = (int) get_sub_field( 'colunas' );
                if ( ! in_array( $colunas, array( 2, 3, 4 ), true ) ) {
                    $colunas = 3;
                }
                $itens = get_sub_field( 'itens' );
                if ( ! $titulo && empty( $itens ) ) {
                    continue;
                }
                ?>
                <section class="encontro-livre-bloco encontro-livre-cards">
                    <?php if ( $titulo ) : ?>
                        <h2><?php echo esc_html( $titulo ); ?></h2>
                    <?php endif; ?>
                    <?php if ( ! empty( $itens ) && is_array( $itens ) ) : ?>
                        <div class="encontro-livre-cards-grid is-<?php echo (int) $colunas; ?>">
                            <?php foreach ( $itens as $item ) : ?>
                                <article class="encontro-livre-card">
                                    <?php if ( ! empty( $item['imagem'] ) ) : ?>
                                        <div class="encontro-livre-card-media">
                                            <?php rede_bvs_encontro_livre_imagem( $item['imagem'], 'medium_large' ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="encontro-livre-card-body">
                                        <?php if ( ! empty( $item['titulo'] ) ) : ?>
                                            <h3><?php echo esc_html( $item['titulo'] ); ?></h3>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $item['texto'] ) ) : ?>
                                            <div class="encontro-livre-richtext">
                                                <?php rede_bvs_encontro_livre_html( $item['texto'] ); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php rede_bvs_encontro_livre_botao( isset( $item['link'] ) ? $item['link'] : array() ); ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>

            <?php elseif ( 'dados' === $layout ) : ?>
                <?php
                $titulo = get_sub_field( 'titulo' );
                $linhas = get_sub_field( 'linhas' );
                if ( ! $titulo && empty( $linhas ) ) {
                    continue;
                }
                ?>
                <section class="encontro-livre-bloco encontro-livre-dados-bloco">
                    <?php if ( $titulo ) : ?>
                        <h2><?php echo esc_html( $titulo ); ?></h2>
                    <?php endif; ?>
                    <?php if ( ! empty( $linhas ) && is_array( $linhas ) ) : ?>
                        <dl class="encontro-livre-dados">
                            <?php foreach ( $linhas as $linha ) : ?>
                                <?php if ( empty( $linha['rotulo'] ) && empty( $linha['valor'] ) ) { continue; } ?>
                                <div class="encontro-livre-dados-item">
                                    <dt><?php echo esc_html( $linha['rotulo'] ); ?></dt>
                                    <dd><?php echo wp_kses_post( $linha['valor'] ); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    <?php endif; ?>
                </section>

            <?php elseif ( 'destaque' === $layout ) : ?>
                <?php
                $estilo = get_sub_field( 'estilo' ) === 'claro' ? 'is-claro' : 'is-escuro';
                $titulo = get_sub_field( 'titulo' );
                $texto  = get_sub_field( 'texto' );
                $link   = get_sub_field( 'link' );
                if ( ! $titulo && ! $texto && empty( $link['url'] ) ) {
                    continue;
                }
                ?>
                <section class="encontro-livre-bloco encontro-livre-destaque <?php echo esc_attr( $estilo ); ?>">
                    <?php if ( $titulo ) : ?>
                        <h2><?php echo esc_html( $titulo ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $texto ) : ?>
                        <div class="encontro-livre-richtext">
                            <?php rede_bvs_encontro_livre_html( $texto ); ?>
                        </div>
                    <?php endif; ?>
                    <?php rede_bvs_encontro_livre_botao( $link ); ?>
                </section>

            <?php elseif ( 'midia' === $layout ) : ?>
                <?php
                $titulo   = get_sub_field( 'titulo' );
                $conteudo = get_sub_field( 'conteudo' );
                if ( ! $titulo && ! $conteudo ) {
                    continue;
                }
                ?>
                <section class="encontro-livre-bloco encontro-livre-midia">
                    <?php if ( $titulo ) : ?>
                        <h2><?php echo esc_html( $titulo ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $conteudo ) : ?>
                        <div class="encontro-livre-richtext encontro-livre-midia-frame">
                            <?php rede_bvs_encontro_livre_html( $conteudo ); ?>
                        </div>
                    <?php endif; ?>
                </section>

            <?php elseif ( 'html' === $layout ) : ?>
                <?php
                $html = get_sub_field( 'codigo_html', false );
                $css  = get_sub_field( 'codigo_css', false );
                $html = is_string( $html ) ? $html : '';
                $css  = is_string( $css ) ? $css : '';
                if ( '' === trim( $html ) && '' === trim( $css ) ) {
                    continue;
                }
                $css = preg_replace( '/<\s*\/\s*style/i', '', $css );
                ?>
                <section class="encontro-livre-bloco encontro-livre-html">
                    <?php if ( '' !== trim( $css ) ) : ?>
                        <style><?php echo $css; ?></style>
                    <?php endif; ?>
                    <?php if ( '' !== trim( $html ) ) : ?>
                        <div class="encontro-livre-html-codigo">
                            <?php echo $html; ?>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

        <?php endwhile; ?>
    <?php elseif ( current_user_can( 'edit_post', get_the_ID() ) ) : ?>
        <p class="encontro-livre-vazio">Este encontro está no modo conteúdo livre, mas ainda não tem blocos. Adicione blocos no campo “Blocos do conteúdo livre”.</p>
    <?php endif; ?>
</main>
