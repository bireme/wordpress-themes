<?php
/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<?php

/**
 * Fires before the display of a member's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_header' ); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div id="item-header-avatar">
				<a href="<?php bp_displayed_user_link(); ?>">

					<?php bp_displayed_user_avatar( 'type=full' ); ?>

				</a>
			</div><!-- #item-header-avatar -->

			<div id="item-header-content">

				<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
					<h2 class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></h2>
				<?php endif; ?>

				<?php

				/**
				 * Fires before the display of the member's header meta.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_before_member_header_meta' ); ?>

				<div id="item-meta">					

					<div id="item-buttons" class="grid-buttons-member">
						<?php

						/**
						 * Fires in the member header actions section.
						 *
						 * @since 1.2.6
						 */
						do_action( 'bp_member_header_actions' ); ?>
					</div><!-- #item-buttons -->

					<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_user_last_activity( bp_displayed_user_id() ) ); ?>"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>

					<?php if ( bp_is_active( 'activity' ) ) : ?>

					<div id="latest-update">

						<?php bp_activity_latest_update( bp_displayed_user_id() ); ?>

					</div>

					<?php endif; ?>

					<?php

					/**
					 * Fires after the group header actions section.
					*
					* If you'd like to show specific profile fields here use:
					* bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
					*
					* @since 1.2.0
					*/
					do_action( 'bp_profile_header_meta' );

					?>

				</div><!-- #item-meta -->

			</div><!-- #item-header-content -->
		</div>
	</div>

	<?php

	/**
	 * Fires after the display of a member's header.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_header' ); ?>

	<div class="row">
		<div class="col-md-12">
			<div id="template-notices" role="alert" aria-atomic="true">
				<?php

				/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
				do_action( 'template_notices' ); ?>

			</div>
		</div>
	</div>
</div>
