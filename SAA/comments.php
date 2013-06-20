<?php
// Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
 
    if ( post_password_required() ) { ?>
        <p class="nocomments">Este artigo está protegido por senha. Insira-a para ver os comentários.</p>
    <?php
        return;
    }
?>


<div id="respond">
    <h3>Deixe o seu comentário!</h3>

    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
        <?php if ( $user_ID ) : ?>

        <p>Autentificado como <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(); ?>" title="Sair desta conta">Sair desta conta &raquo;</a></p>

        <?php else : ?>
            <div class="row-fluid margin-bottom10">
				<input type="text" class="input" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" placeholder="Nome" tabindex="1" />		
			</div>

			<div class="row-fluid margin-bottom10">
				<input type="text" class="input" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" placeholder="E-mail" tabindex="2" />
			</div>
        <?php endif; ?>

        <div class="row-fluid margin-bottom5">
			<textarea name="comment" id="comment" cols="58" rows="6" placeholder="Comentário" tabindex="4"></textarea>
		</div>
		
		<div class="row-fluid">
			<input name="submit" class="pull-right i-btEnviar margin-right125" type="submit" id="submit" tabindex="3" value="<?php esc_attr_e('Submit Comment'); ?>" />
		</div>

        <?php comment_id_fields(); ?>
        <?php do_action('comment_form', $post->ID); ?>
	</form>

    <p class="cancel"><?php cancel_comment_reply_link('Cancelar Resposta'); ?></p>
</div>

<div id="comments">
    <h2 class="comentarios-tit margin-top10">Comentários (<?php comments_number('0','1','%'); ?>)</h2>
 
    <?php if ( have_comments() ) : ?>
        <ol class="commentlist">
        	<?php wp_list_comments('avatar_size=50&type=comment'); ?>
    	</ol>
 
        <?php if ($wp_query->max_num_pages > 1) : ?>

        <div class="pagination">
        <ul>
            <li class="older"><?php previous_comments_link('Anteriores'); ?></li>
            <li class="newer"><?php next_comments_link('Novos'); ?></li>
        </ul>
    </div>
    
    <?php endif; ?>
 
    <?php endif; ?>
 
    <?php if ( comments_open() ) : ?>
 
     <?php else : ?>
        <h3>Os comentários estão fechados.</h3>
	<?php endif; ?>
</div>