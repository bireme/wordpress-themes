<?php

load_theme_textdomain('refnet', get_stylesheet_directory() . '/languages');

function my_theme_localized( $locale )
{
        if ( isset( $_GET['l'] ) )
        {
		$locale = esc_attr( $_GET['l'] );
        }
        return $locale;
}
add_filter( 'locale', 'my_theme_localized' );

function translate_custom_field_key ($meta_key) {
//add cases according to your own needs

        switch ($meta_key) {

                case "status":
                        $meta_key_translated = __('Status','refnet');
                        break;
                case "responsible":
                        $meta_key_translated = __('Responsable','refnet');
                        break;
                case "description_of_the_search":
                        $meta_key_translated = __('Description of the search','refnet');
                        break;
                case "deadlines":
                        $meta_key_translated = __('Deadlines','refnet');
                        break;
                case "main_subject_of_the_search":
                        $meta_key_translated = __('Main subject of the search','refnet');
                        break;
                case "secondary_subject_of_the_search":
                        $meta_key_translated = __('Secondary subject of the search','refnet');
                        break;
                case "other_secondary_subject_of_the_search":
                        $meta_key_translated = __('Other secondary subject of the search','refnet');
                        break;
                case "vhls_databases":
                        $meta_key_translated = __('VHL Databases','refnet');
                        break;
                case "other_vhls_databases":
                        $meta_key_translated = __('Other VHL Databases','refnet');
                        break;
                case "other_databases":
                        $meta_key_translated = __('Other Databases','refnet');
                        break;
                case "more_other_databases":
                        $meta_key_translated = __('More Other Databases','refnet');
                        break;
                case "publication_year":
                        $meta_key_translated = __('Publication year','refnet');
                        break;
                case "country_or_region_of_publication":
                        $meta_key_translated = __('Country or Region of publication','refnet');
                        break;
                case "country_or_region_as_subject":
                        $meta_key_translated = __('Country or Region as subject','refnet');
                        break;
                case "text_language":
                        $meta_key_translated = __('Text language','refnet');
                        break;
                case "other_text_language":
                        $meta_key_translated = __('Other Text language','refnet');
                        break;
                case "publication_type":
                        $meta_key_translated = __('Publication type','refnet');
                        break;
                case "other_publication_type":
                        $meta_key_translated = __('Other Publication type','refnet');
                        break;
                case "conditions":
                        $meta_key_translated = __('Conditions (gender, age etc)','refnet');
                        break;
                case "other_conditions":
                        $meta_key_translated = __('Other Conditions','refnet');
                        break;
                case "vhl_instance":
                        $meta_key_translated = __('VHL instance','refnet');
                        break;
                case "type_of_search_strategy":
                        $meta_key_translated = __('Type of search strategy','refnet');
                        break;
                case "lilacs_iah_search_expression":
                        $meta_key_translated = __('iAH Search Expression for LILACS','refnet');
                        break;
                case "lilacs_iahx_search_expression":
                        $meta_key_translated = __('iAHx Search Expression for LILACS','refnet');
                        break;
                case "lilacs_url_to_search_results":
                        $meta_key_translated = __('URL to Search Results for LILACS','refnet');
                        break;
                case "medline_iah_search_expression":
                        $meta_key_translated = __('iAH Search Expression for MEDLINE','refnet');
                        break;
                case "medline_iahx_search_expression":
                        $meta_key_translated = __('iAHx Search Expression for MEDLINE','refnet');
                        break;
                case "medline_url_to_search_results":
                        $meta_key_translated = __('URL to Search Results for MEDLINE','refnet');
                        break;
                case "cochrane_iah_search_expression":
                        $meta_key_translated = __('iAH Search Expression for COCHRANE','refnet');
                        break;
                case "cochrane_iahx_search_expression":
                        $meta_key_translated = __('iAHx Search Expression for COCHRANE','refnet');
                        break;
                case "cochrane_url_to_search_results":
                        $meta_key_translated = __('URL to Search Results for COCHRANE','refnet');
                        break;
                default:
                        $meta_key_translated = $meta_key;
                        break;

        }
        return $meta_key_translated;

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

global $site_lang;

if(is_plugin_active('multi-language-framework')) {
        $mlf_options = get_option('mlf_config');
        $current_language = get_bloginfo('language');
        $site_lang = substr($current_language, 0,2);
} else {
        $site_lang = my_theme_localized($locale);
}

function append_query_string() {
	global $site_lang;
	return add_query_arg("l", $site_lang, get_permalink());
}
add_filter('the_permalink','append_query_string');

function filter_add_query_vars($query_vars) {   
	$query_vars[] = 'filtersearch'; 
      	return $query_vars;
}
add_filter( 'query_vars', 'filter_add_query_vars' ); 

function create_bread_crumb($post_title){
	global $site_lang;

	$bread_crumb = '<div class="breadcrumb"> <a href="';
	if(is_plugin_active('multi-language-framework')) {
                $bread_crumb .= esc_url(home_url('/'.($site_lang)));
        } else {
                $bread_crumb .= esc_url(home_url('/?l='.($site_lang)));
        }
	$bread_crumb .= '" class="home">';
	$bread_crumb .= __('Home', 'refnet');
	$bread_crumb .= "</a> > " . trim($post_title) . "</div>";

	return $bread_crumb;
}

function create_language_list($current_lang){

	echo '<ul id="languages_list">';
	
	if ($_SERVER['REQUEST_URI'] == $_SERVER['REDIRECT_URL']) {
		$current_url = $_SERVER['REQUEST_URI'] . "?l=" . $current_lang;
	} else {
		$current_url = $_SERVER['REQUEST_URI'];
	}
	
	switch ($current_lang) {
		case "pt_BR":
			echo '<li><a href="' . preg_replace("/l=[a-zA-Z_]{5}/", "l=es_ES", $current_url)  . '">' . __('Espanol','refnet') . '</a></li>';
			echo '<li><a href="' . preg_replace("/l=[a-zA-Z_]{5}/", "l=en_US", $current_url)  . '">' . __('English','refnet') . '</a></li>';
			break;
		case "es_ES":
			echo '<li><a href="' .  preg_replace("/l=[a-zA-Z_]{5}/", "l=pt_BR", $current_url) . '">' . __('Portugues','refnet') . '</a></li>';
			echo '<li><a href="' .  preg_replace("/l=[a-zA-Z_]{5}/", "l=en_US", $current_url) . '">' . __('English','refnet') . '</a></li>';
			break;
		case "en_US":
			echo '<li><a href="' .  preg_replace("/l=[a-zA-Z_]{5}/", "l=es_ES", $current_url) . '">' . __('Espanol','refnet') . '</a></li>';
			echo '<li><a href="' .  preg_replace("/l=[a-zA-Z_]{5}/", "l=pt_BR", $current_url) . '">' . __('Portugues','refnet') . '</a></li>';
			break;
	}

	echo '</ul>';
}
