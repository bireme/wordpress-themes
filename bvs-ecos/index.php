<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-md-12 col-lg-12">
		<div id="main" class="site-main" role="main">

			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e("Home", "bvs-ecos"); ?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php single_post_title(); ?></li>
				</ol>
			</nav>

			<div class="entry-header">
				<h1 class="title"><?php single_post_title(); ?></h1>
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
