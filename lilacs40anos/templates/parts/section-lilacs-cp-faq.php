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

/** Configurações dos campos de administração */
$selected_categories = get_post_meta(get_the_ID(), '_lilacs_cp_faq_selected_categories', true);
$display_order = get_post_meta(get_the_ID(), '_lilacs_cp_faq_display_order', true) ?: 'name_asc';
$show_empty_categories = get_post_meta(get_the_ID(), '_lilacs_cp_faq_show_empty_categories', true);

/** Terms (categorias de FAQ) */
$terms_args = [
  'taxonomy'   => 'ufaq-category',
  'hide_empty' => !$show_empty_categories,
];

// Se categorias específicas foram selecionadas, filtrar apenas essas
if (!empty($selected_categories) && is_array($selected_categories)) {
  $terms_args['include'] = $selected_categories;
}

// Definir ordenação baseada na configuração
switch ($display_order) {
  case 'name_desc':
    $terms_args['orderby'] = 'name';
    $terms_args['order'] = 'DESC';
    break;
  case 'id_asc':
    $terms_args['orderby'] = 'term_id';
    $terms_args['order'] = 'ASC';
    break;
  case 'id_desc':
    $terms_args['orderby'] = 'term_id';
    $terms_args['order'] = 'DESC';
    break;
  case 'count_desc':
    $terms_args['orderby'] = 'count';
    $terms_args['order'] = 'DESC';
    break;
  case 'count_asc':
    $terms_args['orderby'] = 'count';
    $terms_args['order'] = 'ASC';
    break;
  default: // name_asc
    $terms_args['orderby'] = 'name';
    $terms_args['order'] = 'ASC';
}

$terms = get_terms($terms_args);
$terms = is_array($terms) ? $terms : [];

/** Pré-calcula IDs estáveis para categorias e posts */
foreach ($terms as $ti => $term){
  $t_title = $term->name ?? ('Categoria '.($ti+1));
  $terms[$ti]->_id = 'grp-'.bvs_slug($t_title).'-'.$ti;

  // garante array de posts mesmo se não houver nenhum
  $terms[$ti]->_posts = [];

  // pega posts da taxonomia (apenas publicados)
  $args = [
    'post_type'      => 'ufaq',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'tax_query'      => [[
      'taxonomy' => 'ufaq-category',
      'field'    => 'term_id',
      'terms'    => $term->term_id,
    ]],
    'orderby' => 'title',
    'order'   => 'ASC',
  ];
  $posts = get_posts($args);
  $posts = is_array($posts) ? $posts : [];
  foreach($posts as $pi => $p){
    $terms[$ti]->_posts[$pi] = (object)[
      '_id'     => 'top-'.bvs_slug($p->post_title).'-'.$ti.'-'.$pi,
      'title'   => $p->post_title,
      'content' => $p->post_content,
      'ID'      => $p->ID,
    ];
  }
}
?>
<section id="faq-page" aria-label="FAQ – Devemos">
  <style>
    /* reutiliza estilos simples do exemplo; ajuste conforme tema */
    #faq-page{padding:18px 12px 32px;background:#fff}
    .faq-wrap{max-width:1360px;margin:0 auto;display:grid;grid-template-columns:320px 1fr;gap:22px;transition:grid-template-columns .2s ease}
    @media (max-width:980px){ .faq-wrap{grid-template-columns:1fr} }
    .faq-wrap.is-collapsed{grid-template-columns:48px 1fr}

    .faq-side{background:#fff;padding:16px;border-right:1px solid #e6ebf2;position:relative}
    .faq-search input{width:100%;padding:10px;border-radius:12px;border:1px solid #e6ebf2}
    .acc{border-top:1px solid #e6ebf2}
    .acc-item{border-bottom:1px solid #e6ebf2}
    .acc-hd{display:flex;align-items:center;justify-content:space-between;padding:12px;cursor:pointer;background:#fff;border:none}
    .acc-hd h4{    margin: 0;
    color: var(--text);
    font-family: 'Noto Sans' !important;
    font-size: 18px;
    text-align: left;
    line-height: 100%;
    font-weight: 700;}
    .acc-hd .caret img{width:18px;height:18px;display:block;opacity:.9;transition:transform .2s ease;transform-origin:center}
    .acc-hd[aria-expanded="true"] .caret img{transform:rotate(90deg)}
    .acc-panel{display:none;padding:6px 0 12px}
    .acc-panel.is-open{display:block}
    .chip-all{display:flex;align-items:center;gap:8px;background:#eef3fb;padding:6px 10px;border-radius:999px;margin:6px 8px;cursor:pointer}
    .topic-list{padding-left:12px;max-height:58vh;overflow:auto}
    .row-topic{display:flex;align-items:center;justify-content:space-between;padding:8px;border-radius:8px;cursor:pointer}
    .row-topic:hover{background:#f1f5f9}
    .row-topic.is-active{background:#f1f5f9}
    .faq-main{background:#fff;border-radius:12px;padding:16px}
    .topic-wrap{display:none}
    .topic-wrap.is-visible{display:block}
    .topic-block{padding:18px;border-radius:10px;background:#fff;margin-bottom:14px}
    .topic-title{font-weight:700;color:#0a6ad8;margin-bottom:8px}

    .side-toggle{
      position: absolute;
      top: 10px;
      right: -41px;
      width: 41px;
      height: 41px;
      border: 1px solid #e6ebf2;
      border-radius: 8px;
      background: #F1F1F1;
      cursor: pointer;
      display:flex;align-items:center;justify-content:center;
      box-shadow: 0 1px 2px rgba(10, 20, 40, .05);
    }
    .side-toggle img{width:18px;height:18px;display:block;transition:transform .2s ease;transform-origin:center}
    .faq-wrap.is-collapsed .side-toggle img{transform:scaleX(-1)}
    .faq-wrap.is-collapsed .faq-side .hide-on-collapse{display:none}
    .faq-wrap.is-collapsed .faq-side{padding:12px}
    .faq-wrap.is-collapsed .side-toggle{right:10px}
  </style>

  <div class="faq-wrap">
    <aside class="faq-side" id="faq-side">

      <button class="side-toggle" id="faq-collapse" type="button" title="Encolher/expandir">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/toogle.png' ); ?>" alt="Toggle">
      </button>

      <div class="hide-on-collapse">
        <div class="faq-search">
          <input id="faq-q" type="search" placeholder="Pesquise no FAQ" aria-label="Pesquisar FAQ">
        </div>

        <?php if(empty($terms)): ?>
          <p class="indicator-empty">Nenhuma categoria de FAQ encontrada.</p>
        <?php else: ?>
          <nav class="acc" id="faq-acc" aria-label="Categorias de FAQ">
            <?php foreach($terms as $gi => $g):
              $gid = $g->_id;
              $gtitle = $g->name ?? ('Categoria '.($gi+1));
              $posts = isset($g->_posts) ? $g->_posts : [];
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
                  <strong>Todas as perguntas</strong><span class="badge">(<?php echo count($posts); ?>)</span>
                </button>
                <div class="topic-list">
                  <?php foreach($posts as $pi => $p): ?>
                    <div class="row-topic" role="button" tabindex="0" data-goto="<?php echo esc_attr($gid.'::'.$p->_id); ?>">
                      <span class="name"><?php echo esc_html($p->title); ?></span>
                      <span class="badge"><?php echo ($pi+1); ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </section>
            <?php endforeach; ?>
          </nav>
        <?php endif; ?>
      </div>
    </aside>

    <main class="faq-main" id="faq-main">
      <?php if(empty($terms)): ?>
        <div class="indicator-empty">Cadastre categorias e perguntas no painel administrativo.</div>
      <?php else: ?>
        <?php foreach($terms as $gi => $g):
          $gid = $g->_id; $gtitle = $g->name ?? ('Categoria '.($gi+1));
          $posts = isset($g->_posts) ? $g->_posts : [];
        ?>
          <div class="topic-wrap" id="wrap-<?php echo esc_attr($gid); ?>" data-wrap="<?php echo esc_attr($gid); ?>">
            <?php foreach($posts as $pi => $p): ?>
              <article class="topic-block" id="<?php echo esc_attr($p->_id); ?>" data-topic-of="<?php echo esc_attr($gid); ?>">
                <h5 class="topic-title"><?php echo esc_html($p->title); ?></h5>
                <div class="topic-content"><?php echo apply_filters('the_content', $p->content); ?></div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </main>
  </div>

<script>
(function(){
  const wrap = document.querySelector('.faq-wrap');
  const toggle = document.getElementById('faq-collapse');
  const key = 'faqSideCollapsed';

  function setCollapsed(on){
    wrap.classList.toggle('is-collapsed', !!on);
    localStorage.setItem(key, on ? '1' : '0');
  }

  if(localStorage.getItem(key) === '1') setCollapsed(true);
  toggle?.addEventListener('click', ()=> setCollapsed(!wrap.classList.contains('is-collapsed')));
})();
</script>

<script>
(function(){
  const acc = document.getElementById('faq-acc');
  const q = document.getElementById('faq-q');
  const side = document.getElementById('faq-side');
  const allWraps = Array.from(document.querySelectorAll('.topic-wrap'));
  if(!acc) return;

  acc.addEventListener('click', (e)=>{
    const hd = e.target.closest('.acc-hd');
    if(hd){
      const item = hd.parentElement;
      const panel = item.querySelector('.acc-panel');
      const expanded = hd.getAttribute('aria-expanded') === 'true';
      hd.setAttribute('aria-expanded', String(!expanded));
      panel.classList.toggle('is-open', !expanded);
    }
  });

  acc.addEventListener('click', (e)=>{
    const btn = e.target.closest('[data-all-of]');
    if(!btn) return;
    const gid = btn.getAttribute('data-all-of');
    showCategory(gid);
    side.querySelectorAll('.chip-all').forEach(b=>b.classList.remove('is-active'));
    side.querySelectorAll('.row-topic').forEach(r=>r.classList.remove('is-active'));
    btn.classList.add('is-active');
  });

  acc.addEventListener('click', (e)=>{
    const row = e.target.closest('.row-topic');
    if(!row) return;
    const ref = row.getAttribute('data-goto');
    const [gid, tid] = ref.split('::');
    showCategory(gid, tid);
    side.querySelectorAll('.chip-all').forEach(b=>b.classList.remove('is-active'));
    side.querySelectorAll('.row-topic').forEach(r=>r.classList.remove('is-active'));
    row.classList.add('is-active');
  });

  acc.addEventListener('keydown', (e)=>{
    if((e.key==='Enter'||e.key===' ') && e.target.classList.contains('row-topic')){
      e.preventDefault(); e.target.click();
    }
  });

  q.addEventListener('input', (e)=>{
    const term = e.target.value.trim().toLowerCase();
    const items = acc.querySelectorAll('.acc-item');
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
      it.style.display = anyVisible ? '' : 'none';
      if(anyVisible && term){
        it.querySelector('.acc-hd').setAttribute('aria-expanded','true');
        panel.classList.add('is-open');
      }
    });
  });

  function showCategory(gid, tid=null){
    allWraps.forEach(w=>w.classList.toggle('is-visible', w.getAttribute('data-wrap')===gid));
    const wrap = document.getElementById('wrap-'+gid);
    if(!wrap) return;
    const blocks = Array.from(wrap.querySelectorAll('.topic-block'));
    if(tid){
      blocks.forEach(b=> b.style.display = (b.id===tid) ? '' : 'none');
      document.getElementById(tid)?.scrollIntoView({behavior:'smooth', block:'start'});
    }else{
      blocks.forEach(b=> b.style.display = '');
      wrap.scrollIntoView({behavior:'smooth', block:'start'});
    }
  }

  const firstItem = acc.querySelector('.acc-item');
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
