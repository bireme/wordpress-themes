<?php
/**
 * LÓGICA DE DADOS (MANUAL OU RSS + DEBUG)
 */

// 1) URL DO RSS
$rss_url = 'https://pesquisa.bvsalud.org/portal/?output=rss&lang=pt&from=0&sort=YEAR_DESC&format=summary&count=20&fb=&page=1&tab=&range_year_start=&range_year_end=&skfp=&index=&q=%28instance%3A%22regional%22%29+AND+%28+db%3A%28%22LILACS%22%29%29';

// 2) Limite de itens
$rss_limit = (int) get_post_meta(get_the_ID(), '_bireme_rc_rss_limit', true);
if ( $rss_limit <= 0 ) $rss_limit = 6;

// 3) MODO (manual|rss) -> padrão: manual
//    Defina esse meta no post/página pra controlar:
//    _bireme_rc_mode = manual  (ou)  rss
$mode = (string) get_post_meta(get_the_ID(), '_bireme_rc_mode', true);
$mode = $mode ? strtolower(trim($mode)) : 'manual';
if ( ! in_array($mode, ['manual','rss'], true) ) $mode = 'manual';

$debug_msg = '';
$rc = null;

// ==============================================================================
// A) PRIMEIRO: CARREGA O MANUAL (SEMPRE) — pra respeitar o modo manual
// ==============================================================================
$rc_manual = function_exists('bireme_get_lilacs_recent_meta') ? bireme_get_lilacs_recent_meta(get_the_ID()) : null;

// Se estiver em modo manual, já usa o manual e NÃO busca RSS
if ( $mode === 'manual' ) {
  $rc = $rc_manual;
}

// ==============================================================================
// B) SÓ SE MODO RSS: tenta buscar RSS e, se falhar, cai no manual
// ==============================================================================
function bireme_fake_browser_request( $args ) {
    $args['user-agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';
    $args['headers']['Accept']          = 'application/rss+xml, application/xml, text/xml, text/html, */*;q=0.1';
    $args['headers']['Accept-Language'] = 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
    $args['timeout']   = 25;
    $args['sslverify'] = false;
    return $args;
}

if ( $mode === 'rss' && ! empty($rss_url) ) {

    if ( ! function_exists('fetch_feed') ) {
        include_once( ABSPATH . WPINC . '/feed.php' );
    }

    add_filter('wp_feed_cache_transient_lifetime', 'bireme_force_feed_refresh_zero');
    function bireme_force_feed_refresh_zero($seconds){ return 0; }

    add_filter('http_request_args', 'bireme_fake_browser_request');

    $feed = fetch_feed($rss_url);

    remove_filter('wp_feed_cache_transient_lifetime', 'bireme_force_feed_refresh_zero');
    remove_filter('http_request_args', 'bireme_fake_browser_request');

    if ( ! is_wp_error($feed) ) {

        $maxitems  = $feed->get_item_quantity($rss_limit);
        $rss_items = $feed->get_items(0, $maxitems);

        $items_formatted = [];

        foreach ( $rss_items as $item ) {
            $title = (string) $item->get_title();
            $url   = (string) $item->get_permalink();

            $desc_raw = (string) $item->get_description();
            if ( empty($desc_raw) ) $desc_raw = (string) $item->get_content();

            $desc_raw = preg_replace('/<hr\s*\/?>/i', ' ', $desc_raw);
            $desc_txt = wp_strip_all_tags($desc_raw, true);
            $desc_txt = trim(preg_replace('/\s+/', ' ', $desc_txt));
            $desc_txt = wp_trim_words($desc_txt, 34, '…');

            if (trim($title) === '') continue;

            $items_formatted[] = [
                'title' => $title,
                'url'   => $url,
                'desc'  => $desc_txt,
            ];
        }

        if ( ! empty($items_formatted) ) {
            // usa título/sub do manual se existirem, mas itens do RSS
            $rc = [
                'title'    => !empty($rc_manual['title']) ? $rc_manual['title'] : 'Publicações recentes em saúde',
                'subtitle' => !empty($rc_manual['subtitle']) ? $rc_manual['subtitle'] : '',
                'items'    => $items_formatted,
            ];
        } else {
            // RSS veio vazio -> fallback manual
            $rc = $rc_manual;
        }

    } else {
        $debug_msg = $feed->get_error_message();
        $rc = $rc_manual; // fallback manual quando RSS falha
    }
}

// ==============================================================================
// EXIBIÇÃO
// ==============================================================================
if ($rc && !empty($rc['items'])) :
?>

<?php if ( ! empty($debug_msg) ) : ?>
  <div style="background:#ffebee; border:2px solid #c62828; color:#c62828; padding:15px; margin:20px auto; max-width:1280px; text-align:center; font-weight:bold; z-index:9999;">
    ATENÇÃO - ERRO AO BUSCAR RSS: <?php echo esc_html($debug_msg); ?>
  </div>
<?php endif; ?>

<section id="lilacs-recent" aria-label="Publicações recentes em saúde">
  <style>
  <?php echo <<<'CSS'
  #lilacs-recent{
    --container: 1280px;
    --gutter: 20px;
    --pad-left: max(var(--gutter), calc((100% - var(--container)) / 2));
    background: #085695;
    padding: 28px 0;
    min-height: 420px;
    display: flex;
    align-content: center;
    align-items: center;
    overflow-x: hidden;
  }
  #lilacs-recent .rc-wrap{
    display:flex;
    align-items:flex-start;
    gap:18px;
    padding-left: var(--pad-left);
    overflow: hidden;
    min-width: 0;
  }
  #lilacs-recent .rc-left{width:584px;color:#fff;}
  #lilacs-recent .rc-title{
    font-size: 36px;font-family: 'Noto Sans';font-weight: 700;line-height: 100%;
    margin: 0 0 12px;
  }
  #lilacs-recent .rc-sub{
    font-family: 'Noto Sans';font-size: 18px;font-weight: 400;line-height: 150%;
    margin: 0 0 14px;
  }
  #lilacs-recent .rc-nav{
    display: flex;gap: 8px;justify-content: flex-end;padding-right: 30px;
  }
  #lilacs-recent .rc-btn{
    width:28px;height:28px;border-radius:999px;border:none;
    display:flex;align-items:center;justify-content:center;cursor:pointer;
    background:#00205C;color:#fff;
  }
  #lilacs-recent .rc-btn:hover{filter:brightness(1.08)}
  #lilacs-recent .rc-btn[disabled]{opacity:.45;cursor:not-allowed}
  #lilacs-recent .rc-btn svg{width:14px;height:14px}

  #lilacs-recent .rc-viewport{flex:1 1 auto;overflow-x:hidden;min-width:0;}
  #lilacs-recent .rc-track{display:flex;gap:14px;will-change:transform;transition:transform .45s ease;min-width:0;}

  #lilacs-recent .rc-card{
    flex: 0 0 clamp(240px, 30vw, 360px);
    background: #00205C;color:#fff;border-radius: 12px;padding: 16px;min-height: 253px;
    position: relative;box-shadow: 0 10px 24px rgba(3, 10, 24, .25);
  }
  #lilacs-recent .rc-card a{color:inherit;text-decoration:none;display:block;height:100%}
  #lilacs-recent .rc-card h4{
    margin:0;font-family:'Noto Sans';font-weight:400;font-size:20px;line-height:150%;
    padding:20px 20px 10px;
  }
  #lilacs-recent .rc-desc{
    margin:0;padding:0 20px 34px;font-family:'Noto Sans';font-size:14px;line-height:150%;
    color:rgba(255,255,255,.86);
    display:-webkit-box;-webkit-line-clamp:5;-webkit-box-orient:vertical;overflow:hidden;
  }
  #lilacs-recent .rc-go{
    position:absolute;right:10px;bottom:10px;width:26px;height:26px;border-radius:999px;
    background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;
  }
  #lilacs-recent .rc-go svg{width:14px;height:14px;color:#fff}

  @media (max-width: 920px){
    #lilacs-recent .rc-wrap{flex-direction:column; gap:14px}
    #lilacs-recent .rc-left{width:auto; padding-right:var(--gutter)}
    #lilacs-recent .rc-nav{justify-content:flex-start; padding-right:0}
  }
  CSS; ?>
  </style>

  <div class="rc-wrap">
    <div class="rc-left">
      <h2 class="rc-title"><?php echo esc_html($rc['title'] ?: 'Publicações recentes em saúde'); ?></h2>
      <?php if(!empty($rc['subtitle'])): ?>
        <p class="rc-sub"><?php echo esc_html($rc['subtitle']); ?></p>
      <?php endif; ?>
      <div class="rc-nav">
        <button class="rc-btn" id="rc-prev" aria-label="Anterior">
          <svg viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <button class="rc-btn" id="rc-next" aria-label="Próximo">
          <svg viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>
    </div>

    <div class="rc-viewport">
      <div class="rc-track" id="rc-track">
        <?php foreach($rc['items'] as $item):
          $t = trim($item['title'] ?? '');
          $u = esc_url($item['url'] ?? '#');
          $d = trim($item['desc'] ?? '');
          if($t==='') continue; ?>
          <article class="rc-card">
            <a href="<?php echo $u; ?>" target="_blank" rel="noopener">
              <h4><?php echo esc_html($t); ?></h4>
              <?php if($d !== ''): ?>
                <p class="rc-desc"><?php echo esc_html($d); ?></p>
              <?php endif; ?>
              <span class="rc-go" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </span>
            </a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <script>
  (function(){
    const track = document.getElementById('rc-track');
    const prev  = document.getElementById('rc-prev');
    const next  = document.getElementById('rc-next');
    if(!track) return;

    function gap(){ return 14; }
    function cardWidth(){
      const card = track.querySelector('.rc-card');
      return card ? (card.getBoundingClientRect().width + gap()) : 320;
    }
    function viewWidth(){ return track.parentElement.getBoundingClientRect().width; }

    let offset = 0;
    function clamp(v,min,max){ return Math.max(min, Math.min(max,v)); }
    function maxOffset(){
      const children = Array.from(track.children);
      if(children.length === 0) return 0;
      const tw = children.reduce((acc,el)=> acc + el.getBoundingClientRect().width, 0) + (children.length-1)*gap();
      return Math.max(0, tw - viewWidth());
    }
    function apply(){
      offset = clamp(offset, 0, maxOffset());
      track.style.transform = 'translateX(' + (-offset) + 'px)';
      if(prev) prev.disabled = (offset <= 0);
      if(next) next.disabled = (offset >= maxOffset() - 1);
    }
    function slide(dir){
      const perView = Math.max(1, Math.floor(viewWidth() / cardWidth()));
      const step   = perView * cardWidth();
      offset = clamp(offset + (dir * step), 0, maxOffset());
      apply();
    }

    if(prev) prev.addEventListener('click', ()=> slide(-1));
    if(next) next.addEventListener('click', ()=> slide(1));
    window.addEventListener('resize', apply);
    apply();
  })();
  </script>
</section>

<?php endif; ?>
