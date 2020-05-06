<?php 
	// Register Custom Navigation Walker 
require_once get_template_directory().'/class-wp-bootstrap-navwalker.php';
	// Title - tag <title>
add_theme_support('title-tag');
	// Menus Top/Language
add_action('init', 'action_init');
function action_init()
{
	register_nav_menu('main-nav', 'Main Menu (top)');
	register_nav_menu('Language', 'Language');
	register_nav_menu('rodape1', 'Rodapé 1');
	register_nav_menu('rodape2', 'Rodapé 2');
}
add_action('wp_enqueue_scripts','style_top');
function style_top(){
	//Add Styles Top
	wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
	wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
	wp_enqueue_style('aos',get_stylesheet_directory_uri().'/css/aos.css');
	wp_enqueue_style('slick',get_stylesheet_directory_uri().'/css/slick.css');
	wp_enqueue_style('theme-slick',get_stylesheet_directory_uri().'/css/slick-theme.css');
	wp_enqueue_style('acessibilidade',get_stylesheet_directory_uri().'/css/accessibility.css');
	wp_enqueue_style('feedback',get_stylesheet_directory_uri().'/css/feedback.css');
	wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
	wp_enqueue_style('fonts','https://fonts.googleapis.com/css?family=Oswald:600|Roboto:400,700&display=swap');
}
	//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
	wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.4.1.min.js');
	wp_enqueue_script('popper',get_stylesheet_directory_uri().'/js/popper.min.js');
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
	wp_enqueue_script('aos',get_stylesheet_directory_uri().'/js/aos.js');
	wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
	wp_enqueue_script('slick',get_stylesheet_directory_uri().'/js/slick.min.js');
	wp_enqueue_script('feedback',get_stylesheet_directory_uri().'/js/feedback.js');
	wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
	wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
	//Adiciona suporte a miniaturas (imagem destacada)
add_theme_support('post-thumbnails');
	//Adicionar tamanhos de imagem no Wordpress
add_image_size('Partners', 600, 200, true);
	//Custo post type
add_action('init', 'custon_posts');
function custon_posts(){
	registrar_custom_post_type();
}
function registrar_custom_post_type() {
		//HOME
	$home = array(
		'name' 				=> 'Home'
	);
	$argsHome = array(
		'labels' 		=> $home,
		'public' 		=> true,
		'hierarchical' 	=> false,
		'menu_position' => 10,
		'supports' 		=> array('title'),
		'menu_icon'		=> 'dashicons-admin-home',
	);
	register_post_type( 'home' , $argsHome );
		//News
	$News = array(
		'name' 					=> 'News',
		'singular_name' 		=> 'Novelty',
		'add_new' 				=> 'Add News',
		'add_new_item' 			=> 'Add News Item',
		'edit_item' 			=> 'Edit News',
		'new_item' 				=> 'New Item',
		'view_item' 			=> 'View News',
		'search_items' 			=> 'Search News',
		'not_found' 			=> 'No News Found',
		'not_found_in_trash' 	=> 'No News in Trash',
		'parent_item_colon' 	=> '',
		'menu_name' 			=> 'News'
	);
	$argsNews = array(
		'labels' 		=> $News,
		'public' 		=> true,
		'hierarchical' 	=> false,
		'menu_position' => 11,
		'supports' => array('title','editor'),
		'menu_icon'		=> 'dashicons-clipboard'
	);
	register_post_type( 'News' , $argsNews );
		//Partners
	$Partners = array(
		'name' 					=> 'Partners',
		'singular_name' 		=> 'Partner',
		'add_new' 				=> 'Add Partners',
		'add_new_item' 			=> 'Add Partners Item',
		'edit_item' 			=> 'Edit Partners',
		'new_item' 				=> 'New Item',
		'view_item' 			=> 'View Partners',
		'search_items' 			=> 'Search Partners',
		'not_found' 			=> 'No Partners Found',
		'not_found_in_trash' 	=> 'No Partners in Trash',
		'parent_item_colon' 	=> '',
		'menu_name' 			=> 'Partners'
	);
	$argsPartners = array(
		'labels' 		=> $Partners,
		'public' 		=> true,
		'hierarchical' 	=> false,
		'menu_position' => 12,
		'supports'		=> array('title'),
		'menu_icon'		=> 'dashicons-screenoptions'
	);
	register_post_type( 'Partners' , $argsPartners );
}
	//widgets - Home
register_sidebar(array(
	'name'			=> 'Home',
	'id'			=> 'home_widget',
	'description'	=> 'Widgets Home',
	'class'			=> 'list-unstyled',
	'before_title'	=> '<h5>',
	'after_title'	=> '</h5>'
));
add_action('init', function() {
	// Form
	pll_register_string('Search', 'Search', 'Form'); 

	// Text default
	pll_register_string('Search for', 'Search for', 'Text default');
	pll_register_string('Page:', 'Page:', 'Text default');
	pll_register_string('Term', 'Terms and conditions of use', 'Text default'); 
	pll_register_string('Privacy policy', 'Privacy policy', 'Text default'); 
	pll_register_string('All Descriptor Terms', 'All Descriptor Terms', 'Text default');
	pll_register_string('Main Heading (Descriptor) Terms', 'Main Heading (Descriptor) Terms', 'Text default');
	pll_register_string('Unique ID', 'Unique ID', 'Text default');
	pll_register_string('Concept ID', 'Concept ID', 'Text default');
	pll_register_string('Tree number ID', 'Tree number ID', 'Text default');
	pll_register_string('All Qualifier Terms', 'All Qualifier Terms', 'Text default');
	pll_register_string('Meet DeCS', 'Meet DeCS', 'Text default');
	pll_register_string('Contact us', 'Contact us', 'Text default');
	pll_register_string('For Developers', 'For Developers', 'Text default');
	pll_register_string('How to use DeCS', 'How to use DeCS', 'Text default');
	pll_register_string('DeCS in Numbers', 'DeCS in Numbers', 'Text default');
	pll_register_string('About DeCS', 'About DeCS', 'Text default');
	pll_register_string('Partners', 'Partners', 'Text default');
	pll_register_string('New DeCS website in beta version', 'New DeCS website in beta version', 'Text default');
	pll_register_string('Allowable Qualifiers', 'Allowable Qualifiers', 'Text default');
	pll_register_string('Annotation', 'Annotation', 'Text default');
	pll_register_string('Any descriptor term', 'Any descriptor term', 'Text default');
	pll_register_string('Any qualifier term', 'Any qualifier term', 'Text default');
	pll_register_string('Concept UI', 'Concept UI', 'Text default');
	pll_register_string('Concepts', 'Concepts', 'Text default');
	pll_register_string('Date of Entry', 'Date of Entry', 'Text default');
	pll_register_string('DeCS ID', 'DeCS ID', 'Text default');
	pll_register_string('Descriptor English', 'Descriptor English', 'Text default');
	pll_register_string('Descriptor French', 'Descriptor French', 'Text default');
	pll_register_string('Descriptor Portuguese', 'Descriptor Portuguese', 'Text default');
	pll_register_string('Descriptor Spanish', 'Descriptor Spanish', 'Text default');
	pll_register_string('Details', 'Details', 'Text default');
	pll_register_string('English', 'English', 'Text default');
	pll_register_string('Entry term(s)', 'Entry term(s)', 'Text default');
	pll_register_string('Exact descriptor term', 'Exact descriptor term', 'Text default');
	pll_register_string('French', 'French', 'Text default');
	pll_register_string('Hierarchical Code', 'Hierarchical Code', 'Text default');
	pll_register_string('Page', 'Page', 'Text default');
	pll_register_string('Portuguese', 'Portuguese', 'Text default');
	pll_register_string('Preferred term', 'Preferred term', 'Text default');
	pll_register_string('Revision Date', 'Revision Date', 'Text default');
	pll_register_string('Scope note', 'Scope note', 'Text default');
	pll_register_string('See details', 'See details', 'Text default');
	pll_register_string('See in another language', 'See in another language', 'Text default');
	pll_register_string('Spanish', 'Spanish', 'Text default');
	pll_register_string('Tree number(s)', 'Tree number(s)', 'Text default');
	pll_register_string('Tree Structures', 'Tree Structures', 'Text default');
	pll_register_string('You have selected the view in', 'You have selected the view in', 'Text default');
	pll_register_string('Numbers', 'Numbers', 'Text default');
	pll_register_string('Numbers - Descriptors and Qualifiers', 'Numbers - Descriptors and Qualifiers', 'Text default');
	pll_register_string('Descriptors and Qualifiers', 'Descriptors and Qualifiers', 'Text default'); 
	pll_register_string('Numbers - Unique DeCS Descriptors and Qualifiers', 'Numbers - Unique DeCS Descriptors and Qualifiers', 'Text default'); 
	pll_register_string('Unique DeCS Descriptors and Qualifiers', 'Unique DeCS Descriptors and Qualifiers', 'Text default'); 
	pll_register_string('Numbers - Hierarchical Codes in DeCS categories', 'Numbers - Hierarchical Codes in DeCS categories', 'Text default'); 
	pll_register_string('Hierarchical Codes in DeCS categories', 'Hierarchical Codes in DeCS categories', 'Text default'); 
	pll_register_string('History Note', 'History Note', 'Text default');
	pll_register_string('Date Established', 'Date Established', 'Text default');
	pll_register_string('No results found', 'No results found', 'Text default');
	pll_register_string('Results', 'Results', 'Text default');
	pll_register_string('Terms and conditions of use', 'Terms and conditions of use', 'Text default');
	pll_register_string('Privacy policy', 'Privacy policy', 'Text default');

	//Accessibility
	pll_register_string('Main content', 'Main content', 'Accessibility');
	pll_register_string('Menu', 'Menu', 'Accessibility');
	pll_register_string('Footer', 'Footer', 'Accessibility');
	pll_register_string('High contrast', 'High contrast', 'Accessibility'); 

});


// http://wordpressbr.blogspot.com/2012/11/personalizar-o-menu-do-wpnavmenu.html
class description_walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth, $args)
	{

		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );

		$class_names = ' class="'. esc_attr( $class_names ) . ' cat-'.$item->object_id.'"';

		$output .= '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		// from search
		$q = $_GET['q'];
		$filter = $_GET['filter'];
		$id= $_GET['id'];

		if ( !empty($q) and !empty($filter) and empty($id) ){
			// renders results page
			// ex.: ths?filter=ths_termall&q=temefos

			$url_filter = 'ths?filter=' . $filter . '&q=' . $q ;
			$attributes .= !empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . $url_filter . '"' : '';
		} elseif ( !empty($q) and !empty($filter) and !empty($id) ){
			// renders the record detailing page
			// ex.: ths/resource/?id=2&filter=ths_termall&q=temefos
			$url_filter = 'ths/resource/?id=' . $id . '&filter=' . $filter . '&q=' . $q ;
			$attributes .= !empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . $url_filter . '"' : '';
		} else {
			// renders home page
			$url_filter = '';
			$attributes .= !empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
		}
		
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= $description.$args->link_after;
		$item_output .= '</a>';

		$output .= apply_filters( 'walker_nav_menu', $item_output, $item, $depth, $args );

	}
}

?>