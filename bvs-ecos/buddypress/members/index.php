<?php
/**
 * BuddyPress - Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 12.0.0
 */

/**
 * Fires at the top of the members directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_directory_members_page' ); ?>

<div id="buddypress">

	<?php

	/**
	 * Fires before the display of the members.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members' ); ?>

	<?php

	/**
	 * Fires before the display of the members content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members_content' ); ?>

	<?php /* Backward compatibility for inline search form. Use template part instead. */ ?>
	<?php if ( has_filter( 'bp_directory_members_search_form' ) ) : ?>

		<div id="members-dir-search" class="dir-search" role="search">
			<?php bp_directory_members_search_form(); ?>
		</div><!-- #members-dir-search -->

	<?php else: ?>

		<?php bp_get_template_part( 'common/search/dir-search-form' ); ?>

	<?php endif; ?>

	<?php
	/**
	 * Fires before the display of the members list tabs.
	 *
	 * @since 1.8.0
	 */
	do_action( 'bp_before_directory_members_tabs' ); ?>

	<form action="" method="post" id="members-directory-form" class="dir-form">

		<div class="item-list-tabs" aria-label="<?php esc_attr_e( 'Members directory main navigation', 'buddypress' ); ?>" role="navigation">
			<ul>
				<li class="selected" id="members-all"><a href="<?php bp_members_directory_permalink(); ?>"><?php printf( esc_html__( 'All Members %s', 'buddypress' ), '<span>' . esc_html( bp_get_total_member_count() ) . '</span>' ); ?></a></li>

				<?php if ( is_user_logged_in() && bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
					<li id="members-personal"><a href="<?php bp_loggedin_user_link( array( bp_get_friends_slug(), 'my-friends' ) ); ?>"><?php printf( esc_html__( 'My Friends %s', 'buddypress' ), '<span>' . esc_html( bp_get_total_friend_count( bp_loggedin_user_id() ) ) . '</span>' ); ?></a></li>
				<?php endif; ?>

				<?php

				/**
				 * Fires inside the members directory member types.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_members_directory_member_types' ); ?>

			</ul>
		</div><!-- .item-list-tabs -->

		<div class="item-list-tabs" id="subnav" aria-label="<?php esc_attr_e( 'Members directory secondary navigation', 'buddypress' ); ?>" role="navigation">
			<ul>
				<?php

				/**
				 * Fires inside the members directory member sub-types.
				 *
				 * @since 1.5.0
				 */
				do_action( 'bp_members_directory_member_sub_types' ); ?>

				<li id="members-order-select" class="last filter row">
					<div class="col-auto">
						<label for="members-order-by"><?php esc_html_e( 'Order By:', 'buddypress' ); ?></label>
					</div>
					<div class="col-auto grid-select">
						<select id="members-order-by" class="form-select">
							<option value="active"><?php esc_html_e( 'Last Active', 'buddypress' ); ?></option>
							<option value="newest"><?php esc_html_e( 'Newest Registered', 'buddypress' ); ?></option>

							<?php if ( bp_is_active( 'xprofile' ) ) : ?>
								<option value="alphabetical"><?php esc_html_e( 'Alphabetical', 'buddypress' ); ?></option>
							<?php endif; ?>

							<?php

							/**
							 * Fires inside the members directory member order options.
							 *
							 * @since 1.2.0
							 */
							do_action( 'bp_members_directory_order_options' ); ?>
						</select>
					</div>
				</li>
			</ul>
		</div>

		<h2 class="bp-screen-reader-text">
			<?php
				/* translators: accessibility text */
				esc_html_e( 'Members directory', 'buddypress' );
			?>
		</h2>

		<div id="members-dir-list" class="members dir-list">
			<?php bp_get_template_part( 'members/members-loop' ); ?>
		</div><!-- #members-dir-list -->

		<?php

		/**
		 * Fires and displays the members content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_directory_members_content' ); ?>

		<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>

		<?php

		/**
		 * Fires after the display of the members content.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_after_directory_members_content' ); ?>

	</form><!-- #members-directory-form -->

	<?php

	/**
	 * Fires after the display of the members.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_members' ); ?>

</div><!-- #buddypress -->

<?php

/**
 * Fires at the bottom of the members directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_after_directory_members_page' );
