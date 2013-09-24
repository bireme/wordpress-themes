<?php
/**
 * Registra o post type Documentos
 *
 */
class Documentos {

	public static $custom_meta_fields;

    static function init() {

    	$prefix = '_pan_';

		// A lista de sites
		$sites = wp_get_sites();

    	if ( $sites ) {
        	$sites_dropdown = array();

        	foreach ( $sites as $site ) {

        		if ( $site['blog_id'] == 1 )
        			continue;

        		$sites_dropdown[] = array(
        			'label' => get_blog_details( $site['blog_id'] )->blogname,
        			'value' => $site['blog_id']
        		);
        	}
    	}

	    self::$custom_meta_fields = array(
			array(
		        'label'			=> __('Publication Source', 'panamazonica'),
		        'description'  	=> '',
		        'id'    		=> $prefix . 'fonte',
		        'type'  		=> 'text',
		        'description'	=> ''
	        ),
	        array(
		        'label'			=> __('Year',   'panamazonica'),
		        'description'  	=> '',
		        'id'    		=> $prefix . 'ano',
		        'type'  		=> 'text',
		        'description'	=> ''
		    ),
		    array(
		        'label'			=> __('Place',   'panamazonica'),
		        'description'  	=> '',
		        'id'    		=> $prefix . 'local',
		        'type'  		=> 'text',
		        'description'	=> ''
		    ),
		    array(
		        'label'			=> __('Author',   'panamazonica'),
		        'description'  	=> '',
		        'id'    		=> $prefix . 'autor',
		        'type'  		=> 'text',
		        'description'	=> ''
		    ),
		    array(
		        'label'			=> __('Collaborators',   'panamazonica'),
		        'description'  	=> '',
		        'id'    		=> $prefix . 'colaboradores',
		        'type'  		=> 'text',
		        'description'	=> ''
		    ),
		    array(
		        'label'=> __('Language',   'panamazonica'),
		        'description'  	=> '',
		        'id'    => $prefix.'idioma',
		        'type'  => 'select',
		        'options' => array (
		            array (
		                'label' => __('Portuguese',   'panamazonica'),
		                'value' => 'pt'
		            ),
		            array (
		                'label' => __('Spanish',   'panamazonica'),
		                'value' => 'es'
		            ),
		            array (
		                'label' => __('English',   'panamazonica'),
		                'value' => 'en'
		            )
		        )
		    ),
		    array(
		        'label'			=> __('Link',   'panamazonica'),
		        'description'  	=> '',
		        'id'    		=> $prefix . 'link',
		        'type'  		=> 'upload',
		        'description'	=> 'Fill in the field with a link or upload a file.'
		    ),
	    );

        add_action( 'init', array( __CLASS__, 'register' ) );
        add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
        add_action( 'save_post', array( __CLASS__, 'save_postdata' ) );
        add_action( 'pre_get_posts', array( __CLASS__, 'pre_get_posts' ) );
        //add_filter('menu_order', array(__CLASS__, 'change_menu_label'));
        //add_filter('custom_menu_order', array(__CLASS__, 'custom_menu_order'));

    }


    /**
     * Registra o post type
     *
     */
    static function register() {

        $args = array(
            'name' => _x( 'Documents', 'post type general name', 'panamazonica' ),
            'singular_name' => _x( 'Document', 'post type singular name', 'panamazonica' ),
            'add_new' => _x( 'Add New', 'documento', 'panamazonica' ),
            'add_new_item' => __( 'Add New Document', 'panamazonica' ),
            'edit_item' => __( 'Edit Document', 'panamazonica' ),
            'new_item' => __( 'New Document', 'panamazonica' ),
            'view_item' => __( 'View Document', 'panamazonica' ),
            'search_items' => __( 'Search Documents', 'panamazonica' ),
            'not_found' =>  __( 'No Document Found', 'panamazonica' ),
            'not_found_in_trash' => __( 'No Document Found in the trash', 'panamazonica' )
         );

        register_post_type( 'documento', array(
        	'labels' => $args,
			'public' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 6,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'author', 'excerpt', 'custom-fields' ),
			//'taxonomies' => array( 'post_tag', 'category' )
        ) );

    }


    /**
     * Adiciona a meta box ao post type
     *
     */
    static function add_meta_box() {

	    add_meta_box(
	        'panamazonica-documentos',
	        __( 'About the document', 'panamazonica' ),
	        array( __CLASS__,'meta_box_cb' ),
	        'documento',
	        'side'
	    );

    }


    /**
     * Callback que cria a estrutura da meta box
     *
     */
    static function meta_box_cb( $post ) {

        // Cria o nonce para verificação
        wp_nonce_field( 'save_documento', 'documento_noncename' );


        foreach ( self::$custom_meta_fields as $field ) {

	        // Recebe os metadados
	        $meta_value =  get_post_meta( $post->ID, $field['id'], true );

	        // Cria a estrutura
	        echo '<p><label for="' . $field['id'] . '">' . $field['label'] . ':</label><br/>';

	        switch ( $field['type'] ) {

	        	// Texto
	        	case 'text':
			        echo '<input type="text" id="' . $field['id'] . '" class="widefat" name="' . $field['id'] . '" value="' . esc_attr( $meta_value ) . '" size="25" />';
			    break;

			    // Dropdown
				case 'select':
					echo '<select class="widefat" name="' . $field['id'] . '" id="' . $field['id'] . '">';
					foreach ( $field['options'] as $option ) {
						echo '<option value="' . $option['value'] . '"' , $meta_value == $option['value'] ? ' selected="selected"' : '' , '>' . $option['label'] . '</option>';
					}
					echo '</select>';
				break;

				// Upload
				case 'upload':
					echo '<input type="text" id="' . $field['id'] . '" class="widefat custom-uploader" name="' . $field['id'] . '" value="' . esc_attr( $meta_value ) . '" size="25" />';
					echo '<br/><br/>';
					echo '<a href="#" id="set-default-image" class="custom-uploader-button button thickbox">Fazer upload</a>';
				break;

			}

			if ( $field['description'] )
				echo '<br/><br/><span class="description">' . $field['description'] . '</span>';

			echo '</p>';

        }

    }


    /**
     * Salva os metadados
     *
     */
    function save_postdata( $post_id ) {

    	global $post;

    	if ( wp_is_post_revision( $post_id ) )
    		return;

        // Verifica o autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		  return;

		// Não salva o campo caso seja uma revisão
		if ( $post->post_type == 'revision' )
			return;

		// Verifica o nonce
        if ( ! wp_verify_nonce( $_POST['documento_noncename'], 'save_documento' ) )
            return;

        // Permissões
        if ( $post->post_type == 'documento' )
		{
			if ( ! current_user_can( 'edit_post', $post_id ) )
		    	return;
		}

		foreach ( self::$custom_meta_fields as $field )
		{
			$old = get_post_meta( $post_id, $field['id'], true );
			$new = $_POST[$field['id']];

			if ( $new && $new != $old )
			    update_post_meta( $post_id, $field['id'], $new );
			elseif ( $new == '' && $old )
				delete_post_meta( $post_id, $field['id'], $old );
	    }
    }

    /**
     * Prepara a query para ser filtrada pela pesquisa dos documentos
     *
     * @param object $wp_query
     */
    static function pre_get_posts( $wp_query ) {

    	global $paged;

        if( ! $wp_query->is_main_query() )
        	return;

        if ( is_admin() )
        	return;

        if ( $wp_query->query_vars['post_type'] === 'documento' && is_post_type_archive('documento'))
        {

        	if ( $_POST['reset'] == 'reset' )
        	{
        		$_SESSION = array();
        		session_unset();
        		session_destroy();
        	}

        	if ( ! empty( $_POST['_pan_fonte']  ) ) $_SESSION['_pan_fonte'] = $_POST['_pan_fonte'];
        	if ( ! empty( $_POST['_pan_ano']  ) ) $_SESSION['_pan_ano'] = $_POST['_pan_ano'];
        	if ( ! empty( $_POST['_pan_local']  ) ) $_SESSION['_pan_local'] = $_POST['_pan_local'];
        	if ( ! empty( $_POST['_pan_autor']  ) ) $_SESSION['_pan_autor'] = $_POST['_pan_autor'];
        	if ( ! empty( $_POST['_pan_colaboradores'] ) ) $_SESSION['_pan_colaboradores'] = $_POST['_pan_colaboradores'];
        	if ( ! empty( $_POST['_pan_idioma'] ) ) $_SESSION['_pan_idioma'] = $_POST['_pan_idioma'];
        	if ( ! empty( $_POST['_pan_grupo']  ) ) $_SESSION['_pan_grupo'] = $_POST['_pan_grupo'];


        	// Se o campo POST não estiver vazio, então adicionamos na query
        	if ( ! empty( $_POST['_pan_fonte'] ) )
        	{
	        	$meta_query[] = array(
                    'key' 		=> '_pan_fonte',
                    'value'		=> esc_attr( $_POST['_pan_fonte'] ),
                    'compare' 	=> 'LIKE',
                    'type' 		=> 'CHAR'
	            );
        	}

        	if ( ! empty( $_POST['_pan_ano'] ) )
        	{
	        	$meta_query[] = array(
                    'key' 		=> '_pan_ano',
                    'value'		=> intval( $_POST['_pan_ano'] ),
                    'compare' 	=> '=',
                    'type' 		=> 'INTEGER'
	            );
        	}

        	if ( ! empty( $_POST['_pan_local'] ) )
        	{
	        	$meta_query[] = array(
                    'key' 		=> '_pan_local',
                    'value'		=> esc_attr( $_POST['_pan_local'] ),
                    'compare' 	=> 'LIKE',
                    'type' 		=> 'CHAR'
	            );
        	}
        	if ( ! empty( $_POST['_pan_autor'] ) )
        	{
        		$raw_authors = esc_attr( $_POST['_pan_autor'] );

        		// Remove as vírgulas e as troca por espaços, se houver
        		$search_items = str_replace(',', ' ', $raw_authors );

        		// Remove múltiplos whitespaces
        		$authors = preg_replace('!\s+!', ' ', $search_items);

        		// Cria a lista com os autores
        		$authors = explode( ' ', $authors );

        		if ( $authors )
        		{
	        		foreach ( $authors as $author )
	        		{
		        		$meta_query[] = array(
		                    'key' 		=> '_pan_autor',
		                    'value'		=> $author,
		                    'compare' 	=> 'LIKE',
		                    'type' 		=> 'CHAR'
			            );
	        		}
        		}
        	}
        	if ( ! empty( $_POST['_pan_colaboradores'] ) )
        	{

	        	$raw_contributors = esc_attr( $_POST['_pan_colaboradores'] );

        		// Remove as vírgulas e as troca por espaços, se houver
        		$search_items = str_replace(',', ' ', $raw_contributors );

        		// Remove múltiplos whitespaces
        		$contributors = preg_replace('!\s+!', ' ', $search_items);

        		// Cria a lista com os autores
        		$contributors = explode( ' ', $contributors );

        		if ( $contributors )
        		{
	        		foreach ( $contributors as $author )
	        		{
		        		$meta_query[] = array(
		                    'key' 		=> '_pan_colaboradores',
		                    'value'		=> $author,
		                    'compare' 	=> 'LIKE',
		                    'type' 		=> 'CHAR'
			            );
	        		}
        		}
        	}
        	if ( ! empty( $_POST['_pan_idioma'] ) )
        	{
	        	$meta_query[] = array(
                    'key' 		=> '_pan_idioma',
                    'value'		=> esc_attr( $_POST['_pan_idioma'] ),
                    'compare' 	=> '=',
                    'type' 		=> 'CHAR'
	            );
        	}
        	elseif ( empty( $_POST['_pan_idioma'] ) && ! empty( $_SESSION['_pan_idioma'] ) )
        	{
	        	unset( $_SESSION['_pan_idioma'] );
        	}
        	if ( ! empty( $_POST['_pan_grupo'] ) && $_POST['_pan_grupo'] > 1 )
        	{
	        	$meta_query[] = array(
                    'key' 		=> '_original_blog_id',
                    'value'		=> intval( $_POST['_pan_grupo'] ),
                    'compare' 	=> '=',
                    'type' 		=> 'INTEGER'
	            );
        	}

        	// Grava a sessão
        	if ( ! empty ( $meta_query ) )
            	$_SESSION['meta_query'] =  $meta_query;

            // Prepara a query
            if ( ! empty ( $_SESSION['meta_query'] ) && empty( $_POST[ 'reset' ] ) )
            	$wp_query->query_vars['meta_query'] = $_SESSION['meta_query'];


        	$wp_query->query_vars['posts_per_page'] = 15;

        	if ( $paged > 0 )
        		$wp_query->query_vars['paged'] = $paged;

        } // if query_vars
    }
}

Documentos::init();
?>
