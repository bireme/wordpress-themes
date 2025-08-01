<?php

/**
 * Search Loop - Single Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<div class="bbp-topic-header">
	<div class="bbp-meta">
		<span class="bbp-topic-post-date"><?php bbp_topic_post_date( bbp_get_topic_id() ); ?></span>
	</div><!-- .bbp-meta -->

	<div class="bbp-topic-title">

		<?php do_action( 'bbp_theme_before_topic_title' ); ?>

		<h3><small><?php esc_html_e( 'Topic:', 'bbpress' ); ?></small>
		<a href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a></h3>

		<div class="bbp-topic-title-meta">

			<?php if ( function_exists( 'bbp_is_forum_group_forum' ) && bbp_is_forum_group_forum( bbp_get_topic_forum_id() ) ) : ?>

				<?php esc_html_e( 'in group forum ', 'bbpress' ); ?>

			<?php else : ?>

				<?php esc_html_e( 'in forum ', 'bbpress' ); ?>

			<?php endif; ?>

			<a href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>"><?php bbp_forum_title( bbp_get_topic_forum_id() ); ?></a>

		</div><!-- .bbp-topic-title-meta -->

		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

	</div><!-- .bbp-topic-title -->

</div><!-- .bbp-topic-header -->

<div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>
	<div class="bbp-topic-author">

		<?php do_action( 'bbp_theme_before_topic_author_details' ); ?>

		<?php bbp_topic_author_link( array( 'show_role' => true ) ); ?>

		<?php do_action( 'bbp_theme_after_topic_author_details' ); ?>

	</div><!-- .bbp-topic-author -->

	<div class="bbp-topic-content">

		<?php do_action( 'bbp_theme_before_topic_content' ); ?>

		<?php bbp_topic_content(); ?>

		<?php do_action( 'bbp_theme_after_topic_content' ); ?>

	</div><!-- .bbp-topic-content -->
</div><!-- #post-<?php bbp_topic_id(); ?> -->
