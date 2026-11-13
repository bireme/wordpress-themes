<?php
/**
 * ACF field groups.
 *
 * @package Observatorio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register local ACF fields for banners.
 */
function observatorio_register_banner_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_observatorio_banner',
			'title'    => __( 'Conteúdo do banner', 'observatorio' ),
			'fields'   => array(
				array(
					'key'          => 'field_observatorio_banner_kicker',
					'label'        => __( 'Chamada', 'observatorio' ),
					'name'         => 'banner_kicker',
					'type'         => 'text',
					'instructions' => __( 'Texto curto exibido acima do título. Ex.: Notícias, Evento, Destaque.', 'observatorio' ),
				),
				array(
					'key'          => 'field_observatorio_banner_description',
					'label'        => __( 'Descrição', 'observatorio' ),
					'name'         => 'banner_description',
					'type'         => 'textarea',
					'rows'         => 4,
					'new_lines'    => '',
				),
				array(
					'key'           => 'field_observatorio_banner_image',
					'label'         => __( 'Imagem', 'observatorio' ),
					'name'          => 'banner_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
					'required'      => 1,
				),
				array(
					'key'          => 'field_observatorio_banner_button',
					'label'        => __( 'Botão', 'observatorio' ),
					'name'         => 'banner_button',
					'type'         => 'link',
					'instructions' => __( 'Defina o texto, o destino e se o link deve abrir em nova aba.', 'observatorio' ),
					'return_format' => 'array',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'banner',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 1,
		)
	);
}
add_action( 'acf/init', 'observatorio_register_banner_acf_fields' );

/**
 * Register local ACF fields for news posts.
 */
function observatorio_register_news_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_observatorio_news',
			'title'  => __( 'Relacionamento da notícia', 'observatorio' ),
			'fields' => array(
				array(
					'key'           => 'field_observatorio_news_thematic_area',
					'label'         => __( 'Área Temática', 'observatorio' ),
					'name'          => 'news_thematic_area',
					'type'          => 'post_object',
					'instructions'  => __( 'Opcional. Relacione esta notícia a uma área temática do Observatório.', 'observatorio' ),
					'post_type'     => array( 'area_tematica' ),
					'post_status'   => array( 'publish' ),
					'return_format' => 'id',
					'ui'            => 1,
					'required'      => 0,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'post',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'side',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 1,
		)
	);
}
add_action( 'acf/init', 'observatorio_register_news_acf_fields' );

/**
 * Register local ACF fields for events.
 */
function observatorio_register_event_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_observatorio_event',
			'title'  => __( 'Detalhes do evento', 'observatorio' ),
			'fields' => array(
				array(
					'key'            => 'field_observatorio_event_start_date',
					'label'          => __( 'Data inicial', 'observatorio' ),
					'name'           => 'event_start_date',
					'type'           => 'date_picker',
					'display_format' => 'd/m/Y',
					'return_format'  => 'Ymd',
					'first_day'      => 1,
					'required'       => 1,
				),
				array(
					'key'            => 'field_observatorio_event_end_date',
					'label'          => __( 'Data final', 'observatorio' ),
					'name'           => 'event_end_date',
					'type'           => 'date_picker',
					'instructions'   => __( 'Preencha somente quando o evento ocorrer em mais de um dia.', 'observatorio' ),
					'display_format' => 'd/m/Y',
					'return_format'  => 'Ymd',
					'first_day'      => 1,
				),
				array(
					'key'          => 'field_observatorio_event_time',
					'label'        => __( 'Horário', 'observatorio' ),
					'name'         => 'event_time',
					'type'         => 'text',
					'instructions' => __( 'Ex.: 14h ou 14h às 17h.', 'observatorio' ),
				),
				array(
					'key'          => 'field_observatorio_event_format',
					'label'        => __( 'Tipo de evento', 'observatorio' ),
					'name'         => 'event_format',
					'type'         => 'text',
					'instructions' => __( 'Ex.: Oficina, Seminário, Reunião ou Lançamento.', 'observatorio' ),
				),
				array(
					'key'           => 'field_observatorio_event_mode',
					'label'         => __( 'Modalidade', 'observatorio' ),
					'name'          => 'event_mode',
					'type'          => 'select',
					'choices'       => array(
						'in_person' => __( 'Presencial', 'observatorio' ),
						'online'    => __( 'Online', 'observatorio' ),
						'hybrid'    => __( 'Híbrido', 'observatorio' ),
					),
					'allow_null'    => 1,
					'return_format' => 'label',
				),
				array(
					'key'   => 'field_observatorio_event_location',
					'label' => __( 'Local', 'observatorio' ),
					'name'  => 'event_location',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_observatorio_event_external_link',
					'label'         => __( 'Link externo', 'observatorio' ),
					'name'          => 'event_external_link',
					'type'          => 'link',
					'instructions'  => __( 'Opcional. Use para inscrição, transmissão ou página externa do evento.', 'observatorio' ),
					'return_format' => 'array',
				),
				array(
					'key'           => 'field_observatorio_event_thematic_area',
					'label'         => __( 'Área Temática', 'observatorio' ),
					'name'          => 'event_thematic_area',
					'type'          => 'post_object',
					'instructions'  => __( 'Opcional. Relacione o evento a uma área temática.', 'observatorio' ),
					'post_type'     => array( 'area_tematica' ),
					'post_status'   => array( 'publish' ),
					'return_format' => 'id',
					'ui'            => 1,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'evento',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 1,
		)
	);
}
add_action( 'acf/init', 'observatorio_register_event_acf_fields' );

/**
 * Register local ACF fields for publications.
 */
function observatorio_register_publication_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_observatorio_publication',
			'title'  => __( 'Detalhes da publicação', 'observatorio' ),
			'fields' => array(
				array(
					'key'   => 'field_observatorio_publication_type',
					'label' => __( 'Tipo de publicação', 'observatorio' ),
					'name'  => 'publication_type',
					'type'  => 'text',
					'instructions' => __( 'Ex.: Gestão e Saúde, Policy Brief, Relatório ou Nota Técnica.', 'observatorio' ),
				),
				array(
					'key'           => 'field_observatorio_publication_file',
					'label'         => __( 'Arquivo', 'observatorio' ),
					'name'          => 'publication_file',
					'type'          => 'file',
					'instructions'  => __( 'Opcional. Anexe o arquivo principal da publicação.', 'observatorio' ),
					'return_format' => 'array',
					'library'       => 'all',
				),
				array(
					'key'           => 'field_observatorio_publication_external_link',
					'label'         => __( 'Link externo', 'observatorio' ),
					'name'          => 'publication_external_link',
					'type'          => 'link',
					'instructions'  => __( 'Opcional. Use quando a publicação estiver hospedada em outro portal.', 'observatorio' ),
					'return_format' => 'array',
				),
				array(
					'key'           => 'field_observatorio_publication_thematic_area',
					'label'         => __( 'Área Temática', 'observatorio' ),
					'name'          => 'publication_thematic_area',
					'type'          => 'post_object',
					'instructions'  => __( 'Opcional. Relacione a publicação a uma área temática.', 'observatorio' ),
					'post_type'     => array( 'area_tematica' ),
					'post_status'   => array( 'publish' ),
					'return_format' => 'id',
					'ui'            => 1,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'publicacao',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 1,
		)
	);
}
add_action( 'acf/init', 'observatorio_register_publication_acf_fields' );

/**
 * Register the global theme settings page in ACF Pro.
 */
function observatorio_register_acf_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'Configurações do Observatório', 'observatorio' ),
			'menu_title' => __( 'Observatório', 'observatorio' ),
			'menu_slug'  => 'observatorio-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
			'position'   => 59,
			'icon_url'   => 'dashicons-admin-settings',
		)
	);
}
add_action( 'acf/init', 'observatorio_register_acf_options_page', 5 );

/**
 * Register global theme fields.
 */
function observatorio_register_global_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_observatorio_global_settings',
			'title'  => __( 'Configurações globais', 'observatorio' ),
			'fields' => array(
				// Editable Home section headings (no changes to existing content queries).
				array( 'key' => 'field_obs_home_headings_tab', 'label' => __( 'Conteúdos da Home', 'observatorio' ), 'type' => 'tab' ),
				array( 'key' => 'field_obs_home_publications_section', 'label' => 'Publicações', 'type' => 'message', 'message' => '<strong>Publicações</strong>' ),
				array( 'key' => 'field_obs_home_publications_kicker', 'label' => 'Chamada — Publicações', 'name' => 'home_publications_kicker', 'type' => 'text', 'default_value' => 'Conhecimento' ),
				array( 'key' => 'field_obs_home_publications_title', 'label' => 'Título — Publicações', 'name' => 'home_publications_title', 'type' => 'text', 'default_value' => 'Publicações' ),
				array( 'key' => 'field_obs_home_publications_description', 'label' => 'Descrição — Publicações', 'name' => 'home_publications_description', 'type' => 'text', 'default_value' => 'Policy briefs e materiais técnicos para apoiar decisões e políticas públicas.' ),
				array( 'key' => 'field_obs_home_thematic_areas_section', 'label' => 'Áreas Temáticas', 'type' => 'message', 'message' => '<strong>Áreas Temáticas</strong>' ),
				array( 'key' => 'field_obs_home_thematic_areas_title', 'label' => 'Título — Áreas Temáticas', 'name' => 'home_thematic_areas_title', 'type' => 'text', 'default_value' => 'Áreas temáticas' ),
				array( 'key' => 'field_obs_home_thematic_areas_description', 'label' => 'Descrição — Áreas Temáticas', 'name' => 'home_thematic_areas_description', 'type' => 'text', 'default_value' => 'Acesse conteúdos organizados nos eixos temáticos do Observatório.' ),
				array( 'key' => 'field_obs_home_news_section', 'label' => 'Notícias', 'type' => 'message', 'message' => '<strong>Notícias</strong>' ),
				array( 'key' => 'field_obs_home_news_kicker', 'label' => 'Chamada — Notícias', 'name' => 'home_news_kicker', 'type' => 'text', 'default_value' => 'Atualidades' ),
				array( 'key' => 'field_obs_home_news_title', 'label' => 'Título — Notícias', 'name' => 'home_news_title', 'type' => 'text', 'default_value' => 'Notícias' ),
				array( 'key' => 'field_obs_home_agenda_section', 'label' => 'Agenda', 'type' => 'message', 'message' => '<strong>Agenda</strong>' ),
				array( 'key' => 'field_obs_home_agenda_title', 'label' => 'Título — Agenda', 'name' => 'home_agenda_title', 'type' => 'text', 'default_value' => 'Agenda' ),
				array( 'key' => 'field_obs_home_preprint_section', 'label' => 'PrePrint', 'type' => 'message', 'message' => '<strong>PrePrint</strong>' ),
				array( 'key' => 'field_obs_home_preprint_title', 'label' => 'Título — PrePrint', 'name' => 'home_preprint_title', 'type' => 'text', 'default_value' => 'PrePrint' ),
				array( 'key' => 'field_obs_home_experience_reports_section', 'label' => 'Relatos de Experiência', 'type' => 'message', 'message' => '<strong>Relatos de Experiência</strong>' ),
				array( 'key' => 'field_obs_home_experience_reports_title', 'label' => 'Título — Relatos de Experiência', 'name' => 'home_experience_reports_title', 'type' => 'text', 'default_value' => 'Relatos de Experiência' ),
				array( 'key' => 'field_obs_home_partners_section', 'label' => 'Parceiros', 'type' => 'message', 'message' => '<strong>Parceiros</strong>' ),
				array( 'key' => 'field_obs_home_partners_kicker', 'label' => 'Chamada — Parceiros', 'name' => 'home_partners_kicker', 'type' => 'text', 'default_value' => 'Rede de colaboração' ),
				array( 'key' => 'field_obs_home_partners_title', 'label' => 'Título — Parceiros', 'name' => 'home_partners_title', 'type' => 'text', 'default_value' => 'Parceiros' ),

				array(
					'key' => 'field_observatorio_commissions_tab',
					'label' => __( 'Comissões Temáticas', 'observatorio' ),
					'type' => 'tab',
				),
				array(
					'key' => 'field_observatorio_commissions_kicker',
					'label' => __( 'Chamada', 'observatorio' ),
					'name' => 'commissions_kicker',
					'type' => 'text',
					'default_value' => 'Articulação e colaboração',
				),
				array(
					'key' => 'field_observatorio_commissions_title',
					'label' => __( 'Título', 'observatorio' ),
					'name' => 'commissions_title',
					'type' => 'text',
					'default_value' => 'Comissões Temáticas',
				),
				array(
					'key' => 'field_observatorio_commissions_description',
					'label' => __( 'Texto', 'observatorio' ),
					'name' => 'commissions_description',
					'type' => 'wysiwyg',
					'tabs' => 'visual',
					'toolbar' => 'basic',
					'media_upload' => 0,
				),
				array(
					'key' => 'field_observatorio_commissions_image',
					'label' => __( 'Imagem', 'observatorio' ),
					'name' => 'commissions_image',
					'type' => 'image',
					'return_format' => 'id',
					'preview_size' => 'medium',
				),
				array(
					'key'   => 'field_observatorio_preprint_tab',
					'label' => __( 'PrePrint', 'observatorio' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_observatorio_preprint_description',
					'label'         => __( 'Sobre o PrePrint', 'observatorio' ),
					'name'          => 'preprint_description',
					'type'          => 'wysiwyg',
					'instructions'  => __( 'Texto de apresentação exibido na seção PrePrint da Home.', 'observatorio' ),
					'tabs'          => 'visual',
					'toolbar'       => 'basic',
					'media_upload'  => 0,
					'delay'         => 0,
				),
				array(
					'key'           => 'field_observatorio_preprint_image',
					'label'         => __( 'Imagem de fundo do PrePrint', 'observatorio' ),
					'name'          => 'preprint_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'           => 'field_observatorio_preprint_button',
					'label'         => __( 'Botão do PrePrint', 'observatorio' ),
					'name'          => 'preprint_button',
					'type'          => 'link',
					'instructions'  => __( 'Defina o texto e o destino do botão exibido na seção PrePrint.', 'observatorio' ),
					'return_format' => 'array',
				),
				array(
					'key'   => 'field_observatorio_experience_reports_tab',
					'label' => __( 'Relatos de Experiência', 'observatorio' ),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_observatorio_experience_reports_description',
					'label'        => __( 'Sobre os Relatos de Experiência', 'observatorio' ),
					'name'         => 'experience_reports_description',
					'type'         => 'wysiwyg',
					'tabs'         => 'visual',
					'toolbar'      => 'basic',
					'media_upload' => 0,
				),
				array(
					'key'           => 'field_observatorio_experience_reports_image',
					'label'         => __( 'Imagem de fundo dos Relatos de Experiência', 'observatorio' ),
					'name'          => 'experience_reports_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'           => 'field_observatorio_experience_reports_button',
					'label'         => __( 'Botão dos Relatos de Experiência', 'observatorio' ),
					'name'          => 'experience_reports_button',
					'type'          => 'link',
					'return_format' => 'array',
				),
				array(
					'key'   => 'field_observatorio_partners_tab',
					'label' => __( 'Parceiros', 'observatorio' ),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_observatorio_partners',
					'label'        => __( 'Parceiros', 'observatorio' ),
					'name'         => 'partners',
					'type'         => 'repeater',
					'instructions' => __( 'Adicione os parceiros na ordem em que devem aparecer na Home.', 'observatorio' ),
					'layout'       => 'row',
					'button_label' => __( 'Adicionar parceiro', 'observatorio' ),
					'sub_fields'   => array(
						array(
							'key'      => 'field_observatorio_partner_name',
							'label'    => __( 'Nome', 'observatorio' ),
							'name'     => 'partner_name',
							'type'     => 'text',
							'required' => 1,
						),
						array(
							'key'           => 'field_observatorio_partner_logo',
							'label'         => __( 'Logo', 'observatorio' ),
							'name'          => 'partner_logo',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
							'required'      => 1,
						),
						array(
							'key'           => 'field_observatorio_partner_link',
							'label'         => __( 'Link', 'observatorio' ),
							'name'          => 'partner_link',
							'type'          => 'link',
							'return_format' => 'array',
						),
					),
				),
				array(
					'key'   => 'field_observatorio_footer_tab',
					'label' => __( 'Rodapé', 'observatorio' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_observatorio_footer_description',
					'label'         => __( 'Descrição do rodapé', 'observatorio' ),
					'name'          => 'footer_description',
					'type'          => 'textarea',
					'rows'          => 3,
					'new_lines'     => 'br',
				),
				array(
					'key'           => 'field_observatorio_footer_sus_logo',
					'label'         => __( 'Logo SUS', 'observatorio' ),
					'name'          => 'footer_sus_logo',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'           => 'field_observatorio_footer_bireme_logo',
					'label'         => __( 'Logo BIREME', 'observatorio' ),
					'name'          => 'footer_bireme_logo',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'observatorio-settings',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 0,
		)
	);
}
add_action( 'acf/init', 'observatorio_register_global_acf_fields' );
