<?php
if (!defined('ABSPATH')) exit;

/** Constantes comuns */
if (!defined('BIREME_LILACS_CP_FIELDS_NONCE'))  define('BIREME_LILACS_CP_FIELDS_NONCE',  'bireme_lilacs_cp_fields_nonce');
if (!defined('BIREME_LILACS_CP_FIELDS_ACTION')) define('BIREME_LILACS_CP_FIELDS_ACTION', 'bireme_lilacs_cp_fields_action');

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

/** Constantes de meta (fallbacks seguros) */
if (!defined('BIREME_LILACS_CP_META_TITLE'))    define('BIREME_LILACS_CP_META_TITLE',   '_lilacs_cp_banner_title');
if (!defined('BIREME_LILACS_CP_META_DESC'))     define('BIREME_LILACS_CP_META_DESC',    '_lilacs_cp_banner_desc');
if (!defined('BIREME_LILACS_CP_META_IMG_ID'))   define('BIREME_LILACS_CP_META_IMG_ID',  '_lilacs_cp_banner_img_id');

/** Render do metabox (callback usado em add_meta_box) */
if (!function_exists('bireme_lilacs_indicadores_render_metabox')) {
  function bireme_lilacs_indicadores_render_metabox($post){
    // Nonce para verificação no save
    if (defined('BIREME_LILACS_CP_FIELDS_ACTION') && defined('BIREME_LILACS_CP_FIELDS_NONCE')) {
      wp_nonce_field(BIREME_LILACS_CP_FIELDS_ACTION, BIREME_LILACS_CP_FIELDS_NONCE);
    }

    $title  = get_post_meta($post->ID, BIREME_LILACS_CP_META_TITLE, true);
    $desc   = get_post_meta($post->ID, BIREME_LILACS_CP_META_DESC, true);
    $img_id = (int) get_post_meta($post->ID, BIREME_LILACS_CP_META_IMG_ID, true);

    // Título
    echo '<p><label for="lilacs_cp_banner_title">' . esc_html__('Título', 'bireme') . '</label></p>';
    echo '<p><input type="text" id="lilacs_cp_banner_title" name="lilacs_cp_banner_title" value="' . esc_attr($title) . '" class="widefat"/></p>';

    // Descrição
    echo '<p><label for="lilacs_cp_banner_desc">' . esc_html__('Descrição', 'bireme') . '</label></p>';
    echo '<p><textarea id="lilacs_cp_banner_desc" name="lilacs_cp_banner_desc" class="widefat" rows="4">' . esc_textarea($desc) . '</textarea></p>';

    // Imagem (hidden id + preview + botões)
    echo '<p><label>' . esc_html__('Imagem (banner)', 'bireme') . '</label></p>';
    echo '<p>';
    if ($img_id) {
      echo wp_get_attachment_image($img_id, 'medium');
    }
    echo '<input type="hidden" id="lilacs_cp_banner_img_id" name="lilacs_cp_banner_img_id" value="' . esc_attr($img_id) . '"/>';
    echo ' <button type="button" class="button button-secondary bireme-lilacs-upload-image">' . esc_html__('Selecionar imagem', 'bireme') . '</button>';
    echo ' <button type="button" class="button bireme-lilacs-remove-image">' . esc_html__('Remover imagem', 'bireme') . '</button>';
    echo '</p>';
  }
}

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
