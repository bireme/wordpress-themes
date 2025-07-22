<?php
/**
 * BuddyPress - Activity Post Form
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 12.0.0
 */

?>

<form action="<?php bp_activity_post_form_action(); ?>" method="post" id="whats-new-form" name="whats-new-form">

	<?php

	/**
	 * Fires before the activity post form.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_activity_post_form' ); ?>

<div class="row">
	<div id="whats-new-avatar" class="col-auto">
		<a href="<?php bp_loggedin_user_link(); ?>">
			<?php bp_loggedin_user_avatar( 'type=full&width=88&height=88' ); ?>
			<label class="username-loggedin"><?php bp_loggedin_user_fullname(); ?></label>
		</a>
	</div>
	<div class="col">
		<?php
		if ( bp_is_group() ) {
			$placeholder_textarea = sprintf(
				/* translators: 1: group name. 2: member name. */
				esc_html__( 'What\'s new in %1$s, %2$s?', 'buddypress' ),
				esc_html( bp_get_group_name() ),
				esc_html( bp_get_user_firstname( bp_get_loggedin_user_fullname() ) )
			);
		} else {
			$placeholder_textarea = sprintf(
				/* translators: %s: member name */
				esc_html__( "What's new, %s?", 'buddypress' ),
				esc_html( bp_get_user_firstname( bp_get_loggedin_user_fullname() ) )
			);
		}
		?>

		<div id="whats-new-content">
			<div id="whats-new-textarea">
				<label for="whats-new" class="bp-screen-reader-text">
					<?php
						/* translators: accessibility text */
						esc_html_e( 'Post what\'s new', 'buddypress' );
					?>
				</label>
				<textarea placeholder="<?php echo $placeholder_textarea; ?>" class="bp-suggestions form-control" name="whats-new" id="whats-new" cols="50" rows="10"
					<?php if ( bp_is_group() ) : ?>data-suggestions-group-id="<?php echo esc_attr( (int) bp_get_current_group_id() ); ?>" <?php endif; ?>
				><?php if ( isset( $_GET['r'] ) ) : ?>@<?php echo esc_textarea( $_GET['r'] ); ?> <?php endif; ?></textarea>
			</div>

			<div id="whats-new-options">				
				<?php if ( bp_is_active( 'groups' ) && !bp_is_my_profile() && !bp_is_group() ) : ?>

					<div id="whats-new-post-in-box" class="row">
						<div class="col-auto">
							<label for="whats-new-post-in">
								<?php esc_html_e( 'Post in', 'buddypress' ); ?>: 
							</label>
						</div>
						<div class="col-auto grid-select">
							<select id="whats-new-post-in" name="whats-new-post-in" class="form-select">
								<option selected="selected" value="0"><?php esc_html_e( 'My Profile', 'buddypress' ); ?></option>

								<?php if ( bp_has_groups( 'user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=100&populate_extras=0&update_meta_cache=0' ) ) :
									while ( bp_groups() ) : bp_the_group(); ?>

										<option value="<?php bp_group_id(); ?>"><?php bp_group_name(); ?></option>

									<?php endwhile;
								endif; ?>

							</select>
						</div>
					</div>
					<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />

				<?php elseif ( bp_is_group_activity() ) : ?>

					<input type="hidden" id="whats-new-post-object" name="whats-new-post-object" value="groups" />
					<input type="hidden" id="whats-new-post-in" name="whats-new-post-in" value="<?php bp_group_id(); ?>" />

				<?php endif; ?>

				<?php

				/**
				 * Fires at the end of the activity post form markup.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_activity_post_form_options' ); ?>

			</div><!-- #whats-new-options -->

			<div id="whats-new-submit">
				<input type="submit" name="aw-whats-new-submit" id="aw-whats-new-submit" class="btn btn-primary" value="<?php esc_attr_e( 'Post Update', 'buddypress' ); ?>" />
			</div>

		</div><!-- #whats-new-content -->
	</div>
</div>

	<?php wp_nonce_field( 'post_update', '_wpnonce_post_update' ); ?>
	<?php

	/**
	 * Fires after the activity post form.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_activity_post_form' ); ?>

</form><!-- #whats-new-form -->
