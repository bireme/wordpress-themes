<?php
/*------------------------ CUSTOM FUNCTIONS ------------------------------*/

if ( ! defined( 'BP_AVATAR_THUMB_WIDTH' ) )
	define( 'BP_AVATAR_THUMB_WIDTH', 88 ); //change this with your desired thumb width, default is 50

if ( ! defined( 'BP_AVATAR_THUMB_HEIGHT' ) )
	define( 'BP_AVATAR_THUMB_HEIGHT', 88 ); //change this with your desired thumb height, default is 50

// if ( ! defined( 'BP_AVATAR_FULL_WIDTH' ) )
// 	define( 'BP_AVATAR_FULL_WIDTH', 260 ); //change this with your desired full size, default is 150

// if ( ! defined( 'BP_AVATAR_FULL_HEIGHT' ) )
// 	define( 'BP_AVATAR_FULL_HEIGHT', 260 ); //change this to default height for full avatar, default is 150


//--- RETURN CURRENT LANGUAGE ---//
function get_current_language(){
    if(function_exists('pll_current_language')){
        $lang = pll_current_language();
    }
    else{
        $lang = get_locale();
    }
    return substr($lang , 0, 2);
}

//--- RETURN LIMITED EXCERPT IN CHARACTERS ---//
function the_excerpt_max_charlength($charlength, $post_id = null){
    if(is_null($post_id)){
        $post_id = get_the_ID();
    }

    $excerpt = get_the_excerpt($post_id);
    $charlength++;

    if (mb_strlen($excerpt) > $charlength) {
        $subex = mb_substr($excerpt, 0, $charlength - 5);
        $exwords = explode(' ', $subex);
        $excut = - (mb_strlen($exwords[count($exwords) - 1]));
        if ($excut < 0) {
            echo mb_substr($subex, 0, $excut);
        } else {
            echo $subex;
        }
        echo '[...]';
    } else {
        echo $excerpt;
    }
}

//--- RETURN LIMITED EXCERPT BBPRESS IN CHARACTERS ---//
function the_topic_excerpt_max_charlength($charlength){
    if(!function_exists('bbp_get_topic_excerpt') || !function_exists('bbp_get_topic_id')){
        the_excerpt_max_charlength($charlength);
        return;
    }

    $excerpt = bbp_get_topic_excerpt(bbp_get_topic_id(), 1000);
    $charlength++;

    if (mb_strlen($excerpt) > $charlength) {
        $subex = mb_substr($excerpt, 0, $charlength - 5);
        $exwords = explode(' ', $subex);
        $excut = - (mb_strlen($exwords[count($exwords) - 1]));
        if ($excut < 0) {
            echo mb_substr($subex, 0, $excut);
        } else {
            echo $subex;
        }
        echo '[...]';
    } else {
        echo $excerpt;
    }
}

function get_pages_buddypress(){
    //echo '<h1>TESTE: '. bp_current_component() .'</h1>';//exit;
    return array('groups', 'members', 'activity', 'profile', 'forums', 'settings', 'events', 'docs');
}

function is_page_from_buddypress(){
    if(!function_exists('bp_current_component')){
        return false;
    }

    return in_array(bp_current_component(), get_pages_buddypress());
}

function get_buddypress_group_status(){
    global $groups_template;
    $group = $groups_template->group;

    return $group->status;
}

function get_icon_buddypress_group_status(){
    
    $status = get_buddypress_group_status();

    if('public' == $status){
        $img_name = 'unlocked.png';
    } elseif ( 'hidden' == $status ) {
        $img_name = 'locked.png';
    } elseif ( 'private' == $status ) {
        $img_name = 'locked.png';
    } else {
        $img_name = 'locked.png';
    }

    return get_template_directory_uri() .'/inc/assets/imgs/icons/'. $img_name;
}

function get_date_course($post_id = null){
    if(is_null($post_id)){
        $post_id = get_the_ID();
    }

    $start_date = get_post_meta($post_id, 'start_date', true);
    $end_date = get_post_meta($post_id, 'end_date', true);

    if (!empty($start_date)) {
        $start_date = DateTime::createFromFormat('Ymd', $start_date)->format('d/m/Y');
    }
    
    if (!empty($end_date)) {
        $end_date = DateTime::createFromFormat('Ymd', $end_date)->format('d/m/Y');
    }

    $label = '';
    if(!empty($start_date) && !empty($end_date)){
        $label = $start_date .'  •  '. $end_date;
    }
    else if(!empty($start_date) || !empty($end_date)){
        $label = $start_date . $end_date;
    }

    return $label;
}

function get_date_and_location_course($post_id = null){
    if(is_null($post_id)){
        $post_id = get_the_ID();
    }

    $start_date = get_post_meta($post_id, 'start_date', true);
    $end_date = get_post_meta($post_id, 'end_date', true);
    $location = get_post_meta($post_id, 'location', true);

    if (!empty($start_date)) {
        $start_date = DateTime::createFromFormat('Ymd', $start_date)->format('d/m/Y');
    }
    
    if (!empty($end_date)) {
        $end_date = DateTime::createFromFormat('Ymd', $end_date)->format('d/m/Y');
    }

    $label = '';
    if(!empty($start_date) && !empty($end_date)){
        $label = $start_date .' - '. $end_date .'. ';
    }
    else if(!empty($start_date) || !empty($end_date)){
        $label = $start_date . $end_date .'. ';
    }

    if(!empty($location)){
        $label = $label . $location;
    }

    return $label;
}


//--- Force non logged in users ---//
add_action( 'bp_template_redirect', 'buddydev_members_only_bp_page' );
function buddydev_members_only_bp_page() {
    if (function_exists('bp_get_community_visibility') && bp_get_community_visibility() == 'members') {

        if ( ! is_user_logged_in() && is_buddypress() && ! ( bp_is_register_page() || bp_is_activation_page() ) ) {
            $redirect = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            bp_core_redirect( wp_login_url( $redirect ) );
        }
    }
}


//--- PAGINATION ---//
function wordpress_pagination(){
    global $wp_query;

    $max_num_pages = get_query_var( 'max_num_pages', null ); //value set in search.php
    if( is_null($max_num_pages) ){
        $max_num_pages = $wp_query->max_num_pages;
    }    

    if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}

	//Mid and End sizes
	$mid = 1;
	if($paged == 1){
		$end = 4;
	}
	else if( ($paged > 1) && ($paged < $max_num_pages-5) ){
		$end = 2;
	}
	else{
		$end = 3;
	}


	$big = 999999999;
    if( $max_num_pages > 1){
        echo paginate_links(array(
            //'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'end_size' => $mid, //numbers after of [...]
            'mid_size' => $end,
            'format' => 'page/%#%/',
            'current' => $paged,
            'total' => $max_num_pages,
            'prev_next' => true,
            'prev_text' => '<i class="fa-solid fa-angle-left"></i>',
            'next_text' => '<i class="fa-solid fa-angle-right"></i>',
        ));
    }

    set_query_var( 'max_num_pages', null );
}

add_filter('get_the_archive_title', function($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) { //for custom post types
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});

function get_base_url_direve(){
    // Get the plugin configuration
    $config = get_option('direve_config');
    $endpoint_plugin = (!empty($config['plugin_slug']) ? $config['plugin_slug'] : 'direve');

    // Dynamically get the base WordPress URL
    $base_url = home_url();
    $plugin_url = $base_url . '/' . $endpoint_plugin;

    return $plugin_url;
}

function get_event_items_direve($limit = null) {
    $rss_url = get_base_url_direve() . '/events-feed?q=&filter=';

    // Make a remote GET request to fetch the RSS feed
    $response = wp_remote_get($rss_url);

    // Check if the request resulted in an error
    if (is_wp_error($response)) {
        error_log('Error fetching RSS: ' . $response->get_error_message());
        return []; // Return an empty array if there's an error
    }

    // Validate the HTTP status code (must be 200 OK)
    $status_code = wp_remote_retrieve_response_code($response);
    if ($status_code !== 200) {
        error_log('Invalid response status: ' . $status_code);
        return []; // Return an empty array if status is not 200
    }

    // Retrieve the body of the response
    $rss_content = wp_remote_retrieve_body($response);

    // Check if the content was loaded correctly
    if (empty($rss_content)) {
        error_log('RSS content is empty.');
        return []; // Return an empty array if the content is empty
    }

    // Load the XML content
    $rss_xml = simplexml_load_string($rss_content);

    // Check if the XML was loaded correctly
    if ($rss_xml === false || !isset($rss_xml->channel->item)) {
        error_log('Invalid or empty XML.');
        return []; // Return an empty array if the XML is malformed or contains no items
    }

    // Array to store the extracted items
    $items = [];
    $count = 0; // Initialize counter

    // Iterate over each item in the RSS
    foreach ($rss_xml->channel->item as $item) {
        // Add item to the array
        $items[] = [
            'title' => (string) $item->title,
            'link' => (string) $item->link,
            'description' => (string) $item->description,
        ];

        $count++; // Increment counter

        // Limit the number of items returned if a limit is set
        if ($limit !== null && $count >= $limit) {
            break; // Stop the loop when the limit is reached
        }
    }

    // Return the array of items
    return $items;
}

add_action('wp_ajax_get_event_items_direve', 'ajax_get_event_items_direve');
add_action('wp_ajax_nopriv_get_event_items_direve', 'ajax_get_event_items_direve');
function ajax_get_event_items_direve() {
    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : null;

    $event_items_direve = get_event_items_direve($limit);
    
    if(!empty($event_items_direve)){
        foreach($event_items_direve as $event){
            ?>
            <a href="<?php echo esc_url($event['link']); ?>" class="item-schedule">
                <h4><?php echo esc_html($event['title']); ?></h4>
                <label><?php echo esc_html($event['description']); ?></label>
            </a>
            <?php
        }
    } else {
        echo '<p>' . __("Nenhum evento encontrado", "bvs-ecos") . '</p>';
    }

    wp_die();
}

add_action('template_redirect', 'redirect_priority_theme');
function redirect_priority_theme() {
    
    if (is_singular('priority-theme')) {
        $link_priority_theme = get_post_meta(get_the_ID(), 'link_priority_theme', true);
        
        if (!empty($link_priority_theme)) {
            wp_redirect($link_priority_theme);
            exit;
        }
    }
}


add_filter('template_include', 'custom_newsletter_page_template');
function custom_newsletter_page_template($template) {
    // Check if the "newsletter" parameter is in the URL and is equal to "subscribed"
    if ( isset($_GET['newsletter']) && $_GET['newsletter'] == 'subscribed' ) {
        // Path to the custom template file we are going to create
        return get_template_directory() . '/newsletter-subscribed-template.php';
    }
    return $template;
}

add_filter('body_class', 'remove_body_classes_for_newsletter');
function remove_body_classes_for_newsletter($classes) {    
    if ( isset($_GET['newsletter']) && $_GET['newsletter'] == 'subscribed' ) {
        // remove classes "front-page" and "home-page" from array of classes body
        $classes = array_diff($classes, array('front-page', 'home-page', 'home', 'bp-legacy'));
    }
    return $classes;
}

function get_default_img_url(){
    return get_template_directory_uri() .'/inc/assets/imgs/logo/thumb-500.jpg';
}


add_filter('comment_form_default_fields', 'remove_comment_fields');
function remove_comment_fields($fields) {
    if (isset($fields['url'])) {
        unset($fields['url']);
    }
    return $fields;
}


// Ativa o filtro que intercepta o HTML gerado por the_post_thumbnail()
add_filter( 'post_thumbnail_html', 'custom_post_thumbnail_with_meta', 10, 5 );

/**
 * Insere título e legenda sob a imagem destacada.
 *
 * @param string       $html               O <img> gerado pelo WP.
 * @param int          $post_id            ID do post em exibição.
 * @param int          $post_thumbnail_id  ID do attachment (imagem).
 * @param string|array $size               Tamanho da imagem.
 * @param array        $attr               Atributos extras da tag <img>.
 * @return string      HTML completo (figure>img + meta).
 */
function custom_post_thumbnail_with_meta( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    // Recupera título e legenda do anexo
    $title   = get_the_title( $post_thumbnail_id );
    $caption = wp_get_attachment_caption( $post_thumbnail_id );

    // Monta o wrapper semântco
    $out  = '<figure class="post-thumbnail-wrapper">';
    $out .= $html;
    if ( $title ) {
        $out .= '<h3 class="post-thumbnail-title">' . esc_html( $title ) . '</h3>';
    }
    if ( $caption ) {
        $out .= '<figcaption class="post-thumbnail-caption">' . esc_html( $caption ) . '</figcaption>';
    }
    $out .= '</figure>';

    return $out;
}



// add_action('wp', function() {
//     if (function_exists('bp_get_community_visibility')) {
//         echo '<h1>TESTE: ' . (bp_get_community_visibility()) . '</h1>';
//     }
// });