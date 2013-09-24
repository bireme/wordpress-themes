<?php get_header(); ?>
    
    
    <?php
    
    // Define o template que será usado
    if ( get_current_blog_id() == 1 )
    	get_template_part( 'front-page', 'principal' );
    else
    	get_template_part( 'front-page', 'grupo' );
    	
    ?> 

                        
<?php get_footer(); ?>
