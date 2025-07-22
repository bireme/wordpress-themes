<?php

/**
 * bbPress - Forum Archive
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>

<section id="primary" class="content-area col-sm-12 col-md-12 col-lg-12">
	<div id="main" class="site-main" role="main">

		<nav aria-label="breadcrumb">
			<?php bbp_breadcrumb(); ?>
		</nav>		

		<div class="entry-header">
			<h1 class="title"><?php _e("Fórum Rede Ecos", "bvs-ecos"); ?></h1>
		</div>

		<?php do_action('bbp_before_main_content'); ?>

		<?php do_action('bbp_template_notices'); ?>

		<div id="forum-front" class="bbp-forum-front">
			<div class="entry-content">

				<?php bbp_get_template_part('content', 'archive-forum'); ?>

			</div>
		</div><!-- #forum-front -->

		<?php do_action('bbp_after_main_content'); ?>

	</div><!-- #main -->
</section><!-- #primary -->

<?php get_footer();
