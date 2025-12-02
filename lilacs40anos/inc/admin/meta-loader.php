<?php
/**
 * Loader de metaboxes por template de página
 * - Inclui um arquivo de campos conforme o template selecionado
 * - Mantém o painel do WP organizado por template
 */

if (!defined('ABSPATH')) exit;

function bireme_current_page_template_slug($post_id = 0){
    if (!$post_id) {
        if (!empty($_GET['post']))     $post_id = (int) $_GET['post'];
        if (!empty($_POST['post_ID'])) $post_id = (int) $_POST['post_ID'];
    }
    if (!$post_id) return '';
    return (string) get_page_template_slug($post_id); // ex: 'page-lilacs-home.php'
}

/**
 * Mapeia o slug do template para um arquivo de campos.
 * Regra: trocar ".php" por "-fields.php" dentro de inc/admin/meta-templates
 * Ex.: page-lilacs-home.php -> page-lilacs-home-fields.php
 */
function bireme_include_template_fields_file($post_id = 0){
    $slug = bireme_current_page_template_slug($post_id);
    if (!$slug) return;

    $file = str_replace('.php', '-fields.php', $slug);
    $path = get_template_directory() . '/inc/admin/meta-templates/' . $file;

    if (file_exists($path)) {
        require_once $path; // o arquivo incluído deve registrar seus próprios hooks
    }
}

/**
 * Admin: incluir arquivos no momento certo
 */
add_action('load-post.php',  function(){ bireme_include_template_fields_file(); });
add_action('load-post-new.php', function(){ bireme_include_template_fields_file(); });

/**
 * Também inclui no save para garantir que os callbacks existam
 */
add_action('save_post_page', function($post_id){
    bireme_include_template_fields_file($post_id);
}, 5, 1);
