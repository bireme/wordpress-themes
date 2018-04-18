<?php
/**
 * PAGE TEMPLATE
 */

get_header(); ?>
<div class="wp-page">
	<div class="container" id="maincontent" tabindex="-1">
		<div class="col-lg-12">
				<h2><?php single_cat_title() ?></h2>
		<?php if (have_posts()) : ?>
		   <?php while (have_posts()) : the_post(); ?>
			   	<a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>">
			   		<div class="archive_shadow">
						<div class="archive_gallery" style="background-image: url(<?php the_post_thumbnail_url();?>);">
							<span class="gallery_title"><?php the_title(); ?></span>
						</div>
			   		</div>
			   	</a>
		    <?php endwhile; ?>
		<?php else : ?>
		  <h2 class="center">Not Found</h2>
		 <p class="center"><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>
		  <?php endif; ?>
		  
		  
			  <?php 
					$hotsite_lang = pll_current_language(slug); //pega o idioma do template
					include "vars_$hotsite_lang.php";
				?>
				<h2><?php echo $bir50_GalleryTitle; ?></h2>
				<div class="col-lg-12">
				    <div class="resCarousel" data-items="1,2,3,3" data-slide="3">
				        <div class="resCarousel-inner" >
							<?php wp_reset_query(); ?>
				        	<?php query_posts("category_name=$bir50_gallerycategory"); ?>
							<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				                <div class="item">
				                    <div class="gallery-carousel">
				                    	<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
					                        <img src="<?php the_post_thumbnail_url(); ?>" class="img-responsive">
				                    	</a>
					                        <div class="gallery_title"><?php the_title_attribute(); ?></div>
				                    </div>
				                </div>
		   					 <?php endwhile; else: ?>
		   					 	<h3>ERRO!</h3>
		   					 <?php endif; ?>
				        </div>
				        <button class='btn btn-default leftLst'><i class="fa fa-fw fa-angle-left"></i></button>
						<button class='btn btn-default rightLst'><i class="fa fa-fw fa-angle-right"></i></button>
				    </div>
				</div>
			    	<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/carousel.css" rel="stylesheet" type="text/css">
			    	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/resCarousel.js"></script>
		</div> <!-- fecha col-lg-12 -->
	</div><!-- fecha container -->
</div> <!-- /wp-page -->
<?php get_footer();
