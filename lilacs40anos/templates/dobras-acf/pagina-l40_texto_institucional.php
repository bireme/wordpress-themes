<?php
/**
 * Dobra: 40 Anos – TEXTO INSTITUCIONAL
 * Slug ACF: l40_texto_institucional
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'l40_esc_text' ) ) { function l40_esc_text( $v ) { return esc_html( (string) $v ); } }

$inst_title      = get_sub_field( 'l40_inst_title' )      ?: '#LILACS40 anos! Ações de celebração do aniversário';
$inst_paragraphs = get_sub_field( 'l40_inst_paragraphs' );
if ( ! is_array( $inst_paragraphs ) ) $inst_paragraphs = [];
?>

<section class="l40-inst-section">
  <div class="l40-container">

    <?php if ( ! empty( $inst_title ) ) : ?>
      <h2 class="l40-inst-title"><?php echo l40_esc_text( $inst_title ); ?></h2>
    <?php endif; ?>

    <?php if ( ! empty( $inst_paragraphs ) ) :
        foreach ( $inst_paragraphs as $row ) :
            $txt = isset( $row['text'] ) ? $row['text'] : '';
            if ( ! empty( $txt ) ) echo '<div class="l40-wysiwyg">' . wp_kses_post( $txt ) . '</div>';
        endforeach;
    else : ?>
      <p>A <strong>LILACS</strong> celebra 40 anos como a principal base de dados da produção científica em saúde da América Latina e Caribe.</p>
    <?php endif; ?>

  </div>
</section>

<style>
.l40-inst-section{padding:40px 0;}
.l40-container{max-width:1180px;margin:0 auto;padding:0 20px;box-sizing:border-box;}
.l40-inst-title{font-family:"Noto Sans",system-ui,sans-serif;font-size:1.8rem;margin-bottom:20px;color:#0f172a;}
.l40-wysiwyg{font-family:"Noto Sans",system-ui,sans-serif;color:#475569;line-height:1.7;margin-bottom:16px;}
.l40-wysiwyg p{margin:0 0 12px;}
.l40-wysiwyg strong{color:#0f172a;}
</style>
