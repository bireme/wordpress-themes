<?php
/**
 * Dobra: Banner da single Produtos
 * Arquivo: /dobras/produto-banner.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Campos ACF
$imagem_fundo = get_sub_field( 'imagem_fundo_banner' ); // url
$titulo       = get_sub_field( 'titulo' );
$descricao    = get_sub_field( 'descricao' );
?>
<style>
/* BANNER SOBRE */

.sobre-banner {
    padding: 0;
    background: #ffffff;
}

.sobre-banner-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

.sobre-banner-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 10px 90px 10px 10px;
    background-color: #e4e7f0;
}

/* Imagem */
.sobre-banner-image {
    width: 100%;
    height: 220px;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;
}

/* Texto opcional (caso use título/descrição no futuro) */
.sobre-banner-text {
    position: absolute;
    left: 32px;
    top: 50%;
    transform: translateY(-50%);
    color: #ffffff;
    max-width: 420px;
}

.sobre-banner-text h1 {
    font-size: 22px;
    margin: 0 0 6px;
    font-weight: 700;
}

.sobre-banner-text p {
    margin: 0;
    font-size: 14px;
}

/* Responsivo */
@media (max-width: 768px) {
    .sobre-banner {
        padding: 20px 0 10px;
    }

    .sobre-banner-wrapper {
        border-radius: 18px 40px 40px 18px;
    }

    .sobre-banner-image {
        height: 140px;
    }

    .sobre-banner-text {
        left: 20px;
        right: 20px;
        max-width: none;
    }

    .sobre-banner-text h1 {
        font-size: 18px;
    }

    .sobre-banner-text p {
        font-size: 13px;
    }
}
</style>

<section class="sobre-banner" aria-label="<?php echo esc_attr( $titulo ? $titulo : 'Banner Sobre BVS' ); ?>">
    <div class="sobre-banner-inner">
        
            <?php
rede_bvs_breadcrumb( array(
    array(
        'label' => 'Rede BVS',
        'url'   => get_permalink( 18 ), // id da página "A Rede BVS" ou outro link
    ),
    array(
        'label' => get_the_title(), // página atual, sem URL
    ),
) );
?>


        <div class="sobre-banner-wrapper">
            <div class="sobre-banner-image"
                 <?php if ( $imagem_fundo ) : ?>
                     style="background-image:url('<?php echo esc_url( $imagem_fundo ); ?>');"
                 <?php endif; ?>>
            </div>

            <?php if ( $titulo || $descricao ) : ?>
                <div class="sobre-banner-text">
                    <?php if ( $titulo ) : ?>
                        <h1><?php echo esc_html( $titulo ); ?></h1>
                    <?php endif; ?>

                    <?php if ( $descricao ) : ?>
                        <p><?php echo esc_html( $descricao ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
