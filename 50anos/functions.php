<?php
/**
 *
 *
 *
 */

/* Remove a barra de Administração, com isso remove também a margin de 32px que ele insere no html*/ 
add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

/**
 * Add a sidebar.
 */
function wpdocs_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Section01', 'textdomain' ),
        'id'            => 'section-1',
        'description'   => __( 'Widgets aparecem na Primeira sessão do HotSite - Recomenda-se colocar depoimentos | Títulos não aparecem!', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="col-lg-6 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="no-display">',
        'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name'          => __( 'Section02', 'textdomain' ),
        'id'            => 'section-2',
        'description'   => __( 'Widgets aparecem na Segunda sessão do HotSite - Cada Widget ocupa 50% da largura página', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="col-lg-6 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name'          => __( 'Section03', 'textdomain' ),
        'id'            => 'section-3',
        'description'   => __( 'Widgets aparecem na Terceira sessão do HotSite - Cada Widget ocupa 100% da largura da página', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="col-lg-12 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name'          => __( 'Section04', 'textdomain' ),
        'id'            => 'section-4',
        'description'   => __( 'Widgets aparecem na Quarta sessão do HotSite - Cada Widget ocupa 50% da largura da página', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="col-lg-6 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name'          => __( 'Section05', 'textdomain' ),
        'id'            => 'section-5',
        'description'   => __( 'Widgets aparecem na Quarta sessão do HotSite - Cada Widget ocupa 50% a largura da página', 'textdomain' ),
        'before_widget' => '<div id="%1$s" class="col-lg-6 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
	}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );

if ( function_exists( 'add_theme_support' ) ) { 
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 450, 250, true ); // default Post Thumbnail dimensions (cropped)

    // additional image sizes
    // delete the next line if you do not need additional image sizes
    add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
}
 ?>