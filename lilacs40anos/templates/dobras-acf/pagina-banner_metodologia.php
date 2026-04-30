<?php
/**
 * Dobra ACF: banner_metodologia
 * Layout: Banner da página de Metodologia
 * Chamado via lilacs_bvs_dobra('pagina-banner_metodologia') dentro de the_row()
 *
 * Sub_fields esperados (ACF):
 *   - titulo_banner   (text)
 *   - descricao_banner (textarea)
 *   - imagem_banner   (image, return_format=url)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$banner_title    = (string) get_sub_field( 'titulo_banner' );
$banner_desc     = (string) get_sub_field( 'descricao_banner' );
$banner_img      = (string) get_sub_field( 'imagem_banner' );
$banner_cor_desc = (string) get_sub_field( 'cor_descricao_banner' );
if ( ! $banner_cor_desc ) $banner_cor_desc = '#00205C';

/** Breadcrumb helper (reutiliza função se já definida) */
if ( ! function_exists( 'bireme_render_breadcrumb_cp' ) ) {
    function bireme_render_breadcrumb_cp() {
        echo '<div class="container-breadcrumb"><nav class="cp-breadcrumb" aria-label="Breadcrumb">';
        if ( function_exists( 'bireme_breadcrumb' ) ) {
            bireme_breadcrumb();
        } elseif ( function_exists( 'yoast_breadcrumb' ) ) {
            yoast_breadcrumb( '<span class="crumbs">', '</span>' );
        } else {
            echo '<span class="crumbs"><a href="' . esc_url( home_url( '/' ) ) . '">Home</a> / ' . esc_html( get_the_title() ) . '</span>';
        }
        echo '</nav></div>';
    }
}
?>
<section id="lilacs-cp-banner" aria-label="Metodologia LILACS – Banner"
  style="<?php echo $banner_img ? '--cp-bg:url(' . esc_url( $banner_img ) . ');' : ''; ?> --cp-desc-color:<?php echo esc_attr( $banner_cor_desc ); ?>">

  <style>
    #lilacs-cp-banner {
      position: relative;
      padding: 0;
      background: #f3f4f6;
      overflow: hidden;
      --cp-bg: none;
    }
    #lilacs-cp-banner .cp-breadcrumb {
      max-width: 100%;
      margin: 0;
      padding: 6px 20px 10px;
      color: #3b4b6a;
      background: #fff;
      display: flex;
      font-family: 'Noto Sans';
      font-size: 16px;
      justify-content: flex-start;
      align-items: flex-start;
      flex-direction: column;
      width: 100%;
      align-content: flex-start;
      padding-left: 17.5vw;
    }
    #lilacs-cp-banner .cp-breadcrumb a { color: #2d5ca8; text-decoration: none; }
    #lilacs-cp-banner .cp-hero {
      position: relative;
      padding: 44px 0 36px;
      background: #f3f4f6;
      min-height: 350px;
      display: flex;
      align-items: center;
    }
    #lilacs-cp-banner .cp-hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background-image: var(--cp-bg);
      background-size: cover;
      background-position: center right;
      background-repeat: no-repeat;
      opacity: 1;
      z-index: 0;
    }
    #lilacs-cp-banner .cp-wrap {
      position: relative;
      z-index: 2;
      max-width: 100%;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: center;
      width: 64%;
    }
    #lilacs-cp-banner .cp-title {
      color: #F96A1E;
      letter-spacing: .2px;
      margin: 0 0 8px;
      text-transform: uppercase;
      text-wrap: balance;
      font-family: 'Noto Sans';
      font-size: 48px !important;
      font-weight: 700;
    }
    #lilacs-cp-banner .cp-desc {
      color: var(--cp-desc-color, #00205C);
      max-width: 880px;
      margin: 0;
      letter-spacing: .2px;
      font-family: 'Noto Sans';
      font-size: 24px !important;
      font-weight: 500;
    }
    @media (min-width: 992px) {
      #lilacs-cp-banner .cp-hero { padding: 60px 0 48px; }
      #lilacs-cp-banner .cp-title { font-size: 44px; }
      #lilacs-cp-banner .cp-desc  { font-size: 19px; }
    }
    @media (max-width: 980px) {
      #lilacs-cp-banner .cp-hero { min-height: 105px; }
      #lilacs-cp-banner .cp-title { font-size: 22px !important; line-height: 1.1; }
      #lilacs-cp-banner .cp-desc  { font-size: 18px !important; line-height: 1.25; }
      #lilacs-cp-banner .cp-wrap  { position: relative; z-index: 2; }
      #lilacs-cp-banner .cp-hero::after {
        content: "";
        position: absolute;
        top: 0; right: 0;
        height: 100%; width: 56px;
        background: #ffffff9c;
        pointer-events: none;
        z-index: 1;
      }
    }
  </style>

  <?php bireme_render_breadcrumb_cp(); ?>

  <div class="cp-hero">
    <div class="cp-wrap">
      <?php if ( $banner_title ) : ?>
        <h1 class="cp-title"><?php echo esc_html( $banner_title ); ?></h1>
      <?php endif; ?>
      <?php if ( $banner_desc ) : ?>
        <p class="cp-desc" style="color:<?php echo esc_attr( $banner_cor_desc ); ?>"><?php echo wp_kses_post( $banner_desc ); ?></p>
      <?php endif; ?>
    </div>
  </div>

</section>
