<?php
/*
Template Name: Eventos
Template Post Type: page
Description: Lista eventos via RSS em cards no padrão visual BVS
*/

if ( ! defined('ABSPATH') ) exit;

get_header();
the_post();

/**
 * ============================
 * Config
 * ============================
 */
$rss_url = 'https://red.teste.bvsalud.org/agenda/events-feed?q=&filter=';

// cache (evita bater no RSS a cada pageview)
$cache_key = 'bvs_eventos_rss_cache_v1_' . md5($rss_url);
$cache_ttl = 10 * MINUTE_IN_SECONDS;

/**
 * ============================
 * Helpers
 * ============================
 */
function bvs_ev_esc($v){ return esc_html((string)$v); }

function bvs_ev_parse_desc($desc_raw){
    $desc = trim(wp_strip_all_tags((string)$desc_raw));

    // esperado: "26/03/2026 - 26/03/2026. São Paulo - Brasil"
    $date_start = '';
    $date_end   = '';
    $place      = '';

    if ( preg_match('~^(\d{2}/\d{2}/\d{4})\s*-\s*(\d{2}/\d{2}/\d{4})\.\s*(.+)$~u', $desc, $m) ) {
        $date_start = $m[1];
        $date_end   = $m[2];
        $place      = trim($m[3]);
    } else {
        // fallback: tenta separar por ". "
        $parts = preg_split('~\.\s*~u', $desc, 2);
        if (!empty($parts[0])) {
            // tenta achar duas datas no primeiro bloco
            if ( preg_match('~(\d{2}/\d{2}/\d{4})\s*-\s*(\d{2}/\d{2}/\d{4})~', $parts[0], $m2) ) {
                $date_start = $m2[1];
                $date_end   = $m2[2];
            }
        }
        $place = !empty($parts[1]) ? trim($parts[1]) : '';
    }

    return array(
        'raw'        => $desc,
        'date_start' => $date_start,
        'date_end'   => $date_end,
        'place'      => $place,
    );
}

function bvs_ev_fetch_rss_items($rss_url, $cache_key, $cache_ttl){
    $cached = get_transient($cache_key);
    if ( is_array($cached) ) return $cached;

    // === CREDENCIAIS RSS (DEFINIDAS DIRETO NO TEMPLATE) ===
    $rss_user = 'admin-tst';
    $rss_pass = 'bireme123';

    $args = array(
        'timeout' => 12,
        'headers' => array(
            'Authorization' => 'Basic ' . base64_encode($rss_user . ':' . $rss_pass),
        ),
    );

    $res = wp_remote_get($rss_url, $args);

    if ( is_wp_error($res) ) {
        return array(
            'ok'    => false,
            'error' => $res->get_error_message(),
            'items' => array(),
        );
    }

    $code = (int) wp_remote_retrieve_response_code($res);
    $body = (string) wp_remote_retrieve_body($res);

    if ( $code !== 200 || empty($body) ) {
        return array(
            'ok'    => false,
            'error' => 'Falha ao carregar o RSS (HTTP ' . $code . ').',
            'items' => array(),
        );
    }

    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($body);

    if ( ! $xml ) {
        return array(
            'ok'    => false,
            'error' => 'O RSS retornou um XML inválido.',
            'items' => array(),
        );
    }

    $items = array();
    if ( isset($xml->channel->item) ) {
        foreach ( $xml->channel->item as $it ) {
            $items[] = array(
                'title' => (string) $it->title,
                'link'  => (string) $it->link,
                'desc'  => (string) $it->description,
                'guid'  => isset($it->guid) ? (string)$it->guid : '',
            );
        }
    }

    $payload = array(
        'ok'    => true,
        'error' => '',
        'items' => $items,
    );

    set_transient($cache_key, $payload, $cache_ttl);
    return $payload;
}


/**
 * ============================
 * Data
 * ============================
 */
$feed = bvs_ev_fetch_rss_items($rss_url, $cache_key, $cache_ttl);

/**
 * Banner / breadcrumb (padrão visual BVS)
 */
$page_title = get_the_title();
$home_label = 'Rede BVS';
$home_url   = home_url('/');
$events_label = 'eventos';
$events_url   = get_permalink(get_the_ID()); // a própria página "Eventos"
?>

<main id="conteudo-principal" class="bvs-eventos-page">

  <style>
    .bvs-eventos-page{ background:#fff; }

    /* Banner */
    .bvs-eventos-banner{
      background:#2A377E;
      padding: 34px 0 30px;
      margin: 0;
    }
    .bvs-eventos-banner-inner{
      max-width:1180px;
      margin:0 auto;
      padding:0 16px;
    }
    .bvs-eventos-breadcrumb{
      color: rgba(255,255,255,.88);
      font-size: 13px;
      margin: 0 0 10px;
    }
    .bvs-eventos-breadcrumb a{
      color: rgba(255,255,255,.95);
      text-decoration: none;
    }
    .bvs-eventos-breadcrumb a:hover{ text-decoration: underline; }

    .bvs-eventos-title{
      color:#fff;
      font-size: 34px;
      line-height: 1.15;
      margin:0;
      font-weight: 700;
      letter-spacing: -0.02em;
    }
    .bvs-eventos-sub{
      color: rgba(255,255,255,.92);
      margin-top: 10px;
      font-size: 16px;
      max-width: 860px;
    }

    /* Conteúdo */
    .bvs-eventos-wrap{
      max-width:1180px;
      margin: 0 auto;
      padding: 26px 16px 42px;
    }

    /* Grid de cards */
    .bvs-eventos-grid{
      display:grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 18px;
    }
    @media (max-width: 980px){
      .bvs-eventos-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 620px){
      .bvs-eventos-grid{ grid-template-columns: 1fr; }
      .bvs-eventos-title{ font-size: 28px; }
    }

    /* Card padrão BVS */
    .bvs-ev-card{
      background:#fff;
      border: 1px solid rgba(0,0,0,.08);
      border-radius: 14px;
      overflow:hidden;
      box-shadow: 0 10px 24px rgba(0,0,0,.06);
      transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
      display:flex;
      flex-direction:column;
      min-height: 180px;
    }
    .bvs-ev-card:hover{
      transform: translateY(-2px);
      box-shadow: 0 16px 34px rgba(0,0,0,.10);
      border-color: rgba(42,55,126,.35);
    }

    .bvs-ev-card-head{
      padding: 16px 16px 10px;
    }
    .bvs-ev-badges{
      display:flex;
      gap: 8px;
      flex-wrap: wrap;
      margin-bottom: 10px;
    }
    .bvs-ev-badge{
      display:inline-flex;
      align-items:center;
      gap: 8px;
      border-radius: 999px;
      padding: 6px 10px;
      font-size: 12px;
      line-height: 1;
      background: rgba(42,55,126,.10);
      color:#2A377E;
      font-weight: 600;
    }
    .bvs-ev-title{
      margin:0;
      font-size: 17px;
      line-height: 1.25;
      font-weight: 700;
      color:#0f172a;
    }

    .bvs-ev-card-body{
      padding: 0 16px 14px;
      color:#334155;
      font-size: 14px;
      line-height: 1.55;
      flex:1;
    }
    .bvs-ev-meta{
      display:flex;
      gap: 10px;
      flex-wrap: wrap;
      color:#475569;
      font-size: 13px;
      margin-top: 8px;
    }
    .bvs-ev-meta span{
      display:inline-flex;
      align-items:center;
      gap: 8px;
    }

    .bvs-ev-card-foot{
      padding: 12px 16px 16px;
      border-top: 1px solid rgba(0,0,0,.06);
      display:flex;
      justify-content:flex-end;
      align-items:center;
      gap: 10px;
    }
    .bvs-ev-btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap: 8px;
      padding: 10px 12px;
      border-radius: 10px;
      background:#2A377E;
      color:#fff !important;
      text-decoration:none !important;
      font-weight: 700;
      font-size: 13px;
      line-height: 1;
      transition: filter .15s ease, transform .15s ease;
    }
    .bvs-ev-btn:hover{
      filter: brightness(1.05);
      transform: translateY(-1px);
    }

    .bvs-ev-empty{
      background: #f8fafc;
      border: 1px dashed rgba(0,0,0,.18);
      border-radius: 14px;
      padding: 18px;
      color:#334155;
    }
    .bvs-ev-empty strong{ color:#0f172a; }
  </style>

  <section class="bvs-eventos-banner" aria-label="Banner Eventos">
    <div class="bvs-eventos-banner-inner">
      <div class="bvs-eventos-breadcrumb">
        <a href="<?php echo esc_url($home_url); ?>"><?php echo esc_html($home_label); ?></a>
        &nbsp;&gt;&nbsp;
        <a href="<?php echo esc_url($events_url); ?>"><?php echo esc_html($events_label); ?></a>
        &nbsp;&gt;&nbsp;
        <span><?php echo esc_html($page_title); ?></span>
      </div>

      <h1 class="bvs-eventos-title"><?php echo esc_html($page_title); ?></h1>
      <div class="bvs-eventos-sub">
        Próximos eventos da Rede BVS. Lista atualizada automaticamente a partir do feed oficial.
      </div>
    </div>
  </section>

  <section class="bvs-eventos-wrap" aria-label="Lista de eventos">
    <?php if ( ! empty($feed['ok']) && ! empty($feed['items']) ) : ?>

      <div class="bvs-eventos-grid">
        <?php foreach ( $feed['items'] as $it ) :
          $parsed = bvs_ev_parse_desc($it['desc']);
          $title  = $it['title'];
          $link   = $it['link'];
          $date_start = $parsed['date_start'];
          $date_end   = $parsed['date_end'];
          $place      = $parsed['place'];

          $date_label = '';
          if ( $date_start && $date_end ) {
            $date_label = ($date_start === $date_end) ? $date_start : ($date_start . ' – ' . $date_end);
          } else {
            $date_label = $parsed['raw'];
          }
        ?>
          <article class="bvs-ev-card">
            <div class="bvs-ev-card-head">
              <div class="bvs-ev-badges">
                <?php if ( $date_label ) : ?>
                  <span class="bvs-ev-badge"><?php echo bvs_ev_esc($date_label); ?></span>
                <?php endif; ?>
                <?php if ( $place ) : ?>
                  <span class="bvs-ev-badge"><?php echo bvs_ev_esc($place); ?></span>
                <?php endif; ?>
              </div>

              <h2 class="bvs-ev-title"><?php echo bvs_ev_esc($title); ?></h2>
            </div>

            <div class="bvs-ev-card-body">
              <?php if ( $parsed['raw'] ) : ?>
                <div class="bvs-ev-meta">
                  <?php if ( $date_label ) : ?>
                    <span>📅 <?php echo bvs_ev_esc($date_label); ?></span>
                  <?php endif; ?>
                  <?php if ( $place ) : ?>
                    <span>📍 <?php echo bvs_ev_esc($place); ?></span>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>

            <div class="bvs-ev-card-foot">
              <?php if ( $link ) : ?>
                <a class="bvs-ev-btn" href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer">
                  Ver detalhes →
                </a>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

    <?php else : ?>
      <div class="bvs-ev-empty">
        <strong>Não foi possível carregar os eventos.</strong><br>
        <?php echo ! empty($feed['error']) ? esc_html($feed['error']) : 'O feed não retornou itens.'; ?>
        <br><br>
        <small>Feed: <?php echo esc_html($rss_url); ?></small>
      </div>
    <?php endif; ?>
  </section>

</main>

<?php get_footer(); ?>
