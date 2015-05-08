<?php
/**
 *
 * DEfinições específicas para BIREME
 *
 */
 /* Load up our theme options page and related code. */

include_once(ABSPATH.'wp-admin/includes/plugin.php');

$current_language = strtolower(get_bloginfo('language'));

if ($current_language != ''){
   $current_language = '_' . $current_language;
}

load_plugin_textdomain( 'vhl', false,  BVS_PLUGIN_DIR . '/languages' );

if ( is_admin() ) require_once( TEMPLATEPATH . '/bireme_archives/admin_settings.php' );

$settings = get_option( "wp_bvs_theme_settings" );
$layout = $settings['layout'];
$total_columns = $layout['total'];
$top_sidebar = $layout['top-sidebar'];
$footer_sidebar = $layout['footer-sidebar'];

//Set default variables related to current language when multi-language-framework is not installed
$variables_mlf = array (
			'header' => "header",
			'top_sidebar' => "top_sidebar",
			'footer_sidebar' => "footer_sidebar",
			'footer' => "footer",
			'level2' => "level2",
		);
if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
	foreach ($variables_mlf as $vmlf) {
		$variables_mlf [$vmlf] = $vmlf . $current_language;
	}
}

// sidebars do template
register_sidebar( array(
	'name' => __('Header','vhl'),
	//'id' => 'header' . $current_language,
	'id' => $variables_mlf['header'],
	'description' => '',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<strong class="widget-title">',
	'after_title' => '</strong>',
) );

//SideBar Auxiliar Top só aparece se ativado
if ($top_sidebar == true){
    register_sidebar( array(
	'name' => __('Top Auxiliary SideBar','vhl'),
	//'id' => 'top_sidebar' . $current_language,
	'id' => $variables_mlf['top_sidebar'],
	'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );
}

// gerando as sidebars dinamicamente
for($i=1; $i <= $total_columns; $i++) {
    $column = "column-" . $i;
    if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
      $column .= $current_language;
    }
    register_sidebar( array(
	'name' => __('Column', 'vhl') . ' ' . $i,
	//'id' => 'column-' . $i . $current_language,
	'id' => $column,
	'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );

}
//SideBar Auxiliar Footer só aparece se ativado
if ($footer_sidebar == true){
    register_sidebar( array(
	'name' => __('Footer Auxiliary SideBar','vhl'),
	//'id' => 'footer_sidebar' . $current_language,
	'id' => $variables_mlf['footer_sidebar'],
	'description' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );
}

register_sidebar( array(
	'name' => __('Footer','vhl'),
	//'id' => 'footer' . $current_language,
	'id' => $variables_mlf['footer'],
	'description' => '',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<strong class="widget-title">',
	'after_title' => '</strong>',
) );

register_sidebar( array(
	'name' => __('Level 2','vhl'),
	//'id' => 'level2' . $current_language,
	'id' => $variables_mlf['level2'],
	'description' => 'Widgets que aparecerão em segundo nível',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<strong class="widget-title">',
	'after_title' => '</strong>',
) );

$custom_header_file = TEMPLATEPATH . '/bireme_archives/custom/custom-header.php';

if(file_exists($custom_header_file)) {
    add_action('wp_head', 'add_custom_header');
}

function add_custom_header(){
    include_once(TEMPLATEPATH . '/bireme_archives/custom/custom-header.php');
}

$custom_include_file = TEMPLATEPATH . '/bireme_archives/custom/include.php';
if(file_exists($custom_include_file)) {
    require_once($custom_include_file);
}

add_filter('widget_text', 'do_shortcode');

// Display the value of custom fields 
function bir_show_custom_field($post_id, $key, $label="", $html4label="", $html4custom_field="", $single=true, $separator=",") {
/*
	Samples for $html4label and $html4custom_field. Keep always the strings "label" and "custom_field", because the function will replace them using regular expression.

	$html4label
		"<li>label</li>"
		"<dt>label</dt>"
	$html4custom_field
		"<li>custom_field</li>"
		"<dd>custom_field</dd>"
		"<p>custom_field</p>"
*/	

	$customField = get_post_meta($post_id, $key, $single);
	
	if (!is_array($customField)) {
		if (trim($customField)!= "") {
			if ($html4label != "")
				echo preg_replace("/label/", $label, $html4label);
			else
				echo $label;

			if ($html4custom_field != "")
				echo preg_replace("/custom_field/", $customField, $html4custom_field);
			else
				echo $customField;
		}
	} else {
		if ($html4label != "")
			echo preg_replace("/label/", $label, $html4label);
		else
			 echo $label;

		$count = count($customField);
		$lastValue = end($customField);
		$text = "";
		foreach ( $customField as $value) {
			$text .= $value;	
			if ($value != $lastValue) $text .= $separator . " ";
		}	 
		if ($html4custom_field != "")
			echo preg_replace("/custom_field/", $text, $html4custom_field);
		else
			 echo $text;
	}
}

function bir_has_no_empty_custom_field ($post_id, $custom_field_keys, $single=true) {
        $found = false;
        foreach ($custom_field_keys as $cfk) {
                $custom_field = get_post_meta($post_id, $cfk, $single);
                if (!is_array($custom_field)) {
                        if (trim($custom_field)!= "") {
                                $found = true;
                                break;
                        }
                } else {
                        $found = true;
                        break;
                }
        }
        return $found;
}

function scripts_method() {
	wp_enqueue_script(
		'vhl-functions',
		get_template_directory_uri() . '/js/functions.js'
	);
	wp_localize_script('vhl-functions', 'network_script_vars', array(
			'imgpath' => get_template_directory_uri() . "/bireme_archives/default/",
			'group' => array('cl_bvs', 'sub_bvs', 'subdev_bvs', 'cl_cvsp', 'cl_scielo', 'sub_scielo', 'subdev_scielo')
		)
	);
}
add_action('wp_enqueue_scripts', 'scripts_method');

function comment_reply_filter($link){
    if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
        $language = strtolower(get_bloginfo('language'));
        $prefix = substr($language, 0,2);
        if($prefix == mlf_get_option('default_language'))
            $prefix = '';
        else
            $prefix = '/'.$prefix; 
    }
    else
        $prefix = '';

    return str_replace($_SERVER[REQUEST_URI], $prefix.$_SERVER[REQUEST_URI], $link);
}
add_filter('comment_reply_link', 'comment_reply_filter');

/**
* Find and close unclosed xml tags
**/
function html_tidy($src){
    libxml_use_internal_errors(true);
    $x = new DOMDocument;
    $x->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$src);
    $x->formatOutput = true;
    $ret = preg_replace('~<(?:!DOCTYPE|/?(?:html|body|head))[^>]*>s*~i', '', $x->saveHTML());
    $done=trim(str_replace('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">','',$ret));
    return $done;
}

function http_request_local( $args, $url ) {
   if ( preg_match('/xml|rss|feed/', $url) ){
      $args['reject_unsafe_urls'] = false;      
   }
   return $args;
}
add_filter( 'http_request_args', 'http_request_local', 5, 2 );

function vhl_breadcrumb() {
    global $mlf_config;
    global $site_lang;
    $lang = '';

    if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
        if ( $mlf_config['default_language'] != $site_lang ) $lang = $site_lang;
    }

    $breadcrumb = '';
    $before_bc = '<div class="breadcrumb"><a href="' . esc_url( home_url( "/".( $lang ) ) ) . '" class="home">Home</a> > ';
    $after_bc = '</div>';
    $ancestors = get_post_ancestors();
    $ancestors = array_reverse($ancestors);

    if( count($ancestors) > 0 ) {
        foreach( $ancestors as $ancestor) {
            $breadcrumb .= '<a href="' . get_permalink( $ancestor ) .'">' . get_the_title( $ancestor ) . '</a> > ';
        }
    }
    $breadcrumb .= get_the_title();

    echo $before_bc . $breadcrumb . $after_bc;
}

?>
