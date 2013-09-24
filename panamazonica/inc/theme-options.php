<?php
/**
 * Faz as confifgurações inicias
 * 
 */
function theme_options_init() {
    global $pagenow;
    
    register_setting('theme_options_options', 'theme_options', 'theme_options_validate_callback_function');
    
	add_action( 'admin_notices', 'theme_options_admin_notice');
	add_action( 'admin_head-toplevel_page_theme_options', 'theme_options_enqueue_scripts');
   
}

add_action('admin_init', 'theme_options_init');


/**
 * Retorna uma string com a URL da imagem padrão
 *
 * @return string $file_name O endereço da imagem
 */
function get_blog_default_image() {
	
	return get_template_directory_uri() . '/images/grupo-no-thumbnail.gif';
}


/**
 * Recebe os valores padrões do theme options
 * 
 */
function get_theme_default_options() {
    
    // Coloquei aqui o nome e o valor padrão de cada opção que você criar
    
    return array(
        'lead_text' 	=> 'A Rede Pan-Amazônica de Ciência, Tecnologia e Inovação em Saúde é uma rede cooperativa entre instituições de ensino, investigação e gestão que visa incentivar e contribuir para a implantação de políticas de integração regional na Amazônia para o desenvolvimento.',
        'lead_link' 	=> '',
        'logo'			=> get_blog_default_image(),
        'facebook'		=> '',
        'twitter'		=> '',
        'footer_text'	=> ''
    );

}

/**
 * Adiciona a página responsável pelas opções do tema
 * 
 */
function theme_options_menu() {
    
    // Por padrão criamos uma página exclusiva para as opções desse site
    // Mas se quiser você pode colocar ela embaixo de aparencia, opções, ou o q vc quiser. O modelo para todos os casos estão comentados abaixo
    
    $topLevelMenuLabel = __( 'Pan-Amazonian Network Options', 'theme options page', 'panamazonica' );
    $page_title = 'Opções';
    $menu_title = 'Opções';
    
    /* Top level menu */
    add_submenu_page('theme_options', $page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    $page_name = add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
        
    /* Menu embaixo de um menu existente */
    //add_dashboard_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_posts_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_plugin_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_media_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_links_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_pages_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_comments_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_plugins_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_users_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_management_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_options_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_theme_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    
}

add_action('admin_menu', 'theme_options_menu');


/**
 * Faz a validação dos dados
 * 
 */
function theme_options_validate_callback_function($input) {
	
	if ( ! empty( $_FILES['logo']['name'] ) )
	{

		$allowed_file_types = array('jpg' =>'image/jpg','jpeg' =>'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png');
		
		if ( ! in_array( $_FILES['logo']['type'], $allowed_file_types ) )
			wp_die( __( 'Sorry, this file type is not permitted for security reasons.' ) );
		
		/*
		 * O antigo wp_handle_upload( $_FILES[$field], array( 'test_form' => false ) ); foi substituído
		 */
		$upload = media_handle_upload( 'logo', 0 );
		
		if ( $upload )
			$input['logo'] = $upload;

	}
	else 
	{
		
		if ( isset( $_POST['restore-default-image'] ) && $_POST['restore-default-image'] == 1 )
		{
			unset( $input['logo']);
		}
		else
		{
			$logo = get_theme_option( 'logo' );
		
			if ( ! empty( $logo ) )
				$input['logo'] = get_theme_option( 'logo' );
		}
	}
    
    return $input;

}


/**
 * Cria o formulário com as opções
 * 
 */
function theme_options_page_callback_function() {
    
    // Crie o formulário. Abaixo você vai ver exemplos de campos de texto, textarea e checkbox. Crie quantos você quiser
    global $blog_id;
    ?>
	<div class="wrap span-20">
		<h2>
			<?php
			_e( 'Pan-Amazonian Network Options', 'theme options page', 'panamazonica' );
			
			if ( $blog_id > 1 ) :
				echo '<br/><small>';
				printf( __( '%s Group', 'theme options page', 'panamazonica'), get_blog_details( $blog_id )->blogname );
				echo '</small>';
			endif;
			?>
		</h2>
		
		<form action="options.php" method="post" class="panamazonica-theme-options clear prepend-top" enctype="multipart/form-data">
		  	<?php settings_fields('theme_options_options'); ?>
		  	<?php $options = wp_parse_args( get_option('theme_options'), get_theme_default_options() );?>
			
			<?php //////////// Edite a partir daqui ////////// ?>
			
			<?php if ( $blog_id == 1 ) : ?>
			<h3><?php _e( 'Featured Text', 'theme options page', 'panamazonica' ); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="lead_text"><?php _e( 'Text', 'theme options page', 'panamazonica' ); ?></label></th>
						<td>
							
							<textarea id="lead_text" name="theme_options[lead_text]" rows="3" cols="80"><?php echo htmlspecialchars($options['lead_text']); ?></textarea>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="lead_link"><?php echo _x( 'Link', 'theme options page', 'panamazonica' ) . ' ' . _x( '<span class="description">(with http://)</span>', 'theme options page', 'panamazonica' ); ?></label></th>
						<td>
							<input type="text" id="lead_link" class="text" name="theme_options[lead_link]" placeholder="http://" size="78" value="<?php echo htmlspecialchars($options['lead_link']); ?>"/>
						</td>
					</tr>
				</tbody>
			</table>
			
			<h3><?php _e( 'Social Networks', 'theme options page', 'panamazonica' ); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="facebook"><?php echo _x( 'Facebook', 'theme options page', 'panamazonica' ) . ' ' . _x( '<span class="description">(with http://)</span>', 'theme options page', 'panamazonica' ); ?></label></th>
						<td>
							<input type="text" id="facebook" class="text" name="theme_options[facebook]" size="78" value="<?php echo htmlspecialchars($options['facebook']); ?>"/>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="twitter"><?php echo _x( 'Twitter', 'theme options page', 'panamazonica' ) . ' ' . _x( '<span class="description">(with http://)</span>', 'theme options page', 'panamazonica' ); ?></label></th>
						<td>
							<input type="text" id="twitter" class="text" name="theme_options[twitter]" size="78" value="<?php echo htmlspecialchars($options['twitter']); ?>"/>
						</td>
					</tr>
				</tbody>
			</table>
			
			<?php else : ?>
		
			<h3><?php _e( 'Logo', 'theme options page', 'panamazonica' ); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="logo"><?php _e( 'Group Thumbnail', 'theme options page', 'panamazonica' ); ?></label></th>
						<td>
							<?php $default_image = get_blog_default_image(); ?>
							
							<?php $logo_url = ( is_int( $options['logo'] ) ) ? wp_get_attachment_thumb_url( $options['logo'] ) : $default_image; ?>
							<img src="<?php echo $logo_url; ?>" class="uploaded-logo" alt="Logo" width="150" height="150" />
							<p>
								<label for="logo"><?php _e( 'Upload an image from your computer', 'theme options page', 'panamazonica' ); ?></label><br/>
								<input id="logo" type="file" name="logo" value="" size="78" />
							</p>
							
							<?php if ( $logo_url != $default_image ) : ?>
								<a href="#" class="remove-custom-logo"><?php _e( 'Remove image', 'theme options page', 'panamazonica' ); ?></a>
							<?php endif; ?>
							
							<input type="hidden" name="default-image-src" class="default-image-src" value="<?php echo get_blog_default_image(); ?>" />
							
						</td>
					</tr>
				</tbody>
			</table>
			
			<?php endif; ?>
			
			<h3><?php _e( 'Footer Text', 'theme options page', 'panamazonica' ); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="footer_text"><?php _e( 'Text', 'theme options page', 'panamazonica' ); ?></label></th>
						<td>
							<textarea id="footer_text" name="theme_options[footer_text]" rows="3" cols="80"><?php echo htmlspecialchars($options['footer_text']); ?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
			
			  
			<?php ///// Edite daqui pra cima //// ?>
		  
			<p class="submit clear prepend-top">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'default' ); ?>" />
			</p>
		</form>
	</div><!-- /wrap -->

	<?php
} 

/**
 * Recebe as opções do tema
 * 
 */
function get_theme_option($option_name) {
    $option = wp_parse_args( 
        get_option('theme_options'), 
        get_theme_default_options()
    );
    
    return isset($option[$option_name]) ? $option[$option_name] : false;
}

/**
 * Cria uma mensagem para as opções salvas
 * 
 */
function theme_options_admin_notice() {
    global $pagenow;

    if ( $_GET['page'] == 'theme_options' && isset($_GET['settings-updated'] ) ) {
         echo '<div class="updated"><p><strong>';
         _e( 'Settings saved.', 'default' );
         echo '</strong></p></div>';
    }
}

function theme_options_enqueue_scripts(  ) {
	
	wp_enqueue_script( 'theme-options', get_bloginfo( 'stylesheet_directory' ) . '/js/theme-options.js', array( 'jquery' ) );
}
?>