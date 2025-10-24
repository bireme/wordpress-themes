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
if (!function_exists('lilacs_is_metodologia_template')) {
  function lilacs_is_metodologia_template($slug){
    $valid = array(
      'page-lilacs-metodologia.php',
      'templates/page-lilacs-metodologia.php',
    );
    return in_array($slug, $valid, true);
  }
}

/** Enqueue media (tudo ok) */
add_action('admin_enqueue_scripts', function($hook){
  if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
  wp_enqueue_media();
});

/** Adiciona o metabox só quando o template correto estiver ativo */
add_action('add_meta_boxes', function($post_type, $post){
  if ($post_type !== 'page' || ! $post) return;


  add_meta_box(
    'bireme_lilacs_metodologia_box',
    __('LILACS – Metodologia (Banner)', 'bireme'),
    'bireme_lilacs_metodologia_render_metabox',
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
  if ( ! lilacs_is_metodologia_template($tpl) ) return;

  $title  = isset($_POST['lilacs_cp_banner_title']) ? sanitize_text_field( wp_unslash($_POST['lilacs_cp_banner_title']) ) : '';
  $desc   = isset($_POST['lilacs_cp_banner_desc'])  ? wp_kses_post( wp_unslash($_POST['lilacs_cp_banner_desc']) ) : '';
  $img_id = isset($_POST['lilacs_cp_banner_img_id']) ? (int) $_POST['lilacs_cp_banner_img_id'] : 0;

  update_post_meta($post_id, BIREME_LILACS_CP_META_TITLE,  $title);
  update_post_meta($post_id, BIREME_LILACS_CP_META_DESC,   $desc);
  update_post_meta($post_id, BIREME_LILACS_CP_META_IMG_ID, $img_id);
}, 10, 1);
