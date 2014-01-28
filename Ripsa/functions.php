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

function create_bread_crumb($post_title){
        global $site_lang;

        $bread_crumb = '<div class="breadcrumb"> <a href="';
        if(is_plugin_active('multi-language-framework')) {
                $bread_crumb .= esc_url(home_url('/'.($site_lang)));
        } else {
                $bread_crumb .= esc_url(home_url('/?l='.($site_lang)));
        }
        $bread_crumb .= '" class="home">';
	$bread_crumb .= __('Fichas de Qualificação da Ripsa', 'Ripsa');
        $bread_crumb .= '</a>';
	if (is_category()) {
		$category = get_the_category();
		$bread_crumb .= " > " . $category[0]->cat_name;
	}
        if ( is_single() ) {
		$category = get_the_category();
                $bread_crumb .= ' > <a href="' . site_url() . '/category/' . $category[0]->slug . '/' . '?l=' . $site_lang . '">' . $category[0]->cat_name . '</a>';
        	$bread_crumb .= " > " . trim($post_title);
        }
        $bread_crumb .= '</div>';
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



// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'my_mce_buttons_2');

// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'note',  
			'block' => 'div',  
			'classes' => 'notes',
			'wrapper' => true,
		),
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	return $init_array;  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );


?>
