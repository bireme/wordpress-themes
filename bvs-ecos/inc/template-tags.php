<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WP_Bootstrap_Starter
 */

if ( ! function_exists( 'wp_bootstrap_starter_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function wp_bootstrap_starter_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Postado em %s', 'post date', 'bvs-ecos' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'por %s', 'autor da postagem', 'bvs-ecos' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span> | <span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo ' | <span class="comments-link"><i class="fa fa-comments" aria-hidden="true"></i> ';
        /* translators: %s: post title */
        comments_popup_link( sprintf( wp_kses( __( 'Deixe um comentário<span class="screen-reader-text"> em %s</span>', 'bvs-ecos' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
        echo '</span>';
    }

}
endif;

if ( ! function_exists( 'wp_bootstrap_starter_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function wp_bootstrap_starter_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'bvs-ecos' ) );
		if ( $categories_list && wp_bootstrap_starter_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Postado em %1$s', 'bvs-ecos' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'bvs-ecos' ) );
		if ( $tags_list ) {
			printf( ' | <span class="tags-links">' . esc_html__( 'Marcado %1$s', 'bvs-ecos' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}


	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Editar %s', 'bvs-ecos' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		' | <span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function wp_bootstrap_starter_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'wp_bootstrap_starter_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'wp_bootstrap_starter_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so wp_bootstrap_starter_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so wp_bootstrap_starter_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in wp_bootstrap_starter_categorized_blog.
 */
function wp_bootstrap_starter_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'wp_bootstrap_starter_categories' );
}
add_action( 'edit_category', 'wp_bootstrap_starter_category_transient_flusher' );
add_action( 'save_post',     'wp_bootstrap_starter_category_transient_flusher' );


if ( ! function_exists( 'wp_bootstrap_starter_comment' ) ) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    function wp_bootstrap_starter_comment( $comment, $args, $depth ) {
       // $GLOBALS['comment'] = $comment;

        if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media' ); ?>>
            <div class="comment-body">
                <?php _e( 'Pingback:', 'bvs-ecos' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Editar', 'bvs-ecos' ), '<span class="edit-link">', '</span>' ); ?>
            </div>

        <?php else : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body media mb-4">
                <a class="comment-author" href="#">
                    <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>					
                </a>

                <div class="media-body">
                    <div class="media-body-wrap card">

                        <div class="card-header">
                            <h5 class="author-name"><?php printf( __( '%s <span class="says">disse</span>', 'bvs-ecos' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></h5>
                            <div class="comment-meta">
								<?php _e("em", "bvs-ecos"); ?>
                                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">									
                                    <time datetime="<?php comment_time( 'c' ); ?>">
                                        <?php printf( _x( '%1$s às %2$s', '1: data, 2: hora', 'bvs-ecos' ), get_comment_date(), get_comment_time() ); ?>
                                    </time>
                                </a>
                                <?php edit_comment_link( __( '<span style="margin-left: 5px;" class="fa-solid fa-pen-to-square"></span> Editar', 'bvs-ecos' ), '<span class="edit-link">', '</span>' ); ?>
                            </div>
                        </div>                       

                        <div class="comment-content card-block">
                            <div class="wrap-text"><?php comment_text(); ?></div>
                        </div><!-- .comment-content -->

						<?php if ( '0' == $comment->comment_approved ) : ?>
                            <p class="comment-awaiting-moderation"><?php _e( 'Seu comentário está aguardando moderação.', 'bvs-ecos' ); ?></p>
                        <?php endif; ?>

                        <?php comment_reply_link(
                            array_merge(
                                $args, array(
                                    'add_below' => 'div-comment',
                                    'depth' 	=> $depth,
                                    'max_depth' => $args['max_depth'],
                                    'before' 	=> '<footer class="reply comment-reply card-footer">',
                                    'after' 	=> '</footer><!-- .reply -->'
                                )
                            )
                        ); ?>

                    </div>
                </div><!-- .media-body -->

            </article><!-- .comment-body -->

            <?php
        endif;
    }
endif; // ends check for wp_bootstrap_starter_comment()
