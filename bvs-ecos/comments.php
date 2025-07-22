<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) : ?>

        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ( '1' === $comments_number ) {
                printf(
					/* translators: 1: title. */
					esc_html__( 'Um comentário sobre "%1$s"', 'bvs-ecos' ),
					'<span>' . esc_html(get_the_title()) . '</span>'
				);
            } else {
                printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s comentário em "%2$s"', '%1$s comentários sobre "%2$s"', $comments_number, 'comments title', 'bvs-ecos' ) ),
					esc_html( number_format_i18n( $comments_number ) ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
            }
            ?>
        </h2><!-- .comments-title -->


        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Navegação de comentários', 'bvs-ecos' ); ?></h2>
                <div class="nav-links">

                    <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Comentários mais antigos', 'bvs-ecos' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Comentários mais recentes', 'bvs-ecos' ) ); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-above -->
        <?php endif; // Check for comment navigation. ?>

        <ul class="comment-list">
            <?php
            wp_list_comments( array( 'callback' => 'wp_bootstrap_starter_comment', 'avatar_size' => 50 ));
            ?>
        </ul><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Navegação de comentários', 'bvs-ecos' ); ?></h2>
                <div class="nav-links">

                    <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Comentários mais antigos', 'bvs-ecos' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Comentários mais recentes', 'bvs-ecos' ) ); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-below -->
            <?php
        endif; // Check for comment navigation.

    endif; // Check for have_comments().


    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

        <p class="no-comments"><?php esc_html_e( 'Comentários estão fechados.', 'bvs-ecos' ); ?></p>
        <?php
    endif; ?>

    <?php comment_form( $args = array(
        'id_form'           => 'commentform',  // that's the wordpress default value! delete it or edit it ;)
        'id_submit'         => 'commentsubmit',
        'title_reply'       => __( 'Deixe uma resposta', 'bvs-ecos' ),  // that's the wordpress default value! delete it or edit it ;)
		/* translators: 1: Reply Specific User */
        'title_reply_to'    => __( 'Deixe uma resposta para %s', 'bvs-ecos' ),  // that's the wordpress default value! delete it or edit it ;)
        'cancel_reply_link' => __( 'Cancelar resposta', 'bvs-ecos' ),  // that's the wordpress default value! delete it or edit it ;)
        'label_submit'      => __( 'Postar Comentário', 'bvs-ecos' ),  // that's the wordpress default value! delete it or edit it ;)
        'class_form'        => 'comment-form row',
        
        'fields' => array(
            'author' => '<div class="comment-form-author col-md-6">
                <label for="author">' . __( 'Nome', 'bvs-ecos' ) . '*</label>
                <input placeholder="' . __( 'Nome', 'bvs-ecos' ) . '" id="author" name="author" type="text" class="form-control" value="" aria-required="true" />
            </div>',
            'email'  => '<div class="comment-form-email col-md-6">
                <label for="email">' . __( 'Email', 'bvs-ecos' ) . '*</label>
                <input placeholder="' . __( 'Email', 'bvs-ecos' ) . '" id="email" name="email" type="email" class="form-control" value="" aria-required="true" />
            </div>',
            'cookies' => '<div class="comment-form-cookies-consent col-md-12">
                 <input id="wp-comment-cookies-consent" class="form-check-input" name="wp-comment-cookies-consent" type="checkbox" value="yes" /> ' .
                '<label for="wp-comment-cookies-consent" class="form-check-label">' . __( 'Salvar meus dados neste navegador para a próxima vez que eu comentar.', 'bvs-ecos' ) . '</label>
            </div>',
        ),

        'comment_field' =>  '<div class="comment-form-comment col-md-12">
            <label for="comment">' . __( 'Mensagem', 'bvs-ecos' ) . '*</label>
            <textarea placeholder="'.__( 'Mensagem', 'bvs-ecos' ).'" id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div>',

        'submit_field' => '<div class="form-submit col-md-12">%1$s %2$s</div>',

        'comment_notes_after' => ''

        // So, that was the needed stuff to have bootstrap basic styles for the form elements and buttons

        // Basically you can edit everything here!
        // Checkout the docs for more: http://codex.wordpress.org/Function_Reference/comment_form
        // Another note: some classes are added in the bootstrap-wp.js - ckeck from line 1

    ));

	?>

</div><!-- #comments -->
