<!DOCTYPE html>
<?php 

get_header();?> 
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
			</ol>
		</nav>
	</div>
	<div id="primary" class="col-md-12 single_post">
		<div class="container" id="main_container">
		<!-- Start the Loop. -->
					 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<div class="post">
						<!-- Display the Title as a link to the Post's permalink. -->
						<h2><?php the_title(); ?></h2>

						<!-- Display the date (November 16th, 2009 format) and a link to other posts by this posts author. -->
						<!--small class="date_post"><?php the_date(); ?> </small-->

						<!-- Display the Post's content in a div box. -->
						<div class="entry">
							<?php the_content(); ?>
						</div>

						<!-- Display a comma separated list of the Post's Categories. -->
						<!--p class="postmetadata"><?php _e( 'Categorias:' ); ?> <?php the_category( ', ' ); ?></p-->
						</div> <!-- closes the first div box -->

						<!-- Stop The Loop (but note the "else:" - see next line). -->
						<!--div class="author_box">
							<?php echo get_the_author_meta('display_name'); ?><br>
							<?php echo get_the_author_meta('description'); ?>
						</div-->
					 <?php endwhile; else : ?>

						<!-- The very first "if" tested to see if there were any Posts to -->
						<!-- display.  This "else" part tells what do if there weren't any. -->
						<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>


						<!-- REALLY stop The Loop. -->
					 <?php endif; ?>

		</div>
 </div><!-- #primary -->
<?php
get_footer(); 
?>
