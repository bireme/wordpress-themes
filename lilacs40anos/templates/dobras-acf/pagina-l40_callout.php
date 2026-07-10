<?php
/**
 * Dobra: 40 Anos – CALLOUT (PARTICIPE)
 * Slug ACF: l40_callout
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'l40_esc_text' ) ) { function l40_esc_text( $v ) { return esc_html( (string) $v ); } }
if ( ! function_exists( 'l40_esc_attr' ) ) { function l40_esc_attr( $v ) { return esc_attr( (string) $v ); } }

$uid       = 'l40-callout-' . get_the_ID() . '-' . get_row_index();
$badge     = get_sub_field( 'l40_callout_badge' )      ?: 'Participe';
$title     = get_sub_field( 'l40_callout_title' )      ?: 'Você faz parte da nossa história';
$text      = get_sub_field( 'l40_callout_text' )       ?: '';
$btn1_lbl  = get_sub_field( 'l40_callout_btn1_label' ) ?: '';
$btn1_url  = get_sub_field( 'l40_callout_btn1_url' )   ?: '';
$btn2_lbl  = get_sub_field( 'l40_callout_btn2_label' ) ?: '';
$btn2_url  = get_sub_field( 'l40_callout_btn2_url' )   ?: '';
?>

<section class="l40-callout" aria-labelledby="<?php echo esc_attr( $uid ); ?>">
  <div class="l40-container">

    <div class="l40-callout__badge">
      <span class="l40-callout__dot" aria-hidden="true"></span>
      <?php echo l40_esc_text( $badge ); ?>
    </div>

    <div class="l40-callout__content">
      <h2 id="<?php echo esc_attr( $uid ); ?>" class="l40-callout__title">
        <?php echo l40_esc_text( $title ); ?>
      </h2>

      <?php if ( ! empty( $text ) ) : ?>
        <p class="l40-callout__text"><?php echo wp_kses_post( wpautop( $text ) ); ?></p>
      <?php endif; ?>

      <div class="l40-callout__actions">
        <?php if ( ! empty( $btn1_url ) && ! empty( $btn1_lbl ) ) : ?>
          <a class="l40-cta-btn l40-cta-btn--primary"
             href="<?php echo l40_esc_attr( $btn1_url ); ?>">
            <?php echo l40_esc_text( $btn1_lbl ); ?>
          </a>
        <?php endif; ?>
        <?php if ( ! empty( $btn2_url ) && ! empty( $btn2_lbl ) ) : ?>
          <a class="l40-cta-btn l40-cta-btn--ghost"
             href="<?php echo l40_esc_attr( $btn2_url ); ?>">
            <?php echo l40_esc_text( $btn2_lbl ); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>

  </div>
</section>

<style>
.l40-callout{padding:42px 0;background:radial-gradient(900px 220px at 20% 10%,rgba(12,67,128,.12),transparent 60%),radial-gradient(700px 220px at 80% 0%,rgba(226,88,44,.14),transparent 55%),linear-gradient(180deg,#fff,#f6f8fb);}
.l40-container{max-width:1180px;margin:0 auto;padding:0 20px;box-sizing:border-box;}
.l40-callout__badge{display:inline-flex;align-items:center;gap:10px;margin:0 0 14px;padding:8px 12px;border-radius:999px;font-family:"Noto Sans",system-ui,sans-serif;font-weight:800;letter-spacing:.02em;color:#0C4380;background:rgba(12,67,128,.08);border:1px solid rgba(12,67,128,.14);}
.l40-callout__dot{width:10px;height:10px;border-radius:50%;background:#E2582C;box-shadow:0 0 0 4px rgba(226,88,44,.18);}
.l40-callout__content{position:relative;padding:28px;border-radius:16px;background:#fff;border:1px solid rgba(12,67,128,.12);box-shadow:0 18px 45px rgba(2,23,55,.08);overflow:hidden;}
.l40-callout__content::after{content:"";position:absolute;top:-120px;right:-160px;width:360px;height:360px;border-radius:50%;background:radial-gradient(circle at 30% 30%,rgba(226,88,44,.22),rgba(12,67,128,.10),transparent 70%);filter:blur(2px);pointer-events:none;}
.l40-callout__title{font-family:"Noto Sans",system-ui,sans-serif;margin:0 0 10px;font-size:clamp(20px,2.1vw,28px);line-height:1.15;color:#0f172a;}
.l40-callout__text{margin:0 0 18px;font-family:"Noto Sans",system-ui,sans-serif;font-size:1rem;color:#475569;max-width:72ch;}
.l40-callout__actions{display:flex;flex-wrap:wrap;gap:12px;align-items:center;}
.l40-cta-btn{display:inline-flex;align-items:center;justify-content:center;min-height:46px;padding:12px 18px;border-radius:30px;text-decoration:none;font-family:"Noto Sans",system-ui,sans-serif;font-weight:800;transition:transform .15s ease,box-shadow .15s ease;}
.l40-cta-btn--primary{color:#fff;background:linear-gradient(90deg,#0C4380,#0b3a70);box-shadow:0 12px 22px rgba(12,67,128,.22);}
.l40-cta-btn--primary:hover{transform:translateY(-1px);box-shadow:0 16px 28px rgba(12,67,128,.28);}
.l40-cta-btn--ghost{color:#0C4380;background:rgba(12,67,128,.06);border:1px solid rgba(12,67,128,.18);}
.l40-cta-btn--ghost:hover{transform:translateY(-1px);background:rgba(12,67,128,.09);}
@media(max-width:640px){
  .l40-callout{padding:34px 0;}
  .l40-callout__content{padding:22px 18px;}
  .l40-cta-btn{width:100%;}
}
</style>
