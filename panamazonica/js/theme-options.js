jQuery(document).ready(function() {
		 	
 	var $remove_logo = jQuery('.remove-custom-logo');
 	
 	$remove_logo.click(function() {
 	
 		var default_image_src =  jQuery('.default-image-src').attr('value');
         
        jQuery('.uploaded-logo').fadeOut('fast',function() {
		    jQuery('.uploaded-logo').attr('src', default_image_src ).fadeIn('fast');
		  });
         
         // Adiciona campo hidden
         jQuery('.panamazonica-theme-options').append('<input type="hidden" name="restore-default-image" value="1" />');
         
         // Remove o link
         jQuery(this).hide();
         
         return false;
    });
 
});