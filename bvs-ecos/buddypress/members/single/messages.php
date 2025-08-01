<?php
/**
 * BuddyPress - Users Messages
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

<div id="grid-search-messages-member" class="row">
	<div class="col-md-12 text-end">

		<?php if ( bp_is_messages_inbox() || bp_is_messages_sentbox() ) : ?>
			<div class="message-search"><?php bp_message_search_form(); ?></div>
		<?php endif; ?>

	</div>
</div>

<?php
switch ( bp_current_action() ) :

	// Inbox/Sentbox
	case 'inbox'   :
	case 'sentbox' :

		/**
		 * Fires before the member messages content for inbox and sentbox.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_messages_content' ); ?>

		<?php if ( bp_is_messages_inbox() ) : ?>
			<h2 class="bp-screen-reader-text">
				<?php
					/* translators: accessibility text */
					esc_html_e( 'Messages inbox', 'buddypress' );
				?>
			</h2>
		<?php elseif ( bp_is_messages_sentbox() ) : ?>
			<h2 class="bp-screen-reader-text">
				<?php
					/* translators: accessibility text */
					esc_html_e( 'Sent Messages', 'buddypress' );
				?>
			</h2>
		<?php endif; ?>

		<div class="messages">
			<?php bp_get_template_part( 'members/single/messages/messages-loop' ); ?>
		</div><!-- .messages -->

		<?php

		/**
		 * Fires after the member messages content for inbox and sentbox.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_messages_content' );
		break;

	// Single Message View
	case 'view' :
		bp_get_template_part( 'members/single/messages/single' );
		break;

	// Compose
	case 'compose' :
		bp_get_template_part( 'members/single/messages/compose' );
		break;

	// Sitewide Notices
	case 'notices' :

		/**
		 * Fires before the member messages content for notices.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_messages_content' ); ?>

		<h2 class="bp-screen-reader-text">
			<?php
				/* translators: accessibility text */
				esc_html_e( 'Sitewide Notices', 'buddypress' );
			?>
		</h2>

		<div class="messages">
			<?php bp_get_template_part( 'members/single/messages/notices-loop' ); ?>
		</div><!-- .messages -->

		<?php

		/**
		 * Fires after the member messages content for inbox and sentbox.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_member_messages_content' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
