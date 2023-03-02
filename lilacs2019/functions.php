<?php
$current_language = strtolower(get_bloginfo('language'));
$suffix = ( !defined( 'POLYLANG_VERSION' ) ) ? '_' . $current_language : '';
$sidebar_name = ( !defined( 'POLYLANG_VERSION' ) ) ? $current_language : '';
function my_function_admin_bar(){
return false;
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');
require_once('class-wp-bootstrap-navwalker.php');
function register_my_menu() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'register_my_menu' );
//Thumbnails
if ( function_exists( 'add_theme_support' ) ) { 
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)
    add_image_size( 'slider', 1250, 9999 ); //1250 pixels wide (and unlimited height)
    add_image_size( 'news', 380, 160, true ); 
    add_image_size( 'news_level_3', 380, 255, true ); 
}

//SideBars
register_sidebar(
        array('name'=>'Menu 1', 
            'id' => 'vhl_menu_1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ));
register_sidebar(
        array('name'=>'Header Menu', 
            'id' => 'header_menu',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
        ));
register_sidebar( array(
    'id'          => 'home_portal',
    'name'        => __( 'Home Portal', $text_domain ),
    'description' => __( 'Nessa área você personaliza a homepage do Portal.', $text_domain ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle no-display">',
	'after_title'   => '</h2>'
) );

register_sidebar( array(
    'id'          => 'footer',
    'name'        => __( 'Footer ou rodapé', $text_domain ),
    'description' => __( 'Nessa área você personaliza o rodapé da página.', $text_domain ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle no-display">',
	'after_title'   => '</h2>'
) );

add_action('admin_menu', 'add_global_custom_options');

function add_global_custom_options()
{
	add_theme_page('Configurar Tema', 'Configurar Tema', 'manage_options', 'functions','global_custom_options');
}

function global_custom_options()
{

?>
<div class="wrap">
<h2>Configurar Tema</h2>
<form method="post" action="options.php">
	<?php wp_nonce_field('update-options') ?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label>Institutional Logo URL 460x52px</label>
				</th>
				<td>
					PT:<input name="BIR_logo_pt" type="text" id="BIR_logo_pt" class="regular-text" value="<?php echo get_option('BIR_logo_pt'); ?>" /><br/>
					ES:<input name="BIR_logo_es" type="text" id="BIR_logo_es" class="regular-text" value="<?php echo get_option('BIR_logo_es'); ?>" /><br/>
					EN:<input name="BIR_logo_en" type="text" id="BIR_logo_en" class="regular-text" value="<?php echo get_option('BIR_logo_en'); ?>" /><br/>
				</td>
			</tr>
		</tbody>
	</table>
	
	<p><input type="submit" name="Submit" value="Store Options" /></p>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="BIR_logo_pt,
												BIR_logo_es, 
												BIR_logo_en" /> 
</form>
</div>
<?php
}
function language_switcher() {
    if ( function_exists( 'pll_the_languages' ) ) {
        if ( $_SERVER['SCRIPT_NAME'] == '/php/bvsnet.php' ) {
            $slugs = pll_languages_list();
            $names = pll_languages_list(array('fields' => 'name'));
            $languages = array_combine($slugs, $names);

            echo "<ul>";
            foreach ($languages as $slug => $name) :
                if ($site_lang == $slug) continue;
                $url = str_replace('lang='.$site_lang, 'lang='.$slug, $_SERVER['REQUEST_URI']);
                ?>
                <li><a href="<?php echo $url; ?>"><?php echo $name; ?></a></li>
                <?php
            endforeach;
            echo "</ul>";
        } else {
            $args = array(
                'dropdown' => 0,
                'show_names' => 1,
                'display_names_as' => 'name',
                'show_flags' => 0,
                'hide_if_empty' => 1,
                'force_home' => 0,
                'echo' => 0,
                'hide_if_no_translation' => 0,
                'hide_current' => 1,
                'post_id' => null,
                'raw' => 0
            );

            echo '<ul>' . pll_the_languages( $args ) . '</ul>';
        }
    }
}
function http_request_local( $args, $url ) {
   if ( preg_match('/xml|rss|feed/', $url) ){
      $args['reject_unsafe_urls'] = false;
   }
   return $args;
}
add_filter( 'http_request_args', 'http_request_local', 5, 2 );

//register_nav_menu('menu_lilacs',__( 'Menu LILACS' ));

function register_theme_menu() {
  register_nav_menu('primary-menu',__( 'Menu Principal' ));
}
add_action( 'init', 'register_theme_menu' );

function custom_menu_location() {
  register_nav_menu('custom-menu-location',__( 'Custom Menu', $text_domain ));
}
add_action( 'init', 'custom_menu_location' );

pll_register_string('Main content', 'Main content', 'Accessibility');
pll_register_string('Menu', 'Menu', 'Accessibility');
pll_register_string('Footer', 'Footer', 'Accessibility');
pll_register_string('High contrast', 'High contrast', 'Accessibility');
?>