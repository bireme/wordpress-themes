<!DOCTYPE html>
<?php 

get_header();?> 
	<div id="primary" class="col-md-8 archive">
		<!-- Start the Loop. -->
					 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<div class="post">
							<!-- Display the Title as a link to the Post's permalink. -->
							<h3><?php the_title(); ?></h3>

							<!-- Display the Post's content in a div box. -->
							<div class="entry">
								<?php the_excerpt(); ?>
							</div>
							<hr>
						</div>

						<!-- Stop The Loop (but note the "else:" - see next line). -->
					 <?php endwhile; else : ?>

						<!-- The very first "if" tested to see if there were any Posts to -->
						<!-- display.  This "else" part tells what do if there weren't any. -->
						<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>


						<!-- REALLY stop The Loop. -->
					 <?php endif; ?>

	</div><!-- #primary -->
	<div class="col-md-4">
	</div>
<?php
get_footer(); 
?>
