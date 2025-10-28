<?php
/**
 * Campos do template: page-lilacs-contato.php
 * Banner + seleção de categorias para FAQ lateral
 * + (NOVO) Bloco da direita editável: título, texto, imagem e botões (texto+link)
 */
if (!defined('ABSPATH')) exit;

/* Constantes base (já existentes) */
if (!defined('BIREME_LILACS_CP_FIELDS_NONCE'))  define('BIREME_LILACS_CP_FIELDS_NONCE',  'bireme_lilacs_cp_fields_nonce');
if (!defined('BIREME_LILACS_CP_FIELDS_ACTION')) define('BIREME_LILACS_CP_FIELDS_ACTION', 'bireme_lilacs_cp_fields_action');

if (!defined('BIREME_LILACS_FAQ_CATS'))         define('BIREME_LILACS_FAQ_CATS',      '_lilacs_faq_sidebar_cats'); // array de term_ids

if (!defined('BIREME_LILACS_CP_META_TITLE'))    define('BIREME_LILACS_CP_META_TITLE',  '_lilacs_cp_banner_title');
if (!defined('BIREME_LILACS_CP_META_DESC'))     define('BIREME_LILACS_CP_META_DESC',   '_lilacs_cp_banner_desc');
if (!defined('BIREME_LILACS_CP_META_IMG_ID'))   define('BIREME_LILACS_CP_META_IMG_ID', '_lilacs_cp_banner_img_id');

/* (NOVO) Constantes do bloco da direita */
if (!defined('BIREME_LILACS_FAQ_BOX_TITLE'))   define('BIREME_LILACS_FAQ_BOX_TITLE',   '_lilacs_faq_box_title');
if (!defined('BIREME_LILACS_FAQ_BOX_DESC'))    define('BIREME_LILACS_FAQ_BOX_DESC',    '_lilacs_faq_box_desc');
if (!defined('BIREME_LILACS_FAQ_BOX_IMG_ID'))  define('BIREME_LILACS_FAQ_BOX_IMG_ID',  '_lilacs_faq_box_img_id');

/* (NOVO) Botões do bloco da direita */
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

/** Renderiza o metabox (Banner + categorias + BLOCO DIREITA + BOTÕES) */
function bireme_lilacs_contato_render_metabox($post){
  wp_nonce_field(BIREME_LILACS_CP_FIELDS_ACTION, BIREME_LILACS_CP_FIELDS_NONCE);

  /* Banner */
  $title  = get_post_meta($post->ID, BIREME_LILACS_CP_META_TITLE,  true);
  $desc   = get_post_meta($post->ID, BIREME_LILACS_CP_META_DESC,   true);
  $img_id = (int) get_post_meta($post->ID, BIREME_LILACS_CP_META_IMG_ID, true);
  $img    = $img_id ? wp_get_attachment_image_url($img_id, 'medium_large') : '';

  /* (NOVO) Bloco Direita */
  $box_title = get_post_meta($post->ID, BIREME_LILACS_FAQ_BOX_TITLE,  true); // h3
  $box_desc  = get_post_meta($post->ID, BIREME_LILACS_FAQ_BOX_DESC,   true); // <p>
  $box_imgid = (int) get_post_meta($post->ID, BIREME_LILACS_FAQ_BOX_IMG_ID, true);
  $box_img   = $box_imgid ? wp_get_attachment_image_url($box_imgid, 'large') : '';

  /* (NOVO) Botões */
  $btn1_text = get_post_meta($post->ID, BIREME_LILACS_FAQ_BTN1_TEXT, true);
  $btn1_url  = get_post_meta($post->ID, BIREME_LILACS_FAQ_BTN1_URL,  true);
  $btn2_text = get_post_meta($post->ID, BIREME_LILACS_FAQ_BTN2_TEXT, true);
  $btn2_url  = get_post_meta($post->ID, BIREME_LILACS_FAQ_BTN2_URL,  true);

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
    .pill{display:inline-block;background:#eef3fb;border:1px solid #dfe8f7;border-radius:999px;padding:6px 12px;margin:4px 6px 0 0;}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
    @media (max-width: 900px){.grid-2{grid-template-columns:1fr;}}
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

    <!-- (NOVO) Botões -->
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

  <!-- Categorias -->
  <?php
  $catsSel  = get_post_meta($post->ID, BIREME_LILACS_FAQ_CATS, true);
  $catsSel  = is_array($catsSel) ? array_values(array_filter(array_map('intval',$catsSel))) : [];

  $allCats = get_terms([
    'taxonomy'   => 'ufaq-category',
    'hide_empty' => false,
  ]);
  ?>
  <h2 style="margin:10px 0 8px;">FAQ – Categorias na lateral</h2>
  <p class="description">Marque as categorias que devem aparecer na coluna esquerda. No front cada categoria vira um “toggle” com as perguntas abaixo; ao clicar numa pergunta, o conteúdo abre à direita.</p>

  <div style="display:flex;gap:10px;flex-wrap:wrap">
    <?php
      if (!is_wp_error($allCats)){
        foreach ($allCats as $t){
          $checked = in_array($t->term_id, $catsSel, true) ? 'checked' : '';
          printf(
            '<label class="pill">
               <input type="checkbox" name="lilacs_faq_cats[]" value="%1$d" %3$s> %2$s
             </label>',
            $t->term_id,
            esc_html($t->name),
            $checked
          );
        }
      }
    ?>
  </div>

  <script>
  (function($){
    try {
      var frame;

      // seletor de imagem (serve para os dois pickers)
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

  // Categorias selecionadas
  $cats = [];
  if (!empty($_POST['lilacs_faq_cats']) && is_array($_POST['lilacs_faq_cats'])) {
    foreach ($_POST['lilacs_faq_cats'] as $tid) {
      $tid = (int)$tid;
      if ($tid && term_exists($tid, 'ufaq-category')) $cats[] = $tid;
    }
  }
  update_post_meta($post_id, BIREME_LILACS_FAQ_CATS, $cats);

}, 10, 1);
