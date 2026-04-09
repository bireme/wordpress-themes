<?php
/**
 * Single: Voz da Rede (CPT voz-da-rede)
 * Exibe o depoimento completo com foto, nome, cargo/país.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$id = get_the_ID();

// Campos ACF
$nome  = function_exists( 'get_field' ) ? get_field( 'nome_do_depoimento', $id ) : '';
$extra = function_exists( 'get_field' ) ? get_field( 'texto_complementar_cargopais', $id ) : '';
$texto = function_exists( 'get_field' ) ? get_field( 'depoimento_completo', $id ) : '';
$foto  = function_exists( 'get_field' ) ? get_field( 'foto_do_autor_depoimento', $id ) : '';

// Fallbacks
if ( empty( $nome ) ) {
    $nome = get_the_title( $id );
}
if ( empty( $texto ) ) {
    $texto = get_the_content();
}

$foto_url = is_array( $foto ) && ! empty( $foto['url'] ) ? $foto['url'] : '';

$archive_url = get_post_type_archive_link( 'voz-da-rede' ) ?: home_url( '/voz-da-rede/' );
?>

<style>
/* ==================== SINGLE VOZ DA REDE ==================== */

.voz-single-banner {
    padding: 0;
    background: transparent;
}

.voz-single-banner-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 16px;
}

.voz-single-breadcrumb {
    margin-bottom: 14px;
}

.voz-single-banner-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 10px 90px 10px 10px;
    background: linear-gradient(135deg, #29367d, #233a8b);
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 32px;
}

.voz-single-banner-content {
    text-align: center;
    color: #fff;
}

.voz-single-banner-avatar {
    margin-bottom: 16px;
}

.voz-single-banner-avatar img {
    width: 96px;
    height: 96px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid rgba(255,255,255,.3);
}

.voz-single-banner-avatar-placeholder {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    background: rgba(255,255,255,.15);
    margin: 0 auto;
}

.voz-single-banner-name {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 4px;
    color: #fff;
}

.voz-single-banner-role {
    font-size: 15px;
    color: rgba(255,255,255,.75);
    margin: 0;
}

/* ==================== CONTEÚDO ==================== */

.voz-single-wrap {
    max-width: 800px;
    margin: 48px auto 60px;
    padding: 0 16px;
}

.voz-single-card {
    background: #fff;
    border-radius: 14px;
    padding: 40px 36px;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
}

.voz-single-quote-icon {
    font-size: 48px;
    line-height: 1;
    color: #233a8b;
    opacity: .2;
    margin-bottom: 12px;
}

.voz-single-texto {
    font-size: 16px;
    color: #333;
    line-height: 1.8;
}

.voz-single-texto p:first-child {
    margin-top: 0;
}

.voz-single-texto p:last-child {
    margin-bottom: 0;
}

.voz-single-date {
    margin-top: 24px;
    font-size: 13px;
    color: #999;
}

/* Botão voltar */
.voz-single-back {
    margin-top: 32px;
    text-align: center;
}

.voz-single-back a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 28px;
    background: #233a8b;
    color: #fff;
    border-radius: 999px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: .2s;
}

.voz-single-back a:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}

/* ==================== RESPONSIVO ==================== */

@media (max-width: 768px) {
    .voz-single-banner-wrapper {
        min-height: 160px;
        padding: 28px 20px;
        border-radius: 10px 60px 10px 10px;
    }
    .voz-single-banner-name {
        font-size: 22px;
    }
    .voz-single-card {
        padding: 28px 20px;
    }
    .voz-single-texto {
        font-size: 15px;
    }
}
</style>

<!-- BANNER -->
<section class="voz-single-banner">
    <div class="voz-single-banner-inner">

        <div class="voz-single-breadcrumb">
            <?php
            if ( function_exists( 'rede_bvs_breadcrumb' ) ) {
                rede_bvs_breadcrumb( array(
                    array( 'label' => rede_bvs_pll( 'Rede BVS' ), 'url' => home_url( '/' ) ),
                    array( 'label' => 'Vozes da Rede', 'url' => esc_url( $archive_url ) ),
                    array( 'label' => $nome ),
                ) );
            }
            ?>
        </div>

        <div class="voz-single-banner-wrapper">
            <div class="voz-single-banner-content">

                <div class="voz-single-banner-avatar">
                    <?php if ( $foto_url ) : ?>
                        <img src="<?php echo esc_url( $foto_url ); ?>" alt="<?php echo esc_attr( $nome ); ?>">
                    <?php else : ?>
                        <div class="voz-single-banner-avatar-placeholder"></div>
                    <?php endif; ?>
                </div>

                <h1 class="voz-single-banner-name"><?php echo esc_html( $nome ); ?></h1>

                <?php if ( $extra ) : ?>
                    <p class="voz-single-banner-role"><?php echo esc_html( $extra ); ?></p>
                <?php endif; ?>

            </div>
        </div>

    </div>
</section>

<!-- DEPOIMENTO -->
<main class="voz-single-wrap">

    <article class="voz-single-card">

        <div class="voz-single-quote-icon">&ldquo;</div>

        <div class="voz-single-texto">
            <?php echo wp_kses_post( wpautop( $texto ) ); ?>
        </div>

        <div class="voz-single-date">
            <?php echo get_the_date( 'd/m/Y', $id ); ?>
        </div>

    </article>

    <div class="voz-single-back">
        <a href="<?php echo esc_url( $archive_url ); ?>">
            &larr; Vozes da Rede
        </a>
    </div>

</main>

<?php get_footer(); ?>
