<!DOCTYPE html>
<?php 

get_header();?> 
	<div id="primary" class="col-md-12 single_post">
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
							<div class="nucleos">
									<?php 
										$nucleosArgs = array( 'post_type' => 'nucleo', 'posts_per_page' => 20);                   
																
											  $nucleosLoop = new WP_Query( $nucleosArgs );                  
																
											  while ( $nucleosLoop->have_posts() ) : $nucleosLoop->the_post();              ?>
										<div class="my_nucleo row">
											<div class="nucleo_thumb col-3">
												<img src="<?php the_post_thumbnail_url( ''); ?>" alt="<?php the_title(); ?>">
											</div>
											<div class="nucleo_info col-9">
												<h3><?php the_title(); ?></h3>
												<?php the_content(); ?>
											</div>
										</div>
										<hr>
									<?php endwhile; ?>
							</div><!-- fecha nucleos -->
				
						</div> <!-- closes the first div box -->

					 <?php endwhile; else : ?>
						<!-- REALLY stop The Loop. -->
					 <?php endif; ?>

 </div><!-- #primary -->
<?php
get_footer(); 
?>
