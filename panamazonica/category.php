<?php get_header(); ?>
	
	<div class="content">
	    
	    <?php if ( have_posts() ) : ?>
    	    <header class="archive-header">
    	    	<?php if ( category_description() ) : ?>
    	        	<div class="archive-meta">
    	        		<?php echo category_description(); ?>
    	        	</div>
	    		<?php endif; ?>
	    		<a href="<?php echo get_category_feed_link( $cat ) ?>" title="<?php _e( 'Subscribe to this category', 'panamazonica' )?>" class="icon-alone feed-link"><span aria-hidden="true" data-icon="&#xf09e;"></span><span class="assistive-text"><?php _e( 'Category feed', 'panamazonica' ); ?></span></a>
    	        <h1 class="archive-title"><?php single_cat_title(); ?></h1>
    	    </header><!-- /archive-header -->
    
            <?php while ( have_posts() ) : the_post(); ?>

            	<?php get_template_part( 'content', get_post_format() ); ?>
        
            <?php endwhile; ?>
        
            <?php panamazonica_content_nav( 'nav-below' ); ?>
        
        <?php else: ?>
        
        	<?php get_template_part( 'content', 'none' ); ?>
        
        <?php endif; ?>
	    
	</div><!-- /content -->
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>