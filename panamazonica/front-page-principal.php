    
    <?php if ($lead = get_theme_option('lead_text')): ?>
        
        <div class="lead over" id="headline">
            <p><?php echo $lead; ?> 
            
            <?php if ($link = get_theme_option('lead_link')): ?>
                <a href="<?php echo $link; ?>" class="read-more">Saiba mais</a></p>
            <?php endif; ?>
            
            <a href="#" id="close-headline" class="icon-alone close-button"><span aria-hidden="true" data-icon="&#x2715;"><span class="assistive-text">Close</span></a>
            
        </div><!-- /lead -->
        
    <?php endif; ?>
    
    <div class="slider-wrapper">
        <div class="slider">
        	<?php
	    	$query = new WP_Query( array( 'posts_per_page' => 5, 'ignore_sticky_posts' => 1, 'meta_key' => '_home', 'meta_value' => 1 ) );
	    	
	        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
	        	
	        	$original_blog_id = get_post_meta($post->ID, '_original_blog_id', true);
	        	$original_post_id = get_post_meta($post->ID, '_original_post_id', true);
		        ?>
	        	<div class="media slide cf">
	        		<div class="img entry-image">
		    			<?php
		    			
		    			if ( $original_ids = panamazonica_get_original_ids() ) :
	    					switch_to_blog( $original_ids['blog_id'] );
	    					echo get_the_post_thumbnail( $original_ids['post_id'], 'post-grande' );
	    					restore_current_blog();
	    				else :
	    					the_post_thumbnail('post-grande');
	    				endif;
	    				
		    			?>
	        		</div>
	        		<div class="bd">
	        			<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	        			<div class="entry-summary">
		        			<?php the_excerpt(); ?>
	        			</div>
	        		</div>
	        	</div><!-- /slide -->
        	<?php endwhile; endif; wp_reset_postdata(); ?>
        </div><!-- /slider -->
    </div><!-- /slider-wrapper -->
    
    <?php panamazonica_grupos_tematicos(); ?>
        			
    <div class="container cf">
        <div class="block loop">
	        <?php the_widget( 'Widget_Acontece_Rede' ); ?>
	    </div>
	    <div class="block loop">
	        <?php the_widget( 'Widget_Documentos' ); ?>
	    </div>
	    <div class="block loop">	       
        	<?php the_widget( 'Widget_Agenda' ); ?>
	    </div>
    </div><!-- /container -->