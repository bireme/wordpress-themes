<?php

require "search-bvs-widget.php";

add_action('widgets_init', 'custom_widgets_area');
function custom_widgets_area() {

    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'Header Widget Area',
            'id' => 'header_widget_area',
            'before_widget' => '<div class="widget">',
            'after_widget' => '</div>',
            'description' => 'Add widgets here',
        ));

        register_sidebar(array(
            'name' => 'Search Frontpage Widget Area',
            'id' => 'search_frontpage_widget_area',
            'before_widget' => '<div class="widget">',
            'after_widget' => '</div>',
            'description' => 'Add widgets here',
        ));

        register_sidebar(array(
            'name' => 'Certificate Widget Area',
            'id' => 'certificate_widget_area',
            'before_widget' => '<div class="widget">',
            'after_widget' => '</div>',
            'description' => 'Add widgets here',
        ));

        register_sidebar(array(
            'name' => 'Footer Widget Area',
            'id' => 'footer_widget_area',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'description' => 'Add widgets here',
        ));
    }
}

add_action( 'after_setup_theme', 'register_menu' );
function register_menu() {
    register_nav_menu( 'network', __('Network Menu') );
}


// Register and load the widget
add_action( 'widgets_init', 'custom_load_widget' );
function custom_load_widget() {
    register_widget( 'search_bvs_widget' );
}

function wp_related_posts(){

    $args = array('posts_per_page' => 4, 'post_in'  => get_the_tag_list());
    $the_query = new WP_Query( $args );
    echo '<section id="related_posts" class="row">';
        echo '<div class="col-md-12"><h2 class="title">'. __('Conteúdo Relacionado', 'bvs_lang') .'</h2></div>';
    while ( $the_query->have_posts() ) : $the_query->the_post();
     
        get_template_part( 'template-parts/item', 'post' );

    endwhile;
        echo '<div class="clearfix"></div>';
    echo '</section>';

    wp_reset_postdata();
}

function get_first_embed_media($post_id){

    $post = get_post($post_id);
    $content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
    $embeds = get_media_embedded_in_content( $content );

    if( !empty($embeds) ) {
        //check what is the first embed containg video tag, youtube or vimeo
        foreach( $embeds as $embed ) {
            if( strpos( $embed, 'video' ) || strpos( $embed, 'youtube' ) || strpos( $embed, 'vimeo' ) ) {
                return $embed;
            }
        }

    } else {
        //No video embedded found
        return false;
    }

}

//--- CUSTOM PAGINATION ---//
function wordpress_pagination(){
    global $wp_query;

    $max_num_pages = get_query_var( 'max_num_pages', null ); //value set in search.php
    if( is_null($max_num_pages) ){
        $max_num_pages = $wp_query->max_num_pages;
    }

    $big = 999999999;

    if( $max_num_pages > 1){
        echo paginate_links(array(
            //'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => 'page/%#%/',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $max_num_pages,
            'prev_text' => '<i class="fas fa-angle-double-left"></i>',
            'next_text' => '<i class="fas fa-angle-double-right"></i>',
        ));
    }

    set_query_var( 'max_num_pages', null );
}

//--- MODIFY COMMENT FIELDS ---//
add_filter('comment_form_default_fields', 'modify_comment_fields');
function modify_comment_fields($fields) {

    //Variables necesarias para que esto funcione
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $fields =  array(
        'author' =>
            '<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
            '" size="30"' . $aria_req . ' placeholder="' . __('Name') . '" />',
    
        'email' =>
            '<input id="email" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
            '" size="30"' . $aria_req . ' placeholder="' . __('Email') . '" />',
    
        'url' => ''
    ); 
    
    return $fields;
}

//--- MODIFY LIST COMMENTS ---//
if ( !function_exists( 'wp_bvs_comments' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function wp_bvs_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        // Display trackbacks differently than normal comments.
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <p><?php _e( 'Pingback:' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Editar)', 'bvs_lang' ), '<span class="edit-link">', '</span>' ); ?></p>
    <?php
            break;
        default :
        // Proceed with normal comments.
        global $post;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment row">
            <div class="col-3 col-sm-3 col-md-2 comment-meta comment-author vcard padding-none-r">
                <?php
                    echo get_avatar( $comment, 74 );                    
                ?>
            </div><!-- .comment-meta -->

            <div class="col-9 col-sm-9 col-md-10">

                <span><strong><?php echo get_comment_author_link(); ?></strong></span>
                <span> - <?php echo get_comment_date('d/M/Y'); ?></span>

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Seu comentário aguarda moderação.', 'bvs_lang' ); ?></p>
                <?php endif; ?>

                <section class="comment-content comment">
                    <?php comment_text(); ?>
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Responder', 'bvs_lang' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </section><!-- .comment-content -->

            </div>

        </article><!-- #comment-## -->
    <?php
        break;
    endswitch; // end comment_type check
}
endif;