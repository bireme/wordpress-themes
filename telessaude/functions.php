<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
$current_language = strtolower(get_bloginfo('language'));

automatic_feed_links();

if ( function_exists('register_sidebar') )
    register_sidebar(
        array('name'=>'Highlights ' .  $current_language,
            'id' => 'vhl_highlights_' . $current_language,
            'description' => __('Destaques', 'example'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle"><span>',
            'after_title' => '</span></h3>',
        ));
    register_sidebar(
        array('name'=>'Coluna 1 ' . $current_language, 
            'id' => 'vhl_column_1_' . $current_language,
            'description' => __('Rede de Conteúdos da BVS', 'example'),
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
        array('name'=>'Cases ' . $current_language, 
            'id' => 'vhl_cases_' . $current_language,
            'description' => __('Casos Destacados', 'example'),
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
		set_post_thumbnail_size(180, 120, true);
        add_image_size('large_highlight', 715, 180, true);
        add_image_size('medium_highlight', 220, 130, true);
        add_image_size('small_highlight', 60, 40, true);
        add_image_size('icon', 16, 16, true);
        add_image_size('cases', 180, 120, true);
        add_image_size('sidebar_highlight', 265, 160, true);
	}
add_filter( 'wp_feed_cache_transient_lifetime', create_function('$a', 'return 300;') );
?>
