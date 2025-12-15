<?php
/**
 * DOBRA: pagina-indexe_seu_periodico
 * ACF Layout: indexe_seu_periodico
 */

if ( ! defined('ABSPATH') ) exit;

// Campos base
$titulo        = get_sub_field('titulo');
$descricao     = get_sub_field('descricao');
$bg            = get_sub_field('cor_de_fundo');

// (no teu ACF tem um campo com nome estranho, mas vou respeitar o que existe)
$cor_head      = get_sub_field('cor_de_fundo_copiar'); // "Cor do titulo e descrição da sessão"

// Alert (wysiwyg)
$alert_html    = get_sub_field('texto_de_alerta');

// Cards (groups)
$cards_groups = [
  'criterios_regionais_de_selecao'     => ['emoji' => '🌎'],
  'criterios_lilacs_brasil'            => ['emoji' => '📄'],
  'processo_de_avaliacao_e_selecao'    => ['emoji' => '⚙️'],
  'resultados_de_anos_anteriores'      => ['emoji' => '📊'],
];

// Highlight
$highlight = get_sub_field('cadastre-se_como_parecerista_ad_hoc_da_lilacs');

// Helpers
$esc_url_or_hash = function($url) {
  $url = trim((string)$url);
  return $url ? esc_url($url) : '#';
};

$has_any = ($titulo || $descricao || $alert_html || !empty($highlight));

?>
<section class="lilacs-indexacao" style="<?php echo $bg ? 'background:' . esc_attr($bg) . ';' : ''; ?>">
  <div class="lilacs-container">

    <?php if ( $titulo || $descricao ) : ?>
      <header class="lilacs-indexacao__head" style="<?php echo $cor_head ? 'color:' . esc_attr($cor_head) . ';' : ''; ?>">
        <?php if ( $titulo ) : ?>
          <h2 style="<?php echo $cor_head ? 'color:' . esc_attr($cor_head) . ';' : ''; ?>">
            <?php echo esc_html($titulo); ?>
          </h2>
        <?php endif; ?>

        <?php if ( $descricao ) : ?>
          <p style="<?php echo $cor_head ? 'color:' . esc_attr($cor_head) . ';' : ''; ?>">
            <?php echo esc_html($descricao); ?>
          </p>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <div class="lilacs-indexacao__grid">
      <?php foreach ( $cards_groups as $group_key => $meta ) :
        $g = get_sub_field($group_key);
        if ( empty($g) || (!isset($g['titulo']) && !isset($g['descricao']) && !isset($g['texto_botao']) && !isset($g['link_do_botao'])) ) {
          continue;
        }

        $card_title = $g['titulo'] ?? '';
        $card_desc  = $g['descricao'] ?? '';
        $btn_text   = $g['texto_botao'] ?? '';
        $btn_link   = $g['link_do_botao'] ?? '';

        // fallback de texto do botão
        if ( empty($btn_text) ) $btn_text = 'Acessar →';

      ?>
        <article class="lilacs-card">
          <div class="lilacs-card__icon" aria-hidden="true"><?php echo esc_html($meta['emoji']); ?></div>

          <?php if ( $card_title ) : ?>
            <h3><?php echo esc_html($card_title); ?></h3>
          <?php endif; ?>

          <?php if ( $card_desc ) : ?>
            <p><?php echo esc_html($card_desc); ?></p>
          <?php else : ?>
            <p></p>
          <?php endif; ?>

          <a class="lilacs-btn" href="<?php echo $esc_url_or_hash($btn_link); ?>" <?php echo $btn_link ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
            <?php echo esc_html($btn_text); ?>
          </a>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ( ! empty($alert_html) ) : ?>
      <div class="lilacs-alert">
        <?php echo wp_kses_post($alert_html); ?>
      </div>
    <?php endif; ?>

    <?php
      if ( ! empty($highlight) ) :
        $h_bg   = $highlight['imagem_de_fundo'] ?? '';
        $h_tit  = $highlight['titulo'] ?? '';
        $h_desc = $highlight['descricao'] ?? '';
        $h_btn  = $highlight['texto_botao'] ?? '';
        $h_link = $highlight['link_botao'] ?? '';

        if ( empty($h_btn) ) $h_btn = 'Saiba mais →';
    ?>
      <div class="lilacs-highlight" style="<?php echo $h_bg ? 'background-image:linear-gradient(135deg, rgba(8,42,83,.92), rgba(10,53,104,.92)), url(' . esc_url($h_bg) . '); background-size:cover; background-position:center;' : ''; ?>">
   

        <div class="lilacs-highlight__content">
          <?php if ( $h_tit ) : ?>
            <h3><?php echo esc_html($h_tit); ?></h3>
          <?php endif; ?>

          <?php if ( $h_desc ) : ?>
            <div class="lilacs-highlight__wys">
              <?php echo wp_kses_post($h_desc); ?>
            </div>
          <?php endif; ?>

          <a class="lilacs-btn lilacs-btn--large" style="background:#f97316;" href="<?php echo $esc_url_or_hash($h_link); ?>" <?php echo $h_link ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
            <?php echo esc_html($h_btn); ?>
          </a>
        </div>
      </div>
    <?php endif; ?>

    <?php if ( ! $has_any ) : ?>
      <div class="bvs-pagina-empty">
        <p>Preencha os campos do bloco “Indexe seu periódico” no ACF.</p>
      </div>
    <?php endif; ?>

  </div>
</section>
<style>
    /* =========================
   LILACS – Indexação (ACF)
========================= */

.lilacs-indexacao {
  padding: 60px 0;
  background: #f5f9ff;
  font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
}

.lilacs-container {
  max-width: 1180px;
  margin: 0 auto;
  padding: 0 20px;
}

/* Cabeçalho */
.lilacs-indexacao__head {
  margin-bottom: 32px;
}

.lilacs-indexacao__head h2 {
  font-size: 32px;
  color: #082a53;
  margin: 0 0 12px;
  letter-spacing: -0.3px;
}

.lilacs-indexacao__head p {
  max-width: 760px;
  font-size: 16px;
  color: #355472;
  line-height: 1.6;
  margin: 0;
}

/* Grid */
.lilacs-indexacao__grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-bottom: 32px;
}

/* Cards */
.lilacs-card {
  background: #fff;
  border-radius: 18px;
  padding: 24px;
  border: 1px solid #d6e2f1;
  box-shadow: 0 12px 32px rgba(8, 42, 83, 0.08);
  display: flex;
  flex-direction: column;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.lilacs-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 18px 44px rgba(8, 42, 83, 0.12);
}

.lilacs-card__icon {
  width: 44px;
  height: 44px;
  border-radius: 14px;
  background: #eaf2fb;
  color: #082a53;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  margin-bottom: 16px;
}

.lilacs-card h3 {
  font-size: 18px;
  color: #082a53;
  margin: 0 0 10px;
}

.lilacs-card p {
  font-size: 14px;
  color: #355472;
  line-height: 1.6;
  margin: 0 0 18px;
  flex: 1;
}

/* Botões */
.lilacs-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px 20px;
  border-radius: 999px;
  background: #082a53;
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  font-size: 14px;
  transition: background 0.15s ease, transform 0.15s ease;
}

.lilacs-btn:hover {
  background: #0a3568;
  transform: translateY(-1px);
}

.lilacs-btn--large {
  padding: 14px 28px;
  font-size: 15px;
}

/* Alerta (wysiwyg) */
.lilacs-alert {
  background: #eaf2fb;
  border-left: 4px solid #082a53;
  padding: 16px 20px;
  border-radius: 12px;
  color: #082a53;
  font-size: 14px;
  margin-bottom: 36px;
}

.lilacs-alert p {
  margin: 0;
}

.lilacs-alert a {
  color: inherit;
  text-decoration: underline;
  font-weight: 600;
}

/* Destaque */
.lilacs-highlight {
  background: linear-gradient(135deg, #082a53, #0a3568);
  border-radius: 22px;
  padding: 32px;
  display: flex;
  gap: 24px;
  align-items: center;
  color: #fff;
  background-size: cover;
  background-position: center;
}

.lilacs-highlight__icon {
  font-size: 36px;
  background: rgba(255, 255, 255, 0.15);
  width: 64px;
  height: 64px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lilacs-highlight__content h3 {
  margin: 0 0 10px;
  font-size: 22px;
}

.lilacs-highlight__wys {
  margin: 0 0 16px;
  font-size: 15px;
  line-height: 1.6;
  max-width: 640px;
}

.lilacs-highlight__wys p {
  margin: 0 0 10px;
}

.lilacs-highlight__wys a {
  color: #fff;
  text-decoration: underline;
  font-weight: 600;
}

/* Responsivo */
@media (max-width: 900px) {
  .lilacs-indexacao__grid {
    grid-template-columns: 1fr;
  }

  .lilacs-highlight {
    flex-direction: column;
    text-align: center;
  }
}

</style>

