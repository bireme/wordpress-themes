<?php
/**
 * Custom post types.
 *
 * @package Observatorio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Banner custom post type.
 */
function observatorio_register_banner_post_type() {
	$labels = array(
		'name'               => __( 'Banners', 'observatorio' ),
		'singular_name'      => __( 'Banner', 'observatorio' ),
		'menu_name'          => __( 'Banners', 'observatorio' ),
		'name_admin_bar'     => __( 'Banner', 'observatorio' ),
		'add_new'            => __( 'Adicionar novo', 'observatorio' ),
		'add_new_item'       => __( 'Adicionar novo banner', 'observatorio' ),
		'new_item'           => __( 'Novo banner', 'observatorio' ),
		'edit_item'          => __( 'Editar banner', 'observatorio' ),
		'view_item'          => __( 'Ver banner', 'observatorio' ),
		'all_items'          => __( 'Todos os banners', 'observatorio' ),
		'search_items'       => __( 'Buscar banners', 'observatorio' ),
		'not_found'          => __( 'Nenhum banner encontrado.', 'observatorio' ),
		'not_found_in_trash' => __( 'Nenhum banner encontrado na lixeira.', 'observatorio' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-images-alt2',
		'supports'           => array( 'title', 'page-attributes' ),
		'has_archive'        => false,
		'rewrite'            => false,
		'query_var'          => false,
	);

	register_post_type( 'banner', $args );
}
add_action( 'init', 'observatorio_register_banner_post_type' );

/**
 * Register the thematic area custom post type.
 */
function observatorio_register_thematic_area_post_type() {
	$labels = array(
		'name'               => __( 'Áreas Temáticas', 'observatorio' ),
		'singular_name'      => __( 'Área Temática', 'observatorio' ),
		'menu_name'          => __( 'Áreas Temáticas', 'observatorio' ),
		'name_admin_bar'     => __( 'Área Temática', 'observatorio' ),
		'add_new'            => __( 'Adicionar nova', 'observatorio' ),
		'add_new_item'       => __( 'Adicionar nova área temática', 'observatorio' ),
		'new_item'           => __( 'Nova área temática', 'observatorio' ),
		'edit_item'          => __( 'Editar área temática', 'observatorio' ),
		'view_item'          => __( 'Ver área temática', 'observatorio' ),
		'all_items'          => __( 'Todas as áreas temáticas', 'observatorio' ),
		'search_items'       => __( 'Buscar áreas temáticas', 'observatorio' ),
		'not_found'          => __( 'Nenhuma área temática encontrada.', 'observatorio' ),
		'not_found_in_trash' => __( 'Nenhuma área temática encontrada na lixeira.', 'observatorio' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-category',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'has_archive'        => true,
		'rewrite'            => array(
			'slug'       => 'areas-tematicas',
			'with_front' => false,
		),
		'query_var'          => true,
		'menu_position'      => 21,
	);

	register_post_type( 'area_tematica', $args );
}
add_action( 'init', 'observatorio_register_thematic_area_post_type' );


/**
 * Register the thematic commission custom post type.
 */
function observatorio_register_thematic_commission_post_type() {
	$labels = array(
		'name'               => __( 'Comissões Temáticas', 'observatorio' ),
		'singular_name'      => __( 'Comissão Temática', 'observatorio' ),
		'menu_name'          => __( 'Comissões Temáticas', 'observatorio' ),
		'name_admin_bar'     => __( 'Comissão Temática', 'observatorio' ),
		'add_new'            => __( 'Adicionar nova', 'observatorio' ),
		'add_new_item'       => __( 'Adicionar nova comissão temática', 'observatorio' ),
		'new_item'           => __( 'Nova comissão temática', 'observatorio' ),
		'edit_item'          => __( 'Editar comissão temática', 'observatorio' ),
		'view_item'          => __( 'Ver comissão temática', 'observatorio' ),
		'all_items'          => __( 'Todas as comissões temáticas', 'observatorio' ),
		'search_items'       => __( 'Buscar comissões temáticas', 'observatorio' ),
		'not_found'          => __( 'Nenhuma comissão temática encontrada.', 'observatorio' ),
		'not_found_in_trash' => __( 'Nenhuma comissão temática encontrada na lixeira.', 'observatorio' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-groups',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'has_archive'        => true,
		'rewrite'            => array(
			'slug'       => 'comissoes-tematicas',
			'with_front' => false,
		),
		'query_var'          => true,
		'menu_position'      => 22,
	);

	register_post_type( 'comissao_tematica', $args );
}
add_action( 'init', 'observatorio_register_thematic_commission_post_type' );

/**
 * Register the event custom post type.
 */
function observatorio_register_event_post_type() {
	$labels = array(
		'name'               => __( 'Eventos', 'observatorio' ),
		'singular_name'      => __( 'Evento', 'observatorio' ),
		'menu_name'          => __( 'Eventos', 'observatorio' ),
		'name_admin_bar'     => __( 'Evento', 'observatorio' ),
		'add_new'            => __( 'Adicionar novo', 'observatorio' ),
		'add_new_item'       => __( 'Adicionar novo evento', 'observatorio' ),
		'new_item'           => __( 'Novo evento', 'observatorio' ),
		'edit_item'          => __( 'Editar evento', 'observatorio' ),
		'view_item'          => __( 'Ver evento', 'observatorio' ),
		'all_items'          => __( 'Todos os eventos', 'observatorio' ),
		'search_items'       => __( 'Buscar eventos', 'observatorio' ),
		'not_found'          => __( 'Nenhum evento encontrado.', 'observatorio' ),
		'not_found_in_trash' => __( 'Nenhum evento encontrado na lixeira.', 'observatorio' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-calendar-alt',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'has_archive'        => true,
		'rewrite'            => array(
			'slug'       => 'eventos',
			'with_front' => false,
		),
		'query_var'          => true,
		'menu_position'      => 23,
	);

	register_post_type( 'evento', $args );
}
add_action( 'init', 'observatorio_register_event_post_type' );

/**
 * Register the publication custom post type.
 */
function observatorio_register_publication_post_type() {
	$labels = array(
		'name'               => __( 'Publicações', 'observatorio' ),
		'singular_name'      => __( 'Publicação', 'observatorio' ),
		'menu_name'          => __( 'Publicações', 'observatorio' ),
		'name_admin_bar'     => __( 'Publicação', 'observatorio' ),
		'add_new'            => __( 'Adicionar nova', 'observatorio' ),
		'add_new_item'       => __( 'Adicionar nova publicação', 'observatorio' ),
		'new_item'           => __( 'Nova publicação', 'observatorio' ),
		'edit_item'          => __( 'Editar publicação', 'observatorio' ),
		'view_item'          => __( 'Ver publicação', 'observatorio' ),
		'all_items'          => __( 'Todas as publicações', 'observatorio' ),
		'search_items'       => __( 'Buscar publicações', 'observatorio' ),
		'not_found'          => __( 'Nenhuma publicação encontrada.', 'observatorio' ),
		'not_found_in_trash' => __( 'Nenhuma publicação encontrada na lixeira.', 'observatorio' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-media-document',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'has_archive'        => true,
		'rewrite'            => array(
			'slug'       => 'publicacoes',
			'with_front' => false,
		),
		'query_var'          => true,
		'menu_position'      => 24,
	);

	register_post_type( 'publicacao', $args );
}
add_action( 'init', 'observatorio_register_publication_post_type' );
