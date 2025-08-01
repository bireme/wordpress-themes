<?php

/**
 * Search Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<div id="bbpress-forums" class="bbpress-wrapper">

	<?php bbp_get_template_part( 'form', 'search' ); ?>

	<?php bbp_set_query_name( bbp_get_search_rewrite_id() ); ?>

	<?php do_action( 'bbp_template_before_search' ); ?>

	<?php if ( bbp_has_search_results() ) : ?>

		<?php bbp_get_template_part( 'pagination', 'search' ); ?>

		<?php bbp_get_template_part( 'loop',       'search' ); ?>

		<?php bbp_get_template_part( 'pagination', 'search' ); ?>

	<?php else : ?>

		<?php bbp_get_template_part( 'feedback',   'no-search' ); ?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_search_results' ); ?>

</div>

