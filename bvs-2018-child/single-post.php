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
		<main id="main" class="site-main" role="main">

		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
		    	<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
			    <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo get_post_type_archive_link('post'); ?>"><?php _e('Notícias', 'bvs_lang'); ?></a></li>
		  	</ol>
		</nav>

		<div class="row justify-content-center content-post">
			<div class="col-md-10">
				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'post' );					

				endwhile; // End of the loop.
				?>
			</div>
		</div>
		
		<?php wp_related_posts(); ?>

		<div class="row">
			<div class="col-md-12">
				<?php 
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</div>
		</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
