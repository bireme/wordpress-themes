<?php

const POST_TYPES_SUPPORT_SUGGESTED = array('post', 'page', 'podcast', 'vhl_collection', 'course');

add_action( 'admin_enqueue_scripts', 'suggested_field_scripts' );
function suggested_field_scripts(){

    $file_dir = get_template_directory_uri();

	$screen = get_current_screen();
 
	if (in_array($screen->post_type, POST_TYPES_SUPPORT_SUGGESTED) && $screen->base === 'post') {
		if ( !wp_style_is('bvs-ecos-select2', 'enqueued') ){
			wp_enqueue_style('bvs-ecos-select2', $file_dir .'/inc/assets/libs/select2-4.0.13/css/select2.min.css', array(), '4.0.13');
		}

		if( !wp_script_is('bvs-ecos-select2', 'enqueued') ){
			wp_enqueue_script('bvs-ecos-select2', $file_dir .'/inc/assets/libs/select2-4.0.13/js/select2.min.js', array('jquery'), '4.0.13', false);
		}

		//wp_enqueue_script('bvs-ecos-select2-translation', $file_dir .'/inc/assets/libs/select2-4.0.13/js/i18n/pt-BR.js', array('bvs-ecos-select2'), '4.0.13', false);
		
		// script to init select2 plugin
		wp_enqueue_script('bvs-ecos-suggested-posts', $file_dir .'/inc/assets/js/suggested-posts.js', array('jquery', 'bvs-ecos-select2'));
	}
}

/*
 * Add a metabox
 */
add_action( 'admin_menu', 'metabox_for_suggested_field' ); 
function metabox_for_suggested_field(){
	add_meta_box( 
		'bvs_ecos_suggested_field', //ID
		__('Publicações Relacionadas', 'bvs-ecos'), //title
		'show_suggested_field', //callback
		POST_TYPES_SUPPORT_SUGGESTED, //post type
		'normal', //context
		'default' //priority
	);
}

/*
 * Display the fields inside it
 */
function show_suggested_field( $post_object ) {
   	$post_1 = '';
   	$post_2 = '';
   	$post_3 = '';
   	$post_4 = '';
	
	if(isset($_GET['post']) && $_GET['post'] != ''){
	   $post_1 = get_post_meta( $post_object->ID, 'suggested_footer_post_1', true );
	   $post_2 = get_post_meta( $post_object->ID, 'suggested_footer_post_2', true );
	   $post_3 = get_post_meta( $post_object->ID, 'suggested_footer_post_3', true );
	   $post_4 = get_post_meta( $post_object->ID, 'suggested_footer_post_4', true );
   	}
?>
   <p><?php _e( 'Selecione até 4 publicações para aparecerem ao final da página como conteúdo sugerido.', 'bvs-ecos' ); ?></p>

   <label for="suggested_footer_post_1"><?php _e( 'Publicação 1', 'bvs-ecos' ); ?></label>
   <select id="suggested_footer_post_1" name="suggested_footer_post_1" class="select2-suggested-posts">
	   <?php if(!empty($post_1)){ ?>
		<option value="<?php echo $post_1; ?>" selected>
			<?php echo get_title_select_option_related_post($post_1); ?>
		</option>
	   <?php } ?>
   </select>

   <label for="suggested_footer_post_2"><?php _e( 'Publicação 2', 'bvs-ecos' ); ?></label>
   <select id="suggested_footer_post_2" name="suggested_footer_post_2" class="select2-suggested-posts">
	   <?php if(!empty($post_2)){ ?>
		<option value="<?php echo $post_2; ?>" selected>
			<?php echo get_title_select_option_related_post($post_2); ?>
		</option>
	   <?php } ?>
   </select>

   <label for="suggested_footer_post_3"><?php _e( 'Publicação 3', 'bvs-ecos' ); ?></label>
   <select id="suggested_footer_post_3" name="suggested_footer_post_3" class="select2-suggested-posts">
	   <?php if(!empty($post_3)){ ?>
	   	<option value="<?php echo $post_3; ?>" selected>
			<?php echo get_title_select_option_related_post($post_3); ?>
		</option>
	   <?php } ?>
   </select>

   <label for="suggested_footer_post_4"><?php _e( 'Publicação 4', 'bvs-ecos' ); ?></label>
   <select id="suggested_footer_post_4" name="suggested_footer_post_4" class="select2-suggested-posts">
	   <?php if(!empty($post_4)){ ?>
	   	<option value="<?php echo $post_4; ?>" selected>
	   		<?php echo get_title_select_option_related_post($post_4); ?>
		</option>
	   <?php } ?>
   </select>

   <style type="text/css">
	   #bvs_ecos_suggested_field label{
		   display: block;
		   margin-top: 15px;
		   margin-bottom: 5px;
	   }

	   #bvs_ecos_suggested_field input, #bvs_ecos_suggested_field textarea{
		   width: 100%;
	   }
   </style>
<?php
}

add_action( 'save_post', 'suggested_posts_save_metaboxdata', 10, 2 );
function suggested_posts_save_metaboxdata( $post_id, $post ){
 
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
 
	// if post type is different from our selected one, do nothing
	if ( in_array($post->post_type, POST_TYPES_SUPPORT_SUGGESTED) ){

		if( isset( $_POST['suggested_footer_post_1'] ) )
			update_post_meta( $post_id, 'suggested_footer_post_1', $_POST['suggested_footer_post_1'] );

		if( isset( $_POST['suggested_footer_post_2'] ) )
			update_post_meta( $post_id, 'suggested_footer_post_2', $_POST['suggested_footer_post_2'] );

		if( isset( $_POST['suggested_footer_post_3'] ) )
			update_post_meta( $post_id, 'suggested_footer_post_3', $_POST['suggested_footer_post_3'] );
		
		if( isset( $_POST['suggested_footer_post_4'] ) )
			update_post_meta( $post_id, 'suggested_footer_post_4', $_POST['suggested_footer_post_4'] );
	}
	return $post_id;
}

add_action( 'wp_ajax_post_suggestion', 'get_post_suggestion_ajax_callback' ); // wp_ajax_{action}
function get_post_suggestion_ajax_callback(){
 
	// we will pass post IDs and titles to this array
	$return = array();
 	
	$search_results = new WP_Query(array( 
		's'						=> $_GET['q'], // the search query
		'post_status' 			=> 'publish', // if you don't want drafts to be returned
		'ignore_sticky_posts' 	=> 1,
		'posts_per_page' 		=> 50, // how much to show at once
		//'lang'           		=> get_current_language(),
	));

	if( $search_results->have_posts() ) :
		while( $search_results->have_posts() ) : $search_results->the_post();			
			// shorten the title a little
			//$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
			$title = get_title_select_option_related_post($search_results->post->ID, $search_results->post->post_title);
			$return[] = array( $search_results->post->ID, $title ); // array( Post ID, Post Title )
		endwhile;
	endif;
	
	echo json_encode( $return );
	die;
}

function get_post_type_name_related_post($post_id){
	$post_type = get_post_type($post_id);
	$post_type_object = get_post_type_object($post_type);

	$post_type_name = $post_type_object->labels->singular_name;

	if($post_type_name == 'Episode'){
		$post_type_name = 'EP Podcast';
	}

	return $post_type_name;
}

function get_title_select_option_related_post($post_id, $post_title = null){
	$post_type_name = get_post_type_name_related_post($post_id);

	if(is_null($post_title)){
		$post_title = get_the_title($post_id);
	}

	return '['. $post_type_name .'] '. $post_title;
}