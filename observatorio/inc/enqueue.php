<?php
/**
 * Theme assets.
 *
 * @package Observatorio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function observatorio_enqueue_assets() {
	$theme = wp_get_theme();

	wp_enqueue_style(
		'observatorio-bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css',
		array(),
		'5.3.8'
	);

	wp_enqueue_style(
		'observatorio-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array( 'observatorio-bootstrap' ),
		$theme->get( 'Version' )
	);

	wp_enqueue_script(
		'observatorio-bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js',
		array(),
		'5.3.8',
		true
	);

	wp_enqueue_script(
		'observatorio-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array( 'observatorio-bootstrap' ),
		$theme->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'observatorio_enqueue_assets' );
