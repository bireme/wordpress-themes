<?php get_header(); ?>
	
	<div class="content">
	    
	    <?php if ( have_posts() ) : ?>
    	    <header class="archive-header">
    	        <h1 class="archive-title"><?php
    	        	if ( is_day() ) :
    	        		printf( __( 'Daily Archives: %s', 'panamazonica' ), '<span>' . get_the_date() . '</span>' );
    	        	elseif ( is_month() ) :
    	        		printf( __( 'Monthly Archives: %s', 'panamazonica' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'panamazonica' ) ) . '</span>' );
    	        	elseif ( is_year() ) :
    	        		printf( __( 'Yearly Archives: %s', 'panamazonica' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'panamazonica' ) ) . '</span>' );
    	        	else :
    	        		_e( 'Archives', 'panamazonica' );
    	        	endif;
    	        ?></h1>
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