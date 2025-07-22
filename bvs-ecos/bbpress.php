<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://bbpress.org/forums/topic/how-do-i-get-bbpress-pages-to-use-a-specific-page-template-in-wordpress/
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

<section id="primary" class="content-area col-sm-12 col-lg-12">
	<div id="main" class="site-main" role="main">

		<?php while (have_posts()) : the_post(); ?>

			<?php if(bbp_is_search()){
				bbp_breadcrumb();
			}
			else{ ?>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e("Home", "bvs-ecos"); ?></a></li>
					<?php if(bp_is_group()){ ?>
					<li class="breadcrumb-item"><a href="<?php echo bp_get_groups_directory_permalink(); ?>"><?php _e("Fórum Rede Ecos", "bvs-ecos"); ?></a></li>
					<?php } ?>
					<li class="breadcrumb-item active" aria-current="page"><?php echo get_the_title(); ?></li>
				</ol>
			</nav>
		<?php
			}
			
			get_template_part('template-parts/content', 'buddypress');			

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</div><!-- #main -->

</section><!-- #primary -->

<?php
get_footer();
