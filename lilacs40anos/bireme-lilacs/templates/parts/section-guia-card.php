<?php
// pegue o ID da página atual
$pid = get_queried_object_id();
if (!$pid && isset($post->ID)) { $pid = (int) $post->ID; }
$pid = (int) $pid;

// ---------- Metas (Guia de Seleção) ----------
$guia_title = get_post_meta($pid, '_metod_guia_title', true);
$guia_desc  = get_post_meta($pid, '_metod_guia_desc', true);
$guia_btn   = get_post_meta($pid, '_metod_guia_btn', true);
$guia_link  = get_post_meta($pid, '_metod_guia_link', true);

// Fallbacks (mantêm o layout original)
if ($guia_title === '') $guia_title = 'Guia de seleção de documentos LILACS';
if ($guia_desc  === '') $guia_desc  = '6ª edição revisada e ampliada - janeiro de 2022';
if ($guia_btn   === '') $guia_btn   = 'Ver guia';
if ($guia_link  === '') $guia_link  = '#';

// ---------- Metas (Critérios) ----------
$crit_title     = get_post_meta($pid, '_metod_crit_title', true);
$crit_btn1_text = get_post_meta($pid, '_metod_crit_btn1_text', true);
$crit_btn1_link = get_post_meta($pid, '_metod_crit_btn1_link', true);
$crit_btn2_text = get_post_meta($pid, '_metod_crit_btn2_text', true);
$crit_btn2_link = get_post_meta($pid, '_metod_crit_btn2_link', true);

// Fallbacks
if ($crit_title     === '') $crit_title     = 'Critérios para seleção e permanência de periódicos na coleção LILACS';
if ($crit_btn1_text === '') $crit_btn1_text = 'Âmbito regional (2020)';
if ($crit_btn1_link === '') $crit_btn1_link = '#';
if ($crit_btn2_text === '') $crit_btn2_text = 'Coleção Brasil (2021)';
if ($crit_btn2_link === '') $crit_btn2_link = '#';
?>

<style>
.guia-section { font-family: 'Poppins', sans-serif; }
.guia-section .guia-conntent { display:flex; justify-content:space-between; max-width:1200px; margin:0 auto; padding:60px 20px; }
.guia-section .section-50 { width:48%; }
.guia-section .guia-card { display:flex; flex-direction:column; justify-content:space-between; background:linear-gradient(135deg, #8d53bb 0%, #0b5696 100%); padding:20px; border-radius:8px; height:100%; }
.guia-section .guia-card h2 { color:#FFFFFF; font-size:24px; font-weight:600; margin-bottom:15px; }
.guia-section .guia-card p { color:#FFFFFF; font-size:18px; margin:0 0 20px 0; }
.guia-section .guia-card a { display:inline-block; color:#00205C; background-color:#fff; padding:10px 50px; border-radius:99px; text-decoration:none; font-size:14px; font-weight:600; font-family:"Poppins", sans-serif; }
.guia-section .guia-card .guia-btns { display:flex; gap:10px; }

/* opcional: responsivo básico */
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
          <h2><?php echo esc_html($guia_title); ?></h2>
          <?php if ($guia_desc !== ''): ?>
            <p><?php echo esc_html($guia_desc); ?></p>
          <?php endif; ?>
        </div>
        <div class="guia-btns">
          <?php if ($guia_btn !== ''): ?>
            <a href="<?php echo esc_url($guia_link); ?>"><?php echo esc_html($guia_btn); ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Card 2: Critérios -->
    <div class="section-50">
      <div class="guia-card">
        <div class="card-content">
          <h2><?php echo esc_html($crit_title); ?></h2>
        </div>
        <div class="guia-btns">
          <?php if ($crit_btn1_text !== ''): ?>
            <a href="<?php echo esc_url($crit_btn1_link); ?>"><?php echo esc_html($crit_btn1_text); ?></a>
          <?php endif; ?>
          <?php if ($crit_btn2_text !== ''): ?>
            <a href="<?php echo esc_url($crit_btn2_link); ?>"><?php echo esc_html($crit_btn2_text); ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
