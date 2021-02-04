<?php

add_image_size( 'news-thumb', 75 ); // 75 pixels wide (and unlimited height)
add_image_size( '75-square-thumb', 75, 75, true ); // (cropped)

function append_post_type($termlink) {
	if (is_single()) {
		$pt = get_post_type();
		return $termlink . "&post_type=" . $pt;
	}
}
add_filter('tag_link','append_post_type');

function read_more_link( $id, $section ) {
    $postmeta = get_post_meta($id, $section, true);
    $doc = new DOMDocument();
    $doc->loadHTML($postmeta);
    $size = $doc->getElementsByTagName('a')->length;
    foreach($doc->getElementsByTagName('a') as $index => $href) { $index++;
        echo utf8_decode($doc->saveHTML($href));
        if ( $size > 5 && $index == 5 ) echo '<div style="display: none;">';
        if ( $size > 5 && $index == $size ) echo '</div><a class="more_like_that" style="display: block; text-align: right; text-decoration: underline; cursor: pointer;">>> Mostrar mais</a>';
    }
}

function barra_gov_render() {
    get_template_part( 'barra-gov' );
}
add_action( 'wp_body_open', 'barra_gov_render' );

function barra_acessibilidade_render() {
    get_template_part( 'barra-acessibilidade' );
}
add_action( 'wp_body_open', 'barra_acessibilidade_render' );

function accessibility_enqueue_style(){
    wp_enqueue_style('acessibilidade',get_stylesheet_directory_uri().'/css/accessibility.css');
}
add_action('wp_enqueue_scripts','accessibility_enqueue_style');

function accessibility_enqueue_script(){
    wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
    wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
}
add_action('wp_footer','accessibility_enqueue_script');

?>
