<?php
/**
 * Dobra ACF: guia_selecao
 * Layout: dois cards lado a lado — Guia de Seleção + Critérios de Periódicos
 * Chamado via lilacs_bvs_dobra('pagina-guia_selecao') dentro de the_row()
 *
 * Sub_fields esperados (ACF):
 *   - guia_titulo        (text)
 *   - guia_descricao     (text)
 *   - guia_btn_texto     (text)
 *   - guia_btn_link      (url)
 *   - criterios_titulo   (text)
 *   - criterios_botoes   (repeater: texto, link)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$guia_titulo    = (string) get_sub_field( 'guia_titulo' );
$guia_desc      = (string) get_sub_field( 'guia_descricao' );
$guia_btn       = (string) get_sub_field( 'guia_btn_texto' );
$guia_link      = (string) get_sub_field( 'guia_btn_link' );
$crit_titulo    = (string) get_sub_field( 'criterios_titulo' );
$crit_botoes    = get_sub_field( 'criterios_botoes' );
if ( ! is_array( $crit_botoes ) ) $crit_botoes = [];

// Fallbacks que mantêm o layout original
if ( ! $guia_titulo ) $guia_titulo = 'Guia de seleção de documentos LILACS';
if ( ! $guia_desc )   $guia_desc   = '6ª edição revisada e ampliada - janeiro de 2022';
if ( ! $guia_btn )    $guia_btn    = 'Ver guia';
if ( ! $guia_link )   $guia_link   = '#';
if ( ! $crit_titulo ) $crit_titulo = 'Critérios para seleção e permanência de periódicos na coleção LILACS';
if ( empty( $crit_botoes ) ) {
    $crit_botoes = [
        [ 'texto' => 'Âmbito regional (2020)', 'link' => '#' ],
        [ 'texto' => 'Coleção Brasil (2021)',   'link' => '#' ],
    ];
}
?>

<style>
.guia-section { font-family: 'Poppins', sans-serif; }
.guia-section .guia-conntent { display:flex; justify-content:space-between; max-width:1200px; margin:0 auto; padding:60px 20px; }
.guia-section .section-50 { width:48%; }
.guia-section .guia-card { display:flex; flex-direction:column; justify-content:space-between; background:linear-gradient(135deg, #8d53bb 0%, #0b5696 100%); padding:20px; border-radius:8px; height:100%; }
.guia-section .guia-card h2 { color:#FFFFFF; font-size:24px; font-weight:600; margin-bottom:15px; }
.guia-section .guia-card p { color:#FFFFFF; font-size:18px; margin:0 0 20px 0; }
.guia-section .guia-card a { display:inline-block; color:#00205C; background-color:#fff; padding:10px 50px; border-radius:99px; text-decoration:none; font-size:14px; font-weight:600; font-family:"Poppins", sans-serif; }
.guia-section .guia-card .guia-btns { display:flex; gap:10px; flex-wrap:wrap; }
@media (max-width: 900px){
  .guia-section .guia-conntent { flex-direction:column; gap:20px; }
  .guia-section .section-50 { width:100%; }
}
</style>

<section class="guia-section">
  <div class="guia-conntent">

    <!-- Card 1: Guia de Seleção -->
    <div class="section-50">
      <div class="guia-card">
        <div class="card-content">
          <h2><?php echo esc_html( $guia_titulo ); ?></h2>
          <?php if ( $guia_desc ) : ?>
            <p><?php echo esc_html( $guia_desc ); ?></p>
          <?php endif; ?>
        </div>
        <div class="guia-btns">
          <?php if ( $guia_btn ) : ?>
            <a href="<?php echo esc_url( $guia_link ); ?>"><?php echo esc_html( $guia_btn ); ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Card 2: Critérios -->
    <div class="section-50">
      <div class="guia-card">
        <div class="card-content">
          <h2><?php echo esc_html( $crit_titulo ); ?></h2>
        </div>
        <div class="guia-btns">
          <?php foreach ( $crit_botoes as $btn ) :
            $btn_texto = (string) ( $btn['texto'] ?? '' );
            $btn_link  = (string) ( $btn['link']  ?? '#' );
            if ( ! $btn_texto ) continue;
          ?>
            <a href="<?php echo esc_url( $btn_link ); ?>"><?php echo esc_html( $btn_texto ); ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

  </div>
</section>
