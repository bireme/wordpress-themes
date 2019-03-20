<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-lg-12">
		<main id="main" class="site-main" role="main">

		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
		    	<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>

	    	<?php 
		    	$parent_page = get_post_ancestors(get_the_ID()); 
		    	if( !empty($parent_page) ) : ?>
			    <li class="breadcrumb-item active" aria-current="page">
			    	<a href="<?php echo get_permalink( $parent_page[0] ); ?>">
			    		<?php echo get_the_title( $parent_page[0] ); ?>
			    	</a>
		    	</li>
			<?php else: ?>
				<li class="breadcrumb-item active" aria-current="page">
					<?php the_title(); ?>
				</li>
			<?php endif; ?>

		  	</ol>
		</nav>

		<div class="row justify-content-center content-page">
			<?php while ( have_posts() ) : the_post(); ?>				

				<div class="col-md-10">
					<?php if( has_post_thumbnail() ): ?>
					<div class="row">
						<div class="page-thumbnail col-md-2">
							<?php the_post_thumbnail(); ?>
						</div>
						<div class="col-md-10">
							<?php 
							get_template_part( 'template-parts/content', 'page' );

			                // If comments are open or we have at least one comment, load up the comment template.
			                if ( comments_open() || get_comments_number() ) :
			                    comments_template();
			                endif;					
							?>
						</div>
					</div>
					<?php else: ?>
						<?php 
						get_template_part( 'template-parts/content', 'page' );

		                // If comments are open or we have at least one comment, load up the comment template.
		                if ( comments_open() || get_comments_number() ) :
		                    comments_template();
		                endif;					
						?>
					<?php endif; ?>
				</div>
			<?php endwhile; // End of the loop. ?>
		</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
