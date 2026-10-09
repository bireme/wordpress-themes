<?php
/**
 * Campos do modo alternativo da single encontro-da-rede.
 * O layout atual continua sendo o padrão.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'acf/init', 'rede_bvs_register_encontro_livre_fields' );

add_filter( 'acf/the_field/allow_unsafe_html', 'rede_bvs_encontro_allow_unsafe_html', 10, 2 );

function rede_bvs_encontro_allow_unsafe_html( $allowed, $selector ) {
    if ( in_array( $selector, array( 'codigo_html', 'codigo_css' ), true ) ) {
        return true;
    }
    return $allowed;
}

function rede_bvs_register_encontro_livre_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    $quando_livre = array(
        array(
            array(
                'field'    => 'field_rede_bvs_encontro_modo',
                'operator' => '==',
                'value'    => 'livre',
            ),
        ),
    );

    acf_add_local_field_group( array(
        'key'                   => 'group_rede_bvs_encontro_modo',
        'title'                 => 'Modo de exibição do encontro',
        'fields'                => array(
            array(
                'key'           => 'field_rede_bvs_encontro_imagem_hero',
                'label'         => 'Imagem de fundo do cabeçalho',
                'name'          => 'imagem_fundo_hero',
                'type'          => 'image',
                'instructions'  => 'Fundo do banner com o título e a busca nesta página. Se ficar vazio, usa a imagem padrão.',
                'return_format' => 'url',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_rede_bvs_encontro_modo',
                'label'         => 'Como exibir o conteúdo',
                'name'          => 'modo_do_encontro',
                'type'          => 'radio',
                'instructions'  => 'O layout atual mantém introdução, próxima sessão e sessões anteriores. O conteúdo livre mantém só o cabeçalho (banner, título e busca) e monta a página com os blocos abaixo.',
                'choices'       => array(
                    'padrao' => 'Layout atual',
                    'livre'  => 'Conteúdo livre',
                ),
                'default_value' => 'padrao',
                'layout'        => 'horizontal',
                'return_format' => 'value',
            ),
            array(
                'key'               => 'field_rede_bvs_encontro_blocos',
                'label'             => 'Blocos do conteúdo livre',
                'name'              => 'blocos_do_encontro',
                'type'              => 'flexible_content',
                'instructions'      => 'Monte a página abaixo do cabeçalho. A ordem dos blocos é a ordem de exibição.',
                'button_label'      => 'Adicionar bloco',
                'conditional_logic' => $quando_livre,
                'layouts'           => array(
                    'layout_rede_bvs_encontro_texto' => array(
                        'key'        => 'layout_rede_bvs_encontro_texto',
                        'name'       => 'texto',
                        'label'      => 'Texto',
                        'display'    => 'block',
                        'sub_fields' => array(
                            array(
                                'key'   => 'field_rede_bvs_encontro_texto_titulo',
                                'label' => 'Título',
                                'name'  => 'titulo',
                                'type'  => 'text',
                            ),
                            array(
                                'key'          => 'field_rede_bvs_encontro_texto_conteudo',
                                'label'        => 'Texto',
                                'name'         => 'conteudo',
                                'type'         => 'wysiwyg',
                                'tabs'         => 'all',
                                'toolbar'      => 'full',
                                'media_upload' => 1,
                            ),
                            array(
                                'key'           => 'field_rede_bvs_encontro_texto_largura',
                                'label'         => 'Largura',
                                'name'          => 'largura',
                                'type'          => 'select',
                                'choices'       => array(
                                    'cheia'   => 'Largura da página',
                                    'estreita' => 'Coluna estreita',
                                ),
                                'default_value' => 'cheia',
                                'ui'            => 1,
                            ),
                        ),
                    ),
                    'layout_rede_bvs_encontro_imagem_texto' => array(
                        'key'        => 'layout_rede_bvs_encontro_imagem_texto',
                        'name'       => 'imagem_texto',
                        'label'      => 'Imagem e texto',
                        'display'    => 'block',
                        'sub_fields' => array(
                            array(
                                'key'           => 'field_rede_bvs_encontro_it_imagem',
                                'label'         => 'Imagem',
                                'name'          => 'imagem',
                                'type'          => 'image',
                                'return_format' => 'array',
                                'preview_size'  => 'medium',
                                'library'       => 'all',
                            ),
                            array(
                                'key'           => 'field_rede_bvs_encontro_it_posicao',
                                'label'         => 'Posição da imagem',
                                'name'          => 'posicao_imagem',
                                'type'          => 'select',
                                'choices'       => array(
                                    'esquerda' => 'Esquerda',
                                    'direita'  => 'Direita',
                                ),
                                'default_value' => 'esquerda',
                                'ui'            => 1,
                            ),
                            array(
                                'key'   => 'field_rede_bvs_encontro_it_titulo',
                                'label' => 'Título',
                                'name'  => 'titulo',
                                'type'  => 'text',
                            ),
                            array(
                                'key'          => 'field_rede_bvs_encontro_it_texto',
                                'label'        => 'Texto',
                                'name'         => 'texto',
                                'type'         => 'wysiwyg',
                                'tabs'         => 'all',
                                'toolbar'      => 'full',
                                'media_upload' => 1,
                            ),
                            array(
                                'key'           => 'field_rede_bvs_encontro_it_link',
                                'label'         => 'Link',
                                'name'          => 'link',
                                'type'          => 'link',
                                'return_format' => 'array',
                            ),
                        ),
                    ),
                    'layout_rede_bvs_encontro_cards' => array(
                        'key'        => 'layout_rede_bvs_encontro_cards',
                        'name'       => 'cards',
                        'label'      => 'Cards',
                        'display'    => 'block',
                        'sub_fields' => array(
                            array(
                                'key'   => 'field_rede_bvs_encontro_cards_titulo',
                                'label' => 'Título da seção',
                                'name'  => 'titulo',
                                'type'  => 'text',
                            ),
                            array(
                                'key'           => 'field_rede_bvs_encontro_cards_colunas',
                                'label'         => 'Colunas',
                                'name'          => 'colunas',
                                'type'          => 'select',
                                'choices'       => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',
                                ),
                                'default_value' => '3',
                                'ui'            => 1,
                            ),
                            array(
                                'key'          => 'field_rede_bvs_encontro_cards_itens',
                                'label'        => 'Cards',
                                'name'         => 'itens',
                                'type'         => 'repeater',
                                'layout'       => 'block',
                                'button_label' => 'Adicionar card',
                                'sub_fields'   => array(
                                    array(
                                        'key'           => 'field_rede_bvs_encontro_card_imagem',
                                        'label'         => 'Imagem',
                                        'name'          => 'imagem',
                                        'type'          => 'image',
                                        'return_format' => 'array',
                                        'preview_size'  => 'medium',
                                        'library'       => 'all',
                                    ),
                                    array(
                                        'key'   => 'field_rede_bvs_encontro_card_titulo',
                                        'label' => 'Título',
                                        'name'  => 'titulo',
                                        'type'  => 'text',
                                    ),
                                    array(
                                        'key'          => 'field_rede_bvs_encontro_card_texto',
                                        'label'        => 'Texto',
                                        'name'         => 'texto',
                                        'type'         => 'wysiwyg',
                                        'tabs'         => 'all',
                                        'toolbar'      => 'basic',
                                        'media_upload' => 0,
                                    ),
                                    array(
                                        'key'           => 'field_rede_bvs_encontro_card_link',
                                        'label'         => 'Link',
                                        'name'          => 'link',
                                        'type'          => 'link',
                                        'return_format' => 'array',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'layout_rede_bvs_encontro_dados' => array(
                        'key'        => 'layout_rede_bvs_encontro_dados',
                        'name'       => 'dados',
                        'label'      => 'Dados (rótulo e valor)',
                        'display'    => 'block',
                        'sub_fields' => array(
                            array(
                                'key'   => 'field_rede_bvs_encontro_dados_titulo',
                                'label' => 'Título da seção',
                                'name'  => 'titulo',
                                'type'  => 'text',
                            ),
                            array(
                                'key'          => 'field_rede_bvs_encontro_dados_linhas',
                                'label'        => 'Linhas',
                                'name'         => 'linhas',
                                'type'         => 'repeater',
                                'layout'       => 'table',
                                'button_label' => 'Adicionar linha',
                                'sub_fields'   => array(
                                    array(
                                        'key'   => 'field_rede_bvs_encontro_dados_rotulo',
                                        'label' => 'Rótulo',
                                        'name'  => 'rotulo',
                                        'type'  => 'text',
                                    ),
                                    array(
                                        'key'   => 'field_rede_bvs_encontro_dados_valor',
                                        'label' => 'Valor',
                                        'name'  => 'valor',
                                        'type'  => 'textarea',
                                        'rows'  => 3,
                                        'new_lines' => 'br',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'layout_rede_bvs_encontro_destaque' => array(
                        'key'        => 'layout_rede_bvs_encontro_destaque',
                        'name'       => 'destaque',
                        'label'      => 'Faixa de destaque',
                        'display'    => 'block',
                        'sub_fields' => array(
                            array(
                                'key'           => 'field_rede_bvs_encontro_dest_estilo',
                                'label'         => 'Estilo',
                                'name'          => 'estilo',
                                'type'          => 'select',
                                'choices'       => array(
                                    'escuro' => 'Azul escuro',
                                    'claro'  => 'Claro',
                                ),
                                'default_value' => 'escuro',
                                'ui'            => 1,
                            ),
                            array(
                                'key'   => 'field_rede_bvs_encontro_dest_titulo',
                                'label' => 'Título',
                                'name'  => 'titulo',
                                'type'  => 'text',
                            ),
                            array(
                                'key'          => 'field_rede_bvs_encontro_dest_texto',
                                'label'        => 'Texto',
                                'name'         => 'texto',
                                'type'         => 'wysiwyg',
                                'tabs'         => 'all',
                                'toolbar'      => 'basic',
                                'media_upload' => 0,
                            ),
                            array(
                                'key'           => 'field_rede_bvs_encontro_dest_link',
                                'label'         => 'Botão',
                                'name'          => 'link',
                                'type'          => 'link',
                                'return_format' => 'array',
                            ),
                        ),
                    ),
                    'layout_rede_bvs_encontro_midia' => array(
                        'key'        => 'layout_rede_bvs_encontro_midia',
                        'name'       => 'midia',
                        'label'      => 'Mídia ou HTML',
                        'display'    => 'block',
                        'sub_fields' => array(
                            array(
                                'key'   => 'field_rede_bvs_encontro_midia_titulo',
                                'label' => 'Título',
                                'name'  => 'titulo',
                                'type'  => 'text',
                            ),
                            array(
                                'key'          => 'field_rede_bvs_encontro_midia_conteudo',
                                'label'        => 'Conteúdo',
                                'name'         => 'conteudo',
                                'type'         => 'wysiwyg',
                                'instructions' => 'Vídeo, mapa, shortcode ou HTML.',
                                'tabs'         => 'all',
                                'toolbar'      => 'full',
                                'media_upload' => 1,
                            ),
                        ),
                    ),
                    'layout_rede_bvs_encontro_html' => array(
                        'key'        => 'layout_rede_bvs_encontro_html',
                        'name'       => 'html',
                        'label'      => 'HTML e CSS',
                        'display'    => 'block',
                        'sub_fields' => array(
                            array(
                                'key'          => 'field_rede_bvs_encontro_codigo_html',
                                'label'        => 'HTML',
                                'name'         => 'codigo_html',
                                'type'         => 'textarea',
                                'instructions' => 'Cole o HTML. Ele é renderizado como está, sem o editor visual.',
                                'rows'         => 14,
                                'new_lines'    => '',
                            ),
                            array(
                                'key'          => 'field_rede_bvs_encontro_codigo_css',
                                'label'        => 'CSS',
                                'name'         => 'codigo_css',
                                'type'         => 'textarea',
                                'instructions' => 'Cole só o CSS, sem a tag style. Vale para este bloco e para o restante da página.',
                                'rows'         => 10,
                                'new_lines'    => '',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'encontro-da-rede',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ) );
}
