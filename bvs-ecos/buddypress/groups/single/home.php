<?php
/**
 * BuddyPress - Groups Home
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>
<div id="buddypress">

	<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

	<?php

	/**
	 * Fires before the display of the group home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_group_home_content' ); ?>

	<div id="item-header" role="complementary">

		<?php
		/**
		 * If the cover image feature is enabled, use a specific header
		 */
		if ( bp_group_use_cover_image_header() ) :
			bp_get_template_part( 'groups/single/cover-image-header' );
		else :
			bp_get_template_part( 'groups/single/group-header' );
		endif;
		?>

	</div><!-- #item-header -->

	
	<div class="container">
		<div class="row">
			<div class="col-md-12">	
				<div id="item-nav" class="menu-group">
					<div class="item-list-tabs no-ajax" id="object-nav" aria-label="<?php esc_attr_e( 'Group primary navigation', 'buddypress' ); ?>" role="navigation">
						<ul>

							<?php bp_get_options_nav(); ?>

							<?php

							/**
							 * Fires after the display of group options navigation.
							 *
							 * @since 1.2.0
							 */
							do_action( 'bp_group_options_nav' ); ?>

						</ul>
					</div>
				</div><!-- #item-nav -->

				<div id="item-body">

					<?php

					/**
					 * Fires before the display of the group home body.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_before_group_body' );

					/**
					 * Does this next bit look familiar? If not, go check out WordPress's
					 * /wp-includes/template-loader.php file.
					 *
					 * @todo A real template hierarchy? Gasp!
					 */

						// Looking at home location
						if ( bp_is_group_home() ) :

							if ( bp_group_is_visible() ) {

								// Load appropriate front template
								bp_groups_front_template_part();

							} else {

								/**
								 * Fires before the display of the group status message.
								 *
								 * @since 1.1.0
								 */
								do_action( 'bp_before_group_status_message' ); ?>

								<div id="message" class="info">
									<p><?php bp_group_status_message(); ?></p>
								</div>

								<?php

								/**
								 * Fires after the display of the group status message.
								 *
								 * @since 1.1.0
								 */
								do_action( 'bp_after_group_status_message' );

							}

						// Not looking at home
						else :

							// Group Admin
							if     ( bp_is_group_admin_page() ) : 
								echo '<div class="member-admin-page">';
								bp_get_template_part( 'groups/single/admin' );
								echo '</div>';

							// Group Activity
							elseif ( bp_is_group_activity()   ) : bp_get_template_part( 'groups/single/activity'     );

							// Group Members
							elseif ( bp_is_group_members()    ) : 
								echo '<div class="member-group-page">';
								bp_groups_members_template_part();
								echo '</div>';


							// Group Invitations
							elseif ( bp_is_group_invites()    ) : bp_get_template_part( 'groups/single/send-invites' );

							// Membership request
							elseif ( bp_is_group_membership_request() ) : bp_get_template_part( 'groups/single/request-membership' );

							// Anything else (plugins mostly)
							else                                : bp_get_template_part( 'groups/single/plugins'      );

							endif;

						endif;

					/**
					 * Fires after the display of the group home body.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_after_group_body' ); ?>

				</div><!-- #item-body -->
			</div><!-- .col-md-12 -->
		</div><!-- .row -->
	</div><!-- .container -->

	<?php

	/**
	 * Fires after the display of the group home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_group_home_content' ); ?>

	<?php endwhile; endif; ?>

</div><!-- #buddypress -->
