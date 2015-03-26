<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
$current_language = strtolower(get_bloginfo('language'));

automatic_feed_links();

if ( function_exists('register_sidebar') )
    register_sidebar(
        array('name'=>'Coluna 1 ' .  $current_language,
            'id' => 'vhl_column_1_' . $current_language,
            'description' => __('Rede Social da BVS', 'example'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle"><span>',
            'after_title' => '</span></h3>',
        ));
    register_sidebar(
        array('name'=>'Coluna 2 ' . $current_language, 
            'id' => 'vhl_column_2_' . $current_language,
            'description' => __('Rede de Conteúdos da BVS', 'example'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle"><span>',
            'after_title' => '</span></h3>',
        ));
    register_sidebar(
        array('name'=>'Coluna 3 ' . $current_language, 
            'id' => 'vhl_column_3_' . $current_language,
            'description' => __('Rede de Notícias', 'example'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle"><span>',
            'after_title' => '</span></h3>',
        ));
	   register_sidebar(
        array('name'=>'Footer ' . $current_language, 
            'id' => 'vhl_footer_' . $current_language,
            'description' => __('Rodapé', 'example'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle"><span>',
            'after_title' => '</span></h3>',
        ));
     
     if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
		set_post_thumbnail_size(200, 70, true);
        add_image_size('large_highlight', 580, 340, true);
        add_image_size('medium_highlight', 220, 130, true);
        add_image_size('small_highlight', 60, 40, true);
        add_image_size('icon', 16, 16, true);
	}

add_action('init', 'cptui_register_my_cpt_aps');
function cptui_register_my_cpt_aps() {
    register_post_type('aps', array(
        'label' => 'SOF',
        'description' => '',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => 'aps', 'with_front' => true),
        'query_var' => true,
        'has_archive' => true,
        'supports' => array('title','editor','revisions','thumbnail'),
        'labels' => array (
            'name' => 'SOF',
            'singular_name' => 'SOF',
            'menu_name' => 'SOF',
            'add_new' => 'Add SOF',
            'add_new_item' => 'Add New SOF',
            'edit' => 'Edit',
            'edit_item' => 'Edit SOF',
            'new_item' => 'New SOF',
            'view' => 'View SOF',
            'view_item' => 'View SOF',
            'search_items' => 'Search SOF',
            'not_found' => 'No SOF Found',
            'not_found_in_trash' => 'No SOF Found in Trash',
            'parent' => 'Parent SOF',
            )
        ) 
    ); 
}

?>


