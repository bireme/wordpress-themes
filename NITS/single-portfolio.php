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
						<small class="date_post"><?php the_date(); ?> </small>

						<!-- Display the Post's content in a div box. -->
						<div class="row portfolio-detail">
							<div class="entry col-md-7">
								<?php the_content(); ?>
									<div class="spacer spacetop"></div>
									<b>Inventores:</b><br> <?php echo get_post_meta($post->ID, 'inventors_portfolios', true)?>
									<div class="spacer spacetop"></div>
									<?php echo get_the_term_list( $post->ID, 'tipos', '<b>Tipo:</b> ', ', ', '<br>'); ?>
									<div class="spacer spacetop"></div>
									<?php echo get_the_term_list( $post->ID, 'nucleos', '<b>Núcleos:</b> <br>', ', ', '<br>'); ?>
									<div class="spacer spacetop"></div>
									<?php echo get_the_term_list( $post->ID, 'temas', '<b>Temas:</b> <br>', ', ', '<br>'); ?>
									<div class="spacer spacetop"></div>
									<b>Problema a ser resolvido:</b><br> <?php echo get_post_meta($post->ID, 'problem_portfolios', true)?>
									<div class="spacer spacetop"></div>
									<b>Inovação da Proposta:</b><br> <?php echo get_post_meta($post->ID, 'innovation_portfolios', true)?>
									<div class="spacer spacetop"></div>
									<b>Diferencial:</b><br><?php echo get_post_meta($post->ID, 'advantage_portfolios', true)?>
									<div class="spacer spacetop"></div>
									<b>Status da Propriedade Intelectual:</b> <br><?php echo get_post_meta($post->ID, 'status_portfolios', true)?>
									<div class="spacer spacetop"></div>
									<b>O que buscamos: </b><br><?php echo get_post_meta($post->ID, 'seek_portfolios', true)?>
									<div class="spacer spacetop"></div>
									<b>Mais Informações: </b><br>
										<a href="<?php echo get_post_meta($post->ID, 'link_portfolios', true)?>" alt="Mais Informações">
											Link
										</a>
							</div>
							<div class="thumb col-md-5">
									<img src="<?php the_post_thumbnail_url( 'portfolio'); ?>" alt="<?php the_title(); ?>" style="width: 100%;">

							</div>
						</div>
						<!-- Stop The Loop (but note the "else:" - see next line). -->
						 <form>
						  <input type="button" value="voltar" class="backButton" onclick="history.go(-1)">
						</form>
						<div class="spacer spacetop"></div>
						<hr>
						<div class="author_box spacetop">
							Escrito por: <br>
							<?php echo get_the_author_meta('display_name'); ?><br>
							<?php echo get_the_author_meta('description'); ?>
						</div>
					 <?php endwhile; else : ?>

						<!-- The very first "if" tested to see if there were any Posts to -->
						<!-- display.  This "else" part tells what do if there weren't any. -->
						<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>


						<!-- REALLY stop The Loop. -->
					 <?php endif; ?>

 </div><!-- #primary -->
<?php
get_footer(); 
?>
