<?php
function eventchamp_enqueue_styles() {
    wp_enqueue_style( 'eventchamp-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'eventchamp-child-style', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'eventchamp_enqueue_styles' );