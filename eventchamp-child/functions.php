<?php
    if ( ! function_exists('eventchamp_enqueue_styles') ) {
        function eventchamp_enqueue_styles() {
            wp_enqueue_style( 'eventchamp-style', get_template_directory_uri() . '/style.css' );
            wp_enqueue_style( 'eventchamp-child-style', get_stylesheet_directory_uri() . '/style.css' );
        }
        add_action( 'wp_enqueue_scripts', 'eventchamp_enqueue_styles' );
    }

    if ( ! function_exists('http_request_local') ) {
        function http_request_local( $args, $url ) {
            if ( preg_match('/xml|rss|feed/', $url) ) {
                $args['reject_unsafe_urls'] = false;
            }
            return $args;
        }
        add_filter( 'http_request_args', 'http_request_local', 5, 2 );
    }
?>
