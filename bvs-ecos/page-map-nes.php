<?php

/**
 * Template Name: Mapa de NES
 */
get_header(); ?>

<section id="primary" class="content-area col-sm-12 col-lg-12">
	<div id="main" class="site-main" role="main">

		<?php while (have_posts()) : the_post(); ?>
		
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e("Home", "bvs-ecos"); ?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php echo get_the_title(); ?></li>
				</ol>
			</nav>
		
		<?php
			get_template_part('template-parts/content', 'page-map-nes');			

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
