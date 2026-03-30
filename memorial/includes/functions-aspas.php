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

/**
 * Registra o bloco ACF + campo de seleção
 */
add_action('acf/init', 'memorial_register_aspas_block_and_fields');
function memorial_register_aspas_block_and_fields()
{
    // Registra o bloco
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type([
            'name'            => 'aspas-slider',
            'title'           => 'Aspas Slider',
            'description'     => 'Exibe depoimentos (aspas) selecionados.',
            'render_template' => get_stylesheet_directory() . '/includes/home-aspas.php',
            'category'        => 'formatting',
            'icon'            => 'format-quote',
            'keywords'        => ['aspas', 'vozes', 'depoimento', 'slider'],
            'mode'            => 'preview',
            'supports'        => [
                'align' => true,
            ],
            'enqueue_assets'  => function () {
                wp_enqueue_style('bootstrap-block', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
                wp_enqueue_style('memorial-block-style', get_stylesheet_directory_uri() . '/css/style.css', ['bootstrap-block']);
            },
        ]);
    }

    // Registra o campo de seleção de aspas (bloco)
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group([
            'key'      => 'group_aspas_slider_block',
            'title'    => 'Aspas Slider - Configurações',
            'fields'   => [
                [
                    'key'           => 'field_aspas_selecionadas',
                    'label'         => 'Selecionar Aspas',
                    'name'          => 'aspas_selecionadas',
                    'type'          => 'relationship',
                    'instructions'  => 'Escolha quais depoimentos exibir. Se nenhum for selecionado, serão exibidos 3 aleatórios.',
                    'post_type'     => ['aspas'],
                    'filters'       => ['search'],
                    'return_format' => 'object',
                    'min'           => 0,
                    'max'           => '',
                ],
                [
                    'key'           => 'field_aspas_cor_icone',
                    'label'         => 'Cor das Aspas',
                    'name'          => 'cor_aspas',
                    'type'          => 'color_picker',
                    'instructions'  => 'Escolha a cor dos ícones de aspas nos cards.',
                    'default_value' => '#4e9a51',
                    'enable_opacity' => 0,
                ],
            ],
            'location' => [
                [
                    [
                        'param'    => 'block',
                        'operator' => '==',
                        'value'    => 'acf/aspas-slider',
                    ],
                ],
            ],
        ]);


    }
}