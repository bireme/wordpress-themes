<?php
if (!defined('ABSPATH')) exit;

/** Helper robusto para ler o template atual no admin */
if (!function_exists('lilacs_get_current_template_slug')) {
  function lilacs_get_current_template_slug($post){
    // 1) Se o usuário acabou de escolher no dropdown (antes de salvar)
    if (!empty($_POST['_wp_page_template'])) {
      return sanitize_text_field( wp_unslash($_POST['_wp_page_template']) );
    }
    // 2) API própria do WP (funciona na maioria dos casos)
    $slug = get_page_template_slug($post);
    if ($slug) return $slug;

    // 3) Meta cru (fallback)
    $meta = get_post_meta($post->ID, '_wp_page_template', true);
    return $meta ? $meta : '';
  }
}

/** Slugs aceitos para o template (raiz ou em /templates) */
if (!function_exists('lilacs_is_indicadores_template')) {
  function lilacs_is_indicadores_template($slug){
    $valid = array(
      'page-lilacs-indicadores.php',
      'templates/page-lilacs-indicadores.php',
    );
    return in_array($slug, $valid, true);
  }
}

/** Enqueue media (tudo ok) */
add_action('admin_enqueue_scripts', function($hook){
  if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
  wp_enqueue_media();
});

/** Indicadores template detection */
if (!function_exists('lilacs_is_indicadores_template')) {
  function lilacs_is_indicadores_template($slug){
    $valid = array(
      'page-lilacs-indicadores.php',
      'templates/page-lilacs-indicadores.php',
    );
    return in_array($slug, $valid, true);
  }
}

/** Add metabox for Indicadores template */
add_action('add_meta_boxes', function($post_type, $post){
  if ($post_type !== 'page' || ! $post) return;

  // Only add metabox when editing the indicadores template page
  $tpl = '';
  // Try to detect current template selection in admin
  if (!empty($_POST['_wp_page_template'])) {
    $tpl = sanitize_text_field( wp_unslash($_POST['_wp_page_template']) );
  } else {
    $tpl = get_page_template_slug($post);
    if (!$tpl) $tpl = get_post_meta($post->ID, '_wp_page_template', true) ?: '';
  }
  if ( ! lilacs_is_indicadores_template($tpl) ) return;

  add_meta_box(
    'bireme_lilacs_indicadores_box',
    __('LILACS – Indicadores (Categorias & Tópicos)', 'bireme'),
    'bireme_lilacs_indicadores_render_metabox',
    'page',
    'normal',
    'high'
  );
}, 10, 2);


/** Render metabox: small JS-driven repeater that stores JSON into a hidden input */
function bireme_lilacs_indicadores_render_metabox($post){
  // Current value (array)
  $groups = get_post_meta($post->ID, 'lilacs_indicator_groups', true);
  if (!is_array($groups)) $groups = array();

  // nonce for this metabox
  wp_nonce_field('bireme_lilacs_indicadores_save', 'bireme_lilacs_indicadores_nonce');

  // Hidden JSON field that will be saved
  ?>
  <div id="bireme-indicadores-metabox">
    <p class="description">Organize categorias e tópicos para a página de Indicadores. Use os botões para adicionar/remover. Este conteúdo será salvo no meta key <code>lilacs_indicator_groups</code>.</p>
    <div id="bireme-indicadores-ui"></div>
    <input type="hidden" id="lilacs_indicator_groups_json" name="lilacs_indicator_groups_json" value="<?php echo esc_attr( wp_json_encode($groups) ); ?>">
    <p style="margin-top:.5rem">
      <button type="button" class="button" id="bireme-add-group">+ Adicionar categoria</button>
      <button type="button" class="button" id="bireme-reset-groups">Resetar (apagar todos)</button>
    </p>
  </div>

  <style>
    #bireme-indicadores-ui .group{border:1px solid #ddd;padding:10px;margin:10px 0;border-radius:6px;background:#fff}
    #bireme-indicadores-ui .group .group-head{display:flex;gap:8px;align-items:center}
    #bireme-indicadores-ui .topic{border:1px dashed #e1e1e1;padding:8px;margin:6px 0;border-radius:4px}
    #bireme-indicadores-ui .small-btn{font-size:12px;padding:3px 6px}
  </style>

  <script>
  (function(){
    const container = document.getElementById('bireme-indicadores-ui');
    const jsonField = document.getElementById('lilacs_indicator_groups_json');
    let groups = [];

    try{ groups = JSON.parse(jsonField.value || '[]'); }catch(e){ groups = []; }

    function render(){
      container.innerHTML = '';
      groups.forEach((g, gi)=>{
        const groupEl = document.createElement('div'); groupEl.className='group';
        const head = document.createElement('div'); head.className='group-head';
        const titleInput = document.createElement('input'); titleInput.type='text'; titleInput.placeholder='Título da categoria'; titleInput.style.flex='1'; titleInput.value = g.category || '';
        const remGroup = document.createElement('button'); remGroup.type='button'; remGroup.className='button small-btn'; remGroup.textContent='Remover categoria';
        remGroup.addEventListener('click', ()=>{ groups.splice(gi,1); render(); });
        head.appendChild(titleInput); head.appendChild(remGroup);

        const topicsEl = document.createElement('div'); topicsEl.className='topics';
        (g.topics||[]).forEach((t, ti)=>{
          const tEl = document.createElement('div'); tEl.className='topic';
          const tTitle = document.createElement('input'); tTitle.type='text'; tTitle.placeholder='Título do tópico'; tTitle.style.width='100%'; tTitle.value = t.title || '';
          const tContent = document.createElement('textarea'); tContent.placeholder='Conteúdo (HTML permitido)'; tContent.style.width='100%'; tContent.rows=3; tContent.value = t.content || '';
          const remTopic = document.createElement('button'); remTopic.type='button'; remTopic.className='button small-btn'; remTopic.textContent='Remover tópico';
          remTopic.addEventListener('click', ()=>{ (groups[gi].topics||[]).splice(ti,1); render(); });
          tEl.appendChild(tTitle); tEl.appendChild(document.createElement('br'));
          tEl.appendChild(tContent); tEl.appendChild(document.createElement('br'));
          tEl.appendChild(remTopic);
          topicsEl.appendChild(tEl);

          // bind changes
          tTitle.addEventListener('input', ()=> groups[gi].topics[ti].title = tTitle.value );
          tContent.addEventListener('input', ()=> groups[gi].topics[ti].content = tContent.value );
        });

        const addTopic = document.createElement('button'); addTopic.type='button'; addTopic.className='button small-btn'; addTopic.textContent='+ Adicionar tópico';
        addTopic.addEventListener('click', ()=>{ groups[gi].topics = groups[gi].topics || []; groups[gi].topics.push({title:'',content:''}); render(); });

        groupEl.appendChild(head);
        groupEl.appendChild(topicsEl);
        groupEl.appendChild(addTopic);
        container.appendChild(groupEl);

        // bind title input after append so gi stays stable across rerenders
        titleInput.addEventListener('input', ()=> groups[gi].category = titleInput.value );
      });

      // update hidden field
      jsonField.value = JSON.stringify(groups);
    }

    document.getElementById('bireme-add-group').addEventListener('click', ()=>{ groups.push({category:'',topics:[]}); render(); });
    document.getElementById('bireme-reset-groups').addEventListener('click', ()=>{ if(confirm('Apagar todas as categorias e tópicos?')){ groups = []; render(); } });

    // Intercept WP form submit to ensure hidden field has latest value
    const form = document.getElementById('post');
    if(form){ form.addEventListener('submit', ()=>{ jsonField.value = JSON.stringify(groups); }); }

    // initial render
    render();
  })();
  </script>
  <?php
}

/** Save handler for indicadores metabox */
add_action('save_post_page', function($post_id){
  // Check nonce
  if ( empty($_POST['bireme_lilacs_indicadores_nonce']) ||
       ! wp_verify_nonce($_POST['bireme_lilacs_indicadores_nonce'], 'bireme_lilacs_indicadores_save') ) {
    return;
  }
  // Autosave, permissions
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  // Only save when template is indicadores
  $tpl = get_page_template_slug($post_id);
  if (!$tpl) $tpl = get_post_meta($post_id, '_wp_page_template', true) ?: '';
  if (! lilacs_is_indicadores_template($tpl)) return;

  $json = isset($_POST['lilacs_indicator_groups_json']) ? wp_unslash($_POST['lilacs_indicator_groups_json']) : '';
  if (!$json) {
    // empty -> delete meta
    delete_post_meta($post_id, 'lilacs_indicator_groups');
    return;
  }

  $data = json_decode($json, true);
  if (!is_array($data)) return;

  // sanitize structure: categories -> topics[] {title, content}
  $out = array();
  foreach($data as $g){
    $cat = isset($g['category']) ? sanitize_text_field($g['category']) : '';
    $topics_in = isset($g['topics']) && is_array($g['topics']) ? $g['topics'] : array();
    $topics_out = array();
    foreach($topics_in as $t){
      $tt = isset($t['title']) ? sanitize_text_field($t['title']) : '';
      // allow basic HTML in content
      $tc_raw = isset($t['content']) ? wp_unslash($t['content']) : '';  if ( current_user_can('unfiltered_html') ) {   // Admin/Editor com permissão: salva cru, sem remover <script>   $tc = $tc_raw; } else {   // Outros perfis: libera um whitelist que inclui <script>   $allowed = wp_kses_allowed_html('post');    // Permitir <script> com atributos comuns   $allowed['script'] = array(     'type'        => true,     'src'         => true,     'async'       => true,     'defer'       => true,     'id'          => true,     'crossorigin' => true,     'integrity'   => true,   );    // Complementos úteis para seu caso   $allowed['div']['id']    = true;   $allowed['div']['class'] = true;   $allowed['div']['style'] = true;    $allowed['object'] = array(     'type'   => true,     'data'   => true,     'width'  => true,     'height' => true,     'style'  => true,     'id'     => true,     'class'  => true,   );   $allowed['param'] = array(     'name'  => true,     'value' => true,   );    $tc = wp_kses( $tc_raw, $allowed ); }
      if ($tt === '' && $tc === '') continue; // skip empty
      $topics_out[] = array('title' => $tt, 'content' => $tc);
    }
    // If both empty, skip group
    if ($cat === '' && empty($topics_out)) continue;
    $out[] = array('category' => $cat, 'topics' => $topics_out);
  }

  update_post_meta($post_id, 'lilacs_indicator_groups', $out);
}, 10, 1);

/** Adiciona o metabox só quando o template correto estiver ativo */
add_action('add_meta_boxes', function($post_type, $post){
  if ($post_type !== 'page' || ! $post) return;


  add_meta_box(
    'bireme_lilacs_indicadores_box',
    __('LILACS – indicadores (Banner)', 'bireme'),
    'bireme_lilacs_indicadores_render_metabox',
    'page',
    'normal',
    'high'
  );
}, 10, 2);

/** Salvamento (somente se o template da página for o esperado) */
add_action('save_post_page', function($post_id){
  if (!isset($_POST[BIREME_LILACS_CP_FIELDS_NONCE]) ||
      !wp_verify_nonce($_POST[BIREME_LILACS_CP_FIELDS_NONCE], BIREME_LILACS_CP_FIELDS_ACTION)) return;

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  $tpl = get_page_template_slug($post_id);
  if (!$tpl) {
    // fallback se get_page_template_slug retornar vazio
    $tpl = get_post_meta($post_id, '_wp_page_template', true);
  }
  if ( ! lilacs_is_indicadores_template($tpl) ) return;

  $title  = isset($_POST['lilacs_cp_banner_title']) ? sanitize_text_field( wp_unslash($_POST['lilacs_cp_banner_title']) ) : '';
  $desc   = isset($_POST['lilacs_cp_banner_desc'])  ? wp_kses_post( wp_unslash($_POST['lilacs_cp_banner_desc']) ) : '';
  $img_id = isset($_POST['lilacs_cp_banner_img_id']) ? (int) $_POST['lilacs_cp_banner_img_id'] : 0;

  update_post_meta($post_id, BIREME_LILACS_CP_META_TITLE,  $title);
  update_post_meta($post_id, BIREME_LILACS_CP_META_DESC,   $desc);
  update_post_meta($post_id, BIREME_LILACS_CP_META_IMG_ID, $img_id);
}, 10, 1);
