<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
// LANGUAGE 
global $site_lang;
global $current_language;

$site_lang = get_locale($locale);
$current_language = strtolower(get_bloginfo('language'));

$wpdecs_array_locale = array(
    'pt_BR' => 'pt',
    'en_US' => 'en',
    'es_ES' => 'es'
);

automatic_feed_links();

if ( function_exists('register_sidebar') ) {
    register_sidebar(
        array('name'=>'Coluna 1 ' .  $current_language,
            'id' => 'vhl_column_1_' . $current_language,
            'description' => __('Rede Social da BVS', 'example'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle"><span>',
            'after_title' => '</span></h3>',
        ));
    register_sidebar(
        array('name'=>'Coluna 2 ' . $current_language, 
            'id' => 'vhl_column_2_' . $current_language,
            'description' => __('Rede de Conteúdos da BVS', 'example'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle"><span>',
            'after_title' => '</span></h3>',
        ));
    register_sidebar(
        array('name'=>'Coluna 3 ' . $current_language, 
            'id' => 'vhl_column_3_' . $current_language,
            'description' => __('Rede de Notícias', 'example'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle"><span>',
            'after_title' => '</span></h3>',
        ));
    register_sidebar(
        array('name'=>'Footer ' . $current_language, 
            'id' => 'vhl_footer_' . $current_language,
            'description' => __('Rodapé', 'example'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widgettitle"><span>',
            'after_title' => '</span></h3>',
        ));
}

if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(200, 70, true);
    add_image_size('large_highlight', 580, 340, true);
    add_image_size('medium_highlight', 220, 130, true);
    add_image_size('small_highlight', 60, 40, true);
    add_image_size('icon', 16, 16, true);
}

add_filter( 'manage_edit-aps_columns', 'edit_aps_columns' ) ;
function edit_aps_columns( $columns ) {

    $taxonomies = get_object_taxonomies( 'aps', 'objects' );
    $columns = array();
    $columns['cb'] = '<input type="checkbox" />';
    $columns['title'] = __( 'SOF' );

    foreach ( $taxonomies as $tax => $data ) :
        $columns[$tax] = __( $data->labels->name );
    endforeach;

    $columns['date'] = __( 'Date' );

    return $columns;
}

add_action( 'manage_aps_posts_custom_column', 'manage_aps_columns', 10, 2 );
function manage_aps_columns( $column, $post_id ) {
    global $post;
    $taxonomies = get_object_taxonomies( 'aps' );
    //echo "<pre>"; print_r($taxonomies); echo "</pre>";
    if ( in_array( $column, $taxonomies ) ) :

            /* Get the terms for the post. */
            $terms = get_the_terms( $post_id, $column );

            /* If terms were found. */
            if ( !empty( $terms ) ) {

                $out = array();

                /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                foreach ( $terms as $term ) {
                    $out[] = sprintf( '<a href="%s">%s</a>',
                        esc_url( add_query_arg( array( 'post_type' => $post->post_type, $column => $term->slug ), 'edit.php' ) ),
                        esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $column, 'display' ) )
                    );
                }

                /* Join the terms, separating them with a comma. */
                echo join( ', ', $out );
            }

            /* If no terms were found, output a default message. */
            else {
                _e( 'Nenhum' );
            }

    endif;
}

//add_filter( 'manage_edit-aps_sortable_columns', 'aps_sortable_columns' );
function aps_sortable_columns( $columns ) {

    $taxonomies = get_object_taxonomies( 'aps' );

    foreach ( $taxonomies as $tax ) :
        $columns[$tax] = $tax;
    endforeach;

    return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */
//add_action( 'load-edit.php', 'edit_aps_load' );

function edit_aps_load() {
    add_filter( 'request', 'sort_bvsaps' );
}

/* Sorts the SOFs. */
function sort_bvsaps( $vars ) {

    $taxonomies = get_object_taxonomies( 'aps' );

    /* Check if we're viewing the 'aps' post type. */
    if ( isset( $vars['post_type'] ) && 'aps' == $vars['post_type'] ) {

            /* Check if 'orderby' is set to custom taxonomy. */
            if ( isset( $vars['orderby'] ) && in_array( $vars['orderby'], $taxonomies ) ) {

                /* Merge the query vars with our custom variables. */
                $vars = array_merge(
                    $vars,
                    array(
                        'meta_key' => $vars['orderby'],
                        'orderby' => 'meta_value_num'
                    )
                );
            }
    }

    return $vars;
}

function aps_cp_filter() {
    global $typenow;

    // select the custom taxonomy
    $taxonomies = get_object_taxonomies( 'aps' );

    // select the type of custom post
    if( $typenow == 'aps' ){

        foreach ($taxonomies as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            $terms = get_terms($tax_slug);
            if(count($terms) > 0) {
                echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
                echo "<option value=''>Show All $tax_name</option>";
                foreach ($terms as $term) {
                    echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name . '</option>';
                }
                echo "</select>";
            }
        }
    }
}
add_action( 'restrict_manage_posts', 'aps_cp_filter' );

add_action('admin_head', 'admin_custom_css');
function admin_custom_css() {
    echo '<style>
        .wp-admin select {
            max-width: 200px;
        } 
    </style>';
}

?>
