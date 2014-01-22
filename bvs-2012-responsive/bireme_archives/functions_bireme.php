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
	'name' => __('Header','vhl') . $current_language,
	//'id' => 'header' . $current_languager
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
	'name' => __('Top Auxiliary SideBar','vhl') . $current_language,
	//'id' => 'top_sidebar' . $current_language,
	'id' => $variables_mlf['top_sidebar'],
	'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
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
	'name' => __('Column', 'vhl') . ' ' . $i . $current_language,
	//'id' => 'column-' . $i . $current_language,
	'id' => $column,
	'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );

}
//SideBar Auxiliar Footer só aparece se ativado
if ($footer_sidebar == true){
    register_sidebar( array(
	'name' => __('Footer Auxiliary SideBar','vhl') . $current_language,
	//'id' => 'footer_sidebar' . $current_language,
	'id' => $variables_mlf['footer_sidebar'],
	'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<strong class="widget-title">',
        'after_title' => '</strong>',
    ) );
}

register_sidebar( array(
	'name' => __('Footer','vhl') . $current_language,
	//'id' => 'footer' . $current_language,
	'id' => $variables_mlf['footer'],
	'description' => '',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<strong class="widget-title">',
	'after_title' => '</strong>',
) );

register_sidebar( array(
	'name' => __('Level 2','vhl') . $current_language,
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

?>
