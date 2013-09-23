<?php get_header(); ?>
	
			<div class="content">
			
				<?php
				
				while ( have_posts() ) : the_post();
				
					get_template_part( 'content', 'single' );
				
					comments_template('', true);
									
				endwhile;
				
				panamazonica_content_nav( 'nav-below' );
				
				?>
			
			</div><!-- /content -->		
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>