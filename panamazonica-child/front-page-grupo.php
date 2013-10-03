	<div class="container cf">
	
		<?php 
	//	if ( class_exists('EletroWidgets' ) ) : 
	//		new EletroWidgets(3);	
	//	else :
		?>		
	
        	<div class="block loop">
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('First Column') ) : else : ?>
			<?php endif; ?>	
		</div>
		<div class="block loop">
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Second Column') ) : else : ?>
			<?php endif; ?>	
	    	</div>
	    	<div class="block loop">	       
	    		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Third Column') ) : else : ?>
			<?php endif; ?>	
		</div>
	    
	    	<?php // endif; ?>
	    
	</div><!-- /container -->
