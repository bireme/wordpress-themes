<?php
// Title - tag <title> 
add_theme_support( 'title-tag' );
// Posta Thumbnails
add_theme_support( 'post-thumbnails' );
//Register Custom Navigation Walker 
require_once get_template_directory().'/class-wp-bootstrap-navwalker.php';
add_action('wp_enqueue_scripts','style_top');
function style_top(){
//Add Styles Top
	wp_enqueue_style('bootstrap',get_stylesheet_directory_uri().'/css/bootstrap.min.css');
	wp_enqueue_style('style',get_stylesheet_directory_uri().'/css/style.css');
	wp_enqueue_style('slick',get_stylesheet_directory_uri().'/css/slick.css');
	wp_enqueue_style('theme-slick',get_stylesheet_directory_uri().'/css/slick-theme.css');
	wp_enqueue_style('acessibilidade',get_stylesheet_directory_uri().'/css/accessibility.css');
	wp_enqueue_style('fontawesome',get_stylesheet_directory_uri().'/css/fontawesome/css/all.css');
}
//Add Scripts Footer
add_action('wp_footer','scripts_footer');
function scripts_footer(){
	wp_enqueue_script('jquery', get_stylesheet_directory_uri().'/js/jquery-3.4.1.min.js');
	wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'));
	wp_enqueue_script('cookie',get_stylesheet_directory_uri().'/js/cookie.js');
	wp_enqueue_script('slick',get_stylesheet_directory_uri().'/js/slick.min.js');
	wp_enqueue_script('accessibility',get_stylesheet_directory_uri().'/js/accessibility.js');
	wp_enqueue_script('main',get_stylesheet_directory_uri().'/js/main.js');
}
// Menus Topo
add_action('init', 'action_init');
function action_init()
{
	register_nav_menu('main-nav', 'Main Menu (top)');
	register_nav_menu('boletim-nav', 'Boletim');
	register_nav_menu('ministros-nav', 'Ministros');
}
//Custom Post Type
add_action('init', 'custon_posts');
function custon_posts(){
	registrar_custom_post_type();
}
function registrar_custom_post_type() {
// Banners
	$descritivosBanner = array(
		'name' => 'Banner',
		'singular_name' => 'Banner',
		'add_new' => 'Add New Banner',
		'add_new_item' => 'Add Banner',
		'edit_item' => 'Edit Banner',
		'new_item' => 'New Banner',
		'view_item' => 'View Banner',
		'search_items' => 'Search Banner',
		'not_found' =>  'No Banner Found',
		'not_found_in_trash' => 'No Banner in Trash',
		'parent_item_colon' => '',
		'menu_name' => 'Banner'
	);
	$argsBanner = array(
		'labels' => $descritivosBanner,
		'public' => true,
		'hierarchical' => false,
		'menu_position' => 11,
		'supports' => array('title','thumbnail')
	);
	register_post_type( 'banners' , $argsBanner );
//MiniBanners
	$MiniBanners = array(
		'name' 					=> 'Mini Banners',
		'singular_name' 		=> 'Mini Banner',
		'add_new' 				=> 'Add Mini Banner',
		'add_new_item' 			=> 'Add Mini Banners Item',
		'edit_item' 			=> 'Edit Mini Banner',
		'new_item' 				=> 'New Item',
		'view_item' 			=> 'View Mini Banners',
		'search_items' 			=> 'Search Mini Banners',
		'not_found' 			=> 'No Mini Banners Found',
		'not_found_in_trash' 	=> 'No Mini Banners in Trash',
		'parent_item_colon' 	=> '',
		'menu_name' 			=> 'Mini Banners'
	);
	$MiniBanners = array(
		'labels' 		=> $MiniBanners,
		'public' 		=> true,
		'hierarchical' 	=> false,
		'menu_position' => 12,
		'supports'		=> array('title'),
		'menu_icon'		=> 'dashicons-screenoptions'
	);
	register_post_type( 'MiniBanners' , $MiniBanners );
//Temas
	$Temas = array(
		'name' 					=> 'Temas',
		'singular_name' 		=> 'Tema',
		'add_new' 				=> 'Add Tema',
		'add_new_item' 			=> 'Add Temas Item',
		'edit_item' 			=> 'Edit Tema',
		'new_item' 				=> 'New Item',
		'view_item' 			=> 'View Temas',
		'search_items' 			=> 'Search Temas',
		'not_found' 			=> 'No Temas Found',
		'not_found_in_trash' 	=> 'No Temas in Trash',
		'parent_item_colon' 	=> '',
		'menu_name' 			=> 'Temas'
	);
	$Temas = array(
		'labels' 		=> $Temas,
		'public' 		=> true,
		'hierarchical' 	=> false,
		'menu_position' => 12,
		'supports'		=> array('title'),
		'menu_icon'		=> 'dashicons-feedback'
	);
	register_post_type( 'Tema' , $Temas );
	flush_rewrite_rules();
}
// WIDGETS
register_sidebar([
	'name'			=> 'Header',
	'id'			=> 'header',
	'description'	=> 'header',
	'before_title'	=> '<h5>',
	'after_title'	=> '</h5>'
]);
register_sidebar([
	'name'			=> 'Rodape 1',
	'id'			=> 'footer1',
	'description'	=> 'Coluna 1',
	'before_title'	=> '<h5>',
	'after_title'	=> '</h5>'
]);
register_sidebar([
	'name'			=> 'Rodape 2',
	'id'			=> 'footer2',
	'description'	=> 'Coluna 2',
	'before_title'	=> '<h5>',
	'after_title'	=> '</h5>'
]);
register_sidebar([
	'name'			=> 'Rodape 3',
	'id'			=> 'footer3',
	'description'	=> 'Coluna 3',
	'before_title'	=> '<h5>',
	'after_title'	=> '</h5>'
]);
register_sidebar([
	'name'			=> 'Rodape 4',
	'id'			=> 'footer4',
	'description'	=> 'Coluna 4',
	'before_title'	=> '<h5>',
	'after_title'	=> '</h5>'
]);
//Adicionar tamanhos de imagem no Wordpress
add_image_size('banners', 1200, 400, true);
add_image_size('banners-mobile', 600, 300, true);
add_image_size('mini-banners',576,240,true);
add_image_size('tema',576,300,true);



/*Estação BVS*/
function criar_cpt_pontos_mapa() {
    register_post_type('ponto_mapa', [
        'labels' => [
            'name' => 'Pontos do Mapa',
            'singular_name' => 'Ponto do Mapa',
            'add_new_item' => 'Adicionar novo ponto',
            'edit_item' => 'Editar ponto',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-location-alt',
        'supports' => ['title'],
        'has_archive' => false,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'criar_cpt_pontos_mapa');

function campos_ponto_mapa() {
    add_meta_box(
        'dados_ponto_mapa',
        'Dados do ponto',
        'html_campos_ponto_mapa',
        'ponto_mapa',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'campos_ponto_mapa');

function html_campos_ponto_mapa($post) {
    $endereco = get_post_meta($post->ID, '_endereco', true);
    $detalhes = get_post_meta($post->ID, '_detalhes', true);
    $lat = get_post_meta($post->ID, '_lat', true);
    $lng = get_post_meta($post->ID, '_lng', true);
    ?>

    <p>
        <label>Endereço</label><br>
        <input type="text" name="endereco" value="<?php echo esc_attr($endereco); ?>" style="width:100%;">
    </p>
    <p>
        <label>Detalhes</label><br>
        <?php
        wp_editor(
            $detalhes,
            'detalhes',        array(
                'textarea_name' => 'detalhes',
                'textarea_rows' => 8,
                'media_buttons' => false,
                'teeny' => true
            )
        );
        ?>
    </p>

    <p>
        <label>Latitude</label><br>
        <input type="text" name="lat" value="<?php echo esc_attr($lat); ?>" style="width:100%;">
    </p>

    <p>
        <label>Longitude</label><br>
        <input type="text" name="lng" value="<?php echo esc_attr($lng); ?>" style="width:100%;">
    </p>

    <?php
}

function salvar_campos_ponto_mapa($post_id) {
    if (array_key_exists('endereco', $_POST)) {
        update_post_meta($post_id, '_endereco', sanitize_text_field($_POST['endereco']));
    }
    if (array_key_exists('detalhes', $_POST)) {
        update_post_meta($post_id, '_detalhes', wp_kses_post($_POST['detalhes']));
    }

    if (array_key_exists('lat', $_POST)) {
        update_post_meta($post_id, '_lat', sanitize_text_field($_POST['lat']));
    }

    if (array_key_exists('lng', $_POST)) {
        update_post_meta($post_id, '_lng', sanitize_text_field($_POST['lng']));
    }
}
add_action('save_post_ponto_mapa', 'salvar_campos_ponto_mapa');


function shortcode_mapa_pontos_interativo() {
    $query = new WP_Query([
        'post_type'      => 'ponto_mapa',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    $pontos = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $lat = get_post_meta(get_the_ID(), '_lat', true);
            $lng = get_post_meta(get_the_ID(), '_lng', true);
            $endereco = get_post_meta(get_the_ID(), '_endereco', true);
            $detalhes = get_post_meta(get_the_ID(), '_detalhes', true);

            if ($lat && $lng) {
                $pontos[] = [
                    'titulo'   => get_the_title(),
                    'endereco' => $endereco,
                    'detalhes' => $detalhes,
                    'lat'      => $lat,
                    'lng'      => $lng,
                ];
            }
        }
    }

    wp_reset_postdata();

    wp_enqueue_style(
        'leaflet-css',
        'https://unpkg.com/leaflet/dist/leaflet.css'
    );

    wp_enqueue_script(
        'leaflet-js',
        'https://unpkg.com/leaflet/dist/leaflet.js',
        [],
        null,
        true
    );

    wp_enqueue_script(
        'mapa-pontos-js',
        plugin_dir_url(__FILE__) . 'assets/js/mapa-pontos.js',
        ['leaflet-js'],
        null,
        true
    );

    wp_localize_script('mapa-pontos-js', 'MAPA_PONTOS_DATA', [
        'pontos' => $pontos,
    ]);

    ob_start();
    ?>

    <div class="mapa-pontos-container">
        <div id="mapa-pontos"></div>

        <div class="mapa-pontos-lista">
            <h3>Pontos cadastrados</h3>

            <?php if (!empty($pontos)) : ?>
                <ul>
                    <?php foreach ($pontos as $index => $ponto) : ?>
                        <li 
                        class="mapa-ponto-item"
                        data-index="<?php echo esc_attr($index); ?>"
                        >
                        <strong><?php echo esc_html($ponto['titulo']); ?></strong>
                        <span><?php echo esc_html($ponto['endereco']); ?></span>
                        <span class="detalhes">
                            <?php echo wpautop( wp_kses_post($ponto['detalhes']) ); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Nenhum ponto cadastrado.</p>
        <?php endif; ?>
    </div>
</div>

<?php
return ob_get_clean();
}
add_shortcode('mapa_pontos', 'shortcode_mapa_pontos_interativo');
?>