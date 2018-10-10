<?php
require_once('class-wp-bootstrap-navwalker.php');
function register_my_menu() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'register_my_menu' );
//Thumbnails
if ( function_exists( 'add_theme_support' ) ) { 
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)
    add_image_size( 'slider', 1250, 9999 ); //1250 pixels wide (and unlimited height)
    add_image_size( 'news', 380, 160, true ); 
    add_image_size( 'news_level_3', 380, 255, true ); 

    // additional image sizes
    // delete the next line if you do not need additional image sizes
    //add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
}
//SideBars
register_sidebar( array(
    'id'          => 'home_portal',
    'name'        => __( 'Home Portal', $text_domain ),
    'description' => __( 'Nessa área você personaliza a homepage do Portal.', $text_domain ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle no-display">',
	'after_title'   => '</h2>'
) );
register_sidebar( array(
    'id'          => 'footer',
    'name'        => __( 'Footer ou rodapé', $text_domain ),
    'description' => __( 'Nessa área você personaliza o rodapé da página.', $text_domain ),
	'before_widget' => '<div id="%1$s" class="widget %2$s col-lg-4">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle no-display">',
	'after_title'   => '</h2>'
) );

//slider_home.php - Arquivo com a rotina do slider
require_once('slider_home.php');

//home-news level 2
require_once('home_news.php');

//home-news level 3
require_once('home_newslevel3.php');

?>