<?php
// Suporte a thumbnails
add_theme_support('post-thumbnails');

// Suporte a título dinâmico
add_theme_support('title-tag');

//Add Styles Top
add_action('wp_enqueue_scripts', 'style_top');
function style_top()
{
    wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/css/style.css');
    wp_enqueue_style('slick', get_stylesheet_directory_uri() . '/css/slick.css');
    wp_enqueue_style('theme-slick', get_stylesheet_directory_uri() . '/css/slick-theme.css');
    wp_enqueue_style('icones-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');
}
//Add Scripts Footer
add_action('wp_footer', 'scripts_footer');
function scripts_footer()
{
    wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-3.7.1.min.js');
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js');
    wp_enqueue_script('slick-js', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '', true);
    wp_enqueue_script('main', get_stylesheet_directory_uri() . '/js/main.js');
}

// Register menus
function tmgl_register_menus()
{
    register_nav_menus(array(
        'global-menu' => __('Global Menu', 'tmgl'),
        'regional-menu' => __('Regional Menu', 'tmgl'),
        'footer-left' => __('Footer Left', 'tmgl'),
        'footer-right' => __('Footer Right', 'tmgl'),
        'footer-center' => __('Footer Center', 'tmgl')
    ));
}
add_action('init', 'tmgl_register_menus');
//Widget
register_sidebar([
    'name' => 'Footer 1',
    'id' => 'footer_1',
    'description' => 'Footer 1',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
]);
register_sidebar([
    'name' => 'Footer 2',
    'id' => 'footer_2',
    'description' => 'Footer 2',
    'before_title' => '<h5>',
    'after_title' => '</h5>'
]);

// Custom Post Type Trending Topics
function create_trending_topics_cpt()
{
    $labels = array(
        'name' => _x('Trending Topics', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('Trending Topic', 'Post Type Singular Name', 'textdomain'),
        'menu_name' => __('Trending Topics', 'textdomain'),
        'name_admin_bar' => __('Trending Topic', 'textdomain'),
        'archives' => __('Item Archives', 'textdomain'),
        'attributes' => __('Item Attributes', 'textdomain'),
        'parent_item_colon' => __('Parent Item:', 'textdomain'),
        'all_items' => __('All Items', 'textdomain'),
        'add_new_item' => __('Add New Item', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'new_item' => __('New Item', 'textdomain'),
        'edit_item' => __('Edit Item', 'textdomain'),
        'update_item' => __('Update Item', 'textdomain'),
        'view_item' => __('View Item', 'textdomain'),
        'view_items' => __('View Items', 'textdomain'),
        'search_items' => __('Search Item', 'textdomain'),
        'not_found' => __('Not found', 'textdomain'),
        'not_found_in_trash' => __('Not found in Trash', 'textdomain'),
        'featured_image' => __('Featured Image', 'textdomain'),
        'set_featured_image' => __('Set featured image', 'textdomain'),
        'remove_featured_image' => __('Remove featured image', 'textdomain'),
        'use_featured_image' => __('Use as featured image', 'textdomain'),
        'insert_into_item' => __('Insert into item', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'textdomain'),
        'items_list' => __('Items list', 'textdomain'),
        'items_list_navigation' => __('Items list navigation', 'textdomain'),
        'filter_items_list' => __('Filter items list', 'textdomain'),
    );
    $args = array(
        'label' => __('Trending Topic', 'textdomain'),
        'description' => __('Post Type for Trending Topics', 'textdomain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
        'taxonomies' => array('category', 'post_tag'), // Adicionando categorias e tags padrão
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true, // Suport Editor Gutenberg
        'menu_icon' => 'dashicons-format-aside',

    );
    register_post_type('trending_topics', $args);
}
add_action('init', 'create_trending_topics_cpt', 0);

// Custom Post Type Featured Stories
function create_featured_stories_cpt()
{
    $labels = array(
        'name' => _x('Featured Stories', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('Featured Story', 'Post Type Singular Name', 'textdomain'),
        'menu_name' => __('Featured Stories', 'textdomain'),
        'name_admin_bar' => __('Featured Story', 'textdomain'),
        'archives' => __('Item Archives', 'textdomain'),
        'attributes' => __('Item Attributes', 'textdomain'),
        'parent_item_colon' => __('Parent Item:', 'textdomain'),
        'all_items' => __('All Items', 'textdomain'),
        'add_new_item' => __('Add New Item', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'new_item' => __('New Item', 'textdomain'),
        'edit_item' => __('Edit Item', 'textdomain'),
        'update_item' => __('Update Item', 'textdomain'),
        'view_item' => __('View Item', 'textdomain'),
        'view_items' => __('View Items', 'textdomain'),
        'search_items' => __('Search Item', 'textdomain'),
        'not_found' => __('Not found', 'textdomain'),
        'not_found_in_trash' => __('Not found in Trash', 'textdomain'),
        'featured_image' => __('Featured Image', 'textdomain'),
        'set_featured_image' => __('Set featured image', 'textdomain'),
        'remove_featured_image' => __('Remove featured image', 'textdomain'),
        'use_featured_image' => __('Use as featured image', 'textdomain'),
        'insert_into_item' => __('Insert into item', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'textdomain'),
        'items_list' => __('Items list', 'textdomain'),
        'items_list_navigation' => __('Items list navigation', 'textdomain'),
        'filter_items_list' => __('Filter items list', 'textdomain'),
    );
    $args = array(
        'label' => __('Featured Story', 'textdomain'),
        'description' => __('Post Type for Featured Stories', 'textdomain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
        'taxonomies' => array('category', 'post_tag'), // Adicionando categorias e tags padrão
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true, // Suport Editor Gutenberg
        'menu_icon' => 'dashicons-star-filled',
    );
    register_post_type('featured_stories', $args);
}
add_action('init', 'create_featured_stories_cpt', 0);

// Custom Post Type Dimensions
function create_dimensions_cpt()
{
    $labels = array(
        'name' => _x('Dimensions', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('Dimension', 'Post Type Singular Name', 'textdomain'),
        'menu_name' => __('Dimensions', 'textdomain'),
        'name_admin_bar' => __('Dimension', 'textdomain'),
        'archives' => __('Dimension Archives', 'textdomain'),
        'attributes' => __('Dimension Attributes', 'textdomain'),
        'parent_item_colon' => __('Parent Dimension:', 'textdomain'),
        'all_items' => __('All Dimensions', 'textdomain'),
        'add_new_item' => __('Add New Dimension', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'new_item' => __('New Dimension', 'textdomain'),
        'edit_item' => __('Edit Dimension', 'textdomain'),
        'update_item' => __('Update Dimension', 'textdomain'),
        'view_item' => __('View Dimension', 'textdomain'),
        'view_items' => __('View Dimensions', 'textdomain'),
        'search_items' => __('Search Dimension', 'textdomain'),
        'not_found' => __('Not found', 'textdomain'),
        'not_found_in_trash' => __('Not found in Trash', 'textdomain'),
        'featured_image' => __('Featured Image', 'textdomain'),
        'set_featured_image' => __('Set featured image', 'textdomain'),
        'remove_featured_image' => __('Remove featured image', 'textdomain'),
        'use_featured_image' => __('Use as featured image', 'textdomain'),
        'insert_into_item' => __('Insert into dimension', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this dimension', 'textdomain'),
        'items_list' => __('Dimensions list', 'textdomain'),
        'items_list_navigation' => __('Dimensions list navigation', 'textdomain'),
        'filter_items_list' => __('Filter dimensions list', 'textdomain'),
    );
    $args = array(
        'label' => __('Dimension', 'textdomain'),
        'description' => __('Post Type for Dimensions', 'textdomain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
        'taxonomies' => array('category', 'post_tag'), // Adicionando categorias e tags padrão
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true, // Suport Editor Gutenberg
        'menu_icon' => 'dashicons-chart-bar',
    );
    register_post_type('dimensions', $args);
}
add_action('init', 'create_dimensions_cpt', 0);






function create_navegation_cpt()
{
    $labels = array(
        'name' => _x('Navegations', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('Navegation', 'Post Type Singular Name', 'textdomain'),
        'menu_name' => __('Navegations', 'textdomain'),
        'name_admin_bar' => __('Navegation', 'textdomain'),
        'archives' => __('Item Archives', 'textdomain'),
        'attributes' => __('Item Attributes', 'textdomain'),
        'parent_item_colon' => __('Parent Item:', 'textdomain'),
        'all_items' => __('All Items', 'textdomain'),
        'add_new_item' => __('Add New Item', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'new_item' => __('New Item', 'textdomain'),
        'edit_item' => __('Edit Item', 'textdomain'),
        'update_item' => __('Update Item', 'textdomain'),
        'view_item' => __('View Item', 'textdomain'),
        'view_items' => __('View Items', 'textdomain'),
        'search_items' => __('Search Item', 'textdomain'),
        'not_found' => __('Not found', 'textdomain'),
        'not_found_in_trash' => __('Not found in Trash', 'textdomain'),
        'featured_image' => __('Featured Image', 'textdomain'),
        'set_featured_image' => __('Set featured image', 'textdomain'),
        'remove_featured_image' => __('Remove featured image', 'textdomain'),
        'use_featured_image' => __('Use as featured image', 'textdomain'),
        'insert_into_item' => __('Insert into item', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'textdomain'),
        'items_list' => __('Items list', 'textdomain'),
        'items_list_navigation' => __('Items list navigation', 'textdomain'),
        'filter_items_list' => __('Filter items list', 'textdomain'),
    );
    $args = array(
        'label' => __('Navegation', 'textdomain'),
        'description' => __('Post Type for Navegations', 'textdomain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats'),
        'taxonomies' => array('category', 'post_tag'), // Adicionando categorias e tags padrão
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true, // Suport Editor Gutenberg
        'menu_icon' => 'dashicons-admin-site-alt3',

    );
    register_post_type('navegation', $args);
}
add_action('init', 'create_navegation_cpt', 0);



function create_videos_cpt()
{
    $labels = array(
        'name' => _x('Videos', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('Videos', 'Post Type Singular Name', 'textdomain'),
        'menu_name' => __('Videos', 'textdomain'),
        'name_admin_bar' => __('Videos', 'textdomain'),
        'archives' => __('Item Archives', 'textdomain'),
        'attributes' => __('Item Attributes', 'textdomain'),
        'parent_item_colon' => __('Parent Item:', 'textdomain'),
        'all_items' => __('All Items', 'textdomain'),
        'add_new_item' => __('Add New Item', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'new_item' => __('New Item', 'textdomain'),
        'edit_item' => __('Edit Item', 'textdomain'),
        'update_item' => __('Update Item', 'textdomain'),
        'view_item' => __('View Item', 'textdomain'),
        'view_items' => __('View Items', 'textdomain'),
        'search_items' => __('Search Item', 'textdomain'),
        'not_found' => __('Not found', 'textdomain'),
        'not_found_in_trash' => __('Not found in Trash', 'textdomain'),
        'featured_image' => __('Featured Image', 'textdomain'),
        'set_featured_image' => __('Set featured image', 'textdomain'),
        'remove_featured_image' => __('Remove featured image', 'textdomain'),
        'use_featured_image' => __('Use as featured image', 'textdomain'),
        'insert_into_item' => __('Insert into item', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'textdomain'),
        'items_list' => __('Items list', 'textdomain'),
        'items_list_navigation' => __('Items list navigation', 'textdomain'),
        'filter_items_list' => __('Filter items list', 'textdomain'),
    );
    $args = array(
        'label' => __('Videos', 'textdomain'),
        'description' => __('Post Type for Videos', 'textdomain'),
        'labels' => $labels,
        'supports' => array('title', 'thumbnail', 'custom-fields', 'post-formats'),
        'taxonomies' => array('category', 'post_tag'), // Adicionando categorias e tags padrão
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true, // Suport Editor Gutenberg
        'menu_icon' => 'dashicons-video-alt3',

    );
    register_post_type('videos', $args);
}
add_action('init', 'create_videos_cpt', 0);



flush_rewrite_rules();
function custom_excerpt_length($length)
{
    return 20; // Substitua 100 pelo número de palavras que você deseja
}
add_filter('excerpt_length', 'custom_excerpt_length');

//support custom images
function custom_image_sizes()
{
    add_image_size('bg-header', 1600, 990, true);
    add_image_size('news', 290, 150, true);
    add_image_size('stories-lg', 900, 500, true);
    add_image_size('stories-sm', 400, 250, true);
}
add_action('after_setup_theme', 'custom_image_sizes');
function custom_sizes($sizes)
{
    return array_merge($sizes, array(
        'bg-header' => __('BG Header 1600x990'),
        'news' => __('News 290x150'),
        'stories-lg' => __('Stories Large 900x500'),
        'stories-sm' => __('Stories Small 400x250'),
    ));
}
add_filter('image_size_names_choose', 'custom_sizes');



?>