<?php
/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter().
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 12.0.0
 */

?>

<?php

/**
 * Fires before the display of groups from the groups loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
	<p class="current-group-type"><?php bp_current_group_directory_type_message() ?></p>
<?php endif; ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="group-dir-count-top">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-top">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires before the listing of the groups list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_groups_list' ); ?>

	<div id="groups-list" class="item-list row" aria-live="assertive" aria-atomic="true" aria-relevant="all">

	<?php while ( bp_groups() ) : bp_the_group(); ?>

		<div <?php bp_group_class(array('col-12', 'col-sm-6', 'col-md-6', 'col-lg-3', 'item-post')); ?>>
			<div class="bg-post">
				<div class="content-item-post">
					<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
						<div class="item-avatar">
							<a href="<?php bp_group_url(); ?>"><?php bp_group_avatar( 'type=thumb&width=64&height=64' ); ?></a>
						</div>
					<?php endif; ?>

					<h5 class="title-post"><?php bp_group_link(); ?></h5>			
					
					<div class="summary-post"><?php echo bp_get_group_description_excerpt(); ?></div>

					<?php

					/**
					 * Fires inside the listing of an individual group listing item.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_directory_groups_item' ); ?>

					<div class="action">
						<div class="meta">
							<?php bp_group_type(); ?> / <?php bp_group_member_count(); ?>
						</div>
						<div class="meta-post">
							<span class="last-activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ); ?>">
								<?php
								/* translators: %s: last activity timestamp (e.g. "Active 1 hour ago") */
								printf( esc_html__( 'Active %s', 'buddypress' ), esc_html( bp_get_group_last_active() ) );
								?>
							</span>
						</div>
					</div>
				</div>

				<div class="footer-item-post">
					<a href="<?php bp_group_url(); ?>" class="btn btn-icon btn-primary"><i class="bi bi-arrow-right"></i></a>
				</div>
			</div>
		</div>

	<?php endwhile; ?>

	</div>

	<?php

	/**
	 * Fires after the listing of the groups list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_groups_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="group-dir-count-bottom">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-bottom">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php esc_html_e( 'There were no groups found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of groups from the groups loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_groups_loop' );
