<?php
/**
 * Dobra: Declarações
 * Slug esperado no flexible: pagina-declaracao
 *
 * Usa o layout "declaracao" do Flexible Content "layout".
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Campos da seção
$titulo_secao     = get_sub_field( 'titulo' );
$descricao_secao  = get_sub_field( 'descricao' );

// Repeater de declarações
$declaracoes = array();
if ( have_rows( 'declaracoes' ) ) {
    while ( have_rows( 'declaracoes' ) ) {
        the_row();
        $declaracoes[] = array(
            'titulo'          => get_sub_field( 'titulo' ),
            'breve_descricao' => get_sub_field( 'breve_descricao' ),
            'link'            => get_sub_field( 'link' ),
        );
    }
}

// Se não houver nada, não renderiza
if ( empty( $declaracoes ) && empty( $titulo_secao ) && empty( $descricao_secao ) ) {
    return;
}

if ( ! $titulo_secao ) {
    $titulo_secao = __( 'Declarações', 'rede-bvs' );
}
?>

<style>
/* -------------------------------------------------- */
/* DECLARAÇÕES – LISTA                                */
/* -------------------------------------------------- */

.bvs-declaracoes {
    padding: 28px 0 36px;
}

.bvs-declaracoes-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

/* Título + texto introdutório */

.bvs-declaracoes-title {
    font-size: 26px;
    font-weight: 700;
    color: #28367D;
    margin: 0 0 6px;
}

.bvs-declaracoes-desc {
    font-size: 16px;
    line-height: 1.55;
    color: #28367D;
    max-width: 980px;
    margin: 0 0 18px;
}

/* Lista de itens */

.bvs-declaracoes-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

/* Item base – toda a faixa é clicável quando houver link */

.bvs-declaracoes-item {
    position: relative;
    display: flex;
    align-items: stretch;
    justify-content: space-between;
    background: #eef0f7;
    border-radius: 8px;
    padding: 10px 40px 10px 18px;
    text-decoration: none;
    box-shadow: 0 1px 0 rgba(148, 163, 184, 0.6);
    transition:
        background 0.15s ease,
        box-shadow 0.15s ease,
        transform 0.08s ease;
}

.bvs-declaracoes-item:hover {
    background: #e3e7f3;
    box-shadow:
        0 5px 12px rgba(148, 163, 184, 0.7),
        0 0 0 1px rgba(148, 163, 184, 0.4);
    transform: translateY(-1px);
}

/* Conteúdo de texto (esquerda) */

.bvs-declaracoes-text {
    flex: 1 1 auto;
}

.bvs-declaracoes-item-title {
    font-size: 16px;
    font-weight: 500;
    color: #28367D;
    margin: 0 0 3px;
}

.bvs-declaracoes-item-sub {
    font-size: 14px;
    line-height: 1.45;
    color: #28367D;
    margin: 0;
}

/* Seta à direita (igual ao print, triangular) */

.bvs-declaracoes-item::after {
    content: '';
    position: absolute;
    top: 50%;
    right: 18px;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-top: 7px solid transparent;
    border-bottom: 7px solid transparent;
    border-left: 8px solid #28367D;
}

/* Quando não tiver link, não muda cursor */

.bvs-declaracoes-item--nolink {
    cursor: default;
}

.bvs-declaracoes-item--nolink:hover {
    transform: none;
    box-shadow: 0 1px 0 rgba(148, 163, 184, 0.6);
}

/* Responsivo */

@media (max-width: 768px) {
    .bvs-declaracoes {
        padding: 22px 0 28px;
    }

    .bvs-declaracoes-item {
        padding: 10px 36px 10px 14px;
    }

    .bvs-declaracoes-item-title {
        font-size: 12px;
    }

    .bvs-declaracoes-item-sub {
        font-size: 10px;
    }
}
</style>

<section class="bvs-declaracoes">
    <div class="bvs-declaracoes-inner">

        <h2 class="bvs-declaracoes-title">
            <?php echo esc_html( $titulo_secao ); ?>
        </h2>

        <?php if ( ! empty( $descricao_secao ) ) : ?>
            <p class="bvs-declaracoes-desc">
                <?php echo nl2br( esc_html( $descricao_secao ) ); ?>
            </p>
        <?php endif; ?>

        <?php if ( ! empty( $declaracoes ) ) : ?>
            <div class="bvs-declaracoes-list">
                <?php foreach ( $declaracoes as $item ) :

                    if ( empty( $item['titulo'] ) && empty( $item['breve_descricao'] ) ) {
                        continue;
                    }

                    $has_link = ! empty( $item['link'] );
                    $tag      = $has_link ? 'a' : 'div';

                    $classes = 'bvs-declaracoes-item';
                    if ( ! $has_link ) {
                        $classes .= ' bvs-declaracoes-item--nolink';
                    }

                    $attrs = 'class="' . esc_attr( $classes ) . '"';
                    if ( $has_link ) {
                        $attrs .= ' href="' . esc_url( $item['link'] ) . '" target="_blank" rel="noopener"';
                    }
                    ?>
                    <<?php echo $tag . ' ' . $attrs; ?>>
                        <div class="bvs-declaracoes-text">
                            <?php if ( ! empty( $item['titulo'] ) ) : ?>
                                <p class="bvs-declaracoes-item-title">
                                    <?php echo esc_html( $item['titulo'] ); ?>
                                </p>
                            <?php endif; ?>

                            <?php if ( ! empty( $item['breve_descricao'] ) ) : ?>
                                <p class="bvs-declaracoes-item-sub">
                                    <?php echo esc_html( $item['breve_descricao'] ); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </<?php echo $tag; ?>>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
