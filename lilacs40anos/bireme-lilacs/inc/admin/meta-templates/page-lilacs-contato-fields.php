<?php
/**
 * Campos do template: page-lilacs-contato.php
 * Banner + seleção/ordem de categorias (layout igual a "Perguntas em destaque")
 * + Bloco da direita editável: título, texto, imagem e botões
 * + Perguntas em destaque (seleção direta de posts ufaq com ordenação)
 *
 * correção: substitui HTML5 Drag&Drop por "sortable" com mouse (pointer) puro,
 * garantindo que a posição realmente seja aplicada ao soltar (drop) em WP-Admin.
 */
if (!defined('ABSPATH')) exit;

/* Constantes base */
if (!defined('BIREME_LILACS_CP_FIELDS_NONCE'))  define('BIREME_LILACS_CP_FIELDS_NONCE',  'bireme_lilacs_cp_fields_nonce');
if (!defined('BIREME_LILACS_CP_FIELDS_ACTION')) define('BIREME_LILACS_CP_FIELDS_ACTION', 'bireme_lilacs_cp_fields_action');

/* Categorias selecionadas (array ordenado de term_ids) */
if (!defined('BIREME_LILACS_FAQ_CATS'))         define('BIREME_LILACS_FAQ_CATS',      '_lilacs_faq_sidebar_cats');

/* Perguntas em destaque (array ordenado de post IDs do CPT ufaq) */
if (!defined('BIREME_LILACS_FAQ_FEATURED'))     define('BIREME_LILACS_FAQ_FEATURED',  '_lilacs_faq_featured_ids');

/* Banner */
if (!defined('BIREME_LILACS_CP_META_TITLE'))    define('BIREME_LILACS_CP_META_TITLE',  '_lilacs_cp_banner_title');
if (!defined('BIREME_LILACS_CP_META_DESC'))     define('BIREME_LILACS_CP_META_DESC',   '_lilacs_cp_banner_desc');
if (!defined('BIREME_LILACS_CP_META_IMG_ID'))   define('BIREME_LILACS_CP_META_IMG_ID', '_lilacs_cp_banner_img_id');

/* Bloco da direita */
if (!defined('BIREME_LILACS_FAQ_BOX_TITLE'))   define('BIREME_LILACS_FAQ_BOX_TITLE',   '_lilacs_faq_box_title');
if (!defined('BIREME_LILACS_FAQ_BOX_DESC'))    define('BIREME_LILACS_FAQ_BOX_DESC',    '_lilacs_faq_box_desc');
if (!defined('BIREME_LILACS_FAQ_BOX_IMG_ID'))  define('BIREME_LILACS_FAQ_BOX_IMG_ID',  '_lilacs_faq_box_img_id');

/* Botões do bloco da direita */
if (!defined('BIREME_LILACS_FAQ_BTN1_TEXT'))   define('BIREME_LILACS_FAQ_BTN1_TEXT',   '_lilacs_faq_btn1_text');
if (!defined('BIREME_LILACS_FAQ_BTN1_URL'))    define('BIREME_LILACS_FAQ_BTN1_URL',    '_lilacs_faq_btn1_url');
if (!defined('BIREME_LILACS_FAQ_BTN2_TEXT'))   define('BIREME_LILACS_FAQ_BTN2_TEXT',   '_lilacs_faq_btn2_text');
if (!defined('BIREME_LILACS_FAQ_BTN2_URL'))    define('BIREME_LILACS_FAQ_BTN2_URL',    '_lilacs_faq_btn2_url');

/** Enqueue apenas media (só no editor da página do template) */
add_action('admin_enqueue_scripts', function($hook){
  if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
  wp_enqueue_media();
});

/** Adiciona metabox apenas para o template page-lilacs-contato.php */
add_action('add_meta_boxes', function ($post_type, $post) {
  if ($post_type !== 'page' || ! $post) return;
  $tpl = get_post_meta($post->ID, '_wp_page_template', true);
  if ($tpl !== 'page-lilacs-contato.php') return;

  add_meta_box(
    'bireme_lilacs_contato_box',
    __('LILACS – Periódicos/Revistas', 'bireme'),
    'bireme_lilacs_contato_render_metabox',
    'page',
    'normal',
    'high'
  );
}, 10, 2);

/** Renderiza o metabox (Banner + BLOCO DIREITA + BOTÕES + Categorias (novo layout) + Destaques) */
function bireme_lilacs_contato_render_metabox($post){
  wp_nonce_field(BIREME_LILACS_CP_FIELDS_ACTION, BIREME_LILACS_CP_FIELDS_NONCE);

  /* Banner */
  $title  = get_post_meta($post->ID, BIREME_LILACS_CP_META_TITLE,  true);
  $desc   = get_post_meta($post->ID, BIREME_LILACS_CP_META_DESC,   true);
  $img_id = (int) get_post_meta($post->ID, BIREME_LILACS_CP_META_IMG_ID, true);
  $img    = $img_id ? wp_get_attachment_image_url($img_id, 'medium_large') : '';

  /* Bloco Direita */
  $box_title = get_post_meta($post->ID, BIREME_LILACS_FAQ_BOX_TITLE,  true);
  $box_desc  = get_post_meta($post->ID, BIREME_LILACS_FAQ_BOX_DESC,   true);
  $box_imgid = (int) get_post_meta($post->ID, BIREME_LILACS_FAQ_BOX_IMG_ID, true);
  $box_img   = $box_imgid ? wp_get_attachment_image_url($box_imgid, 'large') : '';

  /* Botões */
  $btn1_text = get_post_meta($post->ID, BIREME_LILACS_FAQ_BTN1_TEXT, true);
  $btn1_url  = get_post_meta($post->ID, BIREME_LILACS_FAQ_BTN1_URL,  true);
  $btn2_text = get_post_meta($post->ID, BIREME_LILACS_FAQ_BTN2_TEXT, true);
  $btn2_url  = get_post_meta($post->ID, BIREME_LILACS_FAQ_BTN2_URL,  true);

  /* Categorias (selecionadas + todas) – novo layout com listas disponível/selecionadas */
  $catsSel  = get_post_meta($post->ID, BIREME_LILACS_FAQ_CATS, true);
  $catsSel  = is_array($catsSel) ? array_values(array_filter(array_map('intval',$catsSel))) : [];

  $allCats = get_terms([
    'taxonomy'   => 'ufaq-category',
    'hide_empty' => false,
  ]);
  $catsById = [];
  if (!is_wp_error($allCats)){
    foreach($allCats as $t){ $catsById[$t->term_id] = $t; }
  }
  $selected_terms = [];
  foreach ($catsSel as $tid){
    if (isset($catsById[$tid])) $selected_terms[] = $catsById[$tid];
  }
  $available_terms = [];
  if (!is_wp_error($allCats)){
    foreach($allCats as $t){
      if (!in_array($t->term_id, $catsSel, true)) $available_terms[] = $t;
    }
  }

  /* Perguntas em destaque */
  $featured_ids = get_post_meta($post->ID, BIREME_LILACS_FAQ_FEATURED, true);
  $featured_ids = is_array($featured_ids) ? array_values(array_filter(array_map('intval',$featured_ids))) : [];

  $ufaq_posts = get_posts([
    'post_type'      => 'ufaq',
    'posts_per_page' => 200,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'suppress_filters' => true,
    'no_found_rows'  => true,
  ]);
  ?>
  <style>
    .lilacs-fields .field{margin:12px 0;}
    .lilacs-fields label{display:block;font-weight:600;margin-bottom:6px;}
    .lilacs-fields input[type=text]{width:100%;}
    .lilacs-fields textarea{width:100%;min-height:110px;}
    .lilacs-help{color:#666;margin:4px 0 0;font-size:12px;}
    .img-picker{display:flex;gap:12px;align-items:flex-start;}
    .img-picker .preview img{max-width:260px;height:auto;border-radius:6px;display:block;background:#f3f4f6;}
    .img-picker .actions button{margin:0 6px 0 0;}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
    @media (max-width: 900px){.grid-2{grid-template-columns:1fr;}}

    /* Boxes reutilizáveis (categorias e destaques) */
    .dual-wrap{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .box{border:1px solid #e5e7eb;border-radius:10px;background:#fff}
    .box .box-hd{padding:10px 12px;border-bottom:1px solid #e5e7eb;font-weight:600}
    .box .box-bd{padding:10px 12px;max-height:360px;overflow:auto}
    .search{width:100%;margin-bottom:8px}
    .list-available .item,
    .list-selected li{display:flex;align-items:center;gap:8px;padding:8px 10px;border:1px solid #e5e7eb;border-radius:10px;background:#f8fafc;margin-bottom:8px}
    .list-available .item:hover{background:#f1f5f9}
    .list-selected{list-style:none;margin:0;padding:0}
    .handle{cursor:grab;opacity:.8}
    .drag-ghost{position:absolute; pointer-events:none; z-index:9999; opacity:.8; transform:translate(-50%,-50%); background:#e2e8f0; padding:6px 10px; border-radius:8px; border:1px solid #cbd5e1}
    .drop-indicator{height:8px;border:1px dashed #94a3b8;border-radius:10px;margin:6px 0}
    .muted{font-size:12px;color:#64748b}
    .btn{display:inline-flex;align-items:center;gap:6px;border-radius:8px;border:1px solid #cbd5e1;background:#fff;padding:6px 10px;cursor:pointer}
    .btn.sm{padding:4px 8px;font-size:12px}
    .btn.primary{background:#2563eb;color:#fff;border-color:#2563eb}
    .btn.danger{background:#ef4444;color:#fff;border-color:#ef4444}
    @media (max-width:900px){.dual-wrap{grid-template-columns:1fr}}
  </style>

  <!-- Banner -->
  <div class="lilacs-fields">
    <h2 style="margin:0 0 8px;">Banner</h2>

    <div class="field">
      <label for="lilacs_cp_banner_title"><?php _e('Título do banner', 'bireme'); ?></label>
      <input type="text" id="lilacs_cp_banner_title" name="lilacs_cp_banner_title"
             value="<?php echo esc_attr($title); ?>"
             placeholder="<?php esc_attr_e('Ex.: Como pesquisar na LILACS?', 'bireme'); ?>">
      <p class="lilacs-help"><?php _e('Se vazio, utiliza o título da página.', 'bireme'); ?></p>
    </div>

    <div class="field">
      <label for="lilacs_cp_banner_desc"><?php _e('Descrição do banner', 'bireme'); ?></label>
      <textarea id="lilacs_cp_banner_desc" name="lilacs_cp_banner_desc"
        placeholder="<?php esc_attr_e('Ex.: Acesse artigos, periódicos científicos e documentos técnicos…', 'bireme'); ?>"><?php
          echo esc_textarea($desc);
      ?></textarea>
    </div>

    <div class="field">
      <label><?php _e('Imagem do banner', 'bireme'); ?></label>
      <div class="img-picker" data-img-picker>
        <div class="preview">
          <?php if ($img): ?>
            <img src="<?php echo esc_url($img); ?>" alt="">
          <?php else: ?>
            <img src="<?php echo esc_url(includes_url('images/media/default.png')); ?>" alt="" style="opacity:.4">
          <?php endif; ?>
        </div>
        <div class="actions">
          <input type="hidden" id="lilacs_cp_banner_img_id" name="lilacs_cp_banner_img_id" value="<?php echo esc_attr($img_id); ?>">
          <button type="button" class="button button-primary" data-img-select><?php _e('Selecionar imagem', 'bireme'); ?></button>
          <button type="button" class="button" data-img-remove><?php _e('Remover', 'bireme'); ?></button>
          <p class="lilacs-help"><?php _e('Recomendado: imagem horizontal grande (ex.: 1600×600+).', 'bireme'); ?></p>
        </div>
      </div>
    </div>
  </div>

  <hr style="margin:20px 0">

  <!-- Bloco da direita (FAQ Content) -->
  <div class="lilacs-fields">
    <h2 style="margin:0 0 8px;">FAQ – Bloco da direita (conteúdo inicial)</h2>
    <p class="description">Este conteúdo aparece inicialmente no painel da direita (antes de selecionar uma pergunta).</p>

    <div class="field">
      <label for="lilacs_faq_box_title">Título (H3)</label>
      <input type="text" id="lilacs_faq_box_title" name="lilacs_faq_box_title"
             value="<?php echo esc_attr($box_title ?: 'Contato'); ?>"
             placeholder="Ex.: Contato">
    </div>

    <div class="field">
      <label for="lilacs_faq_box_desc">Texto</label>
      <textarea id="lilacs_faq_box_desc" name="lilacs_faq_box_desc"
        placeholder="Ex.: Dúvida sobre como pesquisar, comentários, sugestões…"><?php
          echo esc_textarea( $box_desc ?: 'Dúvida sobre como pesquisar, comentários, sugestões ou encontrou um erro? Clique no botão e preencha o formulário. Responderemos em breve.' );
      ?></textarea>
    </div>

    <div class="field">
      <label>Imagem</label>
      <div class="img-picker" data-img-picker>
        <div class="preview">
          <?php if ($box_img): ?>
            <img src="<?php echo esc_url($box_img); ?>" alt="">
          <?php else: ?>
            <img src="<?php echo esc_url(includes_url('images/media/default.png')); ?>" alt="" style="opacity:.4">
          <?php endif; ?>
        </div>
        <div class="actions">
          <input type="hidden" id="lilacs_faq_box_img_id" name="lilacs_faq_box_img_id" value="<?php echo esc_attr($box_imgid); ?>">
          <button type="button" class="button button-primary" data-img-select><?php _e('Selecionar imagem', 'bireme'); ?></button>
          <button type="button" class="button" data-img-remove><?php _e('Remover', 'bireme'); ?></button>
          <p class="lilacs-help"><?php _e('Sugestão: ~800×280px (ou proporcional).', 'bireme'); ?></p>
        </div>
      </div>
    </div>

    <!-- Botões -->
    <div class="field">
      <label>Botão 1</label>
      <div class="grid-2">
        <input type="text" name="lilacs_faq_btn1_text" value="<?php echo esc_attr($btn1_text ?: 'LILACS'); ?>" placeholder="Texto do botão 1 (ex.: LILACS)">
        <input type="text" name="lilacs_faq_btn1_url"  value="<?php echo esc_attr($btn1_url  ?: '#'); ?>" placeholder="Link do botão 1 (https://...)">
      </div>
      <p class="lilacs-help">Use URL completa, ex.: <code>https://bvsalud.org/</code></p>
    </div>

    <div class="field">
      <label>Botão 2</label>
      <div class="grid-2">
        <input type="text" name="lilacs_faq_btn2_text" value="<?php echo esc_attr($btn2_text ?: 'Seleção de revistas'); ?>" placeholder="Texto do botão 2">
        <input type="text" name="lilacs_faq_btn2_url"  value="<?php echo esc_attr($btn2_url  ?: '#'); ?>" placeholder="Link do botão 2 (https://...)">
      </div>
    </div>
  </div>

  <hr style="margin:20px 0">

  <!-- NOVO LAYOUT: Categorias na lateral (estilo "Perguntas em destaque") -->
  <h2 style="margin:10px 0 8px;">FAQ – Categorias na lateral</h2>
  <p class="description">Selecione as <strong>categorias</strong> que devem aparecer na coluna esquerda, clique em “Adicionar” e <strong>arraste para ordenar</strong>. A ordem será respeitada no front-end.</p>

  <div class="dual-wrap" id="cats-wrap" data-cats>
    <!-- Disponíveis -->
    <div class="box">
      <div class="box-hd">Categorias disponíveis</div>
      <div class="box-bd">
        <input type="text" class="search" placeholder="Filtrar por nome…" data-cats-search>
        <div class="list-available" data-cats-available>
          <?php foreach ($available_terms as $t): ?>
            <div class="item" data-cat-item data-id="<?php echo (int)$t->term_id; ?>" data-title="<?php echo esc_attr(mb_strtolower($t->name)); ?>">
              <div style="display:flex;align-items:center;gap:8px;flex:1;">
                <span><?php echo esc_html($t->name); ?></span>
                <span class="muted">#<?php echo (int)$t->term_id; ?></span>
              </div>
              <button type="button" class="btn sm" data-cat-add>Adicionar</button>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Selecionadas -->
    <div class="box">
      <div class="box-hd">Selecionadas (arraste para ordenar)</div>
      <div class="box-bd">
        <ul class="list-selected" data-cats-selected>
          <?php foreach ($selected_terms as $t): ?>
            <li data-id="<?php echo (int)$t->term_id; ?>">
              <span class="handle dashicons dashicons-move" title="Arraste"></span>
              <span style="flex:1"><?php echo esc_html($t->name); ?> <span class="muted">#<?php echo (int)$t->term_id; ?></span></span>
              <button type="button" class="btn danger" data-cat-remove>&times;</button>
              <input type="hidden" name="lilacs_faq_cats[]" value="<?php echo (int)$t->term_id; ?>">
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="muted" style="margin-top:8px">A lista acima define quais categorias aparecem e sua ordem.</p>
      </div>
    </div>
  </div>

  <hr style="margin:20px 0">

  <!-- Perguntas em destaque -->
  <h2 style="margin:10px 0 8px;">Perguntas em destaque</h2>
  <p class="description">Escolha perguntas específicas (CPT <code>ufaq</code>) para destacar no topo do FAQ. Clique em “Adicionar” e <strong>arraste para ordenar</strong>.</p>

  <div class="dual-wrap" id="featured-wrap" data-featured>
    <!-- Disponíveis -->
    <div class="box">
      <div class="box-hd">Perguntas disponíveis</div>
      <div class="box-bd">
        <input type="text" class="search" placeholder="Filtrar por título…" data-av-search>
        <div class="list-available" data-av-list>
          <?php foreach ($ufaq_posts as $p): ?>
            <div class="item" data-av-item data-id="<?php echo (int)$p->ID; ?>" data-title="<?php echo esc_attr(mb_strtolower($p->post_title)); ?>">
              <div style="display:flex;align-items:center;gap:8px;flex:1;">
                <span><?php echo esc_html($p->post_title); ?></span>
                <span class="muted">#<?php echo (int)$p->ID; ?></span>
              </div>
              <button type="button" class="btn sm" data-av-add-one>Adicionar</button>
            </div>
          <?php endforeach; ?>
        </div>
        <p class="muted" style="margin-top:8px">* Lista local (até 200 mais recentes).</p>
      </div>
    </div>

    <!-- Selecionadas -->
    <div class="box">
      <div class="box-hd">Selecionadas (arraste para ordenar)</div>
      <div class="box-bd">
        <ul class="list-selected" data-ft-list>
          <?php foreach ($featured_ids as $fid):
            $pt = get_post($fid);
            if (!$pt || $pt->post_type !== 'ufaq') continue; ?>
            <li data-id="<?php echo (int)$fid; ?>">
              <span class="handle dashicons dashicons-move" title="Arraste"></span>
              <span style="flex:1"><?php echo esc_html(get_the_title($pt)); ?> <span class="muted">#<?php echo (int)$fid; ?></span></span>
              <button type="button" class="btn danger" data-ft-remove>&times;</button>
              <input type="hidden" name="lilacs_faq_featured[]" value="<?php echo (int)$fid; ?>">
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="muted" style="margin-top:8px">A ordem acima será usada no front-end.</p>
      </div>
    </div>
  </div>

  <script>
  (function($){
    try {
      var frame;

      // Media picker (ambos os pickers)
      $(document).on('click','[data-img-select]', function(e){
        e.preventDefault();
        var $picker = $(this).closest('[data-img-picker]');
        var $hid = $picker.find('input[type=hidden]');
        if (!frame) {
          frame = wp.media({
            title: '<?php echo esc_js(__('Selecionar imagem', 'bireme')); ?>',
            button: { text: '<?php echo esc_js(__('Usar esta imagem', 'bireme')); ?>' },
            multiple: false
          });
        }
        frame.off('select');
        frame.on('select', function(){
          var att = frame.state().get('selection').first().toJSON();
          var url = att.sizes && (att.sizes.medium_large || att.sizes.large || att.sizes.medium)
            ? (att.sizes.medium_large?.url || att.sizes.large?.url || att.sizes.medium.url)
            : att.url;
          $hid.val(att.id);
          $picker.find('img').attr('src', url).css('opacity',1);
        });
        frame.open();
      });

      $(document).on('click','[data-img-remove]',function(e){
        e.preventDefault();
        var $picker = $(this).closest('[data-img-picker]');
        $picker.find('input[type=hidden]').val('');
        $picker.find('img').attr('src','<?php echo esc_js( includes_url('images/media/default.png') ); ?>').css('opacity',.4);
      });

      /* =======================================================
         SORTABLE COM MOUSE (SEM HTML5 DnD / SEM jQuery UI)
         Robusto no WP-Admin, fixa a posição ao soltar.
         ======================================================= */

      function makeSortable($ul, inputName){
        var $doc = $(document);
        var dragging = null;       // <li> sendo arrastado
        var $ghost = null;         // clone visual sob o cursor
        var $placeholder = $('<div class="drop-indicator"></div>');
        var startY = 0, offsetY = 0;

        // inicia o arraste a partir do handle
        $ul.on('mousedown', '.handle', function(e){
          e.preventDefault();
          var $li = $(this).closest('li');
          dragging = $li;
          startY = e.pageY;
          offsetY = e.pageY - $li.offset().top;

          // ghost visual
          $ghost = $('<div class="drag-ghost"></div>').text($.trim($li.text()));
          $('body').append($ghost);
          $ghost.css({ left: e.pageX + 'px', top: e.pageY + 'px', width: $li.outerWidth() + 'px' });

          // placeholder ocupa o lugar
          $placeholder.height($li.outerHeight());
          $li.after($placeholder);
          $li.css({ opacity:.4 });

          $doc.on('mousemove.sortable', onMouseMove);
          $doc.on('mouseup.sortable', onMouseUp);
        });

        function onMouseMove(e){
          if (!$ghost || !dragging) return;
          $ghost.css({ left: e.pageX + 'px', top: e.pageY + 'px' });

          // encontra o item após o qual devemos posicionar o placeholder
          var $items = $ul.children('li').not(dragging).not($placeholder);
          var placed = false;
          $items.each(function(){
            var $it = $(this);
            var box = this.getBoundingClientRect();
            var mid = box.top + box.height/2 + window.scrollY;
            if (e.pageY < mid){
              $placeholder.insertBefore($it);
              placed = true;
              return false; // break
            }
          });
          if (!placed){
            $ul.append($placeholder);
          }

          // auto-scroll dentro do box se necessário
          var ulBox = $ul[0].getBoundingClientRect();
          var scrollMargin = 24;
          if (e.clientY < ulBox.top + scrollMargin){
            $ul.scrollTop($ul.scrollTop() - 10);
          } else if (e.clientY > ulBox.bottom - scrollMargin){
            $ul.scrollTop($ul.scrollTop() + 10);
          }
        }

        function onMouseUp(e){
          $doc.off('.sortable');
          if (!dragging) return;

          // coloca o LI na posição final
          $placeholder.replaceWith(dragging);
          dragging.css({ opacity: 1 });
          if ($ghost){ $ghost.remove(); $ghost = null; }
          dragging = null;

          // regrava a ordem dos hidden inputs
          refreshHiddenOrder($ul, inputName);
        }

        // reordena inputs hidden conforme ordem no DOM
        refreshHiddenOrder($ul, inputName);
      }

      function refreshHiddenOrder($ul, inputName){
        var ids = [];
        $ul.children('li').each(function(){
          ids.push(this.getAttribute('data-id'));
        });
        // remove e recria inputs na ordem atual
        $ul.find('input[name="'+inputName+'"]').remove();
        ids.forEach(function(id){
          $ul.append($('<input>', {type:'hidden', name:inputName, value:id}));
        });
      }

      /* =========================
         CATEGORIAS – novo layout
         ========================= */
      var $catsWrap   = $('[data-cats]');
      if ($catsWrap.length){
        var $catSearch = $catsWrap.find('[data-cats-search]');
        var $catAvail  = $catsWrap.find('[data-cats-available]');
        var $catSel    = $catsWrap.find('[data-cats-selected]');

        // Busca local
        $catSearch.on('input', function(){
          var q = $(this).val().toLowerCase().trim();
          $catAvail.find('[data-cat-item]').each(function(){
            var t = $(this).attr('data-title') || '';
            $(this).toggle(t.indexOf(q) !== -1);
          });
        });

        // Adicionar
        $catAvail.on('click','[data-cat-add]', function(){
          var $item = $(this).closest('[data-cat-item]');
          var id = parseInt($item.attr('data-id'), 10);
          if (!id) return;
          if ($catSel.find('li[data-id="'+id+'"]').length) return;

          var title = $item.find('span').first().text();
          var $li = $('<li>', {'data-id':id}).append(
            '<span class="handle dashicons dashicons-move" title="Arraste"></span>'+
            '<span style="flex:1">'+title+' <span class="muted">#'+id+'</span></span>'+
            '<button type="button" class="btn danger" data-cat-remove>&times;</button>'+
            '<input type="hidden" name="lilacs_faq_cats[]" value="'+id+'">'
          );
          $catSel.append($li);
          refreshHiddenOrder($catSel, 'lilacs_faq_cats[]');
        });

        // Remover
        $catsWrap.on('click','[data-cat-remove]', function(){
          $(this).closest('li').remove();
          refreshHiddenOrder($catSel, 'lilacs_faq_cats[]');
        });

        // Sortable por mouse
        makeSortable($catSel, 'lilacs_faq_cats[]');
      }

      /* =========================
         PERGUNTAS EM DESTAQUE
         ========================= */
      var $featWrap = $('[data-featured]');
      if ($featWrap.length){
        var $avSearch = $featWrap.find('[data-av-search]');
        var $avList   = $featWrap.find('[data-av-list]');
        var $ftList   = $featWrap.find('[data-ft-list]');

        // Filtro local
        $avSearch.on('input', function(){
          var q = $(this).val().toLowerCase().trim();
          $avList.find('[data-av-item]').each(function(){
            var t = $(this).attr('data-title') || '';
            $(this).toggle(t.indexOf(q) !== -1);
          });
        });

        // Adicionar
        $avList.on('click','[data-av-add-one]', function(){
          var $item = $(this).closest('[data-av-item]');
          var id = parseInt($item.attr('data-id'), 10);
          if (!id) return;
          if ($ftList.find('li[data-id="'+id+'"]').length) return;

          var title = $item.find('span').first().text();
          var $li = $('<li>', {'data-id':id}).append(
            '<span class="handle dashicons dashicons-move" title="Arraste"></span>'+
            '<span style="flex:1">'+title+' <span class="muted">#'+id+'</span></span>'+
            '<button type="button" class="btn danger" data-ft-remove>&times;</button>'+
            '<input type="hidden" name="lilacs_faq_featured[]" value="'+id+'">'
          );
          $ftList.append($li);
          refreshHiddenOrder($ftList, 'lilacs_faq_featured[]');
        });

        // Remover
        $featWrap.on('click','[data-ft-remove]', function(){
          $(this).closest('li').remove();
          refreshHiddenOrder($ftList, 'lilacs_faq_featured[]');
        });

        // Sortable por mouse
        makeSortable($ftList, 'lilacs_faq_featured[]');
      }

      // Garante ordem no submit
      $('#post').on('submit', function(){
        var $catSel = $('[data-cats-selected]');
        if ($catSel.length) refreshHiddenOrder($catSel, 'lilacs_faq_cats[]');
        var $ftList = $('[data-ft-list]');
        if ($ftList.length) refreshHiddenOrder($ftList, 'lilacs_faq_featured[]');
      });

    } catch(err) {
      console.error('Erro no script do metabox LILACS (contato):', err);
    }
  })(jQuery);
  </script>
  <?php
}

/** Salvamento (apenas quando o template é page-lilacs-contato.php) */
add_action('save_post_page', function($post_id){
  if (!isset($_POST[BIREME_LILACS_CP_FIELDS_NONCE]) ||
      !wp_verify_nonce($_POST[BIREME_LILACS_CP_FIELDS_NONCE], BIREME_LILACS_CP_FIELDS_ACTION)) return;

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  $tpl = get_post_meta($post_id, '_wp_page_template', true);
  if ($tpl !== 'page-lilacs-contato.php') return;

  // Banner
  $title  = isset($_POST['lilacs_cp_banner_title']) ? sanitize_text_field($_POST['lilacs_cp_banner_title']) : '';
  $desc   = isset($_POST['lilacs_cp_banner_desc'])  ? wp_kses_post($_POST['lilacs_cp_banner_desc']) : '';
  $img_id = isset($_POST['lilacs_cp_banner_img_id']) ? (int) $_POST['lilacs_cp_banner_img_id'] : 0;

  update_post_meta($post_id, BIREME_LILACS_CP_META_TITLE,  $title);
  update_post_meta($post_id, BIREME_LILACS_CP_META_DESC,   $desc);
  update_post_meta($post_id, BIREME_LILACS_CP_META_IMG_ID, $img_id);

  // Bloco da direita
  $box_title = isset($_POST['lilacs_faq_box_title']) ? sanitize_text_field($_POST['lilacs_faq_box_title']) : '';
  $box_desc  = isset($_POST['lilacs_faq_box_desc'])  ? wp_kses_post($_POST['lilacs_faq_box_desc']) : '';
  $box_imgid = isset($_POST['lilacs_faq_box_img_id']) ? (int) $_POST['lilacs_faq_box_img_id'] : 0;

  update_post_meta($post_id, BIREME_LILACS_FAQ_BOX_TITLE,  $box_title);
  update_post_meta($post_id, BIREME_LILACS_FAQ_BOX_DESC,   $box_desc);
  update_post_meta($post_id, BIREME_LILACS_FAQ_BOX_IMG_ID, $box_imgid);

  // Botões
  $btn1_text = isset($_POST['lilacs_faq_btn1_text']) ? sanitize_text_field($_POST['lilacs_faq_btn1_text']) : '';
  $btn1_url  = isset($_POST['lilacs_faq_btn1_url'])  ? esc_url_raw($_POST['lilacs_faq_btn1_url']) : '';
  $btn2_text = isset($_POST['lilacs_faq_btn2_text']) ? sanitize_text_field($_POST['lilacs_faq_btn2_text']) : '';
  $btn2_url  = isset($_POST['lilacs_faq_btn2_url'])  ? esc_url_raw($_POST['lilacs_faq_btn2_url']) : '';

  update_post_meta($post_id, BIREME_LILACS_FAQ_BTN1_TEXT, $btn1_text);
  update_post_meta($post_id, BIREME_LILACS_FAQ_BTN1_URL,  $btn1_url);
  update_post_meta($post_id, BIREME_LILACS_FAQ_BTN2_TEXT, $btn2_text);
  update_post_meta($post_id, BIREME_LILACS_FAQ_BTN2_URL,  $btn2_url);

  // Categorias selecionadas (array ordenado)
  $cats_final = [];
  if (!empty($_POST['lilacs_faq_cats']) && is_array($_POST['lilacs_faq_cats'])) {
    foreach ($_POST['lilacs_faq_cats'] as $tid) {
      $tid = (int)$tid;
      if ($tid && term_exists($tid, 'ufaq-category')) $cats_final[] = $tid;
    }
  }
  update_post_meta($post_id, BIREME_LILACS_FAQ_CATS, $cats_final);

  // Perguntas em destaque (array ordenado)
  $featured = [];
  if (!empty($_POST['lilacs_faq_featured']) && is_array($_POST['lilacs_faq_featured'])) {
    foreach ($_POST['lilacs_faq_featured'] as $pid) {
      $pid = (int)$pid;
      if ($pid && get_post_type($pid) === 'ufaq') $featured[] = $pid;
    }
  }
  update_post_meta($post_id, BIREME_LILACS_FAQ_FEATURED, $featured);

}, 10, 1);
