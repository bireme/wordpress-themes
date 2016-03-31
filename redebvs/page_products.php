<?php
/**
 * Template Name: Products
 *
 *
 * @package WordPress
 * @subpackage redebvs
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

<?php get_footer(); ?>