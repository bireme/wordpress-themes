<?php
if ( post_password_required() ) {
    return;
}
?>
<div id="comments">
    <?php if ( have_comments() ) : ?>
        <ol class="comment-list">
            <?php wp_list_comments(); ?>
        </ol>
        <?php the_comments_pagination(); ?>
    <?php endif; ?>
    <?php comment_form(); ?>
</div>
