<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */

$current_language = strtolower(get_bloginfo('language'));
$suffix = ( !defined( 'POLYLANG_VERSION' ) ) ? '_' . $current_language : '';
$sidebar_name = ( !defined( 'POLYLANG_VERSION' ) ) ? $current_language : '';

automatic_feed_links();

if ( function_exists('register_sidebar') ) {
   register_sidebar(
        array('name'=>'Menu 1 ' . $sidebar_name, 
            'id' => 'vhl_menu_1' . $suffix,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ));
   register_sidebar(
        array('name'=>'topSlot ' . $sidebar_name, 
            'id' => 'top_slot' . $suffix,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ));
   register_sidebar(
        array('name'=>'Search VHL ' . $sidebar_name, 
            'id' => 'search_vhl' . $suffix,
			'before_widget' => '<div id="%1$s" class="searchbox_block %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle"><span>',
            'after_title' => '</span></h2>',
        ));
   register_sidebar(
        array('name'=>'slider ' . $sidebar_name, 
            'id' => 'slider' . $suffix,
			'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="sliderTitle"><span>',
            'after_title' => '</span></h2>',
        ));
   register_sidebar(
        array('name'=>'Collections ' . $sidebar_name, 
            'id' => 'collection' . $suffix,
			'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="collectiontitle"><span>',
            'after_title' => '</span></h2>',
        ));
   register_sidebar(
        array('name'=>'Collections3 ' . $sidebar_name, 
            'id' => 'collection3' . $suffix,
			'before_widget' => '<div id="%1$s" class="%2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="collectiontitle"><span>',
            'after_title' => '</span></h2>',
        ));
   register_sidebar(
        array('name'=>'Footer ' . $sidebar_name, 
            'id' => 'vhl_footer' . $suffix,
            'description' => __('Rodapé', 'example'),
            'before_widget' => '<div id="%1$s" class="footer-block %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle"><span>',
            'after_title' => '</span></h2>',
        ));
   register_sidebar(
        array('name'=>'Institutions ' . $sidebar_name, 
            'id' => 'institutions' . $suffix,
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
}

function language_switcher() {
    if ( function_exists( 'pll_the_languages' ) ) {
        if ( $_SERVER['SCRIPT_NAME'] == '/php/bvsnet.php' ) {
            $slugs = pll_languages_list();
            $names = pll_languages_list(array('fields' => 'name'));
            $languages = array_combine($slugs, $names);

            echo "<ul>";
            foreach ($languages as $slug => $name) :
                if ($site_lang == $slug) continue;
                $url = str_replace('lang='.$site_lang, 'lang='.$slug, $_SERVER['REQUEST_URI']);
                ?>
                <li><a href="<?php echo $url; ?>"><?php echo $name; ?></a></li>
                <?php
            endforeach;
            echo "</ul>";
        } else {
            $args = array(
                'dropdown' => 0,
                'show_names' => 1,
                'display_names_as' => 'name',
                'show_flags' => 0,
                'hide_if_empty' => 1,
                'force_home' => 0,
                'echo' => 0,
                'hide_if_no_translation' => 0,
                'hide_current' => 1,
                'post_id' => null,
                'raw' => 0
            );

            echo '<ul>' . pll_the_languages( $args ) . '</ul>';
        }
    }
}

function http_request_local( $args, $url ) {
    if ( preg_match('/xml|rss|feed/', $url) ) {
        $args['reject_unsafe_urls'] = false;
    }

   return $args;
}
add_filter( 'http_request_args', 'http_request_local', 5, 2 );

?>
