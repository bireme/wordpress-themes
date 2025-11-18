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

/** Renderiza o metabox (apenas banner) */
function bireme_lilacs_periodicos_render_metabox($post){
  wp_nonce_field(BIREME_LILACS_CP_FIELDS_ACTION, BIREME_LILACS_CP_FIELDS_NONCE);

  $title  = get_post_meta($post->ID, BIREME_LILACS_CP_META_TITLE,  true);
  $desc   = get_post_meta($post->ID, BIREME_LILACS_CP_META_DESC,   true);
  $img_id = (int) get_post_meta($post->ID, BIREME_LILACS_CP_META_IMG_ID, true);
  $img    = $img_id ? wp_get_attachment_image_url($img_id, 'medium_large') : '';

  ?>
  <style>
    .lilacs-fields .field{margin:12px 0;}
    .lilacs-fields label{display:block;font-weight:600;margin-bottom:6px;}
    .lilacs-fields input[type=text]{width:100%;}
    .lilacs-fields textarea{width:100%;min-height:110px;}
    .lilacs-help{color:#666;margin:4px 0 0;font-size:12px;}
    .img-picker{display:flex;gap:12px;align-items:flex-start;}
    .img-picker .preview img{max-width:220px;height:auto;border-radius:6px;display:block;background:#f3f4f6;}
    .img-picker .actions button{margin:0 6px 0 0;}
  </style>

  <div class="lilacs-fields">
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

  <script>
  (function($){
    try {
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
    } catch(err) {
      console.error('Erro no script do metabox LILACS (periodicos):', err);
    }
  })(jQuery);
  </script>

  <?php
}

/** Salvamento (apenas quando o template é page-lilacs-periodicos.php) */
add_action('save_post_page', function($post_id){
  if (!isset($_POST[BIREME_LILACS_CP_FIELDS_NONCE]) ||
      !wp_verify_nonce($_POST[BIREME_LILACS_CP_FIELDS_NONCE], BIREME_LILACS_CP_FIELDS_ACTION)) return;

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  $tpl = get_post_meta($post_id, '_wp_page_template', true);
  if ($tpl !== 'page-lilacs-periodicos.php') return;

  $title  = isset($_POST['lilacs_cp_banner_title']) ? sanitize_text_field($_POST['lilacs_cp_banner_title']) : '';
  $desc   = isset($_POST['lilacs_cp_banner_desc'])  ? wp_kses_post($_POST['lilacs_cp_banner_desc']) : '';
  $img_id = isset($_POST['lilacs_cp_banner_img_id']) ? (int) $_POST['lilacs_cp_banner_img_id'] : 0;

  update_post_meta($post_id, BIREME_LILACS_CP_META_TITLE,  $title);
  update_post_meta($post_id, BIREME_LILACS_CP_META_DESC,   $desc);
  update_post_meta($post_id, BIREME_LILACS_CP_META_IMG_ID, $img_id);

}, 10, 1);