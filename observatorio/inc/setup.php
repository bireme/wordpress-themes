<?php
/**
 * Theme setup.
 *
 * @package Observatorio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function observatorio_theme_setup() {
	load_theme_textdomain( 'observatorio', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script',
		'style',
	) );

	register_nav_menus( array(
		'primary' => __( 'Menu principal', 'observatorio' ),
		'footer'  => __( 'Menu do rodapé', 'observatorio' ),
	) );
}
add_action( 'after_setup_theme', 'observatorio_theme_setup' );

/**
 * Add Bootstrap classes to the primary navigation.
 */
function observatorio_nav_menu_css_class( $classes, $menu_item, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$classes[] = 'nav-item';
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'observatorio_nav_menu_css_class', 10, 3 );

/**
 * Add Bootstrap link classes to the primary navigation.
 */
function observatorio_nav_menu_link_attributes( $atts, $menu_item, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$atts['class'] = trim( ( $atts['class'] ?? '' ) . ' nav-link' );
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'observatorio_nav_menu_link_attributes', 10, 3 );
