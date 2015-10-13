<?php

$settings = get_option( "wp_bvs_theme_settings");

// Retorna a linguagem atual do site
function vhl_get_language() {
	global $site_lang;

	return $site_lang;
}

// printa a URL do item LOGO (aba Cabeçalho)
function vhl_get_logo_image() {
	global $settings;
	return $settings['header']['logo-' . vhl_get_language() ];
}

// printa o link do item LOGO (aba Cabeçalho)
function vhl_get_logo_link() {
	global $settings;
	return $settings['header']['linkLogo-' . vhl_get_language() ];
}

// printa a URL do item BANNER (aba Cabeçalho)
function vhl_get_banner_image() {
	global $settings;
	return $settings['header']['banner-' . vhl_get_language() ];
}

// printa o link do item BANNER (aba Cabeçalho)
function vhl_get_banner_link() {
	global $settings;
	return $settings['header']['bannerLink-' . vhl_get_language() ];
}

// verifica se é para exibir o título no banner, ou a imagem
function vhl_show_title() {
	global $settings;
	return $settings['header']['title_view'];
}

// exibe true or false, dependendo do que foi marcado na opção Check to hide Header Menu (aba cabeçalho)
function vhl_get_show_header_menu() {
	global $settings;
	return $settings['header']['headerMenu'];	
}

// retorna o id da página de contato (aba Cabeçalho)
function vhl_get_contact_page() {
	global $settings;
	return $settings['header']['contactPage'];		
}

// retorna o bloco de extra header (aba Cabeçalho)
function vhl_get_extrahead() {
	global $settings;
	return stripslashes($settings['header']['extrahead']);
}

// função que carrega as cores dinâmicas, setadas no admin
function vhl_load_dynamic_colors() {
	global $settings;
	include get_stylesheet_directory() . "/dynamic_css.php";
}

// função que retorna o total de colunas (aba Disposição)
function vhl_get_total_columns() {
	global $settings;
	return $settings['layout']['total'];
}

// função que retorna o status da top sidebar (aba Disposição)
function vhl_get_top_auxiliary_sidebar_status() {
	global $settings;

	if($settings['layout']['top-sidebar'] == 'true') {
		return true;
	}
	return false;
}

// função que retorna o status da top sidebar (aba Disposição)
function vhl_get_footer_auxiliary_sidebar_status() {
	global $settings;

	if($settings['layout']['footer-sidebar'] == 'true') {
		return true;
	}
	return false;
}

// função que retorna uma cor, de acordo com o título da mesma (aba Cores)
function vhl_get_color($title) {
	global $settings;
	return $settings['colors'][$title];
}

// retorna a URL do item Imagem de fundo (aba Disposição)
function vhl_get_background_image() {
	global $settings;
	return $settings['layout']['background'];

}
// atalhos
function vhl_logo_image() { print vhl_get_logo_image(); } 
function vhl_logo_link() { print vhl_get_logo_link(); }
function vhl_banner_image() { print vhl_get_banner_image(); } 
function vhl_banner_link() { print vhl_get_banner_link(); }
function vhl_contact_page() { print vhl_get_contact_page(); }
function vhl_extrahead() { print vhl_get_extrahead(); }
function vhl_color($title) { print "#" . vhl_get_color($title); }
function vhl_background_image() { print vhl_get_background_image(); }

?>