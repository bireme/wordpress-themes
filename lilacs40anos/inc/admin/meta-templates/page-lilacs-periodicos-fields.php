<?php
/**
 * Campos do template: page-lilacs-periodicos.php
 * Apenas a aba Banner (mesmas chaves do coordenadores)
 */
if (!defined('ABSPATH')) exit;

/* Definir constantes apenas se ainda não estiverem definidas (usar mesmas chaves) */
if (!defined('BIREME_LILACS_CP_FIELDS_NONCE')) {
  define('BIREME_LILACS_CP_FIELDS_NONCE',  'bireme_lilacs_cp_fields_nonce');
}
if (!defined('BIREME_LILACS_CP_FIELDS_ACTION')) {
  define('BIREME_LILACS_CP_FIELDS_ACTION', 'bireme_lilacs_cp_fields_action');
}

if (!defined('BIREME_LILACS_CP_META_TITLE')) {
  define('BIREME_LILACS_CP_META_TITLE',    '_lilacs_cp_banner_title');
}
if (!defined('BIREME_LILACS_CP_META_DESC')) {
  define('BIREME_LILACS_CP_META_DESC',     '_lilacs_cp_banner_desc');
}
if (!defined('BIREME_LILACS_CP_META_IMG_ID')) {
  define('BIREME_LILACS_CP_META_IMG_ID',   '_lilacs_cp_banner_img_id');
}

/** Enqueue media para o seletor de imagem (somente na tela de edição) */
add_action('admin_enqueue_scripts', function($hook){
  if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
  wp_enqueue_media();
});

/** Adiciona metabox apenas para o template page-lilacs-periodicos.php */
add_action('add_meta_boxes', function ($post_type, $post) {
  if ($post_type !== 'page' || ! $post) return;

  $tpl = get_post_meta($post->ID, '_wp_page_template', true);
  if ($tpl !== 'page-lilacs-periodicos.php') return;

  add_meta_box(
    'bireme_lilacs_periodicos_box',
    __('LILACS – Periódicos/Revistas', 'bireme'),
    'bireme_lilacs_periodicos_render_metabox',
    'page',
    'normal',
    'high'
  );
}, 10, 2);

/** Renderiza o metabox */
function bireme_lilacs_periodicos_render_metabox($post){
  wp_nonce_field(BIREME_LILACS_CP_FIELDS_ACTION, BIREME_LILACS_CP_FIELDS_NONCE);

  $title  = get_post_meta($post->ID, BIREME_LILACS_CP_META_TITLE,  true);
  $desc   = get_post_meta($post->ID, BIREME_LILACS_CP_META_DESC,   true);
  $img_id = (int) get_post_meta($post->ID, BIREME_LILACS_CP_META_IMG_ID, true);
  $img    = $img_id ? wp_get_attachment_image_url($img_id, 'medium_large') : '';

  // ── i18n defaults ──────────────────────────────────────────────────────────
  $i18n_defaults = [
    'pt' => [
      'banner_title' => 'Revistas indexadas na LILACS',
      'banner_desc'  => 'Conheça todos os títulos e pesquise por país, área, editora e Centro Cooperante.',
      'cluster_country'  => 'País',
      'cluster_area'     => 'Área temática',
      'cluster_editor'   => 'Editora',
      'cluster_cc'       => 'Centro Cooperante',
      'col_num'          => '#',
      'col_short_title'  => 'Título abreviado',
      'col_full_title'   => 'Título completo',
      'col_issn'         => 'ISSN',
      'col_editor_code'  => 'Código da Editora',
      'col_cc_code'      => 'Código do Centro Cooperante',
      'toggle_full'      => 'Mostrar título completo',
    ],
    'es' => [
      'banner_title' => 'Revistas indexadas en LILACS',
      'banner_desc'  => 'Conozca todos los títulos y busque por país, área, editorial y Centro Cooperante.',
      'cluster_country'  => 'País',
      'cluster_area'     => 'Área temática',
      'cluster_editor'   => 'Editorial',
      'cluster_cc'       => 'Centro Cooperante',
      'col_num'          => '#',
      'col_short_title'  => 'Título abreviado',
      'col_full_title'   => 'Título completo',
      'col_issn'         => 'ISSN',
      'col_editor_code'  => 'Código del Editorial',
      'col_cc_code'      => 'Código del Centro Cooperante',
      'toggle_full'      => 'Mostrar título completo',
    ],
    'en' => [
      'banner_title' => 'Journals indexed in LILACS',
      'banner_desc'  => 'Discover all titles and search by country, subject area, publisher, and Cooperating Center.',
      'cluster_country'  => 'Country',
      'cluster_area'     => 'Subject area',
      'cluster_editor'   => 'Publisher',
      'cluster_cc'       => 'Cooperating Center',
      'col_num'          => '#',
      'col_short_title'  => 'Abbreviated title',
      'col_full_title'   => 'Full title',
      'col_issn'         => 'ISSN',
      'col_editor_code'  => 'Publisher Code',
      'col_cc_code'      => 'CC Code',
      'toggle_full'      => 'Show full title',
    ],
  ];

  $i18n_keys = array_keys($i18n_defaults['pt']);
  $langs     = ['pt','es','en'];

  // lê valores salvos (preenchendo defaults se vazios)
  $saved = [];
  foreach ($langs as $lang) {
    $saved[$lang] = [];
    foreach ($i18n_keys as $k) {
      $meta_key = "_lilacs_per_i18n_{$lang}_{$k}";
      $val = get_post_meta($post->ID, $meta_key, true);
      $saved[$lang][$k] = $val !== '' ? $val : $i18n_defaults[$lang][$k];
    }
  }

  $lang_labels = ['pt' => 'Português (PT)', 'es' => 'Español (ES)', 'en' => 'English (EN)'];
  $field_labels = [
    'banner_title'     => 'Título do banner',
    'banner_desc'      => 'Descrição do banner',
    'cluster_country'  => 'Filtro: País',
    'cluster_area'     => 'Filtro: Área temática',
    'cluster_editor'   => 'Filtro: Editora',
    'cluster_cc'       => 'Filtro: Centro Cooperante',
    'col_num'          => 'Coluna: #',
    'col_short_title'  => 'Coluna: Título abreviado',
    'col_full_title'   => 'Coluna: Título completo',
    'col_issn'         => 'Coluna: ISSN',
    'col_editor_code'  => 'Coluna: Código da Editora',
    'col_cc_code'      => 'Coluna: Código do Centro Cooperante',
    'toggle_full'      => 'Botão: Mostrar título completo',
  ];
  ?>
  <style>
    .lilacs-fields .field{margin:12px 0;}
    .lilacs-fields label{display:block;font-weight:600;margin-bottom:6px;}
    .lilacs-fields input[type=text]{width:100%;}
    .lilacs-fields textarea{width:100%;min-height:80px;}
    .lilacs-help{color:#666;margin:4px 0 0;font-size:12px;}
    .img-picker{display:flex;gap:12px;align-items:flex-start;}
    .img-picker .preview img{max-width:220px;height:auto;border-radius:6px;display:block;background:#f3f4f6;}
    .img-picker .actions button{margin:0 6px 0 0;}
    .lilacs-i18n-tabs{display:flex;gap:4px;margin:16px 0 0;}
    .lilacs-i18n-tabs button{padding:6px 14px;border:1px solid #ccc;background:#f6f7f7;border-radius:4px 4px 0 0;cursor:pointer;font-size:13px;}
    .lilacs-i18n-tabs button.active{background:#fff;border-bottom-color:#fff;font-weight:700;}
    .lilacs-i18n-panel{border:1px solid #ccc;padding:14px;display:none;}
    .lilacs-i18n-panel.active{display:block;}
    .lilacs-i18n-panel .field{margin:8px 0;}
    .lilacs-i18n-panel label{font-size:12px;font-weight:600;color:#444;display:block;margin-bottom:3px;}
  </style>

  <div class="lilacs-fields">
    <!-- Imagem do banner (compartilhada) -->
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

    <!-- Abas de idioma -->
    <div class="lilacs-i18n-tabs">
      <?php foreach ($langs as $i => $lang): ?>
        <button type="button" class="<?php echo $i===0?'active':''; ?>" data-tab="<?php echo esc_attr($lang); ?>"><?php echo esc_html($lang_labels[$lang]); ?></button>
      <?php endforeach; ?>
    </div>

    <?php foreach ($langs as $i => $lang): ?>
    <div class="lilacs-i18n-panel <?php echo $i===0?'active':''; ?>" id="lilacs-tab-<?php echo esc_attr($lang); ?>">
      <?php foreach ($i18n_keys as $k): ?>
        <?php $meta_key = "_lilacs_per_i18n_{$lang}_{$k}"; ?>
        <div class="field">
          <label><?php echo esc_html($field_labels[$k] ?? $k); ?></label>
          <?php if ($k === 'banner_desc'): ?>
            <textarea name="<?php echo esc_attr($meta_key); ?>"><?php echo esc_textarea($saved[$lang][$k]); ?></textarea>
          <?php else: ?>
            <input type="text" name="<?php echo esc_attr($meta_key); ?>" value="<?php echo esc_attr($saved[$lang][$k]); ?>">
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
  </div>

  <script>
  (function($){
    try {
      // ── Media picker ──────────────────────────────────────────────────────
      var frame;
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
          $hid.val(att.id);
          $picker.find('img').attr('src', (att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url)).css('opacity',1);
        });

        frame.open();
      });

      $(document).on('click','[data-img-remove]',function(e){
        e.preventDefault();
        var $picker = $(this).closest('[data-img-picker]');
        $picker.find('input[type=hidden]').val('');
        $picker.find('img').attr('src','<?php echo esc_js( includes_url('images/media/default.png') ); ?>').css('opacity',.4);
      });

      // ── Language tabs ──────────────────────────────────────────────────────
      $(document).on('click', '.lilacs-i18n-tabs button', function(){
        var lang = $(this).data('tab');
        $('.lilacs-i18n-tabs button').removeClass('active');
        $(this).addClass('active');
        $('.lilacs-i18n-panel').removeClass('active');
        $('#lilacs-tab-' + lang).addClass('active');
      });

    } catch(err) {
      console.error('Erro no script do metabox LILACS (periodicos):', err);
    }
  })(jQuery);
  </script>

  <?php
}

/** Salvamento */
add_action('save_post_page', function($post_id){
  if (!isset($_POST[BIREME_LILACS_CP_FIELDS_NONCE]) ||
      !wp_verify_nonce($_POST[BIREME_LILACS_CP_FIELDS_NONCE], BIREME_LILACS_CP_FIELDS_ACTION)) return;

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  $tpl = get_post_meta($post_id, '_wp_page_template', true);
  if ($tpl !== 'page-lilacs-periodicos.php') return;

  // Imagem (campo compartilhado)
  $img_id = isset($_POST['lilacs_cp_banner_img_id']) ? (int) $_POST['lilacs_cp_banner_img_id'] : 0;
  update_post_meta($post_id, BIREME_LILACS_CP_META_IMG_ID, $img_id);

  // Campos i18n por idioma
  $langs = ['pt','es','en'];
  $text_fields = ['banner_title','cluster_country','cluster_area','cluster_editor','cluster_cc',
                  'col_num','col_short_title','col_full_title','col_issn','col_editor_code','col_cc_code','toggle_full'];
  $textarea_fields = ['banner_desc'];

  foreach ($langs as $lang) {
    foreach ($text_fields as $k) {
      $meta_key = "_lilacs_per_i18n_{$lang}_{$k}";
      $val = isset($_POST[$meta_key]) ? sanitize_text_field(wp_unslash($_POST[$meta_key])) : '';
      update_post_meta($post_id, $meta_key, $val);
    }
    foreach ($textarea_fields as $k) {
      $meta_key = "_lilacs_per_i18n_{$lang}_{$k}";
      $val = isset($_POST[$meta_key]) ? sanitize_textarea_field(wp_unslash($_POST[$meta_key])) : '';
      update_post_meta($post_id, $meta_key, $val);
    }
  }

}, 10, 1);