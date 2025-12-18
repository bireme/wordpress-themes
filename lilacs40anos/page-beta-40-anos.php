<?php
/*
Template Name: 40 ANOS LILACS [BETA]
Template Post Type: page
*/

if ( ! defined('ABSPATH') ) exit;

get_header();
the_post();

/**
 * Helpers
 */
function l40_esc_text($v){ return esc_html((string)$v); }
function l40_esc_attr($v){ return esc_attr((string)$v); }
function l40_esc_url($v){ return esc_url((string)$v); }

/**
 * ACF Fallback-safe getters (não quebra se ACF não estiver ativo)
 */
function l40_get($field, $default = ''){
  if (function_exists('get_field')) {
    $val = get_field($field);
    if ($val !== null && $val !== '' && $val !== false) return $val;
  }
  return $default;
}
function l40_get_repeater($field){
  if (function_exists('get_field')) {
    $val = get_field($field);
    if (is_array($val)) return $val;
  }
  return [];
}

/**
 * HERO (ajustado para os nomes do seu ACF)
 * - mantém fallback para os nomes antigos caso existam em algum lugar
 */
$hero_logo         = l40_get('l40_hero_logo', 'https://springgreen-raven-258256.hostingersite.com/wp-content/uploads/2025/12/Design_sem_nome__1_-removebg-preview-e1765999317964.png');
$hero_title        = l40_get('l40_hero_h1', l40_get('l40_hero_title', 'Ciência em saúde com identidade da América Latina e Caribe'));
$hero_text         = l40_get('l40_hero_lead', l40_get('l40_hero_text', "A LILACS celebra quatro décadas de compromisso com a democratização\ndo acesso à informação científica em saúde, fortalecendo a produção,\nvisibilidade e uso do conhecimento regional."));
$hero_cta_label    = l40_get('l40_hero_cta_label', 'Ver agenda comemorativa');
$hero_cta_url      = l40_get('l40_hero_cta_anchor', l40_get('l40_hero_cta_url', '#agenda'));
$hero_image_right  = l40_get('l40_hero_image_right', ''); // opcional

/**
 * Institucional
 */
$inst_title        = l40_get('l40_inst_title', '#LILACS40 anos! Ações de celebração do aniversário');
$inst_paragraphs   = l40_get_repeater('l40_inst_paragraphs');

/**
 * Callout
 */
$callout_badge     = l40_get('l40_callout_badge', 'Participe');
$callout_title     = l40_get('l40_callout_title', 'Você faz parte da nossa história');
$callout_text      = l40_get('l40_callout_text', "Envie seu depoimento e acompanhe as ações comemorativas em andamento.\nSua experiência fortalece a LILACS e inspira a comunidade.");
$callout_btn1_lbl  = l40_get('l40_callout_btn1_label', 'Enviar depoimento');
$callout_btn1_url  = l40_get('l40_callout_btn1_url', '#depoimentos');
$callout_btn2_lbl  = l40_get('l40_callout_btn2_label', 'Ver como participar');
$callout_btn2_url  = l40_get('l40_callout_btn2_url', '#acoes');

/**
 * Galeria
 */
$gallery_title     = l40_get('l40_gallery_title', 'Galeria de fotos');
$gallery_subtitle  = l40_get('l40_gallery_subtitle', 'Registros dos encontros e ações comemorativas dos 40 anos da LILACS.');
$gallery_items     = l40_get_repeater('l40_gallery_items');
$gallery_cta_label = l40_get('l40_gallery_cta_label', 'Ver agenda de eventos');
$gallery_cta_url   = l40_get('l40_gallery_cta_url', '#agenda');

/**
 * Agenda
 */
$agenda_title      = l40_get('l40_agenda_title', 'Agenda de eventos');
$events            = l40_get_repeater('l40_events');

/**
 * Depoimentos (AJUSTADO PARA SEU ACF ATUAL)
 * - repeater: depoimentos
 * - subfields: nome_depoimento, foto_depoimento, texto_depoimento
 */
$depo_title        = l40_get('l40_depo_title', 'Depoimentos sobre a LILACS');
$depo_intro        = l40_get('l40_depo_intro', "A contribuição da LILACS para o fortalecimento da informação científica\nem saúde é reconhecida por editores, pesquisadores e instituições\nde toda a região.");
$depo_items        = l40_get_repeater('depoimentos');
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="l40-page">

  <!-- HERO (texto + imagem à direita) -->
  <header class="hero hero--split">
    <div class="container hero-grid">

      <div class="hero-content">
        <?php if (!empty($hero_logo)) : ?>
          <img src="<?php echo l40_esc_url($hero_logo); ?>" alt="LILACS 40 anos" class="hero-logo">
        <?php endif; ?>

        <h1><?php echo l40_esc_text($hero_title); ?></h1>

        <?php if (!empty($hero_text)) : ?>
          <p><?php echo wp_kses_post(wpautop($hero_text)); ?></p>
        <?php endif; ?>

        <?php if (!empty($hero_cta_url) && !empty($hero_cta_label)) : ?>
          <a href="<?php echo l40_esc_attr($hero_cta_url); ?>" class="btn-primary"><?php echo l40_esc_text($hero_cta_label); ?></a>
        <?php endif; ?>
      </div>

      <?php if (!empty($hero_image_right)) : ?>
        <div class="hero-seal">
          <img src="<?php echo l40_esc_url($hero_image_right); ?>" alt="" loading="lazy">
        </div>
      <?php endif; ?>

    </div>
  </header>

  <!-- CONTEÚDO -->
  <main>

    <!-- TEXTO INSTITUCIONAL -->
    <section class="section">
      <div class="container narrow">
        <?php if (!empty($inst_title)) : ?>
          <h2><?php echo l40_esc_text($inst_title); ?></h2>
        <?php endif; ?>

        <?php
          if (!empty($inst_paragraphs)) :
            foreach ($inst_paragraphs as $row) :
              $txt = isset($row['text']) ? $row['text'] : '';
              if (!empty($txt)) {
                echo '<div class="l40-wysiwyg">'. wp_kses_post($txt) .'</div>';
              }
            endforeach;
          else :
        ?>
          <p>A <strong>LILACS</strong> celebra 40 anos como a principal base de dados da produção científica em saúde da América Latina e Caribe, reunindo mais de 1 milhão de registros, com 70% do conteúdo em acesso aberto.</p>
          <p>Sua história tem início em <strong>1979</strong>, com o <strong>Index Medicus Latinoamericano (IMLA)</strong> — um sonho e uma necessidade coletiva de constituir sistemas nacionais de informação científica que reunissem e dessem visibilidade à pesquisa em saúde produzida na região. Em <strong>1985</strong>, surge oficialmente a <strong>LILACS</strong>, com uma metodologia própria de gestão da informação e uma atuação em rede, descentralizada e cooperativa, envolvendo coordenadores e centros cooperantes em cada país. De forma pioneira, incorporou tecnologias como o CD-ROM, as primeiras interfaces de pesquisa via WWW e, hoje, avança na aplicação de inteligência artificial em processos de indexação e geração de resumos.</p>
          <p>A Rede LILACS tem um papel fundamental: desde então, mais de 900 instituições em 30 países mantêm viva essa rede coordenada pela BIREME/OPAS/OMS, que consolida décadas de cooperação para ampliar o acesso, a qualidade e o intercâmbio da informação científica em saúde.</p>
          <p>A LILACS deu origem ao ecossistema de informação científica com centenas de bases de dados coordenadas pela BVS e foi plataforma de origem do SciELO, ampliando o alcance global da ciência latino-americana. Hoje, com o LILACS Plus, a rede conecta a produção regional a bases e repositórios internacionais, promovendo a ciência aberta, a interoperabilidade e a visibilidade global da pesquisa regional.</p>
          <p>Celebrar 40 anos da LILACS é celebrar uma história de pessoas, instituições e ideias que seguem impulsionando a forma de fazer e compartilhar ciência — com identidade, cooperação e inovação.</p>
        <?php endif; ?>
      </div>
    </section>

    <!-- PARTICIPE (callout) -->
    <section class="lilacs-callout" aria-labelledby="lilacs-callout-title">
      <div class="lilacs-callout__container">

        <div class="lilacs-callout__badge">
          <span class="lilacs-callout__dot" aria-hidden="true"></span>
          <?php echo l40_esc_text($callout_badge); ?>
        </div>

        <div class="lilacs-callout__content">
          <h2 id="lilacs-callout-title" class="lilacs-callout__title">
            <?php echo l40_esc_text($callout_title); ?>
          </h2>

          <?php if (!empty($callout_text)) : ?>
            <p class="lilacs-callout__text"><?php echo wp_kses_post(wpautop($callout_text)); ?></p>
          <?php endif; ?>

          <div class="lilacs-callout__actions">
            <?php if (!empty($callout_btn1_url) && !empty($callout_btn1_lbl)) : ?>
              <a class="lilacs-btn lilacs-btn--primary" href="<?php echo l40_esc_attr($callout_btn1_url); ?>"><?php echo l40_esc_text($callout_btn1_lbl); ?></a>
            <?php endif; ?>
            <?php if (!empty($callout_btn2_url) && !empty($callout_btn2_lbl)) : ?>
              <a class="lilacs-btn lilacs-btn--ghost" href="<?php echo l40_esc_attr($callout_btn2_url); ?>"><?php echo l40_esc_text($callout_btn2_lbl); ?></a>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </section>

    <!-- GALERIA DE FOTOS -->
    <section id="galeria" class="l40-gallery" aria-label="Galeria de fotos dos eventos LILACS 40 anos">
      <div class="container">
        <div class="l40-gallery__header">
          <h2 class="l40-gallery__title"><?php echo l40_esc_text($gallery_title); ?></h2>
          <?php if (!empty($gallery_subtitle)) : ?>
            <p class="l40-gallery__subtitle"><?php echo wp_kses_post(wpautop($gallery_subtitle)); ?></p>
          <?php endif; ?>
        </div>

        <div class="l40-gallery__grid">
          <?php
          if (!empty($gallery_items)) :
            foreach ($gallery_items as $g) :
              $img = isset($g['image']) ? $g['image'] : '';
              $lnk = isset($g['link']) ? $g['link'] : '';
              $alt = isset($g['alt']) ? $g['alt'] : '';
              if (empty($img)) continue;
              $href = !empty($lnk) ? $lnk : $img;
          ?>
              <a class="l40-gallery__item" href="<?php echo l40_esc_url($href); ?>" target="_blank" rel="noopener">
                <img src="<?php echo l40_esc_url($img); ?>" alt="<?php echo l40_esc_attr($alt); ?>" loading="lazy">
              </a>
          <?php endforeach; else : ?>
            <a class="l40-gallery__item" href="https://via.placeholder.com/1600x1000" target="_blank" rel="noopener">
              <img src="https://via.placeholder.com/900x650" alt="Evento LILACS 40 anos - foto" loading="lazy">
            </a>
          <?php endif; ?>
        </div>

        <div class="l40-gallery__footer">
          <a class="l40-gallery__cta" href="<?php echo l40_esc_attr($gallery_cta_url); ?>"><?php echo l40_esc_text($gallery_cta_label); ?></a>
        </div>
      </div>
    </section>

    <!-- AGENDA (ACCORDION) -->
    <section id="agenda" class="section">
      <div class="container">
        <h2><?php echo l40_esc_text($agenda_title); ?></h2>

        <div class="l40-accordion" data-l40-accordion>
          <?php if (!empty($events)) : ?>
            <?php foreach ($events as $i => $ev) :
              // (imagem do evento) - se você adicionar no ACF, ele já funciona aqui
              $ev_img   = isset($ev['image']) ? $ev['image'] : '';

              $ev_type  = isset($ev['type']) ? $ev['type'] : 'presencial';
              $ev_title = isset($ev['title']) ? $ev['title'] : '';

              // seus nomes no ACF:
              $ev_date  = isset($ev['date_text']) ? $ev['date_text'] : '';
              $ev_time  = isset($ev['time_text']) ? $ev['time_text'] : '';
              $ev_place = isset($ev['place_text']) ? $ev['place_text'] : '';
              $ev_desc = $ev['descricao'];

              $ev_btn_l = isset($ev['btn_label']) ? $ev['btn_label'] : '';
              $ev_btn_u = isset($ev['btn_url']) ? $ev['btn_url'] : '';

              if (empty($ev_title) && empty($ev_date) && empty($ev_time) && empty($ev_place)) continue;

              $type_label = ($ev_type === 'virtual') ? 'Virtual' : 'Presencial';
              $item_id = 'l40-ev-' . (int)$i;
            ?>
              <div class="l40-acc-item">
                <button
                  class="l40-acc-trigger"
                  type="button"
                  aria-expanded="<?php echo ($i===0) ? 'true' : 'false'; ?>"
                  aria-controls="<?php echo l40_esc_attr($item_id); ?>"
                >
                  <span class="l40-acc-title"><?php echo l40_esc_text($ev_title ?: 'Evento'); ?></span>
                  <span class="l40-acc-meta">
                    <span class="event-type <?php echo l40_esc_attr($ev_type); ?>"><?php echo l40_esc_text($type_label); ?></span>
                    <?php if (!empty($ev_date)) : ?><span class="l40-acc-date"><?php echo l40_esc_text($ev_date); ?></span><?php endif; ?>
                  </span>
                  <span class="l40-acc-icon" aria-hidden="true"></span>
                </button>

                <div
                  id="<?php echo l40_esc_attr($item_id); ?>"
                  class="l40-acc-panel"
                  <?php echo ($i===0) ? '' : 'hidden'; ?>
                >
                  <div class="l40-acc-body">
                    <?php if (!empty($ev_img)) : ?>
                      <div class="l40-acc-media">
                        <img src="<?php echo l40_esc_url($ev_img); ?>" alt="" loading="lazy">
                      </div>
                    <?php endif; ?>

                    <div class="l40-acc-content">
                          <?php if (!empty($ev_desc)) : ?>
                                <?= $ev_desc;?>
                              <?php endif; ?>
                      <ul class="event-info">
                        <?php if (!empty($ev_date)) : ?>
                          <li><strong>Data:</strong> <?php echo l40_esc_text($ev_date); ?></li>
                        <?php endif; ?>
                        <?php if (!empty($ev_time)) : ?>
                          <li><strong>Horário:</strong> <?php echo l40_esc_text($ev_time); ?></li>
                        <?php endif; ?>
                        <?php if (!empty($ev_place)) : ?>
                          <li><strong><?php echo ($ev_type === 'virtual') ? 'Formato:' : 'Local:'; ?></strong> <?php echo l40_esc_text($ev_place); ?></li>
                        <?php endif; ?>
                      </ul>

                      <?php if (!empty($ev_btn_u) && !empty($ev_btn_l)) : ?>
                        <a href="<?php echo l40_esc_url($ev_btn_u); ?>" class="btn-secondary l40-acc-btn"><?php echo l40_esc_text($ev_btn_l); ?></a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <div class="l40-acc-item">
              <button class="l40-acc-trigger" type="button" aria-expanded="true" aria-controls="l40-ev-fallback">
                <span class="l40-acc-title">LILACS 40 anos: compromisso com a democratização da Ciência em Saúde</span>
                <span class="l40-acc-meta">
                  <span class="event-type presencial">Presencial</span>
                  <span class="l40-acc-date">2 de novembro de 2025</span>
                </span>
                <span class="l40-acc-icon" aria-hidden="true"></span>
              </button>
              <div id="l40-ev-fallback" class="l40-acc-panel">
                <div class="l40-acc-body">
                  <div class="l40-acc-content">
                    <ul class="event-info">
                      <li><strong>Data:</strong> 2 de novembro de 2025</li>
                      <li><strong>Horário:</strong> 14h às 17h</li>
                      <li><strong>Local:</strong> UFRJ</li>
                    </ul>
                    <a href="#" class="btn-secondary l40-acc-btn">Ver programação</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </section>

    <!-- DEPOIMENTOS (NOVA SECTION) -->
  <!-- DEPOIMENTOS (NOVA SECTION) -->
<?php if (!empty($depo_title) || !empty($depo_intro) || !empty($depo_items)) : ?>
  <section id="depoimentos" class="l40-depo-section" aria-label="Depoimentos">
    <div class="container">

      <header class="l40-depo-header">
        <?php if (!empty($depo_title)) : ?>
          <h2 class="l40-depo-title"><?php echo l40_esc_text($depo_title); ?></h2>
        <?php endif; ?>

        <?php if (!empty($depo_intro)) : ?>
          <p class="l40-depo-intro"><?php echo wp_kses_post(wpautop($depo_intro)); ?></p>
        <?php endif; ?>
      </header>

      <?php if (!empty($depo_items)) : ?>
        <div class="l40-depo-grid">
          <?php foreach ($depo_items as $d) :
            $name  = isset($d['nome_depoimento']) ? trim((string)$d['nome_depoimento']) : '';
            $photo = isset($d['foto_depoimento']) ? trim((string)$d['foto_depoimento']) : '';
            $text  = isset($d['texto_depoimento']) ? trim((string)$d['texto_depoimento']) : '';

            // Só ignora se estiver tudo vazio
            if (empty($name) && empty($text)) continue;
          ?>
            <article class="l40-depo-card">
              <div class="l40-depo-card__head <?php echo empty($photo) ? 'is-no-photo' : ''; ?>">

                <?php if (!empty($photo)) : ?>
                  <img class="l40-depo-avatar"
                       src="<?php echo l40_esc_url($photo); ?>"
                       alt="<?php echo l40_esc_attr($name); ?>"
                       loading="lazy">
                <?php endif; ?>

                <?php if (!empty($name)) : ?>
                  <strong class="l40-depo-name"><?php echo l40_esc_text($name); ?></strong>
                <?php endif; ?>

              </div>

              <?php if (!empty($text)) : ?>
                <div class="l40-depo-text"><?php echo wp_kses_post(wpautop($text)); ?></div>
              <?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>

        <div class="l40-depo-footer">
          <a class="l40-depo-btn" href="/depoimentos-lilacs/">Ver todos os depoimentos</a>
        </div>
      <?php endif; ?>

    </div>
  </section>
<?php endif; ?>


  </main>

</div>

<style>

/* =========================
   ACCORDION (AGENDA)
========================= */
.l40-accordion{
  margin-top: 18px;
  display: grid;
  gap: 12px;
}
.l40-depo-footer{
    padding: 20px 0;
    text-align: right;
}
.l40-depo-btn{
        background: #0c427e;
    padding: 15px;
    border-radius: 30px;
    color: #fff;
    text-decoration: none;
}
.l40-acc-item{
  background: #fff;
  border: 1px solid rgba(12,67,128,.10);
  box-shadow: 0 12px 28px rgba(2, 23, 55, 0.06);
  border-radius: 14px;
  overflow: hidden;
}

.l40-acc-trigger{
  width: 100%;
  text-align: left;
  background: transparent;
  border: 0;
  padding: 16px 18px;
  cursor: pointer;
  display: grid;
  grid-template-columns: 1fr auto auto;
  gap: 12px;
  align-items: center;
}

.l40-acc-title{
  font-weight: 900;
  color: var(--text);
  line-height: 1.2;
}

.l40-acc-meta{
  display: inline-flex;
  gap: 10px;
  align-items: center;
  justify-content: flex-end;
  white-space: nowrap;
}

.l40-acc-date{
  color: var(--muted);
  font-weight: 700;
  font-size: .95rem;
}

.l40-acc-icon{
  width: 14px;
  height: 14px;
  border-right: 2px solid rgba(12,67,128,.7);
  border-bottom: 2px solid rgba(12,67,128,.7);
  transform: rotate(45deg);
  transition: transform .18s ease;
  margin-left: 6px;
}

.l40-acc-trigger[aria-expanded="true"] .l40-acc-icon{
  transform: rotate(-135deg);
}

.l40-acc-panel{
  border-top: 1px solid rgba(12,67,128,.10);
}

.l40-acc-body{
  display: grid;
  grid-template-columns: 320px 1fr;
  gap: 16px;
  padding: 16px 18px 18px;
  align-items: start;
}

.l40-acc-media{
  border-radius: 12px;
  overflow: hidden;
  background: #e9eef5;
  height: 200px;
}

.l40-acc-media img{
  width: 100%;
  height: 100%;
  object-fit: cover;
  display:block;
}

.l40-acc-content .event-info{
  margin-top: 6px;
}

.l40-acc-btn{
  display: inline-block;
  margin-top: 14px;
}

/* responsivo accordion */
@media (max-width: 900px){
  .l40-acc-trigger{
    grid-template-columns: 1fr;
    gap: 10px;
  }
  .l40-acc-meta{
    justify-content: flex-start;
    white-space: normal;
    flex-wrap: wrap;
  }
  .l40-acc-body{
    grid-template-columns: 1fr;
  }
  .l40-acc-media{
    height: 220px;
  }
}

/* =========================
   GALERIA (LILACS 40)
========================= */
.l40-gallery{
  padding: 44px 0;
  background: #ffffff;
  border-top: 1px solid rgba(12,67,128,.08);
}

.l40-gallery__header{
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 18px;
  margin-bottom: 18px;
}

.l40-gallery__title{
  margin: 0;
  font-size: 1.85rem;
  line-height: 1.15;
}

.l40-gallery__subtitle{
  margin: 0;
  color: var(--muted);
  max-width: 70ch;
}

.l40-gallery__grid{
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: 14px;
}

.l40-gallery__item{
  position: relative;
  display: block;
  border-radius: 14px;
  overflow: hidden;
  background: #fff;
  border: 1px solid rgba(12,67,128,.10);
  box-shadow: 0 12px 28px rgba(2, 23, 55, 0.08);
  transform: translateZ(0);
  min-height: 170px;
}

.l40-gallery__item:nth-child(1){ grid-column: span 6; }
.l40-gallery__item:nth-child(2){ grid-column: span 3; }
.l40-gallery__item:nth-child(3){ grid-column: span 3; }
.l40-gallery__item:nth-child(4){ grid-column: span 4; }
.l40-gallery__item:nth-child(5){ grid-column: span 4; }
.l40-gallery__item:nth-child(6){ grid-column: span 4; }

.l40-gallery__item img{
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transform: scale(1.02);
  transition: transform .22s ease, filter .22s ease;
}

.l40-gallery__item::after{
  content:"";
  position:absolute;
  inset:0;
  background: linear-gradient(180deg, rgba(12,67,128,0) 45%, rgba(12,67,128,.22));
  opacity: .9;
  pointer-events:none;
}

.l40-gallery__item::before{
  content:"";
  position:absolute;
  inset:0;
  border-radius: 14px;
  box-shadow: inset 0 0 0 1px rgba(226,88,44,.0);
  transition: box-shadow .22s ease;
  pointer-events:none;
}

.l40-gallery__item:hover img{
  transform: scale(1.07);
  filter: saturate(1.05);
}

.l40-gallery__item:hover::before{
  box-shadow: inset 0 0 0 2px rgba(226,88,44,.55);
}

.l40-gallery__footer{
  display:flex;
  justify-content:flex-end;
  margin-top: 16px;
}

.l40-gallery__cta{
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 400;
    color: #fff;
    background: linear-gradient(90deg, var(--primary), #0b3a70);
    box-shadow: 0 12px 22px rgba(12, 67, 128, .18);
}

.l40-gallery__cta:hover{
  filter: brightness(.98);
  transform: translateY(-1px);
}

@media (max-width: 980px){
  .l40-gallery__header{
    flex-direction: column;
    align-items: flex-start;
  }
  .l40-gallery__item:nth-child(1){ grid-column: span 12; }
  .l40-gallery__item:nth-child(2),
  .l40-gallery__item:nth-child(3),
  .l40-gallery__item:nth-child(4),
  .l40-gallery__item:nth-child(5),
  .l40-gallery__item:nth-child(6){ grid-column: span 6; }
}

@media (max-width: 640px){
  .l40-gallery{ padding: 34px 0; }
  .l40-gallery__item{ grid-column: span 12 !important; min-height: 200px; }
  .l40-gallery__footer{ justify-content: stretch; }
  .l40-gallery__cta{ width: 100%; justify-content: center; }
}

/* =========================
   NOVA SECTION: DEPOIMENTOS
========================= */
.l40-depo-section{
  padding: 44px 0;
  background:
    radial-gradient(900px 220px at 15% 10%, rgba(12,67,128,.10), transparent 60%),
    radial-gradient(700px 220px at 85% 0%, rgba(226,88,44,.10), transparent 55%),
    linear-gradient(180deg, #ffffff, #f6f8fb);
  border-top: 1px solid rgba(12,67,128,.08);
}

.l40-depo-header{
  margin-bottom: 18px;
}

.l40-depo-title{
  margin: 0 0 10px;
  font-size: 1.85rem;
  line-height: 1.15;
}

.l40-depo-intro{
  margin: 0;
  color: var(--muted);
  max-width: 90ch;
}

.l40-depo-grid{
  margin-top: 18px;
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 14px;
}

.l40-depo-card{
  background: #fff;
  border: 1px solid rgba(12,67,128,.10);
  box-shadow: 0 12px 28px rgba(2, 23, 55, 0.06);
  border-radius: 14px;
  padding: 16px;
}

.l40-depo-card__head{
  display:flex;
  gap: 12px;
  align-items:center;
  margin-bottom: 10px;
}

.l40-depo-avatar{
  width: 54px;
  height: 54px;
  border-radius: 999px;
  object-fit: cover;
  display:block;
  background: #e9eef5;
  flex: 0 0 54px;
}
.l40-depo-avatar--empty{
  display:inline-block;
}

.l40-depo-name{
  display:block;
  font-weight: 900;
  color: var(--text);
  line-height: 1.1;
}

.l40-depo-text{
  color: var(--muted);
}

@media (max-width: 980px){
  .l40-depo-grid{ grid-template-columns: 1fr 1fr; }
}

@media (max-width: 640px){
  .l40-depo-section{ padding: 34px 0; }
  .l40-depo-grid{ grid-template-columns: 1fr; }
}

:root {
  --primary: #0C4380;
  --secondary: #E2582C;
  --text: #0f172a;
  --muted: #475569;
  --bg: #ffffff;
  --light: #f5f7fa;
  --radius: 12px;
}

* { box-sizing: border-box; }

.l40-page{
  font-family: "Noto Sans", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  color: var(--text);
  background: var(--bg);
  line-height: 1.6;
}

.container {
  max-width: 1180px;
  margin: 0 auto;
  padding: 0 20px;
}
.container.narrow { max-width: 1180px; }

.section { padding: 16px 0; }
.section.light { background: var(--light); }

.hero {
  background: linear-gradient(180deg, #002a50, #0C4380);
  color: #fff;
  padding: 72px 0;
}

.hero--split .hero-grid{
  display: grid;
  grid-template-columns: 1.2fr .8fr;
  align-items: center;
  gap: 30px;
}

.hero-content { max-width: 720px; }
.hero-logo { max-width: 220px; margin-bottom: 18px; }
.hero h1 { font-size: 2.35rem; margin: 0 0 14px; }
.hero p { font-size: 1.05rem; opacity: 0.95; }

.hero-seal{
  display:flex;
  justify-content:center;
  align-items:center;
}
.hero-seal img{
  width: min(420px, 100%);
  height: auto;
  display:block;
  filter: drop-shadow(0 18px 30px rgba(0,0,0,.25));
  transform: translateY(2px);
}

.btn-primary,
.btn-secondary {
  display: inline-block;
  margin-top: 24px;
  padding: 14px 26px;
  border-radius: 30px;
  text-decoration: none;
  font-weight: 800;
  
}

.btn-primary { background: var(--secondary); color: #fff; }
.btn-primary:hover { filter: brightness(0.97); }

.btn-secondary { border: 2px solid #fff; color: #fff; }

h2 { font-size: 1.8rem; margin-bottom: 16px; }

/* Callout (mantido do seu CSS) */
:root{
  --lilacs-blue: #0C4380;
  --lilacs-orange: #E2582C;
  --lilacs-ink: #0f172a;
  --lilacs-muted: #475569;
  --lilacs-surface: #ffffff;
  --lilacs-radius: 16px;
}

.lilacs-callout{
  padding: 42px 0;
  background:
    radial-gradient(900px 220px at 20% 10%, rgba(12,67,128,.12), transparent 60%),
    radial-gradient(700px 220px at 80% 0%, rgba(226,88,44,.14), transparent 55%),
    linear-gradient(180deg, #fff, #f6f8fb);
}

.lilacs-callout__container{
  max-width: 1180px;
  margin: 0 auto;
  padding: 0 20px;
}

.lilacs-callout__content{
  position: relative;
  padding: 28px 28px 24px;
  border-radius: var(--lilacs-radius);
  background: var(--lilacs-surface);
  border: 1px solid rgba(12,67,128,.12);
  box-shadow: 0 18px 45px rgba(2, 23, 55, 0.08);
  overflow: hidden;
}

.lilacs-callout__content::before{
  content:"";
  position:absolute;
  inset:0;
  padding: 1px;
  border-radius: calc(var(--lilacs-radius) + 2px);
  background: linear-gradient(90deg, rgba(12,67,128,.55), rgba(226,88,44,.55));
  -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;
  pointer-events:none;
}

.lilacs-callout__content::after{
  content:"";
  position:absolute;
  top:-120px;
  right:-160px;
  width: 360px;
  height: 360px;
  border-radius: 50%;
  background: radial-gradient(circle at 30% 30%, rgba(226,88,44,.22), rgba(12,67,128,.10), transparent 70%);
  filter: blur(2px);
  pointer-events:none;
}

.lilacs-callout__badge{
  display: inline-flex;
  align-items: center;
  gap: 10px;
  margin: 0 0 14px;
  padding: 8px 12px;
  border-radius: 999px;
  font-weight: 800;
  letter-spacing: .02em;
  color: var(--lilacs-blue);
  background: rgba(12,67,128,.08);
  border: 1px solid rgba(12,67,128,.14);
}

.lilacs-callout__dot{
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: var(--lilacs-orange);
  box-shadow: 0 0 0 4px rgba(226,88,44,.18);
}

.lilacs-callout__title{
  margin: 0 0 10px;
  font-size: clamp(20px, 2.1vw, 28px);
  line-height: 1.15;
  color: var(--lilacs-ink);
}

.lilacs-callout__text{
  margin: 0 0 18px;
  font-size: 1rem;
  color: var(--lilacs-muted);
  max-width: 72ch;
}

.lilacs-callout__actions{
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  align-items: center;
}

.lilacs-btn{
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 46px;
  padding: 12px 18px;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 800;
  border-radius:30px;
  transition: transform .15s ease, box-shadow .15s ease, background .15s ease, border-color .15s ease;
  will-change: transform;
}

.lilacs-btn--primary{
  color: #fff;
  background: linear-gradient(90deg, var(--lilacs-blue), #0b3a70);
  box-shadow: 0 12px 22px rgba(12,67,128,.22);
}
.lilacs-btn--primary:hover{
  transform: translateY(-1px);
  box-shadow: 0 16px 28px rgba(12,67,128,.28);
}

.lilacs-btn--ghost{
  color: var(--lilacs-blue);
  background: rgba(12,67,128,.06);
  border: 1px solid rgba(12,67,128,.18);
}
.lilacs-btn--ghost:hover{
  transform: translateY(-1px);
  background: rgba(12,67,128,.09);
  border-color: rgba(12,67,128,.26);
}

.lilacs-btn:focus-visible{
  outline: 3px solid rgba(226,88,44,.35);
  outline-offset: 3px;
}

@media (max-width: 900px){
  .hero--split .hero-grid{ grid-template-columns: 1fr; }
  .hero{ padding: 56px 0; }
  .hero h1{ font-size: 1.9rem; }
  .hero-seal{ justify-content:flex-start; }
}

@media (max-width: 640px){
  .lilacs-callout{ padding: 34px 0; }
  .lilacs-callout__content{ padding: 22px 18px; }
  .lilacs-btn{ width: 100%; }
}
</style>

<script>
(function(){
  var root = document.querySelector('[data-l40-accordion]');
  if (!root) return;

  var items = Array.prototype.slice.call(root.querySelectorAll('.l40-acc-item'));
  if (!items.length) return;

  function closeAll(exceptBtn){
    items.forEach(function(it){
      var btn = it.querySelector('.l40-acc-trigger');
      var panel = it.querySelector('.l40-acc-panel');
      if (!btn || !panel) return;
      if (exceptBtn && btn === exceptBtn) return;
      btn.setAttribute('aria-expanded', 'false');
      panel.hidden = true;
    });
  }

  items.forEach(function(it){
    var btn = it.querySelector('.l40-acc-trigger');
    var panel = it.querySelector('.l40-acc-panel');
    if (!btn || !panel) return;

    btn.addEventListener('click', function(){
      var expanded = btn.getAttribute('aria-expanded') === 'true';
      if (expanded) {
        btn.setAttribute('aria-expanded', 'false');
        panel.hidden = true;
      } else {
        closeAll(btn);
        btn.setAttribute('aria-expanded', 'true');
        panel.hidden = false;
      }
    });
  });

  var anyOpen = items.some(function(it){
    var btn = it.querySelector('.l40-acc-trigger');
    return btn && btn.getAttribute('aria-expanded') === 'true';
  });
  if (!anyOpen) {
    var firstBtn = items[0].querySelector('.l40-acc-trigger');
    var firstPanel = items[0].querySelector('.l40-acc-panel');
    if (firstBtn && firstPanel) {
      firstBtn.setAttribute('aria-expanded', 'true');
      firstPanel.hidden = false;
    }
  }
})();
</script>

<?php get_footer(); ?>
