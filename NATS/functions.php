<?php
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

    // additional image sizes
    // delete the next line if you do not need additional image sizes
    //add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
}

register_post_type( 'edital',
        array(
            'labels' => array(
                'name' => 'Editais',
                'singular_name' => 'Edital',
                'add_new' => 'Adicionar novo',
                'add_new_item' => 'Adicionar Edital',
                'edit' => 'Editar',
                'edit_item' => 'Editar Edital',
                'new_item' => 'Novo Edital',
                'view' => 'Ver',
                'view_item' => 'Ver Edital',
                'search_items' => 'Buscar Editais',
                'not_found' => 'Nenhum Edital Encontrado',
                'not_found_in_trash' => 'Nenhum Edital Encontrado na Lixeira',
                'parent' => 'Edital Filho'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
			'menu_icon' => 'dashicons-lightbulb',
            'has_archive' => true
        )
    );

add_action( 'admin_init', 'editais_admin' );

function editais_admin() {
    add_meta_box( 'edital_meta_box',
        'Detalhamentos do Edital',
        'display_edital_meta_box',
        'edital', 'normal', 'high'
    );
}


function display_edital_meta_box( $edital ) {
	?>
	<div class="editais_description">
		<p><?php echo esc_html( __( "Nos campos abaixo, favor detalhar o edital, quanto mais detalhado, melhor será a indexação do edital.", 'editais' ) ); ?></p>
	</div>
	<?php
		${"editais_objectives"} = esc_html (get_post_meta( $edital->ID, "objectives_editais", true ) );
		${"editais_value"} = esc_html (get_post_meta( $edital->ID, "value_editais", true ) );
		${"editais_startDate"} = esc_html (get_post_meta( $edital->ID, "startDate_editais", true ) );
		${"editais_endDate"} = esc_html (get_post_meta( $edital->ID, "endDate_editais", true ) );
		
		${"editais_linkText_01"} = esc_html (get_post_meta( $edital->ID, "linkText_01_editais", true ) );
		${"editais_linkUrl_01"} = esc_html (get_post_meta( $edital->ID, "linkUrl_01_editais", true ) );
		${"editais_linkTarget_01"} = esc_html (get_post_meta( $edital->ID, "linkTarget_01_editais", true ) );
		${"editais_notes_01"} = esc_html (get_post_meta( $edital->ID, "notes_01_editais", true ) );
	?>
	<div class="componente_box compontente_1">
		<div class="componente_content" id="content_comp01">
			<div class="row">
				<div class="col-100">
					<label>Objetivo:</label><br>
					<input type="text" class="editais_objectives" name="objectives_editais" value="<?php echo $editais_objectives; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-100">
					<label>Valor do Fomento:</label><br>
					<input type="text" class="editais_value" name="value_editais" value="<?php echo $editais_value; ?>" />
				</div>
			</div>
			<div class="row">
				<p>Prazo de inscrições: </p>
				<div class="col-50">
					<label>Data de Início:</label> - <?php echo $editais_startDate; ?><br>
					<input type="date" class="editais_date" name="startDate_editais" value="<?php echo $editais_startDate; ?>" />
				</div>
				<div class="col-50">
					<label>Data Final:</label><br>
					<input type="date" class="editais_date" name="endDate_editais" value="<?php echo $editais_endDate; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-30">
					<label>Texto do Link:</label><br>
					<input type="text" class="editais_linkText input100" name="linkText_01_editais" value="<?php echo $editais_linkText_01; ?>" />
				</div>
				<div class="col-30">
					<label>url do Link: </label><br>
					<input type="text" class="editais_linkUrl input100" name="linkUrl_01_editais" value="<?php echo $editais_linkUrl_01; ?>" />
				</div>				
				<div class="col-30">
					<label>Abrir em nova janela?: </label><br>
						<?php
							if(${"editais_linkTarget_01"} == "on") ${"field_linkTarget_checked_01"} = 'checked="checked"'; ?>
						<input type="checkbox" name="linkTarget_01_editais" id="linkTarget_01_editais" <?php echo $field_linkTarget_checked_01; ?> />
				</div>
			</div>
			<div class="row">
				<div class="col-100">
					<label>Notas: </label><br>
					<textarea id="editais_notes_01" name="notes_01_editais"
					  rows="10"><?php echo $editais_notes_01; ?></textarea>
					<span class="comp_info">Campo Notas é interno utilizado somente para a equipe de informação do site, aqui você pode anexar informações que achar necessário.</span><br>
				</div>
			</div>
		</div>
	</div>
<style>
		.componente_box {
			padding: 10px;
		}
		.componente_title:hover {
			cursor: pointer;
			background: #d4eded;
		}
		.componente_box {
			padding: 10px;
		}
		.componente_box textarea {
			width: 100% !important;
		}
		.editais_objectives {
			font-size: 120%;
			width: 100%;
		}
		.editais_description {
			font-style: italic;
		}
		.componente_box h1.componente_title {
			border-bottom: 2px solid #cecece;
			padding: 5px 10px;
		}
		
		.col-100 {
			width: 98%;
			clear: both;
			display: inline-block;
		}
		.col-30 {
			width: 28%;
			float: left;
			padding: 5px;
		}
		.col-50 {
			width: 48%;
			float: left;
		}
		.componente_box input {
		}
		.col-100, .col-50 {
			padding: 1%;
		}
		.input100 {
			width: 100%;
		}
		.select_icon {
			width: 100px;
			float: left;
			text-align: center;
			height: 100px; 
			margin: 5px;
			
		}
		
		input[type=radio] {
		}
		
		input[type=radio]:checked + label>img {
			background: #FFF;
		}

		/* Stuff after this is only to make things more pretty */
		input[type=radio] + label>img {
		  width: 70;
		  height: 70px;
		}
		
		/*ON OFF*/
		.onoffswitch {
			position: relative; width: 90px;
			-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
		}
		.onoffswitch-checkbox {
			display: none !important;
		}
		.onoffswitch-label {
			display: block; overflow: hidden; cursor: pointer;
			border: 2px solid #999999; border-radius: 20px;
		}
		.onoffswitch-inner {
			display: block; width: 200%; margin-left: -100%;
			transition: margin 0.3s ease-in 0s;
		}
		.onoffswitch-inner:before, .onoffswitch-inner:after {
			display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
			font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
			box-sizing: border-box;
		}
		.onoffswitch-inner:before {
			content: "ON";
			padding-left: 10px;
			background-color: #34A7C1; color: #FFFFFF;
		}
		.onoffswitch-inner:after {
			content: "OFF";
			padding-right: 10px;
			background-color: #EEEEEE; color: #999999;
			text-align: right;
		}
		.onoffswitch-switch {
			display: block; width: 18px; margin: 6px;
			background: #FFFFFF;
			position: absolute; top: 0; bottom: 0;
			right: 56px;
			border: 2px solid #999999; border-radius: 20px;
			transition: all 0.3s ease-in 0s; 
		}
		.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
			margin-left: 0;
		}
		.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
			right: 0px; 
		}
		.editais_text {
			border: 1px solid red;
		}
</style>
<?php
}//fecha function display_edital_meta_box

 add_action( 'save_post', 'add_edital_fields', 10, 2 );

function add_edital_fields( $edital_id, $edital ) {
    // Check post type for edital
    if ( $edital->post_type == 'edital' ) {
       // Store data in post meta table if present in post data
			update_post_meta( $edital_id, 'objectives_editais', $_POST['objectives_editais'] );
			update_post_meta( $edital_id, 'value_editais', $_POST['value_editais'] );
			update_post_meta( $edital_id, 'startDate_editais', $_POST['startDate_editais'] );
			update_post_meta( $edital_id, 'endDate_editais', $_POST['endDate_editais'] );
			update_post_meta( $edital_id, 'linkText_01_editais', $_POST['linkText_01_editais'] );
			update_post_meta( $edital_id, 'linkUrl_01_editais', $_POST['linkUrl_01_editais'] );
			update_post_meta( $edital_id, 'linkTarget_01_editais', $_POST['linkTarget_01_editais'] );
			update_post_meta( $edital_id, 'notes_01_editais', $_POST['notes_01_editais'] );			
		}// fecha if $edital
 	}// fecha function

if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
		add_image_size('editais_image', 320, 320, true);
		add_image_size('editais_highlight', 225, 140, true);
	}
// load_plugin_textdomain( 'editais_wordpress', false, basename( dirname( __FILE__ ) ) . '/languages' );

// Create custom taxonomies

// hook into the init action and call create_edital_taxonomies when it fires
add_action( 'init', 'create_edital_taxonomies', 0 );

// create two taxonomies for the post type "edital"
function create_edital_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Instituições Responsáveis', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Instituição Responsável', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Buscar Insituições', 'textdomain' ),
		'all_items'         => __( 'Todas Instituições', 'textdomain' ),
		//'parent_item'       => __( 'Parent Genre', 'textdomain' ),
		//'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
		'edit_item'         => __( 'Editar Instituição', 'textdomain' ),
		'update_item'       => __( 'Atualizar Instituição', 'textdomain' ),
		'add_new_item'      => __( 'Adicionar Nova Instituição', 'textdomain' ),
		'new_item_name'     => __( 'Nome da Nova Instituição', 'textdomain' ),
		'menu_name'         => __( 'Instituição', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'institutions' ),
	);

	register_taxonomy( 'institutions', array( 'edital' ), $args );

	// Create a Taxonomy Agencias 
		$labels = array(
		'name'              => _x( 'Agências', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Agência', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Buscar Agências', 'textdomain' ),
		'all_items'         => __( 'Todas Agências', 'textdomain' ),
		//'parent_item'       => __( 'Parent Genre', 'textdomain' ),
		//'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
		'edit_item'         => __( 'Editar Agência', 'textdomain' ),
		'update_item'       => __( 'Atualizar Agência', 'textdomain' ),
		'add_new_item'      => __( 'Adicionar Nova Agência', 'textdomain' ),
		'new_item_name'     => __( 'Nome da Nova Agência', 'textdomain' ),
		'menu_name'         => __( 'Agência', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'agencias' ),
	);

	register_taxonomy( 'agencias', array( 'edital' ), $args );

	// Create a Taxonomy Institutions
		$labels = array(
		'name'              => _x( 'Instituições Responsáveis', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Instituição Responsável', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Buscar instituições', 'textdomain' ),
		'all_items'         => __( 'Todas instituições', 'textdomain' ),
		'edit_item'         => __( 'Editar instituições', 'textdomain' ),
		'update_item'       => __( 'Atualizar instituições', 'textdomain' ),
		'add_new_item'      => __( 'Adicionar Nova instituições', 'textdomain' ),
		'new_item_name'     => __( 'Nome da Nova instituições', 'textdomain' ),
		'menu_name'         => __( 'instituições', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'institutions' ),
	);

	register_taxonomy( 'institutions', array( 'edital' ), $args );

	// Create a Taxonomy Topics 
		$labels = array(
		'name'              => _x( 'Temas de Interesse', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Tema de Interesse', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Buscar Temas', 'textdomain' ),
		'all_items'         => __( 'Todos Temas', 'textdomain' ),
		'edit_item'         => __( 'Editar Tema', 'textdomain' ),
		'update_item'       => __( 'Atualizar Tema', 'textdomain' ),
		'add_new_item'      => __( 'Adicionar Novo Tema', 'textdomain' ),
		'new_item_name'     => __( 'Nome do Novo Tema', 'textdomain' ),
		'menu_name'         => __( 'Temas de Interesse', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'topics' ),
	);

	register_taxonomy( 'topics', array( 'edital' ), $args );

	// Create a Taxonomy Research Lines 
		$labels = array(
		'name'              => _x( 'Linhas de Pesquisa', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Linha de Pesquisa', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Buscar Linhas de Pesquisa', 'textdomain' ),
		'all_items'         => __( 'Todas Linhas de Pesquisa', 'textdomain' ),
		'edit_item'         => __( 'Editar Linha de Pesquisa', 'textdomain' ),
		'update_item'       => __( 'Atualizar Linha de Pesquisa', 'textdomain' ),
		'add_new_item'      => __( 'Adicionar Nova Linha de Pesquisa', 'textdomain' ),
		'new_item_name'     => __( 'Nome da Nova Linha de Pesquisa', 'textdomain' ),
		'menu_name'         => __( 'Linhas de Pesquisa', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'researchLines' ),
	);

	register_taxonomy( 'researchLines', array( 'edital' ), $args );


	// Create a Taxonomy Publico Alvo 
	$labels = array(
		'name'                       => _x( 'Público-alvo', 'taxonomy general name', 'textdomain' ),
		'singular_name'              => _x( 'Público-Alvo', 'taxonomy singular name', 'textdomain' ),
		'search_items'               => __( 'Buscar Público-Alvo', 'textdomain' ),
		'popular_items'              => __( 'Público-Alvo mais utilizados', 'textdomain' ),
		'all_items'                  => __( 'Todos Público', 'textdomain' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Editar Público', 'textdomain' ),
		'update_item'                => __( 'Atualizar Público', 'textdomain' ),
		'add_new_item'               => __( 'Adicionar Novo Público', 'textdomain' ),
		'new_item_name'              => __( 'Nome do Novo Público', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separar Públicos por vírgula', 'textdomain' ),
		'add_or_remove_items'        => __( 'Adicionar ou Remover Públicos', 'textdomain' ),
		'choose_from_most_used'      => __( 'Escolher entre os Públicos mais usados', 'textdomain' ),
		'not_found'                  => __( 'Nenhum Público encontrado', 'textdomain' ),
		'menu_name'                  => __( 'Públicos', 'textdomain' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'publicos' ),
	);

	register_taxonomy( 'publicos', 'edital', $args );

}


// End of Custom Taxonomies

//SideBars
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
	'before_widget' => '<div id="%1$s" class="widget %2$s col-lg-4">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle no-display">',
	'after_title'   => '</h2>'
) );

//slider_home.php - Arquivo com a rotina do slider
require_once('slider_home.php');

//home-news level 2
require_once('home_news.php');

//home-news level 3
require_once('home_newslevel3.php');

/////////// Edital 

?>