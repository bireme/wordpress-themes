	<div class="container cf">
	
		<?php 
		if ( class_exists('EletroWidgets' ) ) : 
			new EletroWidgets(3);	
		else :
		?>		
	
        <div class="block loop">
	        <?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 4 ) ); ?>
	    </div>
	    <div class="block loop">
	        <?php the_widget( 'Widget_Documentos' ); ?>
	    </div>
	    <div class="block loop">	       
        	<?php the_widget( 'Widget_Agenda' ); ?>
	    </div>
	    
	    <?php endif; ?>
	    
    </div><!-- /container -->