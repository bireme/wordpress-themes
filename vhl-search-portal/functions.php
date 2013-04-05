<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
$current_language = strtolower(get_bloginfo('language'));

automatic_feed_links();

if ( function_exists('register_sidebar') )
   register_sidebar(
        array('name'=>'Menu 1 ' . $current_language, 
            'id' => 'vhl_menu_1_' . $current_language,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ));
   register_sidebar(
        array('name'=>'topSlot ' . $current_language, 
            'id' => 'top_slot_' . $current_language,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ));
   register_sidebar(
        array('name'=>'Search VHL ' . $current_language, 
            'id' => 'search_vhl_' . $current_language,
			'before_widget' => '<div id="%1$s" class="searchbox_block %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle"><span>',
            'after_title' => '</span></h2>',
        ));
   register_sidebar(
        array('name'=>'slider ' . $current_language, 
            'id' => 'slider_' . $current_language,
			'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="sliderTitle"><span>',
            'after_title' => '</span></h2>',
        ));
   register_sidebar(
        array('name'=>'Collections ' . $current_language, 
            'id' => 'collection_' . $current_language,
			'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="collectiontitle"><span>',
            'after_title' => '</span></h2>',
        ));
   register_sidebar(
        array('name'=>'Collections3 ' . $current_language, 
            'id' => 'collection3_' . $current_language,
			'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="collectiontitle"><span>',
            'after_title' => '</span></h2>',
        ));
   register_sidebar(
        array('name'=>'Footer ' . $current_language, 
            'id' => 'vhl_footer_' . $current_language,
            'description' => __('Rodapé', 'example'),
            'before_widget' => '<div id="%1$s" class="footer-block %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle"><span>',
            'after_title' => '</span></h2>',
        ));
   register_sidebar(
        array('name'=>'Institutions ' . $current_language, 
            'id' => 'institutions_' . $current_language,
            'description' => __('Institutions', 'example'),
            'before_widget' => '<div id="%1$s" class="institutions-block %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle"><span>',
            'after_title' => '</span></h2>',
        ));
   
     if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
		set_post_thumbnail_size(200, 70, true);
        add_image_size('large_highlight', 580, 340, true);
        add_image_size('medium_highlight', 220, 130, true);
        add_image_size('small_highlight', 60, 40, true);
        add_image_size('icon', 16, 16, true);
	}
?>
