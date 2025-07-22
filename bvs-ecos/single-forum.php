<?php

/**
 * Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>

	<?php do_action( 'bbp_before_main_content' ); ?>

	<?php do_action( 'bbp_template_notices' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( bbp_user_can_view_forum() ) : ?>

			<nav aria-label="breadcrumb">
				<?php bbp_breadcrumb(); ?>
			</nav>

			<div id="forum-<?php bbp_forum_id(); ?>" class="bbp-forum-content">
				<header class="entry-header">
					<h1 class="title"><?php bbp_forum_title(); ?></h1>
				</header><!-- .entry-header -->
				
				<div class="entry-content">

					<?php bbp_get_template_part( 'content', 'single-forum' ); ?>

				</div>
			</div><!-- #forum-<?php bbp_forum_id(); ?> -->

		<?php else : // Forum exists, user no access ?>

			<?php bbp_get_template_part( 'feedback', 'no-access' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php do_action( 'bbp_after_main_content' ); ?>

<?php get_footer();
