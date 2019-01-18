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
}

// Create Post Type Portfolio
	register_post_type( 'portfolio',
			array(
				'labels' => array(
					'name' => 'Portfólio',
					'singular_name' => 'Portfólio',
					'add_new' => 'Adicionar novo',
					'add_new_item' => 'Adicionar Portfólio',
					'edit' => 'Editar',
					'edit_item' => 'Editar Portfólio',
					'new_item' => 'Novo Portfólio',
					'view' => 'Ver',
					'view_item' => 'Ver Portfólio',
					'search_items' => 'Buscar Portfólios',
					'not_found' => 'Nenhum Portfólio Encontrado',
					'not_found_in_trash' => 'Nenhum Portfólio encontrado na Lixeira',
				),
	 
				'public' => true,
				'description'        => __( 'Description.', 'portfolios' ),
				'menu_position' => 15,
				'supports' => array( 'title', 'thumbnail', 'custom-fields' ),
				'taxonomies' => array( '' ),
				'menu_icon' => 'dashicons-awards',
				'has_archive' => true
			)
		);

	add_action( 'admin_init', 'portfolios_admin' );

	function portfolios_admin() {
		add_meta_box( 'portfolio_meta_box',
			'Detalhamentos do Portfolio',
			'display_portfolio_meta_box',
			'portfolio', 'normal', 'high'
		);
	}


	function display_portfolio_meta_box( $portfolio ) {
		?>
		<div class="portfolios_description">
			<p><?php echo esc_html( __( "Nos campos abaixo, favor detalhar o portfolio, quanto mais detalhado, melhor será sua indexação", 'portfolios' ) ); ?></p>
		</div>
		<?php
			//Portfolio 
			
			$portfolios_problem = esc_html (get_post_meta( $portfolio->ID, "problem_portfolios", true ) );
			$portfolios_innovation = esc_html (get_post_meta( $portfolio->ID, "innovation_portfolios", true ) );
			$portfolios_advantage = esc_html (get_post_meta( $portfolio->ID, "advantage_portfolios", true ) );
			$portfolios_seek = esc_html (get_post_meta( $portfolio->ID, "seek_portfolios", true ) );
			$portfolios_status = esc_html (get_post_meta( $portfolio->ID, "status_portfolios", true ) );
			$portfolios_details = esc_html (get_post_meta( $portfolio->ID, "details_portfolios", true ) );
			$portfolios_inventors = esc_html (get_post_meta( $portfolio->ID, "inventors_portfolios", true ) );
			$portfolios_link = esc_html (get_post_meta( $portfolio->ID, "link_portfolios", true ) );
			$portfolios_notes = esc_html (get_post_meta( $portfolio->ID, "notes_portfolios", true ) );
		?>
		<div class="componente_box">
			<div class="componente_content" id="content">
				<div class="row">
					<div class="col-100 box_editor">
					<label>Problema a ser resolvido:</label>
						<?php 
							$content   = html_entity_decode($portfolios_problem); 
							$editor_id = 'problem_portfolios';
							$settings  = array( 
								'media_buttons' => false ,
								'wpautop'=> true,
								'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' ),
								'editor_height' => 100
							);
							wp_editor($content, $editor_id, $settings);
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-100 box_editor">
						<label>Inovação da Proposta:</label><br>
						<?php 
							$content   = html_entity_decode($portfolios_innovation); 
							$editor_id = 'innovation_portfolios';
							$settings  = array( 
								'media_buttons' => false ,
								'wpautop'=> true,
								'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' ),
								'editor_height' => 100
							);
							wp_editor($content, $editor_id, $settings);
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-100 box_editor">
						<label>Diferencial:</label><br>
						<?php 
							$content   = html_entity_decode($portfolios_advantage); 
							$editor_id = 'advantage_portfolios';
							$settings  = array( 
								'media_buttons' => false ,
								'wpautop'=> true,
								'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' ),
								'editor_height' => 100
							);
							wp_editor($content, $editor_id, $settings);
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-100 box_editor">
						<label>O que buscamos:</label><br>
						<?php 
							$content   = html_entity_decode($portfolios_seek); 
							$editor_id = 'seek_portfolios';
							$settings  = array( 
								'media_buttons' => false ,
								'wpautop'=> true,
								'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' ),
								'editor_height' => 100
							);
							wp_editor($content, $editor_id, $settings);
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-100 box_editor">
						<label>Status da Propriedade Intelectual:</label><br>
						<?php 
							$content   = html_entity_decode($portfolios_status); 
							$editor_id = 'status_portfolios';
							$settings  = array( 
								'media_buttons' => false ,
								'wpautop'=> true,
								'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' ),
								'editor_height' => 100
							);
							wp_editor($content, $editor_id, $settings);
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-100 box_editor">
						<label>Detalhes da Patente:</label><br>
						<?php 
							$content   = html_entity_decode($portfolios_details); 
							$editor_id = 'details_portfolios';
							$settings  = array( 
								'media_buttons' => false ,
								'wpautop'=> true,
								'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' ),
								'editor_height' => 100
							);
							wp_editor($content, $editor_id, $settings);
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-100 box_editor">
					<label>Inventores:</label>
						<?php 
							$content   = html_entity_decode($portfolios_inventors); 
							$editor_id = 'inventors_portfolios';
							$settings  = array( 
								'media_buttons' => false ,
								'wpautop'=> true,
								'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' ),
								'editor_height' => 100
							);
							wp_editor($content, $editor_id, $settings);
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-100 box_editor">
						<label>Link:</label><br>
						<input type="text" class="portfolios_link" name="link_portfolios" value="<?php echo $portfolios_link; ?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-100 box_editor">
						<label>Notas: </label><br>
						<textarea id="portfolios_notes" name="notes_portfolios"
						  rows="5"><?php echo $portfolios_notes; ?></textarea>
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
			
			.componente_box h1.componente_title {
				border-bottom: 2px solid #cecece;
				padding: 5px 10px;
			}
			
			.col-100 {
				width: 98%;
				clear: both;
				display: inline-block;
			}
			.box_editor input, .box_editor textarea {
				width: 100%;
				margin-top: 10px;
			}
			.box_editor label {
				font-size: 150%;
			}
			.box_editor {
				padding: 10px;
				border: 1px solid #dedede;
				margin-bottom: 10px;
			}
	</style>
	<?php
	}//fecha function display_portfolios_meta_box

	 add_action( 'save_post', 'add_portfolio_fields', 10, 2 );

	function add_portfolio_fields( $portfolio_id, $portfolio ) {
		// Check post type for portfolios
		if ( $portfolio->post_type == 'portfolio' ) {
		   // Store data in post meta table if present in post data
				update_post_meta( $portfolio_id, 'problem_portfolios', $_POST['problem_portfolios'] );		
				update_post_meta( $portfolio_id, 'innovation_portfolios', $_POST['innovation_portfolios'] );		
				update_post_meta( $portfolio_id, 'advantage_portfolios', $_POST['advantage_portfolios'] );		
				update_post_meta( $portfolio_id, 'seek_portfolios', $_POST['seek_portfolios'] );		
				update_post_meta( $portfolio_id, 'status_portfolios', $_POST['status_portfolios'] );		
				update_post_meta( $portfolio_id, 'details_portfolios', $_POST['details_portfolios'] );		
				update_post_meta( $portfolio_id, 'inventors_portfolios', $_POST['inventors_portfolios'] );		
				update_post_meta( $portfolio_id, 'link_portfolios', $_POST['link_portfolios'] );		
				update_post_meta( $portfolio_id, 'notes_portfolios', $_POST['notes_portfolios'] );			
			}// fecha if $portfolio
		}// fecha function
	
	if (function_exists('add_theme_support')) {
			add_theme_support('post-thumbnails');
			add_image_size('portfolios_image', 320, 320, true);
			add_image_size('portfolios_highlight', 225, 140, true);
		}

	// Create custom taxonomies
	add_action( 'init', 'create_portfolios_taxonomies', 0 );

	// create two taxonomies, for the post type "portfolio"
	function create_portfolios_taxonomies() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Núcleos', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Núcleo', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Buscar Núcleos', 'textdomain' ),
			'all_items'         => __( 'Todos Núcleos', 'textdomain' ),
			'edit_item'         => __( 'Editar Núcleo', 'textdomain' ),
			'update_item'       => __( 'Atualizar Núcleo', 'textdomain' ),
			'add_new_item'      => __( 'Adicionar Novo Núcleo', 'textdomain' ),
			'new_item_name'     => __( 'Nome do Novo Núcleo', 'textdomain' ),
			'menu_name'         => __( 'Núcleos Responsáveis', 'textdomain' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'nucleos' ),
		);

		register_taxonomy( 'nucleos', array( 'portfolio' ), $args );

		// Create a Taxonomy Temas 
			$labels = array(
			'name'              => _x( 'Temas', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Tema', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Buscar Temas', 'textdomain' ),
			'all_items'         => __( 'Todos Temas', 'textdomain' ),
			'edit_item'         => __( 'Editar Tema', 'textdomain' ),
			'update_item'       => __( 'Atualizar Tema', 'textdomain' ),
			'add_new_item'      => __( 'Adicionar Novo Tema', 'textdomain' ),
			'new_item_name'     => __( 'Nome do Novo Tema', 'textdomain' ),
			'menu_name'         => __( 'Tema', 'textdomain' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'temas' ),
		);

		register_taxonomy( 'temas', array( 'portfolio' ), $args );
	}
	// End of Custom Taxonomies

// END of Post Type Portfolio

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

?>