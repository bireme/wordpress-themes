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

	if ( isset( $_GET['s'] ) )
        {
		return add_query_arg(array('l' => $site_lang, 'se' => $_GET['s']), get_permalink());
        } else {
		return add_query_arg("l", $site_lang, get_permalink());
	}
}
add_filter('the_permalink','append_query_string');

function filter_add_query_vars($query_vars) {   
	$query_vars[] = 'filtersearch'; 
      	return $query_vars;
}
add_filter( 'query_vars', 'filter_add_query_vars' ); 

function append_l_menu_link($sorted_menu_items) {
	global $site_lang;
	foreach ($sorted_menu_items as $item) {
		$item->url = add_query_arg("l", $site_lang, $item->url);
	}
	return $sorted_menu_items;
}

add_filter('wp_nav_menu_objects', 'append_l_menu_link');

function extract_text_by_language_markup($text) {
//If the title or the text has language markup like [pt_BR][/pt_BR], this function recognizes the tag and returns the corresponding text. 
	global $site_lang;
	$pattern_start = '/\[' . $site_lang  . ']/';
	$pattern_end = '/\[\/' . $site_lang . ']/';

	if (preg_match($pattern_start, $text) && preg_match($pattern_end, $text)) {
		$extracted_text = explode("[/" . $site_lang . "]", $text);
		$extracted_text = explode("[" . $site_lang . "]", $extracted_text[0]);
		return $extracted_text[1];
	} else {
		$extracted_text = preg_split('/\[\/(pt_BR|en_US|es_ES)]/', $text);
		if (count($extracted_text) > 1) {
			$extracted_text = preg_split('/\[(pt_BR|en_US|es_ES)]/', $extracted_text[0]);
			return $extracted_text[1];
		} else {
			return $text;
		}
	}
}

add_filter('widget_text','extract_text_by_language_markup');
add_filter('widget_title','extract_text_by_language_markup');

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
	if ( isset($_GET['se']) and is_single()){
		$bread_crumb .= '</a> > <a href="' . site_url() . '?l=' . $site_lang . '&s=' . $_GET['se'] . '">' . __('Search Result','refnet');
	}
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

function bir_show_custom_field_translated($post_id, $key, $label="", $html4label="", $html4custom_field="", $single=true, $separator=",", $other=FALSE, $breakline=FALSE) {
/*
	$key - identification of the custom field
        Samples for $html4label and $html4custom_field. Keep always the strings "label" and "custom_field", because the function will replace them using regular expression.

        $html4label
                "<li>label</li>"
                "<dt>label</dt>"
        $html4custom_field
                "<li>custom_field</li>"
                "<dd>custom_field</dd>"
                "<p>custom_field</p>"

	$separator - character to delimiter a list of words
	$other - to know if a custom field value set as "Other" should be displayed ot replaced by other content
	$breakline - content with break line (/n) can be splited.
*/
        $customField = get_post_meta($post_id, $key, $single);

        if (is_array($customField) or trim($customField)!= "") {

        	if ($html4label != "")
                	$text2show = preg_replace("/label/", $label, $html4label);
                else
                        $text2show = $label;
	
		if (!is_array($customField) and preg_match("/\n/", $customField) and $breakline) {
			$customField = preg_split("/\n/", $customField);
		}

        	if (!is_array($customField)) {
                        if ($html4custom_field != "")
                                $text2show .= preg_replace("/custom_field/", bir_translate_custom_field_values($customField, $other), $html4custom_field);
                        else
                                $text2show .= bir_translate_custom_field_values($customField, $other);
                } else {
                	$count = count($customField);
	                $lastValue = end($customField);
        	        $text = "";
                	foreach ( $customField as $value) {
                        	$text .= bir_translate_custom_field_values(trim($value), $other);
	                        if ($value != $lastValue) $text .= $separator . " ";
        	        }
                	if ($html4custom_field != "")
	                        $text2show .= preg_replace("/custom_field/", $text, $html4custom_field);
        	        else
                	        $text2show .= $text;
	        }
	}
	return $text2show;
}

function bir_translate_custom_field_values($custom_field_value, $other=FALSE) {

	$custom_field_value_translated = "";

	switch ($custom_field_value) {
		// Case para o campo VHL's databases dp field group Databases
		case "MEDLINE":
			$custom_field_value_translated = __('MEDLINE','refnet');
			break;
		case "LILACS":
			$custom_field_value_translated = __('LILACS','refnet');
			break;
		case "CDSR - Cochrane Systematic Reviews Database":
			$custom_field_value_translated = __('CDSR - Cochrane Systematic Reviews Database','refnet');
			break;
		case "CENTRAL Controlled Clinical Trials":
			$custom_field_value_translated = __('CENTRAL Controlled Clinical Trials : CENTRAL Controlled Clinical Trials','refnet');
			break;
		case "DARE - Database of Abstracts of Review of Effects":
			$custom_field_value_translated = __('DARE - Database of Abstracts of Review of Effects','refnet');
			break;
		case "NHS Economic Evaluations Database":
			$custom_field_value_translated = __('NHS Economic Evaluations Database','refnet');
			break;
		case "HTA - Health Technology Assessment Database":
			$custom_field_value_translated = __('HTA - Health Technology Assessment Database','refnet');
			break;
		case "WHOLIS (WHO Library Database)":
			$custom_field_value_translated = __('WHOLIS (WHO Library Database)','refnet');
			break;
		case "PAHO (PAHO Library Database)":
			$custom_field_value_translated = __('PAHO (PAHO Library Database)','refnet');
			break;
		//Case para o campo Text Language do field group General Search Fielters
		case "English":
			$custom_field_value_translated = __('English','refnet');
			break;
		case "Spanish":
			$custom_field_value_translated = __('Spanish','refnet');
			break;
		case "Portuguese":
			$custom_field_value_translated = __('Portuguese','refnet');
			break;
		case "Any language":
			$custom_field_value_translated = __('Any language','refnet');
			break;
		//Case para o campo Publication Type do field group General Search Fielters
		case "Journal Article":
			$custom_field_value_translated = __('Journal Article','refnet');
			break;
		case "Grey literature (non conventional literature)":
			$custom_field_value_translated = __('Grey literature (non conventional literature)','refnet');
			break;
		case "Thesis":
			$custom_field_value_translated = __('Thesis','refnet');
			break;
		case "Book chapter":
			$custom_field_value_translated = __('Book chapter','refnet');
			break;
		//Case para o campo Limits do field group General Search Fielters
		case "Infant, newborn (birth to 1 month)":
			$custom_field_value_translated = __('Infant, newborn (birth to 1 month)','refnet');
			break;
		case "Infant (1 to 23 months)":
			$custom_field_value_translated = __('Infant (1 to 23 months)','refnet');
			break;
		case "Child, pre-school (2 to 5 years)":
			$custom_field_value_translated = __('Child, pre-school (2 to 5 years)','refnet');
			break;
		case "Child (6 to 12 years)":
			$custom_field_value_translated = __('Child (6 to 12 years)','refnet');
			break;
		case "Adolescent (13 to 18 years)":
			$custom_field_value_translated = __('Adolescent (13 to 18 years)','refnet');
			break;
		case "Adult (19 to 44 years)":
			$custom_field_value_translated = __('Adult (19 to 44 years)','refnet');
			break;
		case "Middle Age (45 to 64 years)":
			$custom_field_value_translated = __('Middle Age (45 to 64 years)','refnet');
			break;
		case "Aged (65 and older)":
			$custom_field_value_translated = __('Aged (65 and older)','refnet');
			break;
		case "Female":
			$custom_field_value_translated = __('Female','refnet');
			break;
		case "Male":
			$custom_field_value_translated = __('Male','refnet');
			break;
		case "Humans":
			$custom_field_value_translated = __('Humans','refnet');
			break;
		case "Animals":
			$custom_field_value_translated = __('Animals','refnet');
			break;
		//Case para o campo Type of search strategy do field group Search Strategy Scope
		case "None":
			$custom_field_value_translated = __('None','refnet');
			break;
		case "Regional themes":
			$custom_field_value_translated = __('Regional themes','refnet');
			break;
		case "National themes":
			$custom_field_value_translated = __('National themes','refnet');
			break;
		case "Reference queries/Clusters":
			$custom_field_value_translated = __('Reference queries/Clusters','refnet');
			break;
		case "Commemorative dates, Campaigns":
			$custom_field_value_translated = __('Commemorative dates, Campaigns','refnet');
			break;
		case "Other":
		case "Others":
			if ($other) {
				$custom_field_value_translated = __('Other','refnet');
			} else {
				$custom_field_value_translated = "other_to_replace";
			}
			break;
		default:
			$custom_field_value_translated = $custom_field_value;
			break;
	}
	return $custom_field_value_translated;
}
