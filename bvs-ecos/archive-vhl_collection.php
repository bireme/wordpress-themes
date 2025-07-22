<?php

/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

<section id="primary" class="content-area col-sm-12 col-lg-12">
	<div id="main" class="site-main" role="main">

		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e("Home", "bvs-ecos"); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php _e("Coleção BVS", "bvs-ecos"); ?></li>
			</ol>
		</nav>

		<div class="entry-header">
			<h1 class="title"><?php _e("Coleção BVS", "bvs-ecos"); ?></h1>
		</div>

		<div class="row list-posts">
			<?php if (have_posts()):

				/* Start the Loop */
				while (have_posts()): the_post();

					get_template_part('template-parts/items/item-25', 'post');

				endwhile;

				get_template_part( 'template-parts/navigation' );

			else:

				get_template_part('template-parts/content', 'none');

			endif; ?>
		</div>

	</div><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
