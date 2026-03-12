<?php
/**
 * Memorial - Aspas
 */
add_action('init', 'memorial_register_cpt_aspas');

function memorial_register_cpt_aspas(): void
{
    $labels = [
        'name'                  => 'Aspas',
        'singular_name'         => 'Aspa',
        'menu_name'             => 'Aspas',
        'name_admin_bar'        => 'Aspa',
        'add_new'               => 'Adicionar nova',
        'add_new_item'          => 'Adicionar nova aspa',
        'new_item'              => 'Nova aspa',
        'edit_item'             => 'Editar aspa',
        'view_item'             => 'Ver aspa',
        'all_items'             => 'Todas as aspas',
        'search_items'          => 'Pesquisar aspas',
        'not_found'             => 'Nenhuma aspa encontrada.',
        'not_found_in_trash'    => 'Nenhuma aspa encontrada na lixeira.',
        'featured_image'        => 'Imagem destacada',
        'set_featured_image'    => 'Definir imagem destacada',
        'remove_featured_image' => 'Remover imagem destacada',
        'use_featured_image'    => 'Usar como imagem destacada',
        'archives'              => 'Arquivos de aspas',
        'items_list'            => 'Lista de aspas',
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-format-quote',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'],
        'rewrite'             => [
            'slug'       => 'aspas',
            'with_front' => false,
        ],
        'has_archive'         => true,
        'hierarchical'        => false,
        'show_in_rest'        => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'query_var'           => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
    ];

    register_post_type('aspas', $args);
}