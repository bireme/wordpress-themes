jQuery(document).ready(function() {

	// Os radios
	var radios = jQuery('input[name="tax_input[agenda_tipo]"]');
	
	// O radio selecionado ao entrar na edição do post
	var current_radio = jQuery('input[name="tax_input[agenda_tipo]"]:checked');
	
	// O título da meta box
	var container_title = jQuery('#agenda_data .hndle');
	
	// É no parent que verificamos as classes atribuídas
 	var parent = jQuery('#agenda_data .inside p');
	
	// Classe atribuída ao parent
	var parent_class;
    
    jQuery(radios).bind('change', function(e) {
    
    	var $this;
    	
    	var label_title;
    	
        id = jQuery(this).attr('id');
        label = jQuery('label[for='+id+']').text();
        
        var label_container = '<em class="agenda-title"> &#8605; ' + label + '</em>';
        
        // As classes do <p>
        parent_class = (label == 'Evento') ? 'evento' : 'reuniao';
        
        // Adiciona o label ao título da meta box
        if ( e.originalEvent !== undefined )
        {
        	label_title = jQuery(container_title).children('.agenda-title');
        	
    		if ( label_title.length > 0 )
    			jQuery(label_title).remove();
    			
    	}
    	/*
    	jQuery(container_title).append('<em class="agenda-title"> ' + label + '</em>', function() {
	    	jQuery('<em class="agenda-title"> ' + label + '</em>').fadeIn();	
    	});*/
    	
    	jQuery(label_container).appendTo(container_title).hide().fadeIn().css({
    		'color': '#999',
    		'font-size': '13px',
    	});
    	
        
	    jQuery(parent).each( function(i) {
	    
	    	$this = jQuery(this);
	    
	    	// Não precisamos do fadeIn para o trigger
	    	if ( e.originalEvent !== undefined )
		    	if ( $this.hasClass(parent_class) )
		    			$this.fadeIn();
	    
    		// Se o <p> não possuir a classe, escondemos os elementos
    		if ( ! $this.hasClass(parent_class) )
	    		$this.hide();
    	});
    });
    
    jQuery(current_radio).trigger('change');
 
});