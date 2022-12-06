<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-lg-9">
		<main id="main" class="site-main" role="main">

		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
		    	<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?php _e('Segunda Opinião Formativa - SOF', 'bvs_lang'); ?></li>
		  	</ol>
		</nav>

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'sof' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.		
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_template_part( 'template-parts/related', 'sofs' ); ?>

<?php get_template_part( 'template-parts/last', 'sofs' ); ?>

<?php 
get_footer('full');
