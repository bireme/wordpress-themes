<?php
/**
 * Dobra: 40 Anos – HERO
 * Slug ACF: l40_hero
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'l40_esc_text' ) ) { function l40_esc_text( $v ) { return esc_html( (string) $v ); } }
if ( ! function_exists( 'l40_esc_attr' ) ) { function l40_esc_attr( $v ) { return esc_attr( (string) $v ); } }
if ( ! function_exists( 'l40_esc_url'  ) ) { function l40_esc_url( $v )  { return esc_url( (string) $v );  } }

$logo        = get_sub_field( 'l40_hero_logo' );
$title       = get_sub_field( 'l40_hero_h1' )          ?: 'Ciência em saúde com identidade da América Latina e Caribe';
$lead        = get_sub_field( 'l40_hero_lead' )         ?: '';
$cta_label   = get_sub_field( 'l40_hero_cta_label' )   ?: 'Ver agenda comemorativa';
$cta_url     = get_sub_field( 'l40_hero_cta_anchor' )  ?: '#agenda';
$img_right   = get_sub_field( 'l40_hero_image_right' );

$logo_url    = is_array( $logo )      ? $logo['url']      : (string) $logo;
$img_r_url   = is_array( $img_right ) ? $img_right['url'] : (string) $img_right;
?>

<header class="l40-hero hero--split">
  <div class="l40-container l40-hero-grid">

    <div class="l40-hero-content">
      <?php if ( ! empty( $logo_url ) ) : ?>
        <img src="<?php echo l40_esc_url( $logo_url ); ?>" alt="LILACS 40 anos" class="l40-hero-logo">
      <?php endif; ?>

      <h1 class="l40-hero-h1"><?php echo l40_esc_text( $title ); ?></h1>

      <?php if ( ! empty( $lead ) ) : ?>
        <div class="l40-hero-lead"><?php echo wp_kses_post( wpautop( $lead ) ); ?></div>
      <?php endif; ?>

      <?php if ( ! empty( $cta_url ) && ! empty( $cta_label ) ) : ?>
        <a href="<?php echo l40_esc_attr( $cta_url ); ?>" class="l40-btn-primary">
          <?php echo l40_esc_text( $cta_label ); ?>
        </a>
      <?php endif; ?>
    </div>

    <?php if ( ! empty( $img_r_url ) ) : ?>
      <div class="l40-hero-seal">
        <img src="<?php echo l40_esc_url( $img_r_url ); ?>" alt="" loading="lazy">
      </div>
    <?php endif; ?>

  </div>
</header>

<style>
.l40-hero{background:linear-gradient(180deg,#002a50,#0C4380);color:#fff;padding:72px 0;}
.l40-container{max-width:1180px;margin:0 auto;padding:0 20px;box-sizing:border-box;}
.l40-hero-grid{display:grid;grid-template-columns:1.2fr .8fr;align-items:center;gap:30px;}
.l40-hero-content{max-width:720px;}
.l40-hero-logo{max-width:220px;margin-bottom:18px;display:block;}
.l40-hero-h1{font-family:"Noto Sans",system-ui,sans-serif;font-size:2.35rem;margin:0 0 14px;color:#fff;line-height:1.2;}
.l40-hero-lead{font-size:1.05rem;opacity:.95;color:#fff;}
.l40-hero-lead p{margin:0 0 8px;}
.l40-btn-primary{display:inline-block;margin-top:24px;padding:14px 26px;border-radius:30px;text-decoration:none;font-weight:800;background:#E2582C;color:#fff;font-family:"Noto Sans",system-ui,sans-serif;}
.l40-btn-primary:hover{filter:brightness(.97);}
.l40-hero-seal{display:flex;justify-content:center;align-items:center;}
.l40-hero-seal img{width:min(420px,100%);height:auto;filter:drop-shadow(0 18px 30px rgba(0,0,0,.25));}
@media(max-width:900px){
  .l40-hero-grid{grid-template-columns:1fr;}
  .l40-hero{padding:56px 0;}
  .l40-hero-h1{font-size:1.9rem;}
}
</style>
