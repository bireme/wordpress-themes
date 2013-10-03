<?php
/**
 * Faz a configuração inicial do tema
 *
 */
function panamazonica_setup() {

	// define o tamanho da área de conteúdo
	global $content_width;
	if ( !isset( $content_width ) )
		$content_width = 540;

	// torna o tema traduzível
	load_theme_textdomain( 'panamazonica', get_template_directory() . '/languages' );

	// adiciona estilo ao editor
	add_editor_style();

	// adiciona os links pros feeds padrão
	add_theme_support( 'automatic-feed-links' );

	// adiciona suporte a imagens destacadas
	add_theme_support( 'post-thumbnails' );

	// adiciona os tamanhos
	//add_image_size( 'destaque', 488, 300, true );

	// registra os menus
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'panamazonica' ),
		'secondary' => __( 'Secondary Menu', 'panamazonica' )
	) );

	// registra as áreas de widgets
	add_action( 'widgets_init', 'panamazonica_register_sidebars' );

	require_once( get_template_directory() . '/inc/widgets.php' );

	// adiciona o suporte a fundo personalizado
	$bg_args = array(
		'default-color' => 'f5f4ef',
		'default-image' => get_template_directory_uri() . '/images/bg.jpg'
	);
	add_theme_support( 'custom-background', $bg_args );

	// remove o estilo padrão das galerias
	add_filter( 'use_default_gallery_style', '__return_false' );

	// filtra os padroes dos uploads
	update_option( 'image_default_link_type', 'none' );
	update_option( 'image_default_align', 'center' );

	// adiciona as opções do tema
	require_once( get_template_directory() . '/inc/theme-options.php' );

	// adiciona a página de contato
	require_once( get_template_directory() . '/inc/opcoes-de-contato.php' );

	// adiciona os post types
	require_once( get_template_directory() . '/inc/post-type-agenda.php' );
	require_once( get_template_directory() . '/inc/post-type-documentos.php' );

	// chama o hacklab_posts2home
	require_once( get_template_directory() . '/inc/hacklab_post2home/hacklab_post2home.php' );

	// define widgets padrao pra lateral
	if ( isset( $_GET['activated'] ) ) {
		update_option( 'widget_agenda', array( 2 => array( 'title' => ''), '_multiwidget' => 1 ) );
		update_option( 'widget_documentos', array( 2 => array( 'title' => ''), '_multiwidget' => 1 ) );
		update_option( 'sidebars_widgets', array ( 'wp_inactive_widgets' => array ( ), 'primary-widget-area' => array ( 0 => 'widget_agenda-2', 1 => 'recent-posts-2', 2 => 'widget_documentos-2' ) ) );
	}

	// adiciona às opções do menu uma meta box com link para os arquivos dos post types (agenda, documento etc)
	add_action( 'admin_head-nav-menus.php', 'panamazonica_cpt_archive_menu_meta_box' );
	add_filter( 'wp_get_nav_menu_items', 'panamazonica_cpt_archive_menu_filter', 10, 3 );

	// chama o custom uploader
	require_once( get_template_directory() . '/inc/custom-uploader.php' );

}
add_action( 'after_setup_theme', 'panamazonica_setup' );

/**
 * Registra as áreas de widgets
 *
 */
function panamazonica_register_sidebars() {

	// Lateral
  	register_sidebar( array (
  		'name' => __( 'Primary Aside','panamazonica' ),
  		'description' => __( 'Sidebar content','panamazonica' ),
  		'id' => 'primary-widget-area',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget' => "</div>",
  		'before_title' => '<h3 class="widget-title">',
  		'after_title' => '</h3>',
  	) );
}

/**
 * Adiciona a logo do site na tela de login.
 *
 */
function panamazonica_custom_login_logo() {
	echo '
	<style type="text/css">
		.login h1 a {
			background: url("' . get_bloginfo('stylesheet_directory') . '/images/panamazonica.png") top center no-repeat;
			background-size: 100% auto;
			margin: 0 auto;
			min-height: 70px;
			width: 300px;
			height: auto;
		}
	</style>';
}
add_action( 'login_head', 'panamazonica_custom_login_logo', 11 );


/**
 * Troca o underscore padrão que inicia os custom fields ocultos por outro caractere
 *
 * @return bool Verdadeiro para meta keys que começam com hífen ("-")
 */
function unprotected_meta( $protected, $meta_key ) {

	$protected = ( '-' == $meta_key[0] );

	return $protected;

}
//add_filter( 'is_protected_meta', 'unprotected_meta', 10, 2 );


/**
 * Cria a fila dos scripts usados no site
 *
 */
function panamazonica_load_scripts() {

	// jQuery Cycle
	wp_enqueue_script( 'cycle', get_template_directory_uri() . '/js/jquery.cycle.all.js', array( 'jquery' ), '' );

	// jQuery Tabs
	wp_enqueue_script( 'jquery-ui-tabs' );

	// jQuery CookieBar
	wp_enqueue_script( 'cookiebar', get_template_directory_uri() . '/js/jquery.cookieBar.js', array( 'jquery' ), '' );

	//jQuery do projeto
	wp_enqueue_script('panamazonica_projeto', get_template_directory_uri().'/js/panamazonica.js', array('jquery'));

	//jQuery validate
	wp_enqueue_script('panamazonica_validate', get_template_directory_uri().'/js/jquery.validate.js', array('jquery'));

	// Comment reply
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
		wp_enqueue_script( 'comment-reply' );

}

add_action( 'wp_enqueue_scripts', 'panamazonica_load_scripts' );


/**
 * Chama os scripts no <head>
 *
 */
function panamazonica_head_scripts() {

	if ( get_current_blog_id() == 1 && ( is_front_page() || is_home() ) ) : ?>

	<script>
	jQuery(document).ready(function() {
		jQuery('#headline').cookieBar({
			closeButton : '.close-button'
		});
	});
	</script>

	<?php
	endif;
}

add_action( 'wp_head', 'panamazonica_head_scripts' );


/**
 * Chama os scripts do rodapé
 *
 */
function panamazonica_scripts() {
	?>
	<script>
		jQuery(document).ready(function() {
			<?php if ( is_front_page() || is_home() ) : ?>
			// Slider
		    jQuery('.slider') .after('<div class="navigation slider-navigation">').cycle({
		        fx:     'fade',
		        speed:  '700',
		        fit: 	1,
		        height: 280,
		        pager:  '.slider-navigation'
		    });
		    <?php endif; ?>

		    // Tabs
		    jQuery('.tabs-agenda').tabs();
		});
	</script>
	<?php
}

add_action( 'wp_footer', 'panamazonica_scripts' );


function panamazonica_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'panamazonica' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span aria-hidden="true" data-icon="&#xf0a8;"></span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span aria-hidden="true" data-icon="&#xf0a9;"></span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( sprintf( __('%s Older posts', 'panamazonica' ), '<span aria-hidden="true" data-icon="&#xf0a8;"></span>' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="icon-alone nav-home"><span aria-hidden="true" data-icon="&#x2302;"></span><span class="assistive-text"><?php _e( 'Home', 'panamazonica' ); ?></span></a>
			<div class="nav-next"><?php previous_posts_link( sprintf( __('Newer posts %s', 'panamazonica' ), '<span aria-hidden="true" data-icon="&#xf0a9;"></span>' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}


/**
 * Retorna os logins digitados dentro do custom field '_panamazonica_team'
 *
 */
function panamazonica_get_team() {
	global $post;

	$equipe = get_post_meta( $post->ID, '_pan_team', true );

	if ( $equipe ) {

		// Transforma em minúsculas e cria um array
		$equipe = strtolower( $equipe );
		$equipe = explode( ',', $equipe );

		return $equipe;
	}
}


/**
 * Cria um título bem formatado e mais específico
 * pra mostrar no cabeçalho do documento, baseado na página sendo visualizada
 *
 */
function panamazonica_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Adiciona o nome do site.
	$title .= get_bloginfo( 'name' );

	// Adiciona a descrição do site pra home/primeira página.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Adiciona o número da página, se necessário.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'panamazonica' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'panamazonica_wp_title', 10, 2 );


/**
 * Adiciona os favicons aos pingbacks & trackbacks
 *
 */
function panamazonica_get_favicon( $url = '' ) {
	if ( ! empty ( $url ) )
		$url = parse_url( $url );

	$url = 'http://www.google.com/s2/favicons?domain=' . $url['host'];

	return $url;
}


function panamazonica_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
    ?>
    <li class="pingback">
       	<?php if(function_exists('panamazonica_get_favicon')) { ?><img src="<?php echo panamazonica_get_favicon( $comment->comment_author_url ); ?>" alt="Favicon" class="favicon" /><?php } ?><?php comment_author_link(); ?><?php edit_comment_link( sprintf( __( '%1$sEdit%2$s', 'f451' ), '<span aria-hidden="true" data-icon="&#x270d;"></span><span class="assistive-text">', '</span>' ) ); ?>
    <?php
            break;
        default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment-container">
            <div class="comment-content">
            	<?php comment_text(); ?>
            </div><!-- /comment-content -->

            <footer class="comment-meta vcard">
            	<div class="comment-author-avatar">
            		<?php echo get_avatar( $comment, 96 ); ?>
            	</div>
            	<cite class="fn">
	            	<?php echo get_comment_author_link(); ?>
            	</cite>
            	<?php comment_reply_link( array_merge( $args, array( 'reply_text' => '<span aria-hidden="true" data-icon="&#xe712;"></span><span class="assistive-text">Reply</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            	<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php printf( __( '%1$s at %2$s', 'panamazonica' ), get_comment_date(), get_comment_time() ); ?>" class="comment-permalink icon-alone"><span aria-hidden="true" data-icon="&#x1f517;"></span><span class="assistive-text"><? _e('Permalink', 'panamazonica'); ?></span></a>
            	<?php edit_comment_link( sprintf( __( '%1$sEdit%2$s', 'f451' ), '<span aria-hidden="true" data-icon="&#x270d;"></span><span class="assistive-text">', '</span>' ) ); ?>
            </footer>

            <?php if ( $comment->comment_approved == '0' ) : ?>
            	<em class="comment-on-hold"><?php _e( 'Your comment is awaiting moderation.', 'panamazonica' ); ?></em>
            <?php endif; ?>

        </article><!-- /comment -->

    <?php
            break;
    endswitch;
}


if( !function_exists('wp_get_sites') ) {
	/**
	 * Return a list of sites for the current network
	 *
	 * @since 3.5.0
	 *
	 * @param array|string $args Optional. Override default arguments.
	 * @return array site list and values
	 */
	function wp_get_sites( $args = array() ) {
		// replacement for wp-includes/ms-deprecated.php#get_blog_list
		// see wp-admin/ms-sites.php#352
		//  also wp-includes/ms-functions.php#get_blogs_of_user
		//  also wp-includes/post-template.php#wp_list_pages
		global $wpdb;

		$defaults = array(
			'include_public'	=> '1',			// Include blogs marked as public
			'include_archived'	=> '0',			// Include archived sites
			'include_mature'	=> '0',			// Included blogs marked as mature
			'include_spam'		=> '0',			// Include sites marked as "spam"
			'include_deleted'	=> '0',			// Include deleted sites
			'domain'			=> '',			// domain is this value
			'path'				=> '',			// path is like this value
			'reg_date_since'	=> '',			// sites registered since (accepts pretty much any valid date like tomorrow, today, 5/12/2009, etc.)
			'reg_date_before'	=> '',			// sites registered before
			'sort_column'		=> 'registered',// or last_updated, blogname, site_id.
			'order'				=> 'desc',		// or asc
			'limit_results'		=> '',			// return this many results
			'start'				=> '',			// return results starting with this item
			'postcount'			=> false		// add postcount info - default to false
		);

		$r = wp_parse_args( $args, $defaults );
		extract( $r, EXTR_SKIP );

		$query = "SELECT * FROM $wpdb->blogs WHERE site_id = %d ";
		$query_args = Array( $wpdb->siteid );

		foreach( Array( 'public', 'archived', 'mature', 'spam', 'deleted' ) as $param ) {
			$var = "include_{$param}";
			$var = $$var;
			if ( $var == 1 )
				$query .= " AND $param = '1' ";
			elseif ( ( $var === 0 ) || ( $var === '0' ) )
				$query .= " AND $param = '0' ";
		}

		if ( !empty( $domain ) ) {
			$query .= " AND ( domain = '%s' ) ";
			$query_args[] = $domain;
		}

		if ( !empty( $path ) ) {
			$query .= " AND ( path LIKE '%%%s%%' ) ";
			$query_args[] = $path;
		}

		if( !empty( $reg_date_since ) ) {
			$query .= " AND unix_timestamp( b.date_registered ) > '%s' ";
			$query_args[] = strtotime( $reg_date_since );
		}
		if( !empty( $reg_date_before ) ) {
			$query .= " AND unix_timestamp( b.date_registered ) < '%s' ";
			$query_args[] = strtotime( $reg_date_before );
		}

		$sort_column = strtolower( $sort_column );

		if ( !in_array( $sort_column, Array( 'registered', 'last_updated', 'blog_id', 'domain' ) ) )
			$sort_column = 'registered';

		$query .= " ORDER BY {$sort_column} ";
		$order = strtoupper( $order );
		if ( $order !== 'ASC' ) $order = 'DESC';
		$query .= $order;

		if ( !empty( $start ) || !empty( $limit_results ) ) {
			if ( empty( $start ) )
				$start = 0;
			else
				$start = absint( $start );
			if ( empty( $limit_results ) )
				$limit_results = '18446744073709551615'; // 2^64 - 1 -- see docs for LIMIT in http://dev.mysql.com/doc/refman/5.0/en/select.html
			else
				$limit_results = absint( $limit_results );

			if ( empty( $start ) ) {
				if ( !empty( $limit_results ) ) $query .= " LIMIT $limit_results";
			} else {
				$query .= " LIMIT $start, $limit_results";
			}
		}

		$blogs = $wpdb->get_results( $wpdb->prepare( $query, $query_args ), ARRAY_A );
		$blog_list = Array();

		foreach ( (array) $blogs as $details ) {
			$blog_list[ $details['blog_id'] ] = $details;
			if ( $postcount )
				$blog_list[ $details['blog_id'] ]['postcount'] = $wpdb->get_var( "SELECT COUNT(ID) FROM " . $wpdb->get_blog_prefix( $details['blog_id'] ). "posts WHERE post_status='publish' AND post_type='post'" );
		}
		unset( $blogs );
		$blogs = $blog_list;

		if ( false == is_array( $blogs ) )
			return array();

		return $blogs;
	}
}


/**
 * Adiciona novos tipos para upload
 *
 * @param array $mime_types O array original
 * @return array $mime_types O array com os novos tipos
 *
 * @see get_allowed_mime_types() A lista dos mimes cadastrados
 * @see http://www.freeformatter.com/mime-types-list.html
 */
function panamazonica_upload_mimes( $mime_types ) {

    $mime_types['doc'] = 'application/msword';
    $mime_types['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    $mime_types['odt'] = 'application/vnd.oasis.opendocument.text';
    $mime_types['ppt|pps'] = 'application/vnd.ms-powerpoint';

    return $mime_types;

}

add_filter( 'upload_mimes', 'panamazonica_upload_mimes' );


/**
 * IDs originais
 *
 * Retorna os IDs originais (blog e post) do post
 *
 */
function panamazonica_get_original_ids( $id = 0 ) {

	global $blog_id;

	// É necessário estar no blog principal para pegar os dados
	if ( $blog_id != 1 )
		switch_to_blog( 1 );

	$post = &get_post($id);
	$id = isset( $post->ID ) ? $post->ID : (int) $id;

	$original_ids = array();

	if ( $original_blog_id = get_post_meta( $id, '_original_blog_id', true ) )
		$original_ids['blog_id'] = $original_blog_id;

	if ( $original_post_id = get_post_meta( $id, '_original_post_id', true ) )
		$original_ids['post_id'] = $original_post_id;

	if ( $original_ids )
		return $original_ids;
	else
		return false;

}


/**
 * Retorna o nome do blog
 *
 */
function panamazonica_get_original_blogname( $id ) {


	$id = ( ! empty( $id ) ) ? (int) $id : get_current_blog_id();

	$original_blogname = get_blog_details( $id )->blogname;

	if ( $original_blogname )
		return $original_blogname;

}


/**
 * Cria um link com o nome do site
 *
 */
function panamazonica_get_site_link( $blog_id ) {

	if ( (int) $blog_id )
	{
		$blogname = get_blog_details( $blog_id )->blogname;
		$blogurl = get_site_url( $blog_id );
		$output .= '<a href="' . $blogurl . '" title="">' . $blogname . '</a>';

		return $output;
	}
	else
		return false;
}


/**
 * Cria a estrutura que lista todos os grupos
 *
 */
function panamazonica_grupos_tematicos() {
	?>
	<div class="groups over">
	    <h3 class="area-title"><?php _e( 'Thematic Groups', 'panamazonica' ); ?></h3>
	    <ul class="groups-list cf">

	    	<?php
	    	if ( $network_sites = wp_get_sites( array( 'sort_column' => 'blogname' ) ) ) :
	    		foreach ( $network_sites as $network_site ) :
		    		// Pula o site principal e omite o site da biblioteca
		    		if ( $network_site['blog_id'] == 1 || $network_site['path'] == '/biblioteca/')
		    			continue;

		    		$site = get_blog_details( $network_site['blog_id'] );

		    		switch_to_blog( $network_site['blog_id'] );

		    		$logo = get_theme_option('logo'); ?>
		    		
		    		<li class="group">
		    			<a href="<?php echo $site->siteurl; ?>" title="<?php echo $site->blogname; ?>">		    		
			    			<?php
			    			if ( is_int( $logo ) )
			    				echo '<img src="' . wp_get_attachment_thumb_url( $logo ) . '" alt="'. $site->blogname . '" />';
			    			else
			    				echo '<span class="group-name">' . $site->blogname . '</span>';
			    			?>
		    			</a>
		    		</li>
		    		
		    		<?php
		    		restore_current_blog();

		    	endforeach;
	    	endif;

	    	?>
	    </ul>
    </div><!-- /grupos -->
	<?php
}


/**
 * Retorna a data do evento no formato "dd/mm/yy a dd/mm/yy"
 *
 * @param int $post_id O ID do post
 * @return string $string A data no formato "dd/mm/yy a dd/mm/yy"
 */
function panamazonica_get_agenda_date( $post_id = 0 ) {

	global $post;

	if ( (int) $post_id == 0 )
		$post_id = $post->ID;

	$format = 'd/m/y';

	$data_inicial = get_post_meta( $post_id, '_pan_data_inicial', true );

    if ( $data_inicial )
    	$data_inicial = date( $format, strtotime( $data_inicial ) );

    $data_final = get_post_meta( $post_id, '_pan_data_final', true );

    if ( $data_final )
    	$data_final = date( $format, strtotime( $data_final ) );

    $string = ( ! $data_final || $data_inicial == $data_final ) ? $data_inicial : $data_inicial . ' a ' . $data_final;

    return $string;

}


/**
 * Lista no blog
 *
 */
function panamazonica_posts_rede() {

	restore_current_blog();

	global $blog_id, $post; ?>

	<div class="acontece over loop cf">
	    <h3 class="area-title"><?php _e('Latest news', 'panamazonica'); ?></h3>

	    <?php
	    $this_blog_id = $blog_id;

	    // Realiza a query no blog principal
	    switch_to_blog( 1 );

	    $rede = new WP_Query( array( 'posts_per_page' => 4, 'ignore_sticky_posts' => 1, 'meta_key' => '_original_blog_id', 'meta_value' => $this_blog_id, 'meta_compare' => '!=' ) );

	    if ( $rede->have_posts() ) : while ( $rede->have_posts() ) : $rede->the_post();
	    ?>

	    <article class="hentry">
        	<h2 class="entry-title">
        		<a href="<?php the_permalink(); ?>">
        			<?php

        			$this_post_id = $post->ID;

        			$original_ids = panamazonica_get_original_ids();

					// Busca o post thumbnail no blog original e depois volta para o site da rede
					switch_to_blog( $original_ids['blog_id'] );
					echo get_the_post_thumbnail( $original_ids['post_id'], 'post-pequeno' );
					switch_to_blog(1);

					the_title(); ?>

					<small>
        			<?php
        			$original_blog_id = ( $original_ids ) ? $original_ids['blog_id'] : 1;
        			
        			/* translators: author and blog name (example: Por Leonardo em Telessaúde) */
	        		printf( __( 'By %1$s in %2$s', 'panamazonica' ), get_the_author(), get_blog_details( $original_ids['blog_id'] )->blogname );
        			?>
        			</small>

        		
        		</a>
        	</h2>
        </article>

	    <?php
	    endwhile; endif;

	    switch_to_blog( $this_blog_id );
	    ?>
    </div><!-- /acontece -->
	<?php

}


/**
 * Retorna o valor do metadado
 *
 * @param string $meta_key O nome da chave
 * @return string|bool O meta value
 */
function panamazonica_get_documento_meta( $meta_key, $id = false ) {

	global $post;

	$id =  ( $id ) ? $id : get_current_blog_id();
	$meta_key = sanitize_title( $meta_key );

	// Se os metadados do blog original estiverem setados quer dizer que é uma cópia
	if ( get_post_meta( $post->ID, '_is_copy', true ) )
	{

		$original_blog_id = get_post_meta( $post->ID, '_original_blog_id', true );
		$original_post_id = get_post_meta( $post->ID, '_original_post_id', true );

		switch_to_blog( $original_blog_id );
		$meta = get_post_meta( $original_post_id, $meta_key, true );
		restore_current_blog();

	}
	else
	{
		$meta = get_post_meta( $post->ID, $meta_key, true );
	}

	if ( $meta )
		return $meta;

}

/**
 * Gerencia os módulos e chama as funções de acordo com as escolhas feitas no theme options
 *
 */
function panamazonica_modulos( $theme_option ) {

	$modulo = get_theme_option( $theme_option );

	if ( $modulo )
	{
		switch ( $modulo )
		{
			case 'ultimos_documentos' :
				panamazonica_ultimos_documentos();
			break;
			case 'ultimos_posts' :
				panamazonica_ultimos_posts();
			break;
			case 'agenda' :
				panamazonica_agenda();
			break;
		}
	}

}


function panamazonica_ultimos_posts() {
	?>
	<h3 class="area-title">Tópicos recentes</h3>
	<?php
	$posts = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 4 ) );

    if ( $posts->have_posts() ) : while ( $posts->have_posts() ) : $posts->the_post(); ?>

    <article>
    	<h2 class="entry-title">
    		<a href="<?php the_permalink(); ?>">
    			<?php the_title(); ?>
    		</a>
    	</h2>
    </article>
    <?php
    endwhile; endif;
}


/**
 * Enfileira os scripts
 *
 */
function panamazonica_enqueue_admin_scripts( $hook ) {

    global $wp_scripts, $post_type;

    if( in_array( $post_type, array( 'agenda', 'documento' ) ) ) {

    	// DatePicker scripts
    	wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery','jquery-ui-core' ) );
    	wp_enqueue_script( 'panamazonica-datepicker', get_stylesheet_directory_uri() . '/js/datepicker.js', array( 'jquery','jquery-ui-core' ) );

    	// DatePicker styles
    	$ui = $wp_scripts->query( 'jquery-ui-core' );
    	$url = 'http://code.jquery.com/ui/' . $ui->ver . '/themes/redmond/jquery-ui.css';
	    wp_enqueue_style( 'jquery-ui-redmond', $url, false, $ui->ver );

    }
}
add_action( 'admin_enqueue_scripts', 'panamazonica_enqueue_admin_scripts' );


/**
 * Remove os widgets da lista usada pelo plugin Eletro Widgets
 *
 * @param array $widgets A lista dos widgets registrados
 * @return array $widgets A lista com os widgets filtrados
 */

function panamazonica_ew_remove_widgets( $widgets ) {

	$unallowed_widgets = array(
		//'WP_Widget_Archives',
		//'WP_Widget_Calendar',
		//'WP_Widget_Categories',
		//'WP_Widget_Links',
		//'WP_Widget_Meta',
		//'WP_Widget_Pages',
		//'WP_Widget_Recent_Comments',
		//'WP_Widget_Recent_Posts',
		//'WP_Widget_RSS',
		//'WP_Widget_Search',
		//'WP_Widget_Tag_Cloud',
		//'WP_Widget_Text',
		//'WP_Nav_Menu_Widget',
	);

	foreach ( $widgets as $key => $widget )
	{
		if ( in_array( get_class($widget['callback'][0]), $unallowed_widgets ) )
            unset( $widgets[$key] );
    }

    return $widgets;

}
add_filter( 'ew_registered_widgets', 'panamazonica_ew_remove_widgets' );


/**
 * Filtro pros campos de contato do usuário
 */
function panamazonica_user_contactmethods( $user_contactmethods ) {

	// remove os desnecessarios
	unset( $user_contactmethods['yim'] );
	unset( $user_contactmethods['aim'] );
	unset( $user_contactmethods['jabber'] );

	// adiciona os uteis
	$user_contactmethods['lattes'] = __( 'Curriculum Lattes', 'panamazonica' );
	$user_contactmethods['phone'] = __( 'Phone', 'panamazonica' );
	$user_contactmethods['mobile'] = __( 'Mobile', 'panamazonica' );

	return $user_contactmethods;

}
add_filter( 'user_contactmethods', 'panamazonica_user_contactmethods' );

/**
 * Adiciona campos extras ao perfil do usuário
 * E podia ter um filtro pra isso também!
 */
function panamazonica_add_custom_user_profile_fields( $user ) {
?>
	<h3><?php _e('Extra Profile Information', 'panamazonica'); ?></h3>
	<table class="form-table">
		<tr>
			<th>
				<label for="country"><?php _e( 'Country', 'panamazonica' ); ?></label>
			</th>
			<td>
				<input type="text" name="country" id="country" value="<?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="institution"><?php _e( 'Institution', 'panamazonica' ); ?></label>
			</th>
			<td>
				<input type="text" name="institution" id="institution" value="<?php echo esc_attr( get_the_author_meta( 'institution', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="occupation"><?php _e( 'Occupation', 'panamazonica' ); ?></label>
			</th>
			<td>
				<input type="text" name="occupation" id="occupation" value="<?php echo esc_attr( get_the_author_meta( 'occupation', $user->ID ) ); ?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="activity"><?php _e( 'Activity', 'panamazonica' ); ?></label>
			</th>
			<td>
				<input type="text" name="activity" id="activity" value="<?php echo esc_attr( get_the_author_meta( 'activity', $user->ID ) ); ?>" class="regular-text" /><span class="description"><?php _e( 'Your role in the Network', 'panamazonica' ); ?></span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="themes"><?php _e( 'Themes of interest', 'panamazonica' ); ?></label>
			</th>
			<td>
				<input type="text" name="themes" id="themes" value="<?php echo esc_attr( get_the_author_meta( 'themes', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
	</table>
<?php }
add_action( 'show_user_profile', 'panamazonica_add_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'panamazonica_add_custom_user_profile_fields' );


/**
 * Grava no banco os campos extras
 * adicionados em panamazonica_add_custom_user_profile_fields()
 */
function panamazonica_save_custom_user_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;
	update_usermeta( $user_id, 'country', $_POST['country'] );
	update_usermeta( $user_id, 'institution', $_POST['institution'] );
	update_usermeta( $user_id, 'occupation', $_POST['occupation'] );
	update_usermeta( $user_id, 'activity', $_POST['activity'] );
	update_usermeta( $user_id, 'themes', $_POST['themes'] );
}
add_action( 'personal_options_update', 'panamazonica_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'panamazonica_save_custom_user_profile_fields' );


/**
 * Define network globals
 */
function ms_define_globals() {
   global $blog_id;
   $GLOBALS['staging'] = ( strstr( $_SERVER['SERVER_NAME'], 'redepanamazonica.mu' ) ) ? true : false;
}
add_action( 'init', 'ms_define_globals', 1 );


/**
 * Display page request info
 *
 * @requires $staging
 */
function wp_page_request_info() {
   	global $staging;

   	if ( $staging )
   	{
   		echo '<div class="num-queries">';
   		echo '- ' . get_num_queries() . ' queries em ' . timer_stop() . ' segundos -';
   		echo '</div>';
   	}

}
add_action( 'wp_footer', 'wp_page_request_info', 1000 );


/**
 * Cria a meta box para a equipe
 *
 */
function panamazonica_team_meta_box() {

	// Campo para preenchimento da equipe apenas dentro do template team.php
    if ( isset( $_GET['post'] ) )
    {
    	$post_id = $_GET['post'];
    	$template_file = get_post_meta( $post_id, '_wp_page_template', true );
    }

	if ( isset( $template_file ) && $template_file == 'page-templates/team.php' )
	{
		add_meta_box(
			'panamazonica_team',
			__( 'Team', 'panamazonica' ),
			'panamazonica_team_meta_box_callback',
			'page',
			'normal',
			'high'
		);
	}

}
add_action( 'add_meta_boxes', 'panamazonica_team_meta_box' );


/**
 * Callback para a criação da meta box "panamazonica_team"
 *
 */
function panamazonica_team_meta_box_callback( $post ) {

    // Recebe os valores
	$meta_value = get_post_meta( $post->ID, '_pan_team', true );

	// Usa o nonce para verificação
	wp_nonce_field( 'panamazonica-team-submit', 'panamazonica-team-check-nonce' );

	echo '<label for="panamazonica-team">';
	_e( 'Add your team by writing their usernames, comma-separated:', 'panamazonica' );
	echo '</label><br/>';
	echo '<input type="text" id="panamazonica-team" name="panamazonica-team" value="' . $meta_value . '" size="100%" />';

}


/**
 * Salva os dados inseridos nas meta boxes
 *
 */
function panamazonica_save_postdata( $post_id ) {

	global $post;


	// Verifica o autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	  return;

	// Não salva o campo caso seja uma revisão
	if ( isset( $post->post_type ) && $post->post_type == 'revision' )
		return;

	// Verifica as permissões
	if ( isset( $post->post_type ) && $post->post_type == 'page' ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return;
	}
	else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;
	}

	// Salvamos os dados para o template team.php
	if ( isset( $post->post_type ) && $post->post_type == 'page' && get_post_meta( $post_id, '_wp_page_template', true ) == 'page-templates/team.php' ){

		// Verifica o nonce
		if( !isset( $_POST['panamazonica-team-check-nonce'] ) || !wp_verify_nonce( $_POST['panamazonica-team-check-nonce'], 'panamazonica-team-submit'  ) )
			return $post_id;

    	// Recebe os valores
    	if ( isset( $_POST['panamazonica-team'] ) )
	    	$meta_value = $_POST['panamazonica-team'];

    	// Atualiza o valor do meta
    	if ( isset( $meta_value ) )
    		update_post_meta( $post_id, '_pan_team', esc_attr( $meta_value ) );

	}

}

add_action( 'save_post', 'panamazonica_save_postdata' );


/**
 * Cria a meta box para o Custom Post Type Archives
 *
 * @link http://bit.ly/WWLiEI Referência para a função
 */
function panamazonica_cpt_archive_menu_meta_box() {
	add_meta_box( 'add-cpt', __( 'Archives' ), 'wp_nav_menu_cpt_archives_meta_box', 'nav-menus', 'side', 'default' );
}


/**
 * Define todos os campos para o Custom Post Type Archives
 *
 * @link http://bit.ly/WWLiEI Referência para a função
 */
function wp_nav_menu_cpt_archives_meta_box() {

	$post_types = get_post_types( array( 'show_in_nav_menus' => true, 'has_archive' => true ), 'object' );

	// Alimenta o walker com as propriedades
	foreach ( $post_types as &$post_type )
	{
		$post_type->classes = array();
		$post_type->type = $post_type->name;
		$post_type->object_id = $post_type->name;
		$post_type->title = $post_type->labels->name;
		$post_type->object = 'cpt-archive';
	}

	$walker = new Walker_Nav_Menu_Checklist( array() ); ?>

	<div id="cpt-archive" class="posttypediv">
		<div id="tabs-panel-cpt-archive" class="tabs-panel tabs-panel-active">
			<ul id="ctp-archive-checklist" class="categorychecklist form-no-clear">
				<?php echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $post_types), 0, (object) array( 'walker' => $walker) ); ?>
			</ul>
		</div><!-- /.tabs-panel -->
	</div>

	<p class="button-controls">
		<span class="add-to-menu">
			<img class="waiting" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
			<input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-ctp-archive-menu-item" id="submit-cpt-archive" />
		</span>
	</p>
	<?php
}


/**
 * Troca as URLs para os objetos do tipo cpt-archive
 *
 * @link http://bit.ly/WWLiEI Referência para a função
 */
function panamazonica_cpt_archive_menu_filter( $items, $menu, $args ) {

	foreach ( $items as &$item )
	{
		if ( $item->object != 'cpt-archive' )
			continue;

		$item->url = get_post_type_archive_link( $item->type );

		// Define o current
		if ( get_query_var( 'post_type' ) == $item->type )
		{
			$item->classes[]= 'current-menu-item';
			$item->current = true;
		}
	}

	return $items;

}


/**
 * Carrega os pointers para serem usados
 *
 * @link http://wp.tutsplus.com/tutorials/integrating-with-wordpress-ui-admin-pointers/
 */
function panamazonica_pointer_load() {

	// Don't run on WP < 3.3
	if ( get_bloginfo( 'version' ) < '3.3' )
	    return;

	// Pointers para a tela atual
	$screen = get_current_screen();
	$screen_id = $screen->id;
	$pointers = apply_filters( 'panamazonica_admin_pointers-' . $screen_id, array() );


	if ( ! $pointers || ! is_array( $pointers ) )
	    return;

	// Recebe os pointers dispensados
	$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

	// Verifica os pointers e remove os dispensados
	$valid_pointers = array();

	foreach ( $pointers as $pointer_id => $pointer )
	{
	    // Sanity check
	    if ( in_array( $pointer_id, $dismissed ) || empty( $pointer )  || empty( $pointer_id ) || empty( $pointer['target'] ) || empty( $pointer['options'] ) )
	        continue;

	    // Adiciona os pointes a lista de válidos
	    $pointer['pointer_id'] = $pointer_id;
	    $valid_pointers['pointers'][] =  $pointer;
	}

	if ( empty( $valid_pointers ) )
	    return;

	// Pointer style
	wp_enqueue_style( 'wp-pointer' );

	// Custom pointer script
	wp_enqueue_script( 'panamazonica-pointer', get_bloginfo( 'stylesheet_directory' ) . '/js/panamazonica-pointer.js', array( 'wp-pointer' ) );

	// Adiciona as opções do pointer ao script
	wp_localize_script( 'panamazonica-pointer', 'panamazonicaPointer', $valid_pointers );
}

add_action( 'admin_enqueue_scripts', 'panamazonica_pointer_load', 1000 );


/**
 * Pointer para o post type Documento
 *
 * @return array $p O pointer cadastrado
 */
function panamazonica_pointer_documento( $p ) {
    $p['pointer-documento'] = array(
        'target' => '#panamazonica-documentos',
        'options' => array(
            'content' => sprintf( '<h3>%s</h3><p>%s</p>',
                __( 'About the Document', 'panamazonica' ),
                __( 'Provide the document data, such as source, year of publication, authors and collaborators. Remember: the more information you add, the easier will be to find this document through the search.', 'panamazonica' )
            ),
            'position' => array( 'edge' => 'right', 'align' => 'top' )
        )
    );

    return $p;
}

add_filter( 'panamazonica_admin_pointers-documento', 'panamazonica_pointer_documento' );


/**
 * Pointer para o post type Agenda
 *
 * @return array $p O pointer cadastrado
 */
function panamazonica_pointer_agenda( $p ) {

    $p['pointer-agenda'] = array(
        'target' => '#agenda_tipo',
        'options' => array(
            'content' => sprintf( '<h3>%s</h3><p>%s</p>',
                __( 'About the Agenda', 'panamazonica' ),
                __( 'Select the event type (event or meeting) and enter the area above, along other data you consider important.', 'panamazonica' )
            ),
            'position' => array( 'edge' => 'right', 'align' => 'top' )
        )
    );

    return $p;
}

add_filter( 'panamazonica_admin_pointers-agenda', 'panamazonica_pointer_agenda' );

/**
 * Recent_Posts widget class
 *
 * @since 2.8.0
 */
class WP_Widget_Recent_Posts_new extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site") );
		parent::__construct('recent-posts', __('Recent Posts'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts_new', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
				<small class="the_author">/ Por <?php the_author_posts_link(); ?></small>

			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts_new', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = (bool) $new_instance['show_date'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts_new', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
	}
}
function register_widget_post_recent_new() {
	register_widget( 'WP_Widget_Recent_Posts_new' );
}

add_action( 'widgets_init', 'register_widget_post_recent_new' );


//homepage featured news 
if ( function_exists('register_sidebar') )

   	register_sidebar( array (
  		'name' => __( 'Featured News','panamazonica' ),
  		'description' => __( 'News from the management group of the network','panamazonica' ),
  		'id' => 'featured-news',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget' => '</div>',
  		'before_title' => '<h3 class="widget-title">',
  		'after_title' => '</h3>',
  	) );
  

?>
