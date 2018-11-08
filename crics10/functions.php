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

    function app_init() {

        if ( ! is_admin() && ! isset($_COOKIE['crics10']) && strpos($_SERVER['HTTP_USER_AGENT'], 'gonative') !== false ) {
            add_action( 'template_redirect', 'app_page' );
        }

    }
    add_action( 'init', 'app_init' );

    function app_page() {
        
        // generate app cookie
        setCookie( 'crics10', time(), 0, '/' );
        
        // force reload the page on hitting back button
        header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
        header('Pragma: no-cache'); // HTTP 1.0.
        header('Expires: 0'); // Proxies.

        // force status to 200 - OK
        status_header(200);
        
        // redirect to page and finish execution
        require_once( get_stylesheet_directory() . '/app.php' );
        exit();

    }

    function maybe_redirect($template) {

        if ( ! wp_get_referer() && isset($_COOKIE['crics10-home']) && strpos($_SERVER['HTTP_USER_AGENT'], 'gonative') !== false ) {
            if ( ! isset($_COOKIE['crics10-redirect']) ) {
                setCookie( 'crics10-redirect', time(), 0, '/' );
            }

            wp_redirect( $_COOKIE['crics10-home'] );
            exit();
        }

        return $template;

    }
    add_action( 'home_template', 'maybe_redirect' );

?>
