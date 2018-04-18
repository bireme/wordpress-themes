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
				<div class="col-lg-6">
					<?php 
						$value = get_field( "video_relacionado" );
					?>
					<h4 class="archive_video_title"><?php the_title(); ?></h4>
					<div class="youtube_video video_archive">
						<iframe class='video' src='https://www.youtube.com/embed/<?php echo $value;?>?rel=0&amp;controls=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe>
					</div>
				</div>
		    <?php endwhile; ?>
		<?php else : ?>
		  <h2 class="center">Not Found</h2>
		 <p class="center"><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>
		  <?php endif; ?>
		</div> <!-- fecha col-lg-12 -->
	</div><!-- fecha container -->
</div> <!-- /wp-page -->
<?php get_footer();
