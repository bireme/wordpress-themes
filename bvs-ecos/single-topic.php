<?php

/**
 * Single Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>

<?php do_action('bbp_before_main_content'); ?>

<?php do_action('bbp_template_notices'); ?>

<?php if (bbp_user_can_view_forum(array('forum_id' => bbp_get_topic_forum_id()))) : ?>

	<?php while (have_posts()) : the_post(); ?>

		<nav aria-label="breadcrumb">
			<?php bbp_breadcrumb(); ?>
		</nav>

		<div id="bbp-topic-wrapper-<?php bbp_topic_id(); ?>" class="bbp-topic-wrapper">
			<header class="entry-header">
				<h1 class="title"><?php bbp_topic_title(); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">

				<?php bbp_get_template_part('content', 'single-topic'); ?>

			</div>
		</div><!-- #bbp-topic-wrapper-<?php bbp_topic_id(); ?> -->

	<?php endwhile; ?>

<?php elseif (bbp_is_forum_private(bbp_get_topic_forum_id(), false)) : ?>

	<?php bbp_get_template_part('feedback', 'no-access'); ?>

<?php endif; ?>

<?php do_action('bbp_after_main_content'); ?>

<?php get_footer();
