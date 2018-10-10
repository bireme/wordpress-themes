<?php
    function theme_enqueue_styles() {

        $parent_style = 'parent-style';

        wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
        wp_enqueue_style( 'child-style',
            get_stylesheet_directory_uri() . '/style.css',
            array( $parent_style ),
            wp_get_theme()->get('Version')
        );

    }
    add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

    function app_page_init() {

        if ( ! is_admin() && ! $_COOKIE['crics10'] && strpos($_SERVER['HTTP_USER_AGENT'], 'gonative') !== false ) {
            add_action( 'template_redirect', 'app_page_redirect' );
        }

    }
    add_action( 'init', 'app_page_init' );

    function app_page_redirect() {

        setCookie( 'crics10', time(), 0, '/' );
        require_once( get_stylesheet_directory() . '/app.php' );
        exit();

    }
?>
