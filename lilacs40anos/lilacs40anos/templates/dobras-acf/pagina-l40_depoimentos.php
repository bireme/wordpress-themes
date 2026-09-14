<?php
/**
 * Dobra: 40 Anos – DEPOIMENTOS
 * Slug ACF: l40_depoimentos
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'l40_esc_text' ) ) { function l40_esc_text( $v ) { return esc_html( (string) $v ); } }
if ( ! function_exists( 'l40_esc_url'  ) ) { function l40_esc_url( $v )  { return esc_url( (string) $v );  } }

$depo_title = get_sub_field( 'l40_depo_title' ) ?: 'Depoimentos sobre a LILACS';
$depo_intro = get_sub_field( 'l40_depo_intro' ) ?: '';
$depo_items = get_sub_field( 'depoimentos' );
if ( ! is_array( $depo_items ) ) $depo_items = [];
?>

<section id="depoimentos" class="l40-depo-section" aria-label="Depoimentos">
  <div class="l40-container">

    <header class="l40-depo-header">
      <?php if ( ! empty( $depo_title ) ) : ?>
        <h2 class="l40-depo-title"><?php echo l40_esc_text( $depo_title ); ?></h2>
      <?php endif; ?>
      <?php if ( ! empty( $depo_intro ) ) : ?>
        <p class="l40-depo-intro"><?php echo wp_kses_post( wpautop( $depo_intro ) ); ?></p>
      <?php endif; ?>
    </header>

    <?php if ( ! empty( $depo_items ) ) : ?>
      <div class="l40-depo-grid">
        <?php foreach ( $depo_items as $d ) :
          $name  = isset( $d['nome_depoimento'] )  ? trim( (string) $d['nome_depoimento'] )  : '';
          $photo = isset( $d['foto_depoimento'] )  ? trim( (string) $d['foto_depoimento'] )  : '';
          $text  = isset( $d['texto_depoimento'] ) ? trim( (string) $d['texto_depoimento'] ) : '';
          if ( empty( $name ) && empty( $text ) ) continue;
        ?>
          <article class="l40-depo-card">
            <div class="l40-depo-card__head <?php echo empty( $photo ) ? 'is-no-photo' : ''; ?>">
              <?php if ( ! empty( $photo ) ) : ?>
                <img class="l40-depo-avatar"
                     src="<?php echo l40_esc_url( $photo ); ?>"
                     alt="<?php echo esc_attr( $name ); ?>"
                     loading="lazy">
              <?php endif; ?>
              <?php if ( ! empty( $name ) ) : ?>
                <strong class="l40-depo-name"><?php echo l40_esc_text( $name ); ?></strong>
              <?php endif; ?>
            </div>
            <?php if ( ! empty( $text ) ) : ?>
              <div class="l40-depo-text"><?php echo wp_kses_post( wpautop( $text ) ); ?></div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<style>
.l40-container{max-width:1180px;margin:0 auto;padding:0 20px;box-sizing:border-box;}
.l40-depo-section{padding:44px 0;background:radial-gradient(900px 220px at 15% 10%,rgba(12,67,128,.10),transparent 60%),radial-gradient(700px 220px at 85% 0%,rgba(226,88,44,.10),transparent 55%),linear-gradient(180deg,#fff,#f6f8fb);border-top:1px solid rgba(12,67,128,.08);}
.l40-depo-header{margin-bottom:18px;}
.l40-depo-title{font-family:"Noto Sans",system-ui,sans-serif;margin:0 0 10px;font-size:1.85rem;line-height:1.15;color:#0f172a;}
.l40-depo-intro{margin:0;font-family:"Noto Sans",system-ui,sans-serif;color:#475569;max-width:90ch;}
.l40-depo-intro p{margin:0;}
.l40-depo-grid{margin-top:18px;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;}
.l40-depo-card{background:#fff;border:1px solid rgba(12,67,128,.10);box-shadow:0 12px 28px rgba(2,23,55,.06);border-radius:14px;padding:16px;}
.l40-depo-card__head{display:flex;gap:12px;align-items:center;margin-bottom:10px;}
.l40-depo-avatar{width:54px;height:54px;border-radius:999px;object-fit:cover;display:block;background:#e9eef5;flex:0 0 54px;}
.l40-depo-name{display:block;font-family:"Noto Sans",system-ui,sans-serif;font-weight:900;color:#0f172a;line-height:1.1;}
.l40-depo-text{font-family:"Noto Sans",system-ui,sans-serif;color:#475569;font-size:.95rem;}
.l40-depo-text p{margin:0 0 6px;}
@media(max-width:980px){ .l40-depo-grid{grid-template-columns:1fr 1fr;} }
@media(max-width:640px){ .l40-depo-section{padding:34px 0;} .l40-depo-grid{grid-template-columns:1fr;} }
</style>
