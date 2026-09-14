<?php
/**
 * Dobra ACF: padroes_internacionais
 * Layout: Título à esquerda + faixa de logos à direita
 * Chamado via lilacs_bvs_dobra('pagina-padroes_internacionais') dentro de the_row()
 *
 * Sub_fields esperados (ACF):
 *   - titulo  (text)
 *   - logos   (repeater): imagem (image url), alt (text), link (url)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$titulo = (string) get_sub_field( 'titulo' );
$logos  = get_sub_field( 'logos' );
if ( ! is_array( $logos ) ) $logos = [];

if ( ! $titulo ) {
    $titulo = 'Padrões internacionais que são a base da Metodologia LILACS';
}

// Não renderiza se não houver logos
if ( empty( $logos ) ) return;
?>

<style>
.padroes-inter-section { width: 100%; }
.padroes-inter-content {
  max-width: 1200px; margin: 0 auto;
  padding: 60px 20px;
  display: flex; align-items: center; justify-content: space-between; gap: 32px;
}
.padroes-inter-section .content-text {
  flex: 0 0 320px;
}
.padroes-inter-section .content-text h2 {
  color: #00205C; font-size: 24px; font-weight: 600; line-height: 1.4; margin: 0;
  font-family: 'Noto Sans', sans-serif;
}
.padroes-inter-section .content-logos {
  flex: 1 1 auto;
  display: flex; align-items: center; justify-content: space-between;
  gap: 48px;
  flex-wrap: nowrap;
  min-height: 64px;
}
.padroes-inter-section .content-logos img {
  display: block; height: 44px; width: auto; object-fit: contain;
  transition: transform .15s ease;
}
.padroes-inter-section .content-logos img:hover { transform: translateY(-2px); }
@media (max-width: 1100px) {
  .padroes-inter-section .content-logos { flex-wrap: wrap; row-gap: 24px; column-gap: 36px; justify-content: flex-start; }
}
@media (max-width: 768px) {
  .padroes-inter-content { flex-direction: column; align-items: flex-start; gap: 20px; }
  .padroes-inter-section .content-text { flex: 0 0 auto; }
  .padroes-inter-section .content-logos { width: 100%; justify-content: space-between; }
}
</style>

<section class="padroes-inter-section" aria-labelledby="padroes-inter-title">
  <div class="padroes-inter-content">
    <div class="content-text">
      <h2 id="padroes-inter-title"><?php echo esc_html( $titulo ); ?></h2>
    </div>
    <div class="content-logos" aria-label="<?php echo esc_attr( $titulo ); ?>">
      <?php foreach ( $logos as $logo ) :
        $src  = (string) ( $logo['imagem'] ?? '' );
        $alt  = (string) ( $logo['alt']    ?? 'Logo' );
        $link = (string) ( $logo['link']   ?? '' );
        if ( ! $src ) continue;
      ?>
        <?php if ( $link ) : ?>
          <a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $alt ); ?>">
            <img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
          </a>
        <?php else : ?>
          <img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
