<?php
function barra_acessibilidade_render() {
    get_template_part( 'topAccessibility' );
}
add_action( 'wp_body_open', 'barra_acessibilidade_render' );

function accessibility_enqueue_style(){
    wp_enqueue_style('acessibilidade',get_stylesheet_directory_uri().'/css/accessibility.css');
}

add_action('wp_enqueue_scripts','accessibility_enqueue_style');
function accessibility_enqueue_script(){
    wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
    wp_enqueue_script('acessibilidade',get_stylesheet_directory_uri().'/js/accessibility.js');
}
add_action('wp_footer','accessibility_enqueue_script');

add_action('init', function() {
        //Accessibility
    pll_register_string('Main content', 'Main content', 'Accessibility');
    pll_register_string('Menu', 'Menu', 'Accessibility');
    pll_register_string('Footer', 'Footer', 'Accessibility');
    pll_register_string('High contrast', 'High contrast', 'Accessibility'); 

});

?>