<?php
if (!defined('ABSPATH')) exit;

// Campos da layout "sobre"
$imagem    = get_sub_field('imagem');   // return_format: array
$titulo    = get_sub_field('titulo');
$descricao = get_sub_field('descricao');

$img_url = '';
if ( !empty($imagem) && !empty($imagem['url']) ) {
    $img_url = $imagem['url'];
}
?>

<style>
    .home-sobre-imagem{
            max-width: 49%;
    float: left;
    display: block;
    z-index: 99999999;
    }
    .home-sobre-imagem img{
        width:100%;
        border-radius:10px 90px 10px 10px;
        margin-top: -66px;
        min-height: 502px;
    object-fit: cover;
    }
    .home-sobre-texto{
            width: 55%;
    float: left;
    z-index: 99999999;
    }
    .home-sobre{
        margin-top:10px;
    }

    /* ===== Ajustes necessários ===== */
    .home-sobre-inner::after{
        content:"";
        display:block;
        clear:both;
    }

    /* Mantém formatação do WYSIWYG (listas, links, strong etc.) */
    .home-sobre-texto *{
        max-width: 100%;
        word-break: break-word;
    }

    /* ===== Responsivo: imagem 100% acima, texto 100% abaixo ===== */
    @media (max-width: 768px){
        .home-sobre-imagem,
        .home-sobre-texto{
            float: none;
            width: 100% !important;
            max-width: 100% !important;
        }

        .home-sobre-imagem img{
            margin-top: 0;
            min-height: 0;
            height: auto;
        }
    }
</style>

<section class="home-sobre">
    <div class="home-sobre-inner">

        <?php if ($img_url): ?>
            <div class="home-sobre-imagem">
                <img src="<?php echo esc_url($img_url); ?>"
                     alt="<?php echo esc_attr($imagem['alt'] ?? $titulo); ?>">
            </div>
        <?php endif; ?>

        <div class="home-sobre-texto">
            <?php if ($titulo): ?>
                <h2><?php echo esc_html($titulo); ?></h2>
            <?php endif; ?>

            <?php if ($descricao): ?>
                <div class="home-sobre-descricao">
                    <?php
                    // Renderiza HTML do WYSIWYG com sanitização padrão do WP
                    echo wp_kses_post( wpautop( $descricao ) );
                    ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>
