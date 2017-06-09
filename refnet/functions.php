<?php

//load_theme_textdomain('refnet', get_stylesheet_directory() . '/languages');

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

load_textdomain('refnet', get_stylesheet_directory() . '/languages/' . $site_lang . '.mo');

function append_query_string() {
	global $site_lang;
	$query_args = array();
	
	$query_args["l"] = $site_lang;
	
	if ( isset( $_GET['s'] ) ) {
		$query_args["se"] = $_GET['s'];
	}

	if (is_category()) {
		global $ct_nm;
		$query_args["ct"] = $ct_nm;
	}

	if (is_page('lista-de-temas')) {
		$query_args["source"] = "bir-qsl";
	}

	return add_query_arg($query_args, get_permalink());

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

function extract_text_by_language_markup($text, $shortcode="") {
//If the title or the text has language markup like [pt_BR][/pt_BR], this function recognizes the tag and returns the corresponding text. 
	global $site_lang;

	if ( $shortcode == '' ){
		$language = $site_lang;
	} else {
		$language = $shortcode;
	}

	$pattern_start = '/\[' . $language  . ']/';
	$pattern_end = '/\[\/' . $language . ']/';

	if (preg_match($pattern_start, $text) && preg_match($pattern_end, $text)) {
		$extracted_text = explode("[/" . $language . "]", $text);
		$extracted_text = explode("[" . $language . "]", $extracted_text[0]);
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

function fix_wp_title($text) {
	$title = extract_text_by_language_markup($text);
	if (is_single() && $title != $text)
		return $title . " | ";
	else
		return $title;
}

function fix_permalink($ID){
	if ( 'acf' != get_post_type() ) {
		$short_codes = array ('pt_br', 'en_us', 'es_es');
		list($permalink, $post_name) = get_sample_permalink($ID, null, null);
		$original_slug = $post_name;

		if ( ! wp_is_post_revision( $post_id ) ){
			remove_action('save_post', 'fix_permalink');
			foreach ($short_codes as $sc) {
				$pos_sc = strpos($original_slug, $sc);
				if ($pos_sc === FALSE) {
					//avoid return 0 as a valid position
					$found_short_codes[] = 10000;
				} else {
					$found_short_codes[] = $pos_sc;
				}
			}
			if (array_sum($found_short_codes) < 30000) {
				array_multisort($found_short_codes, $short_codes);
				$extracted_text = explode($short_codes[0], $original_slug);
				$new_slug = $extracted_text[1];
			} else {
				$new_slug = $original_slug;
			}
			$update_slug = array (
				'ID'          => $ID,
				'post_name'   => $new_slug
			);
			wp_update_post($update_slug);
			add_action('save_post','fix_permalink');
		}
	}
}

function update_translated_title_fields($ID){

	if ( !wp_is_post_revision( $post_id ) ){
	 	remove_action('save_post', 'update_translated_title_fields');
		remove_filter('the_title','extract_text_by_language_markup');
	
		$title_with_shortcodes = get_the_title($ID);
		$titles['pt'] = trim(extract_text_by_language_markup($title_with_shortcodes, "pt_BR"));
		$titles['es'] = trim(extract_text_by_language_markup($title_with_shortcodes, "es_ES"));
		$titles['en'] = trim(extract_text_by_language_markup($title_with_shortcodes, "en_US"));
/*
		$no_empty_titles = array_filter($titles);
		$empty_titles = array_diff($titles, $no_empty_titles);

		if ($empty_titles) {
			foreach ($empty_titles as $et) {
				$titles[key($et)] = $no_empty_titles[0];
			}
		}		
*/		
		update_post_meta($ID, 'title_pt', $titles['pt']);
		update_post_meta($ID, 'title_es', $titles['es']);
		update_post_meta($ID, 'title_en', $titles['en']);
		
                add_action('save_post','update_translated_title_fields');
		add_filter('the_title','extract_text_by_language_markup');
	}
	
}

function update_translated_categories($ID) {
	
	if (!wp_is_post_revision($post_id)){
		remove_action('save_post', 'update_translated_title_fields');
		remove_filter('the_category','extract_text_by_language_markup');
		
		$categories = get_the_category($ID);
		if ($categories){
			foreach ($categories as $cat) {
				$category['pt'] .= trim(extract_text_by_language_markup($cat->name, "pt_BR"));
				$category['es'] .= trim(extract_text_by_language_markup($cat->name, "es_ES"));
				$category['en'] .= trim(extract_text_by_language_markup($cat->name, "en_US"));
				if (end($categories) != $cat) {
					$category['pt'] .= ", ";	                                	
					$category['es'] .= ", ";	                                	
					$category['en'] .= ", ";	                                	
                                }
			}
			update_post_meta($ID, 'category_pt', $category['pt']);
			update_post_meta($ID, 'category_es', $category['es']);
			update_post_meta($ID, 'category_en', $category['en']);
		} else {
			update_post_meta($ID, 'category_pt', '');
			update_post_meta($ID, 'category_es', '');
			update_post_meta($ID, 'category_en', '');
		}

		add_action('save_post','update_translated_title_fields');
		add_filter('the_category','extract_text_by_language_markup');
	}

}

function update_translated_vhl_instance($ID) {
	
	if (!wp_is_post_revision($post_id)){
		remove_action('save_post', 'update_translated_title_fields');
		remove_filter('the_category','extract_text_by_language_markup');
		
		$vhl_instance_with_shortcodes = get_post_meta($ID, "vhl_instance", TRUE);
		$vhl_instance_with_shortcodes = strip_tags($vhl_instance_with_shortcodes);
		$vhl_instance['pt'] = trim(extract_text_by_language_markup($vhl_instance_with_shortcodes, "pt_BR"));
		$vhl_instance['es'] = trim(extract_text_by_language_markup($vhl_instance_with_shortcodes, "es_ES"));
		$vhl_instance['en'] = trim(extract_text_by_language_markup($vhl_instance_with_shortcodes, "en_US"));
		
		update_post_meta($ID, 'vhl_instance_pt', $vhl_instance['pt']);
		update_post_meta($ID, 'vhl_instance_es', $vhl_instance['es']);
		update_post_meta($ID, 'vhl_instance_en', $vhl_instance['en']);

		add_action('save_post','update_translated_title_fields');
		add_filter('the_category','extract_text_by_language_markup');
	}
}

function append_language_category_link ($categories){
	global $site_lang;

	preg_match_all('/http\S+/', $categories, $matches);

	foreach ($matches[0] as $mt) {
		$new_url = str_replace('"', '', $mt) . "?l=" . $site_lang;
		$categories = str_replace($mt, $new_url . '"', $categories);
	}

	return $categories;
}

function translate_categories_edit_post($categories){

	if (is_array($categories)) {
		foreach ($categories as $cat) {
			if (isset($cat->name)) { //when the term is parent
				$cat->name = extract_text_by_language_markup($cat->name);
				$translated_categories[] = $cat;
			}
		}
	} else {
		$translated_categories = extract_text_by_language_markup($categories);
	}
	return $translated_categories;
}

function translate_term_name($term){
	return extract_text_by_language_markup($term);
}

function fix_taxonomy_slug($slug){
	echo '<script type="text/javascript">
		function createSlug() {
			var tagName = jQuery("#tag-name").val();
			var extractedSlug = tagName.split(/\[\/(pt_BR|en_US|es_ES)]/);
			if (extractedSlug.length > 1) {
				var newSlug = extractedSlug[0].split(/\[(pt_BR|en_US|es_ES)]/);
				return newSlug[2];
			} else {
				return tagName;
			}
		}

	
		jQuery("#tag-slug").focus(
			function() { 
				jQuery("#tag-slug").val(createSlug());	
			}

		);
		</script>';
}

add_filter('widget_text','extract_text_by_language_markup');
add_filter('widget_title','extract_text_by_language_markup');
add_filter('the_title','extract_text_by_language_markup');
add_filter('wp_title','fix_wp_title');
add_action('save_post','fix_permalink');
add_action('save_post','update_translated_title_fields');
add_action('save_post','update_translated_categories');
add_action('save_post','update_translated_vhl_instance');
add_filter('wp_list_categories','append_language_category_link');
add_filter('the_category','extract_text_by_language_markup');

if (preg_match('/admin-ajax.php/', $_SERVER['PHP_SELF']) == false){
	add_filter('get_terms','translate_categories_edit_post');
}

add_filter('term_name', 'translate_term_name');

if (preg_match('/edit-tags.php/', $_SERVER['PHP_SELF']) && ($_GET['action'] != 'edit')) {
	add_action('edit_category_form', 'fix_taxonomy_slug');
}

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
	if ( isset($_GET['ct']) and is_single()){
		$bread_crumb .= '</a> > <a href="' . site_url() . '/category/' . $_GET['ct'] . '/' . '?l=' . $site_lang . '">' . __('Category Result','refnet');
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
		case "In review":
			$custom_field_value_translated = __('In review','refnet');
			break;
		case "Reviewed":
			$custom_field_value_translated = __('Reviewed','refnet');
			break;
		default:
			$custom_field_value_translated = $custom_field_value;
			break;
	}
	return extract_text_by_language_markup($custom_field_value_translated);
}

function bir_resolve_link_from_url_shortner($short_url) {

	$headers = get_headers($short_url);
    	$headers = array_reverse($headers);
	foreach($headers as $header) {
        	if (strpos($header, 'Location: ') === 0) {
		        $original_url = str_replace('Location: ', '', $header);
            		break;
        	}	
    	}
	if ($original_url) {
		return $original_url;
	} else {
		return $short_url;
	}

}

function bir_extract_url_iah_search_expression($id, $custom_field_name) {
	$url_to_search_result = trim(bir_show_custom_field_translated($id, $custom_field_name,"","","",TRUE,",",FALSE,FALSE));
        $url_to_search_result = str_replace("&", "&amp;", $url_to_search_result);

        $html = @simplexml_load_string("<html>" . $url_to_search_result . "</html>");
        
        if ($html) {
	        $link = @$html->xpath('//a');
                if ($link) {
        	        $href = $link[0]->attributes()->href;
                } else {
			$href = "";
                }
  	} else {
		$href = "";
       	}
	return str_replace("&amp;", "&", $href);
}

function bir_search_rss_html ($url_html, $url_rss, $button_type, $js_html="", $js_rss="") {

	$html_button = "";

	$url_rss = htmlspecialchars($url_rss, ENT_QUOTES, "UTF-8");
	$url_html = htmlspecialchars($url_html, ENT_QUOTES, "UTF-8");

	if (!$button_type) {
        	$html_button  = '<div class="vertical-tabs">';
       		$html_button .= '<span class="url_iahx">';
		if ($js_html) {
			$html_button .= '<a onclick="' . $js_html . '" ';
		} else {
			$html_button .= '<a target="_blank"';
		}
		$html_button .= "href='" . $url_html . "' " . 'title="' . __('See this search strategy applied on VHL Regional Portal', 'refnet') . '"></a></span>';
                $html_button .= '<span class="rss_feed">';
		if ($js_rss) {
			$html_button .= '<a onclick="' . $js_rss . '" ';
		} else {
			$html_button .= '<a target="_blank"';
		}
		$html_button .= "href='" . $url_rss . "' " . 'title="' . __('Keep up to date with RSS feed', 'refnet') . '"></a></span>';
                $html_button .= '</div>';
        } elseif ($button_type == "link"){
		if ($js_html) {
                        $html_button .= '<a onclick="' . $js_html . '" ';
                } else {
                        $html_button .= '<a target="_blank"';
                }
                $html_button .= "href='" . $url_html . "' " . 'title="' . __('See this search strategy applied on VHL Regional Portal', 'refnet') . '" class="link2vhl"><span>' . __('VHL', 'refnet')  . '</a>, ';
		if ($js_rss) {
                        $html_button .= '<a onclick="' . $js_rss . '" ';
                } else {
                        $html_button .= '<a target="_blank"';
                }
                $html_button .= "href='" . $url_rss . "' " . 'title="' . __('Keep up to date with RSS feed', 'refnet') . '" class="link2rss"><span>' . __('RSS', 'refnet') . '</a>';
        }

	return $html_button;
}

function bir_show_search_rss_buttons_iah($id, $custom_field_name, $button_type="") {
	// refatorar para incluir idioma
	// refatorar para incluir rss

	if (bir_has_no_empty_custom_field ($id, array($custom_field_name))) {
		$href = bir_extract_url_iah_search_expression($id, $custom_field_name);
		if (strlen(urlencode($href)) < 7500 and $href){
	        //strlen check because of 8k limit for GET method
			$url = "?redirect=" . $id . "&what=";
			echo bir_search_rss_html($url . "html", $url . "rss", $button_type);
                } else {
			echo "n/d";
		}	
	} else {
			echo "n/d";	
	}
	return $html_button;
}

function bir_show_search_rss_buttons($id, $custom_field_name, $button_type="") {

	global $site_lang;
	
	$iahx_service = "http://pesquisa.bvsalud.org/portal/";
	$iahx_other_params = "&from=0&sort=&format=summary&count=20&page=1";
	
	if (is_page('lista-de-temas')) {
		$iahx_other_params .= "&source=bir-qsl";	
	}

	if (is_single()) {
		if ($_GET["source"] == 'bir-qsl') {
			$iahx_other_params .= "&source=bir-ss-qsl";
		} else {
			$iahx_other_params .= "&source=bir-ss";
		}
	}

	$iahx_lang_param = "?lang=" . substr($site_lang, 0,2);
	$iahx_index_param = "&index=tw";
	$iahx_query_param = "&q=" . str_replace("&", "%26", trim(bir_show_custom_field_translated(get_the_ID(), $custom_field_name,"","","",TRUE,",",FALSE,FALSE)));
	$iahx_output_param = "&output=rss";
	$iahx_label_param = "&filterLabel=" . get_the_title($id);

	if (bir_has_no_empty_custom_field ($id, array($custom_field_name))) { 
		$iahx_regional_url = $iahx_service . $iahx_lang_param . $iahx_other_params . $iahx_query_param . $iahx_index_param . $iahx_label_param;
		if (strlen(urlencode($iahx_query_param)) < 7500){
		//strlen check because of 8k limit for GET method
			echo bir_search_rss_html($iahx_regional_url, $iahx_regional_url . $iahx_output_param, $button_type);
		} else {
			echo  '<form id="vhl_search" action="' . $iahx_service . '" method="POST" target="_blank">
					<input type="hidden" name="from" value="0"/>
					<input type="hidden" name="sort" value=""/>
					<input type="hidden" name="format" value="summary"/>
					<input type="hidden" name="count" value="20"/>
					<input type="hidden" name="page" value="1"/>
					<input type="hidden" name="lang" value="' . substr($site_lang, 0,2) . '"/>
					<input type="hidden" name="index" value="tw"/>
					<input type="hidden" name="filterLabel" value="'. get_the_title($id) . '"/>' .
					"<input type='hidden' name='q' value='". trim(bir_show_custom_field_translated(get_the_ID(), $custom_field_name,"","","",TRUE,",",FALSE,FALSE)) . "'/>";

			if (is_page('lista-de-temas')) {
				echo '<input type="hidden" name="source" value="bir-sql"/>';
        		}

        		if (is_single()) {
                		if ($_GET["source"] == 'bir-qsl') {
					echo '<input type="hidden" name="source" value="bir-ss-sql"/>';
                		} else {
					echo '<input type="hidden" name="source" value="bir-ss"/>';
               	 		}
        		}

			echo '</form>
			      <script type="text/javascript">
				function submitForm(output) {
					if (output == "rss") {
						var inputRSS = document.createElement("input");
						inputRSS.type = "hidden";
						inputRSS.name = "output";
						inputRSS.value = "rss";
						document.forms["vhl_search"].appendChild(inputRSS);
					}
					document.forms["vhl_search"].submit();
				}
			      </script>';
			echo bir_search_rss_html ("#", "#", $button_type, "javascript:submitForm();", "javascript:submitForm('rss');");
		}
	}

	return $html_button;
}

function custom_slug_box() {
    global $post;
    global $pagenow;
    $post_type = $_GET['post_type'];

    if (is_admin() &&  $post_type == 'search_strategy' && $pagenow == 'post-new.php' OR $pagenow == 'post.php') {
        echo "<script type='text/javascript'>
	            $ = jQuery;
	            $(document).ready(function() {
                    var selection;
                    $('#edit-slug-box').append('<div class=\"langbox\"><a href=\"#\" class=\"button button-small wrap-lang pt_BR\">pt_BR</a> <a href=\"#\" class=\"button button-small wrap-lang es_ES\">es_ES</a> <a href=\"#\" class=\"button button-small wrap-lang en_US\">en_US</a></div>');
                    $('.postbox textarea.textarea').after('<div class=\"langbox\"><a href=\"#\" class=\"button button-small wrap-lang pt_BR\">pt_BR</a> <a href=\"#\" class=\"button button-small wrap-lang es_ES\">es_ES</a> <a href=\"#\" class=\"button button-small wrap-lang en_US\">en_US</a></div>');
                    $('.wrap-lang').hover(function(){
                        selection = getSelectedText();
                        id = $(':focus').attr('id');
                        editorSelection = tinyMCE.activeEditor.selection.getContent();
                    });
	                $('.wrap-lang').click(function(){

                        if (editorSelection) {
                        	alert('AVISO: Em campos WYSIWYG, os shortcodes para idiomas devem ser inseridos manualmente.');
                        }

                        if (selection) {
	                        var element = $('#'+id);
	                        var start = element[0].selectionStart;
	                        var end = element[0].selectionEnd;

	                        if($(this).hasClass('pt_BR')){
	                            var replacement = '[pt_BR]' + selection + '[/pt_BR]';
	                        }
	                        if($(this).hasClass('es_ES')){
	                            var replacement = '[es_ES]' + selection + '[/es_ES]';
	                        }
	                        if($(this).hasClass('en_US')){
	                            var replacement = '[en_US]' + selection + '[/en_US]';
	                        }

	                        element.val(element.val().substring(0, start) + replacement + element.val().substring(end, element.val().length));
                        }

                        return false;

                        });
                        function getSelectedText(){
                            if(window.getSelection){
                                return window.getSelection().toString();
                            }
                            else if(document.getSelection){
                                return document.getSelection();
                            }
                            else if(document.selection){
                                return document.selection.createRange().text;
                            }
                        }
	            });
            </script>
            <style type='text/css'>.langbox { display: inline; }</style>
        ";
    }
}
add_action( 'admin_head', 'custom_slug_box'  );

if (is_admin())
{
	//add_action( 'sidebar_admin_setup', 'custom_widget_expand_control');
}

function custom_widget_expand_control()
{
	global $wp_registered_widgets, $wp_registered_widget_controls;

	foreach ( $wp_registered_widgets as $id => $widget )
	{
		$wp_registered_widget_controls[$id]['callback_redirect']=$wp_registered_widget_controls[$id]['callback'];
		$wp_registered_widget_controls[$id]['callback']='custom_widget_extra_control';
		array_push($wp_registered_widget_controls[$id]['params'],$id);	
	}

}

function custom_widget_extra_control()
{
	global $wp_registered_widget_controls, $wl_options;

	$params=func_get_args();
	$id=array_pop($params);

	$callback=$wp_registered_widget_controls[$id]['callback_redirect'];
	if (is_callable($callback))
		call_user_func_array($callback, $params);		
	
	$id_disp=$id;
	if (!empty($params) && isset($params[0]['number']))
	{	$number=$params[0]['number'];
		if ($number==-1) {$number="__i__";}
		$id_disp=$wp_registered_widget_controls[$id]['id_base'].'-'.$number;
	}

	echo "<p><label for='".$id_disp."-widget_logic'>". __('Widget logic:','widget-logic'). " <textarea class='widefat' type='text' name='".$id_disp."-widget_logic' id='".$id_disp."-widget_logic' ></textarea></label></p>";
}

function custom_parse_query($query) {
	if ( $query->is_category() ) {
		$query->set( 'post_type', 'search_strategy' );
	}
}
add_action( 'parse_query', 'custom_parse_query', 6 );
//add_action( 'pre_get_posts', 'custom_parse_query' );

function custom_scripts() {
	?>
	<script type='text/javascript'>
		$ = jQuery;
		$('.hide-optval select option:first').text('');
    </script>
	<?php
}
add_action( 'wp_footer', 'custom_scripts' );

function init_flush_rewrite_rules() {
    flush_rewrite_rules();
}
add_action( 'init', 'init_flush_rewrite_rules', 10 );

?>
