<?php
/**
 * BuddyPress - Users Notifications
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
</div>

<div class="row">
	<div class="col-md-12 text-end">
		<div id="members-order-select" class="last filter">
			<?php bp_notifications_sort_order_form(); ?>
		</div>
	</div>
</div>

<?php
switch ( bp_current_action() ) :

	case 'unread' :
		bp_get_template_part( 'members/single/notifications/unread' );
		break;

	case 'read' :
		bp_get_template_part( 'members/single/notifications/read' );
		break;

	// Any other actions.
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
