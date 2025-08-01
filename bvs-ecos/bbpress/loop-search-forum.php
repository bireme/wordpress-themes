<?php

/**
 * Search Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<div class="bbp-forum-header">
	<div class="bbp-meta">
		<span class="bbp-forum-post-date"><?php printf( esc_html__( 'Last updated %s', 'bbpress' ), bbp_get_forum_last_active_time() ); ?></span>
	</div><!-- .bbp-meta -->

	<div class="bbp-forum-title">

		<?php do_action( 'bbp_theme_before_forum_title' ); ?>

		<h3><small><?php esc_html_e( 'Forum:', 'bbpress' ); ?></small>
		<a href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></h3>

		<?php do_action( 'bbp_theme_after_forum_title' ); ?>

	</div><!-- .bbp-forum-title -->
</div><!-- .bbp-forum-header -->

<div id="post-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>
	<div class="bbp-forum-content">

		<?php do_action( 'bbp_theme_before_forum_content' ); ?>

		<?php bbp_forum_content(); ?>

		<?php do_action( 'bbp_theme_after_forum_content' ); ?>

	</div><!-- .bbp-forum-content -->
</div><!-- #post-<?php bbp_forum_id(); ?> -->
