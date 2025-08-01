<?php
/**
 * BuddyPress - Groups Cover Image Header.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 12.0.0
 */

/**
 * Fires before the display of a group's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_group_header' ); ?>

<div id="cover-image-container">
	<a id="header-cover-image" href="<?php bp_group_url(); ?>"></a>

	<div id="item-header-cover-image">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
						<div id="item-header-avatar">
							<a href="<?php bp_group_url(); ?>">

								<?php bp_group_avatar(); ?>

							</a>
						</div><!-- #item-header-avatar -->
					<?php endif; ?>

					<div id="item-header-content">						
						<?php

						/**
						 * Fires before the display of the group's header meta.
						 *
						 * @since 1.2.0
						 */
						do_action( 'bp_before_group_header_meta' ); ?>

						<div id="group-meta">

							<?php
							/**
							 * Fires after the group header actions section.
							 *
							 * @since 1.2.0
							 */
							do_action( 'bp_group_header_meta' ); ?>

							<span class="group-type">
								<img src="<?php echo get_icon_buddypress_group_status(); ?>" class="img-fluid icon-status-group" alt="status group"/>
								<?php bp_group_type(); ?>
							</span>
							<span class="last-activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ); ?>">
								<?php
								/* translators: %s: last activity timestamp (e.g. "Active 1 hour ago") */
								printf( esc_html__( 'Active %s', 'buddypress' ), esc_html( bp_get_group_last_active() ) );
								?>
							</span>							

							<?php bp_group_type_list(); ?>
						</div>

						<div id="item-buttons">
							<?php
							/**
							 * Fires in the group header actions section.
							 *
							 * @since 1.2.6
							 */
							do_action( 'bp_group_header_actions' ); ?>
						</div><!-- #item-buttons -->

					</div><!-- #item-header-content -->

					<div id="item-actions">

						<?php if ( bp_group_is_visible() ) : ?>

							<h5 class="admins-group"><?php esc_html_e( 'Group Admins', 'buddypress' ); ?></h5>

							<?php bp_group_list_admins();

							/**
							 * Fires after the display of the group's administrators.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_after_group_menu_admins' );

							if ( bp_group_has_moderators() ) :

								/**
								 * Fires before the display of the group's moderators, if there are any.
								 *
								 * @since 1.1.0
								 */
								do_action( 'bp_before_group_menu_mods' ); ?>

								<h2><?php esc_html_e( 'Group Mods' , 'buddypress' ); ?></h2>

								<?php bp_group_list_mods();

								/**
								 * Fires after the display of the group's moderators, if there are any.
								 *
								 * @since 1.1.0
								 */
								do_action( 'bp_after_group_menu_mods' );

							endif;

						endif; ?>

					</div><!-- #item-actions -->
				</div><!-- .col-md-12 -->
				<div class="col-md-12 group-description">
					<?php bp_group_description(); ?>
				</div>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #item-header-cover-image -->
</div><!-- #cover-image-container -->

<?php
/**
 * Fires after the display of a group's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_group_header' ); ?>

<div class="container">
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