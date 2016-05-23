<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<?php dynamic_sidebar( 'aux-top-level2' ); ?>
<?php if ( function_exists( 'vhl_breadcrumb' ) ) { vhl_breadcrumb(); } ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<div class="spacer"></div>
        <div class="footer_sidebar">
                <?php dynamic_sidebar( 'single-sidebar' ); ?>
                <div class="spacer"></div>
        </div>
<?php get_footer(); ?>
