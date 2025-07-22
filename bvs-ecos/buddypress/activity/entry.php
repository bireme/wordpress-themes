<?php
/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @since 3.0.0
 * @version 12.0.0
 */

/**
 * Fires before the display of an activity entry.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_activity_entry' ); ?>

<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>">
	<div class="row">
		<div class="activity-avatar col-auto">
			<a href="<?php bp_activity_user_link(); ?>">

				<?php bp_activity_avatar(); 				
				
				global $activities_template;
				if ( isset( $activities_template->activity->user_fullname ) ) {	
					$name = $activities_template->activity->user_fullname;
				} else {
					$name = $activities_template->activity->display_name;
				}

				echo '<label class="username-comment d-block">'. $name .'</label>'; 
				
				?>

			</a>
		</div>
		<div class="activity-content col">

			<div class="activity-header">
				<?php bp_activity_action(); ?>
			</div>

			<?php if ( bp_activity_has_content() ) : ?>

				<div class="activity-inner">
					<div class="wrap-text">
						<?php bp_get_template_part( 'activity/type-parts/content',  bp_activity_type_part() ); ?>
					</div>
				</div>

			<?php endif; ?>

			<?php

			/**
			 * Fires after the display of an activity entry content.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_activity_entry_content' ); ?>

			<div class="activity-meta">

				<?php if ( bp_get_activity_type() == 'activity_comment' ) : ?>

					<a href="<?php bp_activity_thread_permalink(); ?>" class="button view bp-secondary-action"><?php esc_html_e( 'View Conversation', 'buddypress' ); ?></a>

				<?php endif; ?>

				<?php if ( is_user_logged_in() ) : ?>

					<?php if ( bp_activity_can_comment() ) : ?>

						<a href="<?php bp_activity_comment_link(); ?>" class="button acomment-reply bp-primary-action" id="acomment-comment-<?php bp_activity_id(); ?>">							
							<?php
							/* translators: %s: number of activity comments */
							printf( esc_html__( 'Comment %s', 'buddypress' ), '(' . esc_html( bp_activity_get_comment_count() ) . ')' );
							?>
						</a>

					<?php endif; ?>

					<?php if ( bp_activity_can_favorite() ) : ?>

						<?php if ( !bp_get_activity_is_favorite() ) : ?>

							<a href="<?php bp_activity_favorite_link(); ?>" class="button fav bp-secondary-action"><?php esc_html_e( 'Favorite', 'buddypress' ); ?></a>

						<?php else : ?>

							<a href="<?php bp_activity_unfavorite_link(); ?>" class="button unfav bp-secondary-action"><?php esc_html_e( 'Remove Favorite', 'buddypress' ); ?></a>

						<?php endif; ?>

					<?php endif; ?>

					<?php if ( bp_activity_user_can_delete() ) bp_activity_delete_link(); ?>

					<?php

					/**
					 * Fires at the end of the activity entry meta data area.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_activity_entry_meta' ); ?>

				<?php endif; ?>

			</div>

		</div>
	</div>

	<?php

	/**
	 * Fires before the display of the activity entry comments.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_activity_entry_comments' ); ?>

	<?php if ( ( bp_activity_get_comment_count() || bp_activity_can_comment() ) || bp_is_single_activity() ) : ?>

		<div class="activity-comments">

			<?php bp_activity_comments(); ?>

			<?php if ( is_user_logged_in() && bp_activity_can_comment() ) : ?>

				<form action="<?php bp_activity_comment_form_action(); ?>" method="post" id="ac-form-<?php bp_activity_id(); ?>" class="ac-form"<?php bp_activity_comment_form_nojs_display(); ?>>
					<div class="row">
						<div class="ac-reply-avatar col-auto">
							<?php bp_loggedin_user_avatar( 'type=full&width=88&height=88' ); ?>
							<label class="username-loggedin"><?php bp_loggedin_user_fullname(); ?></label>
						</div>
						<div class="ac-reply-content col">
							<div class="ac-textarea">
								<label for="ac-input-<?php bp_activity_id(); ?>" class="bp-screen-reader-text">
									<?php
										/* translators: accessibility text */
										esc_html_e( 'Comment', 'buddypress' );
									?>
								</label>
								<textarea id="ac-input-<?php bp_activity_id(); ?>" class="ac-input form-control bp-suggestions" name="ac_input_<?php bp_activity_id(); ?>"></textarea>
							</div>
							<div class="grid-btn-reply">
								<input type="submit" class="btn btn-primary" name="ac_form_submit" value="<?php esc_attr_e( 'Post', 'buddypress' ); ?>" />
								<a href="<?php bp_activity_comment_cancel_url(); ?>" class="ac-reply-cancel btn"><?php esc_html_e( 'Cancel', 'buddypress' ); ?></a>
							</div>							
							<input type="hidden" name="comment_form_id" value="<?php bp_activity_id(); ?>" />
						</div>
					</div>

					<?php

					/**
					 * Fires after the activity entry comment form.
					 *
					 * @since 1.5.0
					 */
					do_action( 'bp_activity_entry_comments' ); ?>

					<?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment_' . bp_get_activity_id() ); ?>

				</form>

			<?php endif; ?>

		</div>

	<?php endif; ?>

	<?php

	/**
	 * Fires after the display of the activity entry comments.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_activity_entry_comments' ); ?>

</li>

<?php

/**
 * Fires after the display of an activity entry.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_activity_entry' );
