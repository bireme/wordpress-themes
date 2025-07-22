<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<div id="post-<?php bbp_reply_id(); ?>" class="reply-header">
	<div class="bbp-meta grid-meta-reply">
		<span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>

		<?php if ( bbp_is_single_user_replies() ) : ?>

			<span class="bbp-header">
				<?php esc_html_e( 'in reply to: ', 'bbpress' ); ?>
				<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
			</span>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

		<?php bbp_reply_admin_links(array('sep' => '')); ?>

		<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>

	</div><!-- .bbp-meta -->
</div><!-- #post-<?php bbp_reply_id(); ?> -->

<div <?php bbp_reply_class(bbp_get_reply_id(), array('grid-topic-item')); ?>>
	<div class="row">
		<div class="grid-reply-author col-auto">

			<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

			<?php bbp_reply_author_link( array( 'show_role' => true ) ); ?>

			<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

		</div><!-- .bbp-reply-author -->

		<div class="grid-reply-content col">

			<div class="wrap-text">
				<?php do_action( 'bbp_theme_before_reply_content' ); ?>

				<?php bbp_reply_content(); ?>

				<?php do_action( 'bbp_theme_after_reply_content' ); ?>
			</div>

			<div class="footer-button-reply">
				<?php 
				$button_reply = bbp_get_reply_to_link(array(
					'id' => bbp_get_reply_id()
				)); 
				
				if(!empty($button_reply)){
					echo $button_reply;
				}
				else{ ?>
					<a role="button" class="bbp-reply-to-link" href="./#new-post" rel="nofollow">
						<?php _e('Responder', 'bvs-ecos'); ?>
					</a>
				<?php } ?>
			</div>
		</div><!-- .bbp-reply-content -->

		
	</div>
</div><!-- .reply -->
