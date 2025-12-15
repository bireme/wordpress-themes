<?php
/**
 * DOBRA: Sua revista na LILACS
 * Slug esperado pelo seu loader: pagina-sua_revista_na_lilacs.php
 * Campos ACF (sub_fields do layout):
 * - titulo, descricao
 * - periodicos_indexados_na_lilacs (group): titulo, descricao (wysiwyg), texto_do_botao, link_do_botao
 * - portal_de_revistas_cientificas (group): titulo, descricao (wysiwyg), texto_do_botao, link_do_botao
 * - atualize_os_dados_do_seu_periodico (group):
 *    titulo, descricao (wysiwyg), texto_do_botao, link_do_botao,
 *    titulo_2, descricao_2 (wysiwyg), texto_do_botao_2, link_do_botao_2
 */

if ( ! defined('ABSPATH') ) exit;

$titulo   = get_sub_field('titulo');
$descricao = get_sub_field('descricao');

$g_periodicos = (array) get_sub_field('periodicos_indexados_na_lilacs');
$g_portal     = (array) get_sub_field('portal_de_revistas_cientificas');
$g_atualize   = (array) get_sub_field('atualize_os_dados_do_seu_periodico');

$periodicos_titulo = $g_periodicos['titulo'] ?? '';
$periodicos_desc   = $g_periodicos['descricao'] ?? '';
$periodicos_btn    = $g_periodicos['texto_do_botao'] ?? '';
$periodicos_link   = $g_periodicos['link_do_botao'] ?? '';

$portal_titulo = $g_portal['titulo'] ?? '';
$portal_desc   = $g_portal['descricao'] ?? '';
$portal_btn    = $g_portal['texto_do_botao'] ?? '';
$portal_link   = $g_portal['link_do_botao'] ?? '';

$atualize_titulo = $g_atualize['titulo'] ?? '';
$atualize_desc   = $g_atualize['descricao'] ?? '';
$atualize_btn    = $g_atualize['texto_do_botao'] ?? '';
$atualize_link   = $g_atualize['link_do_botao'] ?? '';

$atualize_titulo_2 = $g_atualize['titulo_2'] ?? '';
$atualize_desc_2   = $g_atualize['descricao_2'] ?? '';
$atualize_btn_2    = $g_atualize['texto_do_botao_2'] ?? '';
$atualize_link_2   = $g_atualize['link_do_botao_2'] ?? '';

// Link do perfil (atualmente indisponível – você pode transformar em campo depois se quiser)
$perfil_link = 'https://lilacs.bvsalud.org/indicadores-lilacs/#perfil-periodicos';

// CSS só uma vez por página
static $lilacs_revista_css_printed = false;
if ( ! $lilacs_revista_css_printed ) :
  $lilacs_revista_css_printed = true;
  ?>
  <style>
    .lilacs-journal{
      --blue-900:#002A4D;
      --blue-800:#003C71;
      --blue-50:#F5F9FF;
      --stroke:#D6E2F1;
      padding: 44px 20px;
      background: linear-gradient(180deg, var(--blue-50), #ffffff);
    }
    .lilacs-container{ max-width:1180px; margin:0 auto; }
    .lilacs-head h2{
      margin:0 0 10px;
      font-size:30px; line-height:1.2;
      color:var(--blue-800);
      letter-spacing:-0.3px;
    }
    .lilacs-head p{
      margin:0 0 22px;
      color:#355472;
      font-size:15px; line-height:1.6;
      max-width:78ch;
    }
    .lilacs-grid{
      display:grid;
      grid-template-columns: 1fr 1fr 1.2fr;
      gap:16px;
      align-items:stretch;
    }
    .lilacs-card{
      background:#fff;
      border:1px solid var(--stroke);
      border-radius:18px;
      padding:18px;
      box-shadow: 0 10px 30px rgba(0, 60, 113, 0.08);
      display:flex;
      gap:14px;
      transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
    }
    .lilacs-card:hover{
      transform: translateY(-2px);
      border-color:#BFD4EC;
      box-shadow: 0 14px 40px rgba(0, 60, 113, 0.12);
    }
    .lilacs-card__icon{
      width:44px; height:44px;
      border-radius:14px;
      background:#EAF2FB;
      color:#003C71;
      display:grid; place-items:center;
      flex:0 0 44px;
    }
    .lilacs-card__icon svg{ width:22px; height:22px; }
    .lilacs-card__body{
      display:flex;
      flex-direction:column;
      align-items:flex-start;
      width:100%;
    }
    .lilacs-card__body h3{
      margin:2px 0 8px;
      font-size:18px;
      color:var(--blue-900);
      letter-spacing:-0.2px;
    }
    .lilacs-card__body p{
      margin:0 0 14px;
      color:#355472;
      font-size:14px;
      line-height:1.55;
    }
    .lilacs-card__body .lilacs-btn{ margin-top:auto; }

    .lilacs-card--featured{
      border-color:#BFD4EC;
      background: linear-gradient(180deg, #ffffff, #FAFCFF);
    }

    /* BOTÕES – padrão final */
    .lilacs-btn{
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
      border:none;
      min-width:220px;
      box-shadow:0 6px 16px rgba(8, 42, 83, 0.25);
      transition: transform .12s ease, background .12s ease;
      user-select:none;
    }
    .lilacs-btn:hover{ background:#0A3568; transform: translateY(-1px); }
    .lilacs-btn__arrow{ font-weight:900; }

    .lilacs-note{
      margin-top:14px;
      padding-top:14px;
      border-top:1px dashed #CFE0F3;
      width:100%;
    }
    .lilacs-note strong{ color:var(--blue-900); font-size:14px; }
    .lilacs-note p{ margin:6px 0 0; }

    .lilacs-btn--disabled{
      margin-top:10px;
      background:#D1DBE8;
      color:#6B7C93;
      box-shadow:none;
      cursor:not-allowed;
      pointer-events:none;
      min-width:220px;
    }
    .lilacs-wysiwyg > .lilacs-card{
        border:none;
    }

    /* WYSIWYG dentro da dobra */
    .lilacs-card__body .lilacs-wysiwyg{ color:#355472; font-size:14px; line-height:1.6; }
    .lilacs-card__body .lilacs-wysiwyg p{ margin:0 0 12px; }
    .lilacs-card__body .lilacs-wysiwyg a{ color:#0A3568; text-decoration:underline; }

    @media (max-width:980px){
      .lilacs-grid{ grid-template-columns:1fr; }
      .lilacs-btn{ min-width: 100%; }
    }
  </style>
<?php endif; ?>

<section class="lilacs-journal">
  <div class="lilacs-container">
    <header class="lilacs-head">
      <?php if ( ! empty($titulo) ) : ?>
        <h2><?php echo esc_html($titulo); ?></h2>
      <?php endif; ?>

      <?php if ( ! empty($descricao) ) : ?>
        <p><?php echo esc_html($descricao); ?></p>
      <?php endif; ?>
    </header>

    <div class="lilacs-grid">

      <!-- Card: Periódicos indexados -->
      <article class="lilacs-card">
        <div class="lilacs-card__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M8 6h13M8 12h13M8 18h13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M3.5 6h.01M3.5 12h.01M3.5 18h.01" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="lilacs-card__body">
          <h3><?php echo esc_html( $periodicos_titulo ?: 'Periódicos indexados na LILACS' ); ?></h3>

          <?php if ( ! empty($periodicos_desc) ) : ?>
            <div class="lilacs-wysiwyg"><?php echo wp_kses_post($periodicos_desc); ?></div>
          <?php else : ?>
            <p>Consulte a lista atual de periódicos indexados na LILACS.</p>
          <?php endif; ?>

          <?php if ( ! empty($periodicos_link) ) : ?>
            <a class="lilacs-btn"
               href="<?php echo esc_url($periodicos_link); ?>"
               target="_blank" rel="noopener">
              <?php echo esc_html( $periodicos_btn ?: 'Acessar periódicos' ); ?>
              <span class="lilacs-btn__arrow" aria-hidden="true">→</span>
            </a>
          <?php endif; ?>
        </div>
      </article>

      <!-- Card: Portal de Revistas -->
      <article class="lilacs-card">
        <div class="lilacs-card__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" stroke="currentColor" stroke-width="2"/>
            <path d="M2 12h20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M12 2c3.5 3 3.5 17 0 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M12 2c-3.5 3-3.5 17 0 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="lilacs-card__body">
          <h3><?php echo esc_html( $portal_titulo ?: 'Portal de Revistas Científicas' ); ?></h3>

          <?php if ( ! empty($portal_desc) ) : ?>
            <div class="lilacs-wysiwyg"><?php echo wp_kses_post($portal_desc); ?></div>
          <?php else : ?>
            <p>Verifique as informações do seu periódico no Portal de Revistas em Ciências da Saúde.</p>
          <?php endif; ?>

          <?php if ( ! empty($portal_link) ) : ?>
            <a class="lilacs-btn"
               href="<?php echo esc_url($portal_link); ?>"
               target="_blank" rel="noopener">
              <?php echo esc_html( $portal_btn ?: 'Acessar portal' ); ?>
              <span class="lilacs-btn__arrow" aria-hidden="true">→</span>
            </a>
          <?php endif; ?>
        </div>
      </article>

      <!-- Card: Atualize (Featured) -->
      <article class="lilacs-card lilacs-card--featured">
        <div class="lilacs-card__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M12 20h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5Z"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>

        <div class="lilacs-card__body">
          <h3><?php echo esc_html( $atualize_titulo ?: 'Atualize os dados do seu periódico' ); ?></h3>

          <?php if ( ! empty($atualize_desc) ) : ?>
            <div class="lilacs-wysiwyg"><?php echo wp_kses_post($atualize_desc); ?></div>
          <?php else : ?>
            <p>Mantenha as informações corretas e atualizadas para melhor visibilidade e gestão.</p>
          <?php endif; ?>

          <?php if ( ! empty($atualize_link) ) : ?>
            <a class="lilacs-btn"
               href="<?php echo esc_url($atualize_link); ?>"
               target="_blank" rel="noopener">
              <?php echo esc_html( $atualize_btn ?: 'Atualizar agora' ); ?>
              <span class="lilacs-btn__arrow" aria-hidden="true">→</span>
            </a>
          <?php endif; ?>

          <?php if ( ! empty($atualize_titulo_2) || ! empty($atualize_desc_2) || ! empty($atualize_link_2) ) : ?>
            <div class="lilacs-note" role="note">
              <?php if ( ! empty($atualize_titulo_2) ) : ?>
                <strong><?php echo esc_html($atualize_titulo_2); ?></strong>
              <?php else : ?>
                <strong>Avaliação de permanência na coleção</strong>
              <?php endif; ?>

              <?php if ( ! empty($atualize_desc_2) ) : ?>
                <div class="lilacs-wysiwyg" style="margin-top:6px;"><?php echo wp_kses_post($atualize_desc_2); ?></div>
              <?php else : ?>
                <p style="margin:6px 0 0;     margin-bottom: 21px;">Acesse o Perfil de Periódicos LILACS quando o serviço estiver disponível.</p>
              <?php endif; ?>

              <?php if ( ! empty($atualize_link_2) ) : ?>
                <a class="lilacs-btn"
                   href="<?php echo esc_url($atualize_link_2); ?>"
                   target="_blank" rel="noopener">
                  <?php echo esc_html( $atualize_btn_2 ?: 'Acessar' ); ?>
                  <span class="lilacs-btn__arrow" aria-hidden="true">→</span>
                </a>
              <?php else : ?>
                <a class="lilacs-btn lilacs-btn--disabled"
                   href="<?php echo esc_url($perfil_link); ?>"
                   aria-disabled="true"
                   tabindex="-1"
                   title="Temporariamente indisponível">
                  Perfil de periódicos (indisponível)
                </a>
              <?php endif; ?>
            </div>
          <?php endif; ?>

        </div>
      </article>

    </div>
  </div>
</section>



