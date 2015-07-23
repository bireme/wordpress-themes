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

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'SOF' ),
        'ciap2' => __( 'CIAP2' ),
        'tipo-de-profissional' => __( 'Tipo de Profissional' ),
        'date' => __( 'Date' )
    );

    return $columns;
}

add_action( 'manage_aps_posts_custom_column', 'manage_aps_columns', 10, 2 );
function manage_aps_columns( $column, $post_id ) {
    global $post;

    switch( $column ) {

        /* If displaying the 'ciap2' column. */
        case 'ciap2' :

            /* Get the genres for the post. */
            $terms = get_the_terms( $post_id, 'ciap2' );

            /* If terms were found. */
            if ( !empty( $terms ) ) {

                $out = array();

                /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                foreach ( $terms as $term ) {
                    $out[] = sprintf( '<a href="%s">%s</a>',
                        esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'ciap2' => $term->slug ), 'edit.php' ) ),
                        esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'ciap2', 'display' ) )
                    );
                }

                /* Join the terms, separating them with a comma. */
                echo join( ', ', $out );
            }

            /* If no terms were found, output a default message. */
            else {
                _e( 'Nenhum' );
            }

            break;

        /* Just break out of the switch statement for everything else. */
        default :
            break;
    }
}

//add_filter( 'manage_edit-aps_sortable_columns', 'aps_sortable_columns' );
function aps_sortable_columns( $columns ) {

    $columns['ciap2'] = 'ciap2';

    return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */
//add_action( 'load-edit.php', 'edit_aps_load' );

function edit_aps_load() {
    add_filter( 'request', 'sort_bvsaps' );
}

/* Sorts the SOFs. */
function sort_bvsaps( $vars ) {

    /* Check if we're viewing the 'aps' post type. */
    if ( isset( $vars['post_type'] ) && 'aps' == $vars['post_type'] ) {

        /* Check if 'orderby' is set to 'ciap2'. */
        if ( isset( $vars['orderby'] ) && 'ciap2' == $vars['orderby'] ) {

            /* Merge the query vars with our custom variables. */
            $vars = array_merge(
                $vars,
                array(
                    'meta_key' => 'ciap2',
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
    $taxonomies = array('ciap2');

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
                    echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
                }
                echo "</select>";
            }
        }
    }
}
add_action( 'restrict_manage_posts', 'aps_cp_filter' );

?>
