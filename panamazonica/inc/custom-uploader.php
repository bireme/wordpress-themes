<?php

add_action( 'admin_init', array( 'CustomUploader', 'init' ) );


class CustomUploader
{
	public function init()
    {

        if ( ! isset( $this ) )
            return new CustomUploader();

        // Adiciona os filtros apenas dentro do contexto do uploader
		if ( $this->check_custom_uploader_context('panamazonica-custom-uploader') )
		{
			
			add_filter( 'gettext', array( $this, 'custom_uploader_gettext' ), 1, 3 );
		    add_filter( 'media_upload_tabs', array( $this, 'custom_uploader_tabs') , 10, 1 );
		    add_filter( 'attachment_fields_to_edit', array( $this, 'custom_uploader_attachment_fields' ), 20, 2 );
		    add_filter( 'post_mime_types', array( $this, 'custom_uploader_mime_types' ) );
		    add_filter( 'upload_mimes', array( $this, 'custom_uploader_restrict_file_types' ) );
		    add_action( 'pre_get_posts', array( $this, 'list_allowed_types' ) );
		    add_action( 'admin_enqueue_scripts', array( $this, 'disable_gallery' ) );
		    
		}
		
		add_action( 'admin_enqueue_scripts', array( $this, 'custom_uploader_enqueue_scripts' ) );
		add_action( 'admin_print_scripts', array( $this, 'custom_uploader' ), 99 );
		
    }
    
    /**
     * Filtra a query para mostrar apenas os tipos permitidos para upload
     *
     * @param array $wp_query_obj A query
     * @uses self::get_custom_uploader_allowed_types()
     */
    function list_allowed_types( $wp_query_obj )
    {

	    global $pagenow;
	
	    if( 'media-upload.php' != $pagenow )
	        return;
	    
	    $allowed_mime_types = $this->get_custom_uploader_allowed_types();
	    
	    if ( $allowed_mime_types )
	    	$allowed_mime_types = implode( ', ', $allowed_mime_types );
	    
	    $wp_query_obj->set( 'post_mime_type', $allowed_mime_types );
	
	    return;
	    
	}
	
	/**
	 * Lista os formatos permitidos dentro do custom uploader
	 * 
	 * @return array $allowed_mime_types Os tipos permitidos
	 */
	function get_custom_uploader_allowed_types( $mime_types = array() ) {
		
		if ( empty( $mime_types ) )
			$mime_types = get_allowed_mime_types();
		
		$allowed_mime_types = $mime_types;
		
		foreach ( $mime_types as $key => $value )
		{
			if ( wp_match_mime_types( 'image, audio, video', $value ) )
				unset( $allowed_mime_types[$key] );
		}
		
		return $allowed_mime_types;
		
	}
    
    /**
     * @see init()
     */
    public function __construct()
    {
        $this->init();
    }
    
    /**
     * Restringe os uploads, removendo o upload de audio, videos ou imagens
     * 
     * @param array $mime_types O array com os tipos permitidos
     * @return array $allowed_mime_types O novo array apenas com os elementos permitidos
     * @uses self::get_custom_uploader_allowed_types()
     */
    function custom_uploader_restrict_file_types($types)
    {
    
		$allowed_mime_types = $this->get_custom_uploader_allowed_types( $types );
		
		if ( $allowed_mime_types )
			return $allowed_mime_types;
		
    }
    
    /**
     * Remove o tipo Imagem da coluna da Biblioteca
     * 
     */
    function custom_uploader_mime_types ( $type )
    {
	    
	    unset( $type['image'] );
	    
	    return $type;
	    
    }
   
    /**
     * Cria o custom uploader
     * 
     */
	function custom_uploader() {
	?>
		<script>
			jQuery(document).ready(function()
			{
			 
			 	var targetfield = false;
			 	
			 	jQuery('.custom-uploader-button').click(function() {
			         tb_show('', '<?php echo $this->create_custom_uploader_url(); ?>');
			         
			         targetfield = true;
			         
			         return false;
			    });
			    
			 	
			    window.original_send_to_editor = window.send_to_editor;
				
				window.send_to_editor = function(html) {
				
				    if ( targetfield == true ) {
					    
				        fileurl = jQuery( html ).attr( 'href' );
				        console.dir(fileurl);
				        jQuery('.custom-uploader').val(fileurl);
				        
				        targetfield = false;
				        
				        tb_remove();
				
				    } else {
				
				        window.original_send_to_editor(html);
				
				    }
				
				}
			 
			});
		</script>
	<?php
	} 
	   
    /**
     * Cria o link que será usado para chamar o custom uploader
     * 
     */
    function create_custom_uploader_url( $type = '' )
    {
	    
	    $custom_uploader_url = get_upload_iframe_src( $type, null );
		$custom_uploader_url = remove_query_arg( array('TB_iframe'), $custom_uploader_url );
		$custom_uploader_url = add_query_arg( array( 'context' => 'panamazonica-custom-uploader', 'TB_iframe' => 1 ), $custom_uploader_url );
		
		return $custom_uploader_url;
    }
    
    /**
	 * Enfileira os scripts para o theme options
	 *
	 * @param string $hook O hook sendo usado 
	 */
	function custom_uploader_enqueue_scripts($hook)
	{
			
		//Media Uploader Scripts
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		
		//Media Uploader Style
		wp_enqueue_style('thickbox');
		
	}
	
	/**
	 * Muda o texto "Insert into Post" para apenas "Insert"
	 *
	 * @param string $translated O texo que já foi traduzido
	 * @param string $source_text Texto original
	 * @param string $domain Domínio
	 *
	 * @see http://www.viper007bond.com/2011/07/13/changing-core-wordpress-strings/ Referência
	 */
	function custom_uploader_gettext( $translated, $original, $domain ) {
							
	    $strings = array(
	        'Insert into Post' => 'Insert'
	    );
	 
	    if ( isset( $strings[$original] ) ) {
	        $translations = &get_translations_for_domain( $domain );
	        $translated = $translations->translate( $strings[$original] );
	    }
	 
	    return $translated;
		
	}
	
	/**
	 * Remove as abas desnecessárias e filtra o contador da galeria
	 * 
	 * @uses $wpdb
	 * @uses self::get_custom_uploader_allowed_types
	 * @uses wp_post_mime_type_where() Cria o SQL para os mime types
	 *
	 * @param array $default_tabs As abas default
	 * @see http://shibashake.com/wordpress-theme/how-to-hook-into-the-media-upload-popup-interface Hack para o media uploader
	 */
	function custom_uploader_tabs( $default_tabs )
	{
	
		global $wpdb;
		
		$post_id = intval( $_REQUEST['post_id'] );
		
		// Hack para o count apenas mostrar os tipos permitidos de arquivo
		$allowed_mime_types = $this->get_custom_uploader_allowed_types();
		
		$gallery_query = "SELECT count(*)
            	FROM $wpdb->posts
            	WHERE post_type = 'attachment'
            	AND post_status != 'trash'
            	AND post_parent = %d";
            	
        $gallery_query .= wp_post_mime_type_where( $allowed_mime_types );

        if ( $post_id )
            $attachments = intval( $wpdb->get_var( $wpdb->prepare( $gallery_query, $post_id ) ) );

        if ( ! empty( $attachments ) )
        	$default_tabs['gallery'] = sprintf( __('Gallery (%s)'), "<span id='attachments-count'>$attachments</span>" );
        	
        // Remove as tabs desnecessárias (opções: 'type', 'type_url', 'gallery', 'library')
	    unset( $default_tabs['type_url'] );
	
	    return $default_tabs; 
	}
	
	/**
	 * Verifica o contexto do uploader
	 * 
	 * @see http://shibashake.com/wordpress-theme/how-to-hook-into-the-media-upload-popup-interface Hack para o media uploader
	 */
	function check_custom_uploader_context( $context ) {
		global $pagenow; 
		
	    if ( isset( $_REQUEST['context'] ) && $_REQUEST['context'] == $context || strpos( wp_get_referer(), $context ) !== false )
	    {
	        add_filter( 'media_upload_form_url', array( $this, 'add_my_context_to_url' ), 10, 2 );
	        return true;
	    }
	    
	    return false;
	}
	
	/**
	 * Adiciona o contexto a url
	 * 
	 * @see http://shibashake.com/wordpress-theme/how-to-hook-into-the-media-upload-popup-interface Hack para o media uploader
	 */
	function add_my_context_to_url( $url, $type ) {
	    
	    if (isset( $_REQUEST['context'] ) ) {
	        $url = add_query_arg( 'context', $_REQUEST['context'], $url );
	    }
	    
	    return $url;    
	}
	
	/**
	 * Filtra os campos desnecessários para o uploader
	 *
	 * @see http://wordpress.stackexchange.com/questions/42767/thickbox-hacking-removing-fields Referência
	 */
	function custom_uploader_attachment_fields( $form_fields, $post ) {
		
		unset(
	        $form_fields['post_title'],
	        $form_fields['url'],
	        $form_fields['image_alt'], 
	        $form_fields['post_excerpt'], 
	        $form_fields['post_content'], 
	        $form_fields['align'], 
	        $form_fields['image-size']
	    );
	    
	    // Filtra para que o URL sempre receba o endereço do arquivo
	    $url_value = wp_get_attachment_url( $post->ID );
	    $form_fields['url'] = array( 'input' => 'hidden', 'value' => $url_value );
	 
	    // Adiciona o contexto
	    $form_fields['context'] = array( 'input' => 'hidden', 'value' => 'panamazonica-custom-uploader' );
	    
	    return $form_fields;
	}
	
	/**
     * Remove as opções da galeria do custom uploader
     * 
     */
    function disable_gallery()
    {
	    wp_deregister_script( 'admin-gallery' );
    }
	
}