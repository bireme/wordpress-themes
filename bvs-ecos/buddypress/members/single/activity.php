<?php
/**
 * BuddyPress - Users Activity
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<div class="item-list-tabs no-ajax" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'buddypress' ); ?>" role="navigation">
	<div class="row grid-submenu-profile">
		<div class="col-md-12">
			<ul>
				<?php bp_get_options_nav(); ?>
			</ul>
		</div>
	</div>
</div><!-- .item-list-tabs -->

<div id="grid-form-member" class="row">
	<div class="col-md-12">
		<?php

		/**
		 * Fires before the display of the member activity post form.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_activity_post_form' ); 
		
		if ( is_user_logged_in() && bp_is_my_profile() && ( !bp_current_action() || bp_is_current_action( 'just-me' ) ) )
			bp_get_template_part( 'activity/post-form' );

		/**
		 * Fires after the display of the member activity post form.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_activity_post_form' );
		?>
	</div>
</div>

<div class="row">
	<div class="col-md-12 text-end">
		<div id="activity-filter-select" class="last">
			<label for="activity-filter-by"><?php esc_html_e( 'Show:', 'buddypress' ); ?></label>
			<select id="activity-filter-by" class="form-select">
				<option value="-1"><?php esc_html_e( '&mdash; Everything &mdash;', 'buddypress' ); ?></option>

				<?php bp_activity_show_filters(); ?>

				<?php

				/**
				 * Fires inside the select input for member activity filter options.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_member_activity_filter_options' ); ?>

			</select>
		</div>
	</div>
</div>

<?php
/**
 * Fires before the display of the member activities list.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_activity_content' ); ?>

<div class="activity" aria-live="polite" aria-atomic="true" aria-relevant="all">

	<?php bp_get_template_part( 'activity/activity-loop' ) ?>

</div><!-- .activity -->

<?php

/**
 * Fires after the display of the member activities list.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_member_activity_content' );
