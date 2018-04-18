<?php
/**
 * PAGE TEMPLATE
 */

get_header(); ?>
<div class="wp-page">
	<div class="container" id="maincontent" tabindex="-1">
		<div class="col-lg-12">
			<!-- Start the Loop. -->
			 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<!-- Test if the current post is in category 3. -->
				<!-- If it is, the div box is given the CSS class "post-cat-three". -->
				<!-- Otherwise, the div box is given the CSS class "post". -->

				<?php if ( in_category( '3' ) ) : ?>
					<div class="post-cat-three">
				<?php else : ?>
					<div class="post">
				<?php endif; ?>


				<!-- Display the Title as a link to the Post's permalink. -->

				<h2><?php the_title(); ?></h2>


				<!-- Display the Post's content in a div box. -->

				<div class="entry">
					<?php the_content(); ?>
				</div>


				<!-- Display a comma separated list of the Post's Categories. -->

				</div> <!-- closes the first div box -->


				<!-- Stop The Loop (but note the "else:" - see next line). -->

			 <?php endwhile; else : ?>


				<!-- The very first "if" tested to see if there were any Posts to -->
				<!-- display.  This "else" part tells what do if there weren't any. -->
				<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>


				<!-- REALLY stop The Loop. -->
			 <?php endif; ?>
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">

						<?php
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/page/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
				</div>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .wrap -->
	</div><!-- fecha container -->
</div> <!-- /wp-page -->
<?php get_footer();
