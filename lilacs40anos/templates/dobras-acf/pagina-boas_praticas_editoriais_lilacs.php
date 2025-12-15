<?php
/**
 * DOBRA (template-part) — pagina-boas_praticas_editoriais_lilacs.php
 * Layout ACF: boas_praticas_editoriais_lilacs
 *
 * ATENÇÃO:
 * - NÃO puxa header/footer
 * - NÃO faz loop do flexible
 * - Este arquivo é chamado de dentro do the_row() via lilacs_bvs_dobra('pagina-boas_praticas_editoriais_lilacs')
 */

if ( ! defined('ABSPATH') ) exit;

// Campos do layout (sub_fields)
$titulo    = get_sub_field('titulo');
$descricao = get_sub_field('descricao');

$sessoes_virtuais = (array) get_sub_field('sessoes_virtuais');
$guia            = (array) get_sub_field('guia_de_boas_praticas_editoriais');

$dica_alerta = get_sub_field('dica_alerta');

// Helpers
$esc_txt = function($v){ return esc_html( (string) $v ); };
$esc_url = function($v){ return esc_url( (string) $v ); };
$esc_wys = function($v){ return wp_kses_post( (string) $v ); };

// Dados do grupo "Sessões virtuais"
$sv_titulo     = $sessoes_virtuais['titulo']      ?? '';
$sv_descricao  = $sessoes_virtuais['descricao']   ?? '';
$sv_texto_btn  = $sessoes_virtuais['texto_botao'] ?? '';
$sv_link_btn   = $sessoes_virtuais['link_do_botao'] ?? '';

// Dados do grupo "Guia de Boas Práticas Editoriais"
$guia_titulo    = $guia['titulo']      ?? '';
$guia_descricao = $guia['descricao']   ?? '';
$guia_texto_btn = $guia['texto_botao'] ?? '';
?>

<section class="lilacs-dobra lilacs-dobra--boas-praticas" data-dobra="boas_praticas_editoriais_lilacs">
  <div class="container">

    <?php if ( $titulo || $descricao ) : ?>
      <header class="lilacs-dobra__header">
        <?php if ( $titulo ) : ?>
          <h2 class="lilacs-dobra__title"><?php echo $esc_txt($titulo); ?></h2>
        <?php endif; ?>

        <?php if ( $descricao ) : ?>
          <p class="lilacs-dobra__subtitle"><?php echo $esc_txt($descricao); ?></p>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <div class="lilacs-dobra__grid">

      <?php if ( $sv_titulo || $sv_descricao || $sv_texto_btn || $sv_link_btn ) : ?>
        <article class="lilacs-card lilacs-card--sessoes-virtuais">
          <?php if ( $sv_titulo ) : ?>
            <h3 class="lilacs-card__title"><?php echo $esc_txt($sv_titulo); ?></h3>
          <?php endif; ?>

          <?php if ( $sv_descricao ) : ?>
            <div class="lilacs-card__content wysiwyg">
              <?php echo $esc_wys($sv_descricao); ?>
            </div>
          <?php endif; ?>

          <?php if ( $sv_texto_btn && $sv_link_btn ) : ?>
            <div class="lilacs-card__actions">
              <a class="lilacs-btn lilacs-btn--primary" href="<?php echo $esc_url($sv_link_btn); ?>">
                <?php echo $esc_txt($sv_texto_btn); ?>
              </a>
            </div>
          <?php endif; ?>
        </article>
      <?php endif; ?>

      <?php if ( $guia_titulo || $guia_descricao || $guia_texto_btn ) : ?>
        <article class="lilacs-card lilacs-card--guia">
          <?php if ( $guia_titulo ) : ?>
            <h3 class="lilacs-card__title"><?php echo $esc_txt($guia_titulo); ?></h3>
          <?php endif; ?>

          <?php if ( $guia_descricao ) : ?>
            <div class="lilacs-card__content wysiwyg">
              <?php echo $esc_wys($guia_descricao); ?>
            </div>
          <?php endif; ?>

          <?php if ( $guia_texto_btn ) : ?>
            <div class="lilacs-card__actions">
              <button type="button"
                      class="lilacs-btn lilacs-btn--secondary"
                      data-lilacs-copy-target="guia_boas_praticas_editoriais">
                <?php echo $esc_txt($guia_texto_btn); ?>
              </button>

              <!-- Conteúdo “copiável” (se quiser usar JS para copiar/abrir modal/download) -->
              <div class="lilacs-hidden" data-lilacs-copy-source="guia_boas_praticas_editoriais" aria-hidden="true">
                <?php echo $esc_wys($guia_descricao); ?>
              </div>
            </div>
          <?php endif; ?>
        </article>
      <?php endif; ?>

    </div>

    <?php if ( $dica_alerta ) : ?>
      <div class="lilacs-alert lilacs-alert--tip" role="note">
        <div class="lilacs-alert__icon" aria-hidden="true">i</div>
        <div class="lilacs-alert__text"><?php echo $esc_txt($dica_alerta); ?></div>
      </div>
    <?php endif; ?>

  </div>
</section>

<style>
/* =========================
   LILACS – Boas Práticas Editoriais
   (escopo: .lilacs-dobra--boas-praticas)
========================= */

.lilacs-dobra--boas-praticas{
  padding: 64px 0;
  background: #0b2c68;
  font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
}

.lilacs-dobra--boas-praticas .container{
  max-width: 1180px;
  margin: 0 auto;
  padding: 0 20px;
}

/* Header */
.lilacs-dobra--boas-praticas .lilacs-dobra__header{
  margin-bottom: 26px;
}

.lilacs-dobra--boas-praticas .lilacs-dobra__title{
  margin: 0 0 10px;
  font-size: 34px;
  line-height: 1.15;
  color: #fff;
  letter-spacing: -0.4px;
}

.lilacs-dobra--boas-praticas .lilacs-dobra__subtitle{
  margin: 0;
  max-width: 820px;
  font-size: 16px;
  line-height: 1.65;
  color: #fff;
}

/* Grid */
.lilacs-dobra--boas-praticas .lilacs-dobra__grid{
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 20px;
  align-items: stretch;
}

/* Card (base) */
.lilacs-dobra--boas-praticas .lilacs-card{
  position: relative;
  background: #fff;
  border-radius: 18px;
  border: 1px solid #d6e2f1;
  box-shadow: 0 12px 32px rgba(8, 42, 83, 0.08);
  padding: 26px;
  overflow: hidden;
  transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
}

.lilacs-dobra--boas-praticas .lilacs-card:hover{
  transform: translateY(-3px);
  box-shadow: 0 18px 44px rgba(8, 42, 83, 0.12);
  border-color: #c7d9ee;
}

/* Top accent (diferencia os 2 cards sem “poluir”) */
.lilacs-dobra--boas-praticas .lilacs-card::before{
  content:"";
  position:absolute;
  left:0; top:0; right:0;
  height: 5px;
  background: #082a53;
  opacity: .9;
}

.lilacs-dobra--boas-praticas .lilacs-card--sessoes-virtuais::before{
  background: #f97316;
}

.lilacs-dobra--boas-praticas .lilacs-card--guia::before{
  background: linear-gradient(90deg, #082a53 0%, #0b3b77 60%, #0a7aa6 100%);
}

/* Card title */
.lilacs-dobra--boas-praticas .lilacs-card__title{
  margin: 0 0 12px;
  font-size: 18px;
  line-height: 1.35;
  color: #082a53;
}

/* WYSIWYG */
.lilacs-dobra--boas-praticas .lilacs-card__content{
  color: #355472;
  font-size: 14px;
  line-height: 1.7;
}

.lilacs-dobra--boas-praticas .lilacs-card__content > *:first-child{ margin-top: 0; }
.lilacs-dobra--boas-praticas .lilacs-card__content > *:last-child{ margin-bottom: 0; }

.lilacs-dobra--boas-praticas .lilacs-card__content a{
  color: #0a3568;
  font-weight: 700;
  text-decoration: underline;
  text-underline-offset: 3px;
}

.lilacs-dobra--boas-praticas .lilacs-card__content ul,
.lilacs-dobra--boas-praticas .lilacs-card__content ol{
  padding-left: 18px;
  margin: 12px 0 0;
}

.lilacs-dobra--boas-praticas .lilacs-card__content li{
  margin: 6px 0;
}

/* Actions */
.lilacs-dobra--boas-praticas .lilacs-card__actions{
  margin-top: 18px;
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}

/* Buttons */
.lilacs-dobra--boas-praticas .lilacs-btn{
  appearance: none;
  border: 0;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 12px 18px;
  border-radius: 999px;
  font-weight: 800;
  font-size: 14px;
  text-decoration: none;
  transition: transform .15s ease, background .15s ease, box-shadow .15s ease, border-color .15s ease, color .15s ease;
  user-select: none;
  line-height: 1;
}

.lilacs-dobra--boas-praticas .lilacs-btn:focus{
  outline: none;
}

.lilacs-dobra--boas-praticas .lilacs-btn:focus-visible{
  outline: 3px solid rgba(10, 53, 104, 0.25);
  outline-offset: 3px;
}

/* Primary */
.lilacs-dobra--boas-praticas .lilacs-btn--primary{
  background: #082a53;
  color: #fff;
  box-shadow: 0 10px 22px rgba(8, 42, 83, 0.18);
}

.lilacs-dobra--boas-praticas .lilacs-btn--primary:hover{
  background: #0a3568;
  transform: translateY(-1px);
}

/* Secondary (outline chique) */
.lilacs-dobra--boas-praticas .lilacs-btn--secondary{
  background: #ffffff;
  color: #082a53;
  border: 1px solid #c7d9ee;
  box-shadow: 0 10px 22px rgba(8, 42, 83, 0.08);
}

.lilacs-dobra--boas-praticas .lilacs-btn--secondary:hover{
  border-color: #0a3568;
  transform: translateY(-1px);
}

/* Alert / tip */
.lilacs-dobra--boas-praticas .lilacs-alert{
  margin-top: 22px;
  border-radius: 14px;
  border: 1px solid #d6e2f1;
  background: #eaf2fb;
  padding: 14px 16px;
  display: flex;
  gap: 12px;
  align-items: flex-start;
}

.lilacs-dobra--boas-praticas .lilacs-alert__icon{
  width: 28px;
  height: 28px;
  border-radius: 999px;
  background: #0b2c68;
  color: #fff;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 900;
  font-size: 14px;
  line-height: 1;
  flex: 0 0 auto;
}

.lilacs-dobra--boas-praticas .lilacs-alert__text{
  color: #082a53;
  font-size: 14px;
  line-height: 1.6;
}

/* Hidden helper */
.lilacs-dobra--boas-praticas .lilacs-hidden{
  display: none !important;
}

/* Responsive */
@media (max-width: 900px){
  .lilacs-dobra--boas-praticas{
    padding: 52px 0;
  }

  .lilacs-dobra--boas-praticas .lilacs-dobra__title{
    font-size: 28px;
  }

  .lilacs-dobra--boas-praticas .lilacs-dobra__grid{
    grid-template-columns: 1fr;
  }

  .lilacs-dobra--boas-praticas .lilacs-card{
    padding: 22px;
  }
}

</style>