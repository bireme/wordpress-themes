<?php
class Agenda {

    public static $custom_meta_fields;

    static function init(){

    	$prefix = '_pan_';

    	// Array com os elementos que serão preenchidos
    	self::$custom_meta_fields = array(
			array(
		        'label'			=> __( 'Theme', 'panamazonica' ),
		        'id'    		=> $prefix . 'tema',
		        'type'  		=> 'text',
		        'description'	=> '',
		        'context'		=> array( 'evento', 'reuniao' )
	        ),
	        array(
		        'label'			=> __('Start Date', 'panamazonica'),
		        'id'    		=> $prefix . 'data_inicial',
		        'type'  		=> 'text',
		        'description'	=> '',
		        'context'		=> array( 'evento', 'reuniao' )
		    ),
		    array(
		        'label'			=> __('End Date', 'panamazonica'),
		        'id'    		=> $prefix . 'data_final',
		        'type'  		=> 'text',
		        'description'	=> '',
		        'context'		=> array( 'evento' )
		    ),
		    array(
		        'label'			=> __('Time', 'panamazonica'),
		        'id'    		=> $prefix . 'horario',
		        'type'  		=> 'text',
		        'description'  	=> '',
		        'context'		=> array( 'reuniao' )
		    ),
		    array(
		        'label'			=> __('Place', 'panamazonica'),
		        'id'    		=> $prefix . 'local',
		        'type'  		=> 'text',
		        'description'	=> '',
		        'context'		=> array( 'evento', 'reuniao' )
		    ),
		    array(
		        'label'			=> __('Speaker(s)', 'panamazonica'),
		        'id'    		=> $prefix . 'autor',
		        'type'  		=> 'text',
		        'description'	=> '',
		        'context'		=> array( 'evento' )
		    ),
		    array(
		        'label'			=> __('Organizer', 'panamazonica'),
		        'id'    		=> $prefix . 'organizadores',
		        'type'  		=> 'text',
		        'description'	=> '',
		        'context'		=> array( 'evento' )
		    ),
		    array(
		        'label'			=> __('Event website','panamazonica'),
		        'id'    		=> $prefix . 'url_evento',
		        'type'  		=> 'url',
		        'description'  	=> '',
		        'context'		=> array( 'evento' )
		    ),

		    array(
		        'label'			=> __('Participants', 'panamazonica'),
		        'id'    		=> $prefix . 'participantes',
		        'type'  		=> 'text',
		        'description'	=> '',
		        'context'		=> array( 'reuniao' )
		    ),
		    array(
		        'label'			=> __('Record link', 'panamazonica'),
		        'id'    		=> $prefix . 'link_ata',
		        'type'  		=> 'upload',
		        'description'  	=> 'Fill in the field with a link or upload a file.',
		        'context'		=> array( 'reuniao' )
		    ),

	    );

        add_action( 'init', array( __CLASS__, 'register' ), 0 );
        add_action( 'add_meta_boxes', array( __CLASS__, 'add_custom_box' ) );
        add_action( 'save_post', array( __CLASS__, 'save_postdata' ) );
        add_action( 'pre_get_posts', array( __CLASS__, 'pre_get_posts') );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );

        // Adiciona as colunas ao edit.php
        add_filter( 'manage_agenda_posts_columns', array(__CLASS__, 'manage_posts_columns' ), 9 );
	    add_action( 'manage_agenda_posts_custom_column', array(__CLASS__, 'manage_agenda_columns' ), 10, 2 );

	    // Cria o select com o filtro para os tipos da agenda
	    add_action( 'restrict_manage_posts', array( __CLASS__, 'restrict_manage_posts' ) );

    }

    static function register() {

    	// Post type Agenda
        register_post_type('agenda', array(

            'labels' => array(
                'name' => _x('Agenda', 'post type general name', 'panamazonica'),
                'singular_name' => _x('Agenda', 'post type singular name', 'panamazonica'),
                'add_new' => _x('Add New', 'image', 'panamazonica'),
                'add_new_item' => __('Add New Agenda', 'panamazonica'),
                'edit_item' => __('Edit Agenda', 'panamazonica'),
                'new_item' => __('New Agenda', 'panamazonica'),
                'view_item' => __('View Agenda', 'panamazonica'),
                'search_items' => __('Search Agenda', 'panamazonica'),
                'not_found' =>  __('Nothing Found', 'panamazonica'),
                'not_found_in_trash' => __('Nothing Found in the Trash', 'panamazonica'),
                'parent_item_colon' => ''
             ),
             'public' => true,
             'rewrite' => true,
             'capability_type' => 'post',
             'hierarchical' => false,
             'menu_position' => 6,
             'has_archive' => true,
             'supports' => array(
                 	'title',
                    'editor',
                    'excerpt',
                    'custom-fields',
             ),
             'taxonomies' => array(
                 //'post_tag',
                 //'category'
             )
        ));

        // Taxonomia para os tipos (evento, reunião)
        register_taxonomy( 'agenda_tipo', array( 'agenda' ), array(
			'hierarchical' => true,
			//'labels' => $labels,
			'show_ui' => false,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'agenda_tipo' ),
		));

		// Adiciona os dois tipos de agenda
		if ( ! term_exists( 'evento', 'agenda_tipo' ) )
			wp_insert_term( 'Evento', 'agenda_tipo', array( 'slug' => 'evento' ) );

		if ( ! term_exists( 'reuniao', 'agenda_tipo' ) )
			wp_insert_term( 'Reunião', 'agenda_tipo', array( 'slug' => 'reuniao' ) );


    }

    /* Adds a box to the main column on the Post and Page edit screens */
    static function add_custom_box() {

        // A meta box para os dados
        add_meta_box(
            'agenda_data',
            'Dados da Agenda',
            array( __CLASS__,'inner_custom_box_callback_function' ),
            'agenda', // em que post type eles entram?
            'side' // onde? side, normal, advanced
            //,'default' // 'high', 'core', 'default' or 'low'
            //,array('variáve' => 'valor') // variaveis que serão passadas para o callback
        );


        // A meta box que replica a taxonomia 'agenda_tipo', mas com radio buttons
		add_meta_box(
			'agenda_tipo',
			_x( 'Tipo da Agenda', 'tipo do evento da agenda', 'panamazonica' ),
			array( __CLASS__, 'agenda_tipo_callback_function' ),
			'agenda',
			'side',
			'core'
		);

    }

    /* Prints the box content */
    static function agenda_tipo_callback_function( $post ) {

		$taxonomy = 'agenda_tipo';

		$tax = get_taxonomy( $taxonomy );
		$terms = get_terms( $taxonomy, array( 'hide_empty' => 0 ) );

		// Nome do form
		$name = 'tax_input[' . $taxonomy . ']';

		// Pega o current
		$postterms = get_the_terms( $post->ID, $taxonomy );
		$current = ( $postterms ? array_pop( $postterms ) : false );
		$current = ( $current ? $current->term_id : 0 );

		// Não havendo current, usamos como padrão os eventos
		if ( $current == 0 )
			$current = get_term_by( 'slug', 'evento', $taxonomy )->term_id;
		?>
		<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
		    <div id="<?php echo $taxonomy; ?>-all">
		        <ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy?> categorychecklist form-no-clear">
		            <?php foreach( $terms as $term )
		            {
		                $id = $taxonomy . '-' . $term->term_id;

		                echo '<li id="' . $id . '">';
		                echo '<input type="radio" id="in-' . $id . '" name="'. $name . '" ' .checked( $current, $term->term_id, false ) . 'value="' . $term->term_id . '"/> ';
		                echo '<label for="in-' . $id . '" class="selectit">' . $term->name . '</label></li>';
		            }
		            ?>
		       </ul>
		    </div>
		</div>
		<?php
	}

    static function inner_custom_box_callback_function() {
        global $post;


        // Use nonce for verification
        wp_nonce_field( 'save_agenda', 'agenda_noncename' );

        if ( self::$custom_meta_fields )
        {

	        foreach ( self::$custom_meta_fields as $field )
	        {

		        // Recebe os metadados
		        $meta_value =  get_post_meta( $post->ID, $field['id'], true );

		        if ( $meta_value && $field['id'] == '_pan_data_inicial' )
		        	$meta_value = date('d/m/Y', strtotime($meta_value));

		        if ( $meta_value && $field['id'] == '_pan_data_final' )
		        	$meta_value = date('d/m/Y', strtotime($meta_value));


		        // Define o contexto dos campos e os transforma em classe
		        $context = '';

		        if ( $field['context'] )
		        	$context = implode( ' ', $field['context'] );

		        // Cria a estrutura
		        echo '<p class="' . $context . '"><label for="' . $field['id'] . '">' . $field['label'] . ':</label><br/>';

		        switch ( $field['type'] ) {

		        	// Texto
		        	case 'text':
				        echo '<input type="text" id="' . $field['id'] . '" class="widefat" name="' . $field['id'] . '" value="' . esc_attr( $meta_value ) . '" size="25" />';
				    break;

				    // Dropdown
					case 'url':
						echo '<input type="text" id="' . $field['id'] . '" class="widefat" name="' . $field['id'] . '" value="' . esc_url( $meta_value ) . '" size="25" />';
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

    }

    /* When the post is saved, saves our custom data */
    function save_postdata( $post_id ) {

    	if ( wp_is_post_revision( $post_id ) )
    		return;

        // verify if this is an auto save routine.
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times

        if ( !wp_verify_nonce( $_POST['agenda_noncename'], 'save_agenda' ) )
            return;


        // Check permissions
        if ( 'page' == $_POST['post_type'] )
        {
	        if ( !current_user_can( 'edit_page', $post_id ) )
	            return;
        }
        else
        {
	        if ( !current_user_can( 'edit_post', $post_id ) )
	            return;
        }


        $data_inicial = '_pan_data_inicial';
        $data_final = '_pan_data_final';

        // Testes com a data
        if ( $_POST[$data_inicial] )
        {

	        $initial_date_pt = explode('/', trim($_POST[$data_inicial]));
	        $initial_date_en = $initial_date_pt[2].'-'.$initial_date_pt[1].'-'.$initial_date_pt[0];

	        if ($_POST[$data_final]) {
	            $final_date_pt = explode('/', trim($_POST[$data_final]));
	            $final_date_en = $final_date_pt[2].'-'.$final_date_pt[1].'-'.$final_date_pt[0];
	        }
	        else
	            $final_date_en = $initial_date_en;

        }

        // Recebe o contexto / taxonomia da agenda (evento ou reunião)
        $context =  $_POST['tax_input']['agenda_tipo'];
        $context_slug = get_term_by( 'id', $context, 'agenda_tipo' )->slug;

        foreach ( self::$custom_meta_fields as $field )
		{
			$old = get_post_meta( $post_id, $field['id'], true );

			// Testes para adicionar a data no formato correto
			if ( $field['id'] == $data_inicial )
				$new = date( 'Y-m-d h:i', strtotime( $initial_date_en ) );
			elseif ( $field['id'] == $data_final )
				$new = date( 'Y-m-d h:i', strtotime( $final_date_en ) );
			else
				$new = $_POST[$field['id']];

			if ( in_array( $context_slug, $field['context'] ) )
			{
				if ( empty( $old ) && ! empty( $new ) )
					add_post_meta( $post_id, $field['id'], $new, true );
				elseif ( ! empty( $new ) )
					update_post_meta( $post_id, $field['id'], $new );
				else
					delete_post_meta( $post_id, $field['id'] );
			}
			else
			{
				// O post está fora do contexto
				delete_post_meta( $post_id, $field['id'] );
			}

	    }
    }

    function restrict_manage_posts() {
	    if ( isset( $_GET['post_type'] ) )
	    {
	        $post_type = $_GET['post_type'];

	        if ( post_type_exists( $post_type ) && $post_type=='agenda' )
	        {

	        	$agenda = get_terms( 'agenda_tipo' );

	            $html = '';
	            $html .= '<select id="agenda_tipo" name="agenda_tipo">';
	            $html .= '<option value="all">' . _x( 'Show all types', 'tipos da agenda', 'panamazonica' ) . '</option>';
	            $this_sort = $_GET['agenda_tipo'];

	            foreach( $agenda as $agenda_tipo )
	                $html .= '<option value="' . $agenda_tipo->slug . '"' . selected( $this_sort, $agenda_tipo->slug, false ) .'>' . $agenda_tipo->name . '</option>';

	            $html .= '</select>';

	            echo $html;
	        }
	    }
	}

    /**
     * Adiciona a coluna dos Grupos de Trabalho
     *
     * @param array $defaults As colunas pré-definidas,
     * @return array $defaults As colunas atualizadas
     */
    static function manage_posts_columns( $columns ) {

	    unset( $columns['date'] );

	    foreach ( $columns as $key => $title )
	    {
	    	if ( $key == 'title' )
	    	{
	    		$new_columns[$key] = $title;
	    		$new_columns['data_agenda'] = __( 'Date', 'panamazonica' );
	    		$new_columns['tipo_agenda'] = __( 'Type', 'panamazonica' );
	    	}
	    	else
	    		$new_columns[$key] = $title;
	    }

	    return $new_columns;
	}


	/**
	 * Mostra o nome do Grupo com um link para o Painel
	 *
	 * @param string $column_name O nome da coluna
	 * @param int $id O ID do post
	 */
	static function manage_agenda_columns( $column_name, $post_id ) {

	    switch ( $column_name )
	    {
	    	case 'tipo_agenda' :
		    	$tipo_agenda = wp_get_post_terms( $post_id, 'agenda_tipo' );
		    	echo $tipo_agenda[0]->name;
		    break;

		    case 'data_agenda' :
		    	$format = 'd/m/y';

				$data_inicial = get_post_meta( $post_id, '_pan_data_inicial', true );

			    if ( $data_inicial )
			    	$data_inicial = date( $format, strtotime( $data_inicial ) );

			    $data_final = get_post_meta( $post_id, '_pan_data_final', true );

			    if ( $data_final )
			    	$data_final = date( $format, strtotime( $data_final ) );

			    $data = ( ! $data_final || $data_inicial == $data_final ) ? $data_inicial : $data_inicial . ' a ' . $data_final;

			    echo $data;
		    break;

	    }

	}

    /**
     * Prepara a query para ser filtrada pelos meta keys da agenda
     *
     * @param object $wp_query
     *
     * @todo Filtrar a query para que sejam mostrados eventos que já começaram (data_inicial < date()), mas
     * que ainda estão ocorrendo (data final > date())
     */
    static function pre_get_posts($wp_query) {

        if ( is_admin() && $wp_query->query_vars['post_type'] === 'agenda' )
        {

	        // Lista os itens da agenda em ordem cronológica reversa
        	$wp_query->query_vars['orderby'] = 'meta_value';
            $wp_query->query_vars['meta_key'] = '_pan_data_inicial';
        	$wp_query->query_vars['order'] = 'DESC';

        	// Se o filtro foi acionado, mostramos apenas um tipo de agenda
        	if ( isset( $_GET['agenda_tipo'] ) && $_GET['agenda_tipo'] != 'all' )
        		$wp_query->query_vars['agenda_tipo'] = $_GET['agenda_tipo'];
        	else
        		unset($wp_query->query_vars['agenda_tipo']);

        }
        elseif ( $wp_query->query_vars['post_type'] === 'agenda' && is_post_type_archive('agenda')) {

            if (!is_array($wp_query->query_vars['meta_query'])) $wp_query->query_vars['meta_query'] = array();

            $wp_query->query_vars['orderby'] = 'meta_value';
            $wp_query->query_vars['meta_key'] = '_pan_data_inicial';

            if ($wp_query->query_vars['paged'] > 0 || $_GET['filtro'] == 'passados')
            {
            	$wp_query->query_vars['order'] = 'DESC';
                array_push($wp_query->query_vars['meta_query'],
                    array(
                        'key' => '_pan_data_final',
                        'value' => date('Y-m-d'),
                        'compare' => '<=',
                        'type' => 'DATETIME'
                    )
                );

            }
            else
            {
                $wp_query->query_vars['posts_per_page'] = -1;
                $wp_query->query_vars['order'] = 'ASC';
                array_push($wp_query->query_vars['meta_query'],
                    array(
                        'key' => '_pan_data_inicial',
                        'value' => date('Y-m-d'),
                        'compare' => '>=',
                        'type' => 'DATETIME'
                    )
                );

            }
	    }
    }


    static function enqueue_scripts()
    {
	    global $post;

	    if ( $post->post_type == 'agenda' )
	    	wp_enqueue_script( 'agenda', get_stylesheet_directory_uri() . '/js/agenda.js', array( 'jquery' ) );
    }

}

Agenda::init();

?>
