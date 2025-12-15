<?php
/**
 * DOBRA: LILACS Express
 * Arquivo: pagina-lilacs_express.php
 * Obs: este arquivo é chamado via lilacs_bvs_dobra('pagina-lilacs_express')
 * e assume que o ACF já está no layout get_row_layout() === 'lilacs_express'.
 */

if ( ! defined('ABSPATH') ) exit;

// Segurança: só renderiza se estiver no layout correto
if ( function_exists('get_row_layout') && get_row_layout() !== 'lilacs_express' ) {
    return;
}

if ( ! function_exists('get_sub_field') ) {
    return; // ACF não ativo
}

// Campos do layout "lilacs_express"
$titulo    = get_sub_field('titulo');
$descricao = get_sub_field('descricao');

// Group: o_que_e_lilacs-express (atenção ao hífen no name)
$g1 = get_sub_field('o_que_e_lilacs-express');
$g1_titulo      = is_array($g1) ? ($g1['titulo'] ?? '') : '';
$g1_descricao   = is_array($g1) ? ($g1['descricao'] ?? '') : '';
$g1_texto_botao = is_array($g1) ? ($g1['texto_botao'] ?? '') : '';
$g1_link_botao  = is_array($g1) ? ($g1['link_botao'] ?? '') : '';

// Group: tutorial_para_editores
$g2 = get_sub_field('tutorial_para_editores');
$g2_titulo      = is_array($g2) ? ($g2['titulo'] ?? '') : '';
$g2_descricao   = is_array($g2) ? ($g2['descricao'] ?? '') : '';
$g2_texto_botao = is_array($g2) ? ($g2['texto_botao'] ?? '') : '';
$g2_link_botao  = is_array($g2) ? ($g2['link_botao'] ?? '') : '';

// Fallbacks
if ( empty($titulo) )    $titulo = 'LILACS-Express';
if ( empty($descricao) ) $descricao = 'Acesse rapidamente o conteúdo de referência e o tutorial para equipes editoriais.';

if ( empty($g1_titulo) )      $g1_titulo = 'O que é LILACS-Express';
if ( empty($g1_texto_botao) ) $g1_texto_botao = 'Acessar conteúdo';

if ( empty($g2_titulo) )      $g2_titulo = 'Tutorial para editores';
if ( empty($g2_texto_botao) ) $g2_texto_botao = 'Ver tutorial';

// Sanitização
$titulo    = esc_html($titulo);
$descricao = esc_html($descricao);

$g1_titulo = esc_html($g1_titulo);
$g2_titulo = esc_html($g2_titulo);

$g1_descricao = is_string($g1_descricao) ? esc_html($g1_descricao) : '';
$g2_descricao = is_string($g2_descricao) ? esc_html($g2_descricao) : '';

$g1_texto_botao = esc_html($g1_texto_botao);
$g2_texto_botao = esc_html($g2_texto_botao);

// Links (ACF está como text, mas vamos tratar como URL)
$g1_link_botao = esc_url($g1_link_botao);
$g2_link_botao = esc_url($g2_link_botao);
?>

<section class="lilacs-dobra lilacs-express" aria-label="<?php echo esc_attr($titulo); ?>">
  <div class="lilacs-container">

    <header class="lilacs-express__head">
      <h2 class="lilacs-express__title"><?php echo $titulo; ?></h2>
      <p class="lilacs-express__desc"><?php echo $descricao; ?></p>
    </header>

    <div class="lilacs-express__grid">

      <!-- Card 1 -->
      <article class="lilacs-express__card">
        <div class="lilacs-express__icon" aria-hidden="true">
          <!-- Ícone: informação -->
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" stroke="currentColor" stroke-width="2"/>
            <path d="M12 10v7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M12 7h.01" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
          </svg>
        </div>

        <div class="lilacs-express__body">
          <h3 class="lilacs-express__card-title"><?php echo $g1_titulo; ?></h3>

          <?php if ( ! empty($g1_descricao) ) : ?>
            <p class="lilacs-express__card-desc"><?php echo $g1_descricao; ?></p>
          <?php endif; ?>

          <?php if ( ! empty($g1_link_botao) ) : ?>
            <a class="lilacs-express__btn" href="<?php echo $g1_link_botao; ?>" target="_blank" rel="noopener">
              <span><?php echo $g1_texto_botao; ?></span>
              <span class="lilacs-express__btn-arrow" aria-hidden="true">→</span>
            </a>
          <?php endif; ?>
        </div>
      </article>

      <!-- Card 2 -->
      <article class="lilacs-express__card">
        <div class="lilacs-express__icon" aria-hidden="true">
          <!-- Ícone: play/tutorial -->
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="currentColor" stroke-width="2"/>
            <path d="M10.5 8.8v6.4L16.2 12l-5.7-3.2Z" fill="currentColor"/>
          </svg>
        </div>

        <div class="lilacs-express__body">
          <h3 class="lilacs-express__card-title"><?php echo $g2_titulo; ?></h3>

          <?php if ( ! empty($g2_descricao) ) : ?>
            <p class="lilacs-express__card-desc"><?php echo $g2_descricao; ?></p>
          <?php endif; ?>

          <?php if ( ! empty($g2_link_botao) ) : ?>
            <a class="lilacs-express__btn" href="<?php echo $g2_link_botao; ?>" target="_blank" rel="noopener">
              <span><?php echo $g2_texto_botao; ?></span>
              <span class="lilacs-express__btn-arrow" aria-hidden="true">→</span>
            </a>
          <?php endif; ?>
        </div>
      </article>

    </div>

  </div>
</section>

<style>
/* ===== DOBRA: LILACS EXPRESS (escopado) ===== */
.lilacs-express{ padding:44px 0; background:#082a53; }
.lilacs-express .lilacs-container{ max-width:1180px; margin:0 auto; padding:0 20px; }

.lilacs-express__head{ margin-bottom:18px; }
.lilacs-express__title{ margin:0 0 10px; font-size:30px; line-height:1.2; color:#fff; letter-spacing:-0.3px; }
.lilacs-express__desc{ margin:0; color:#fff; font-size:15px; line-height:1.6; max-width:78ch; }

.lilacs-express__grid{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }

.lilacs-express__card{
  background:#fff;
  border:1px solid #D6E2F1;
  border-radius:18px;
  padding:18px;
  box-shadow:0 10px 30px rgba(0,60,113,.08);
  display:flex;
  gap:14px;
  transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease;
}
.lilacs-express__card:hover{
  transform:translateY(-2px);
  border-color:#BFD4EC;
  box-shadow:0 14px 40px rgba(0,60,113,.12);
}

.lilacs-express__icon{
  width:44px; height:44px;
  border-radius:14px;
  background:#EAF2FB;
  color:#003C71;
  display:grid; place-items:center;
  flex:0 0 44px;
}
.lilacs-express__icon svg{ width:22px; height:22px; }

.lilacs-express__body{ display:flex; flex-direction:column; align-items:flex-start; width:100%; }
.lilacs-express__card-title{ margin:2px 0 8px; font-size:18px; color:#002A4D; letter-spacing:-0.2px; }
.lilacs-express__card-desc{ margin:0 0 14px; color:#355472; font-size:14px; line-height:1.55; }

.lilacs-express__btn{
  display:inline-flex;
  align-items:center;
  justify-content:space-between;
  gap:10px;
  padding:12px 18px;
  border-radius:999px;
  text-decoration:none;
  font-weight:700;
  font-size:14px;
  line-height:1;
  background:#082A53;
  color:#fff;
  min-width:220px;
  box-shadow:0 6px 16px rgba(8,42,83,.25);
  transition:transform .12s ease, background .12s ease;
  user-select:none;
  margin-top:auto;
}
.lilacs-express__btn:hover{ background:#0A3568; transform:translateY(-1px); }
.lilacs-express__btn-arrow{ font-weight:900; }

@media (max-width:980px){
  .lilacs-express__grid{ grid-template-columns:1fr; }
  .lilacs-express__btn{ min-width:100%; }
}
</style>


