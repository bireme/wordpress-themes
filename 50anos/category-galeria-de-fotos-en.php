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
		</div> <!-- fecha col-lg-12 -->
	</div><!-- fecha container -->
</div> <!-- /wp-page -->
<?php get_footer();
