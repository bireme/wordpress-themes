<?php

register_nav_menus( array(
	'column-1' => 'Column 1',	
	'column-2' => 'Column 2',
	'column-3' => 'Column 3',
	'column-4' => 'Column 4',
	'bottom' => 'Sitemap menu',
) );


register_sidebar( array(
	'name'          => 'DirEve top sidebar',
	'id'            => 'direve_top_sidebar',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h1 class="widget-title">',
	'after_title'   => '</h1>',
) );


register_sidebar( array(
	'name' => __('slider'),
	'id' => ('slider'),
	'description' => '',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<strong class="widget-title">',
	'after_title' => '</strong>',
) );

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
			'title' => 'post-section-es',
			'inline' => 'span',
			'classes' => 'post-section-es',
			'wrapper' => false,
		),
		array(  
			'title' => 'post-section-en',
			'inline' => 'span',
			'classes' => 'post-section-en',
			'wrapper' => false,
		),
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

?>
