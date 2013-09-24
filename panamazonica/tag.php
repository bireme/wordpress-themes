<?php get_header(); ?>
	
	<div class="content">
	    
	    <?php if ( have_posts() ) : ?>
    	    <header class="archive-header">
    	    	<?php if ( tag_description() ) : ?>
    	        	<div class="archive-meta">
    	        		<?php echo tag_description(); ?>
    	        	</div>
	    		<?php endif; ?>
	    		<a href="<?php echo get_tag_feed_link($tag_id); ?>" title="<?php _e( 'Subscribe to this tag', 'panamazonica' )?>" class="icon-alone feed-link"><span aria-hidden="true" data-icon="&#xf09e;"></span><span class="assistive-text"><?php _e( 'Tag feed', 'panamazonica' ); ?></span></a>
    	        <h1 class="archive-title"><?php single_tag_title(); ?></h1>
    	    </header><!-- /archive-header -->
    
            <?php while ( have_posts() ) : the_post(); ?>

            	<?php get_template_part( 'content', get_post_format() ); ?>
        
            <?php endwhile; ?>
        
            <?php panamazonica_content_nav( 'nav-below' ); ?>
        
        <?php else : ?>
        
        	<?php get_template_part( 'content', 'none' ); ?>
        
        <?php endif; ?>
	    
	</div><!-- /content -->
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>