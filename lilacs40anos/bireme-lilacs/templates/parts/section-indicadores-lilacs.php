<?php
global $post;

/** Helpers */
if (!function_exists('bvs_slug')){
  function bvs_slug($s){
    $s = remove_accents( wp_strip_all_tags( (string)$s ) );
    $s = strtolower( preg_replace('/[^a-z0-9]+/','-', $s) );
    return trim($s,'-') ?: 'item';
  }
}

/** Dados */
$groups = get_post_meta($post->ID, 'lilacs_indicator_groups', true);
$groups = is_array($groups) ? $groups : [];

/** Pré-calcula IDs estáveis para categorias e tópicos */
foreach ($groups as $gi => $g){
  $g_title = $g['category'] ?? ('Categoria '.($gi+1));
  $groups[$gi]['_id'] = 'grp-'.bvs_slug($g_title ?: ('g'.$gi)).'-'.$gi;
  $topics = isset($g['topics']) && is_array($g['topics']) ? $g['topics'] : [];
  foreach ($topics as $ti => $t){
    $t_title = $t['title'] ?? ('Tópico '.($ti+1));
    $groups[$gi]['topics'][$ti]['_id'] = 'top-'.bvs_slug($t_title ?: ('t'.$ti)).'-'.$gi.'-'.$ti;
  }
}
?>
<section id="bvs-page" aria-label="Indicadores – BVS">
  <style>
    :root{
      --bg:#fff; --panel:#fff; --text:#0b2144; --muted:#6b7a90; --line:#e6ebf2;
      --accent:#163b72; --accent-2:#0a6ad8; --chip:#eef3fb; --focus:#0a6ad8;
    }
    #bvs-page{background:var(--bg); padding:18px 12px 32px;}
    #bvs-page *{box-sizing:border-box; font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;}

    .bvs-wrap{max-width:1360px; margin:0 auto; display:grid; grid-template-columns:320px 1fr; gap:22px;}
    /* Mobile: stack sidebar above content (sidebar first) */
    @media (max-width:980px){
      .bvs-wrap{
        display:flex;
        flex-direction:column;
        gap:12px;
      }
      .bvs-side{
        order: -1; /* ensure sidebar is rendered above content */
        width:100%;
        max-width:100%;
        border-right: none;
        border-bottom: 1px solid var(--line);
        padding:12px;
        border-radius:8px;
      }
      .bvs-main{
        order: 0;
        width:100%;
      }
      .bvs-wrap.is-collapsed{ /* don't collapse into narrow side on mobile */
        grid-template-columns: 1fr;
      }
      .side-toggle{ right: 10px; top: 8px; }
    }

    /* Sidebar */
    .bvs-side{background: var(--panel);
    padding: 16px;
    border-right: 1px solid #00205c1a;
    border-radius: 0;}
    .bvs-search{position:relative; margin-bottom:10px;}
    .bvs-search input{
        background: #F1F1F1 !important;
    width: 100%;
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 10px 36px 10px 12px;
    outline: none;
    }
    .bvs-search .ico{position:absolute; right:10px; top:50%; transform:translateY(-50%); display:flex; align-items:center}
    .bvs-search .ico img{width:18px; height:18px; display:block; opacity:.9}
#lilacs-cp-banner .cp-title{max-width:250px;}
    .acc{border-top:1px solid var(--line);}
    .acc-item{border-bottom:1px solid var(--line)}
    .acc-hd{    display: flex
;
    align-items: center;
    justify-content: space-between;
    padding: 12px 6px;
    cursor: pointer;
    gap: 10px;
    background: #fff;
    border: none;}
    .acc-hd h4{    margin: 0;
    color: var(--text);
    font-family: 'Noto Sans' !important;
    font-size: 18px;
    text-align: left;
    line-height: 100%;
    font-weight: 700;}
    .acc-hd .caret{transition:transform .2s ease}
    .acc-hd[aria-expanded="true"] .caret{transform:rotate(90deg)}
    .acc-panel{display:none; padding:6px 0 12px}
    .acc-panel.is-open{display:block;}

    .topic-list{max-height:58vh; overflow:auto; padding-right:4px; padding-left:15px;}
    .row-topic{display:flex; align-items:center; justify-content:space-between; padding:8px 8px; border-radius:10px; cursor:pointer}
    .row-topic:hover{background:#E2E2E2;}
    .row-topic.is-active{background:#E2E2E2;}
    .row-topic .name{font-weight:400; font-size:16px; font-family:'Noto Sans'; color:#00205C;}
    .row-topic .badge{font-size:12px; color:#64748b}

    .chip-all{display:none; align-items:center; gap:8px; background:var(--chip); border:1px solid var(--line); padding:6px 10px; border-radius:999px; margin:6px 8px; cursor:pointer}
    .chip-all.is-active{outline:2px solid var(--focus)}

    /* Main */
    .bvs-main{background:var(--panel); border-radius:14px; padding:16px; box-shadow:0 1px 2px rgba(10,20,40,.05)}
    .indicator-empty{padding:24px;color:var(--muted);text-align:center}

    .topic-wrap{display:none}        /* área de uma categoria */
    .topic-wrap.is-visible{display:block}
    .topic-block{padding:18px 12px; border-radius:10px; background:#fff; margin-bottom:14px; border:none;}
    .topic-title{font-weight:800; color:var(--accent); margin-bottom:8px; font-size:18px}
    .topic-content{color:var(--text)}


      .bvs-wrap{max-width:1360px;margin:0 auto;display:grid;grid-template-columns:320px 1fr;gap:22px;transition:grid-template-columns .2s ease}
  .bvs-wrap.is-collapsed{grid-template-columns:48px 1fr}

  .bvs-side{position:relative}
  .side-toggle{
    position: absolute;
    top: 10px;
    right: -41px;
    width: 41px;
    height: 41px;
    border: 1px solid var(--line);
    border-radius: 8px;
    background: #fff;
    cursor: pointer;
    display: flex
;
    align-items: center;
    justify-content: center;
    box-shadow: 0 1px 2px rgba(10, 20, 40, .05);
    background: #F1F1F1;
  }
  .side-toggle img{width:18px; height:18px; display:block}
/* add: smooth transform and mirror icon when collapsed */
  .side-toggle img{transition:transform .2s ease; transform-origin:center;}
  .bvs-wrap.is-collapsed .side-toggle img{transform:scaleX(-1);}
  .bvs-wrap.is-collapsed .bvs-side .hide-on-collapse{display:none}
  .bvs-wrap.is-collapsed .bvs-side{padding:12px}
  .bvs-wrap.is-collapsed .side-toggle{right:10px}
  </style>

  <div class="bvs-wrap">
    <aside class="bvs-side" id="bvs-side">


      <button class="side-toggle" id="bvs-collapse" type="button" title="Encolher/expandir">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/toogle.png' ); ?>" alt="Toggle">
      </button>

  <div class="hide-on-collapse">


      <div class="bvs-search">
        <input id="bvs-q" type="search" placeholder="Pesquise em indicadores" aria-label="Pesquisar indicadores">
        <span class="ico" aria-hidden="true">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Vector.png' ); ?>" alt="">
        </span>
      </div>

      <?php if(empty($groups)): ?>
        <p class="indicator-empty">Nenhuma categoria/tópico cadastrado.</p>
      <?php else: ?>
        <nav class="acc" id="bvs-acc" aria-label="Categorias de indicadores">
          <?php foreach($groups as $gi => $g):
            $gid = $g['_id'];
            $gtitle = $g['category'] ?? ('Categoria '.($gi+1));
            $topics = isset($g['topics']) && is_array($g['topics']) ? $g['topics'] : [];
          ?>
          <section class="acc-item" data-group="<?php echo esc_attr($gid); ?>">
            <button class="acc-hd" type="button" aria-expanded="false" aria-controls="panel-<?php echo esc_attr($gid); ?>">
              <h4><?php echo esc_html($gtitle); ?></h4>
              <span class="caret" aria-hidden="true">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/chevron.png' ); ?>" alt="">
              </span>
            </button>
            <div id="panel-<?php echo esc_attr($gid); ?>" class="acc-panel" role="region" aria-label="<?php echo esc_attr($gtitle); ?>">
              <button class="chip-all" type="button" data-all-of="<?php echo esc_attr($gid); ?>">
                <strong>Todos os tópicos</strong><span class="badge">(<?php echo count($topics); ?>)</span>
              </button>
              <div class="topic-list">
                <?php foreach($topics as $ti => $t):
                  $tid   = $t['_id'];
                  $ttitle= $t['title'] ?? ('Tópico '.($ti+1));
                ?>
                <div class="row-topic" role="button" tabindex="0"
                     data-goto="<?php echo esc_attr($gid.'::'.$tid); ?>">
                  <span class="name"><?php echo esc_html($ttitle); ?></span>
                  <span class="badge"><?php echo ($ti+1); ?></span>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          </section>
          <?php endforeach; ?>
        </nav>
      <?php endif; ?>
    </aside>

    <main class="bvs-main" id="bvs-main">
      <?php if(empty($groups)): ?>
        <div class="indicator-empty">Cadastre categorias e tópicos no painel administrativo.</div>
      <?php else: ?>
        <?php foreach($groups as $gi => $g):
          $gid = $g['_id']; $gtitle = $g['category'] ?? ('Categoria '.($gi+1));
          $topics = isset($g['topics']) && is_array($g['topics']) ? $g['topics'] : [];
        ?>
          <div class="topic-wrap" id="wrap-<?php echo esc_attr($gid); ?>" data-wrap="<?php echo esc_attr($gid); ?>">
            <?php foreach($topics as $ti => $t):
              $tid = $t['_id']; $ttitle = $t['title'] ?? ('Tópico '.($ti+1)); $tcontent = $t['content'] ?? '';
            ?>
            <article class="topic-block" id="<?php echo esc_attr($tid); ?>" data-topic-of="<?php echo esc_attr($gid); ?>">
  <h5 class="topic-title"><?php echo esc_html($ttitle); ?></h5>
  <div class="topic-content"><?php echo apply_filters('the_content', $tcontent); ?></div>
</article>

            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </main>
  </div>

<script>
(function(){
  const wrap = document.querySelector('.bvs-wrap');
  const toggle = document.getElementById('bvs-collapse');
  const key = 'bvsSideCollapsed';

  function setCollapsed(on){
    wrap.classList.toggle('is-collapsed', !!on);
    localStorage.setItem(key, on ? '1' : '0');
  }

  // estado inicial
  if(localStorage.getItem(key) === '1') setCollapsed(true);

  toggle?.addEventListener('click', ()=> setCollapsed(!wrap.classList.contains('is-collapsed')));
})();
</script>

<script>
(function(){
  const $acc = document.getElementById('bvs-acc');
  const $q   = document.getElementById('bvs-q');
  const side = document.getElementById('bvs-side');
  const allWraps = Array.from(document.querySelectorAll('.topic-wrap'));

  if(!$acc) return;

  /** Abre/fecha acordeões */
  $acc.addEventListener('click', (e)=>{
    const hd = e.target.closest('.acc-hd');
    if(!hd) return;
    const item = hd.parentElement;
    const panel = item.querySelector('.acc-panel');
    const expanded = hd.getAttribute('aria-expanded') === 'true';
    hd.setAttribute('aria-expanded', String(!expanded));
    panel.classList.toggle('is-open', !expanded);
  });

  /** “Todos os tópicos” por categoria */
  $acc.addEventListener('click', (e)=>{
    const btn = e.target.closest('[data-all-of]');
    if(!btn) return;
    const gid = btn.getAttribute('data-all-of');
    showCategory(gid); // mostra todos os artigos dessa categoria
    // marca visual
    side.querySelectorAll('.chip-all').forEach(b=>b.classList.remove('is-active'));
    side.querySelectorAll('.row-topic').forEach(r=>r.classList.remove('is-active'));
    btn.classList.add('is-active');
  });

  /** Clicar num tópico específico */
  $acc.addEventListener('click', (e)=>{
    const row = e.target.closest('.row-topic');
    if(!row) return;
    const ref = row.getAttribute('data-goto'); // "gid::tid"
    const [gid, tid] = ref.split('::');
    showCategory(gid, tid); // mostra apenas esse tópico
    // marca visual
    side.querySelectorAll('.chip-all').forEach(b=>b.classList.remove('is-active'));
    side.querySelectorAll('.row-topic').forEach(r=>r.classList.remove('is-active'));
    row.classList.add('is-active');
  });
  $acc.addEventListener('keydown', (e)=>{
    if((e.key==='Enter'||e.key===' ') && e.target.classList.contains('row-topic')){
      e.preventDefault(); e.target.click();
    }
  });

  /** Busca: filtra categorias e tópicos pelo texto */
  $q.addEventListener('input', (e)=>{
    const term = e.target.value.trim().toLowerCase();
    const items = $acc.querySelectorAll('.acc-item');
    items.forEach(it=>{
      let anyVisible = false;
      const panel = it.querySelector('.acc-panel');
      const rows = it.querySelectorAll('.row-topic');
      rows.forEach(r=>{
        const name = r.querySelector('.name')?.textContent?.toLowerCase() || '';
        const show = !term || name.includes(term);
        r.style.display = show ? '' : 'none';
        anyVisible = anyVisible || show;
      });
      // mostra/esconde categoria conforme resultado
      it.style.display = anyVisible ? '' : 'none';
      if(anyVisible && term){ // se filtrou, já abre
        it.querySelector('.acc-hd').setAttribute('aria-expanded','true');
        panel.classList.add('is-open');
      }
    });
  });

  function showCategory(gid, tid=null){
    // mostra apenas a wrap da categoria
    allWraps.forEach(w=>w.classList.toggle('is-visible', w.getAttribute('data-wrap')===gid));
    const wrap = document.getElementById('wrap-'+gid);
    if(!wrap) return;

    // se veio um tópico específico, esconde os outros via CSS inline
    const blocks = Array.from(wrap.querySelectorAll('.topic-block'));
    if(tid){
      blocks.forEach(b=> b.style.display = (b.id===tid) ? '' : 'none');
      document.getElementById(tid)?.scrollIntoView({behavior:'smooth', block:'start'});
    }else{
      blocks.forEach(b=> b.style.display = '');
      wrap.scrollIntoView({behavior:'smooth', block:'start'});
    }
  }

  /* Estado inicial: abre 1ª categoria e 1º tópico */
  const firstItem = $acc.querySelector('.acc-item');
  if(firstItem){
    const hd = firstItem.querySelector('.acc-hd');
    const panel = firstItem.querySelector('.acc-panel');
    hd.setAttribute('aria-expanded','true');
    panel.classList.add('is-open');

    const gid = firstItem.getAttribute('data-group');
    const firstTopicRow = panel.querySelector('.row-topic');
    if(firstTopicRow){
      firstTopicRow.classList.add('is-active');
      const ref = firstTopicRow.getAttribute('data-goto').split('::');
      showCategory(ref[0], ref[1]);
    }else{
      const allBtn = panel.querySelector('[data-all-of]');
      if(allBtn){ allBtn.classList.add('is-active'); showCategory(gid); }
    }
  }
})();
</script>
</section>