<?php
    if ( ! function_exists('theme_enqueue_styles') ) {
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
    }

    if ( ! function_exists('https_request_local') ) {
        function https_request_local( $args, $url ) {
            if ( preg_match('/xml|rss|feed/', $url) ) {
                $args['reject_unsafe_urls'] = false;
            }
            return $args;
        }
        add_filter( 'http_request_args', 'https_request_local', 5, 2 );
    }
?>