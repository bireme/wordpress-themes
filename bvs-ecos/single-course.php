<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

<section id="primary" class="content-area col-sm-12 col-lg-12">
	<div id="main" class="site-main" role="main">

		<?php while (have_posts()) : the_post(); ?>

			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e("Home", "bvs-ecos"); ?></a></li>									
					<li class="breadcrumb-item"><a href="<?php echo get_post_type_archive_link(get_post_type()); ?>"><?php echo get_post_type_object(get_post_type())->labels->name; ?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php echo get_the_title(); ?></li>
				</ol>
			</nav>

		<?php
			get_template_part('template-parts/content-post');

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</div><!-- #main -->

	<?php get_template_part('template-parts/related', 'posts'); ?>
	
</section><!-- #primary -->

<?php
get_footer();
