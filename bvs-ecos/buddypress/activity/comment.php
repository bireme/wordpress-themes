<?php
/**
 * BuddyPress - Activity Stream Comment
 *
 * This template is used by bp_activity_comments() functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires before the display of an activity comment.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_activity_comment' ); ?>

<li id="acomment-<?php bp_activity_comment_id(); ?>" class="row">
	<div class="acomment-avatar col-auto">
		<a href="<?php bp_activity_comment_user_link(); ?>">
			<?php bp_activity_avatar( 'type=thumb&user_id=' . bp_get_activity_comment_user_id() ); 
			
			global $activities_template;
			$current_activity_item = isset( $activities_template->activity->current_comment ) ? $activities_template->activity->current_comment : $activities_template->activity;

			// Activity user display name.
			$comment_author = isset( $current_activity_item->display_name ) ? $current_activity_item->display_name : $current_activity_item->user_login;

			echo '<label class="username-comment d-block">'. $comment_author .'</label>'; 
			?>
		</a>
	</div>

	<div class="col grid-comment-balloon">

		<div class="acomment-meta">
			<?php
				printf(
					/* translators: 1: user profile link, 2: user name, 3: activity permalink, 4: ISO8601 timestamp, 5: activity relative timestamp */
					esc_html__( '%1$s replied %2$s', 'buddypress' ),
					'<a href="' . esc_url( bp_get_activity_comment_user_link() ) . '">' . esc_html( bp_get_activity_comment_name() ) . '</a>',
					'<a href="' . esc_url( bp_get_activity_comment_permalink() ) . '" class="activity-time-since"><span class="time-since" data-livestamp="' . esc_attr( bp_core_get_iso8601_date( bp_get_activity_comment_date_recorded() ) ) . '">' . esc_html( bp_get_activity_comment_date_recorded() ). '</span></a>'
				);
			?>
		</div>

		<div class="acomment-content">
			<div class="wrap-text">
				<?php bp_activity_comment_content(); ?>
			</div>
		</div>

		<div class="acomment-options">

			<?php if ( is_user_logged_in() && bp_activity_can_comment_reply( bp_activity_current_comment() ) ) : ?>

				<a href="#acomment-<?php bp_activity_comment_id(); ?>" class="acomment-reply button bp-primary-action" id="acomment-reply-<?php bp_activity_id(); ?>-from-<?php bp_activity_comment_id(); ?>"><?php esc_html_e( 'Reply', 'buddypress' ); ?></a>

			<?php endif; ?>

			<?php if ( bp_activity_user_can_delete() ) : ?>

				<a href="<?php bp_activity_comment_delete_link(); ?>" class="delete acomment-delete button confirm bp-secondary-action" rel="nofollow"><?php esc_html_e( 'Delete', 'buddypress' ); ?></a>

			<?php endif; ?>

			<?php

			/**
			 * Fires after the default comment action options display.
			 *
			 * @since 1.6.0
			 */
			do_action( 'bp_activity_comment_options' ); ?>

		</div>
	</div>

	<?php bp_activity_recurse_comments( bp_activity_current_comment() ); ?>
</li>

<?php

/**
 * Fires after the display of an activity comment.
 *
 * @since 1.5.0
 */
do_action( 'bp_after_activity_comment' );
