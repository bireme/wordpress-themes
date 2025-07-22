jQuery(function($){
 	// multiple select with AJAX search
	$('.select2-suggested-posts').select2({
		allowClear: true,
        language: {
			inputTooShort:function(e){ return "Digite "+ (e.minimum-e.input.length) +" ou mais caracteres"; },
			loadingMore: function(){ return "Carregando mais resultados..."; },
			noResults:function(){ return "Nenhum resultado encontrado"; },
			searching:function(){ return "Buscando..."; },
			errorLoading:function(){ return "Os resultados não puderam ser carregados."; }
		},
        placeholder: "Buscar...",
        width: "100%",
        height: "36px",
  		ajax: {
    			url: ajaxurl, // AJAX URL is predefined in WordPress admin
    			dataType: 'json',
    			delay: 250, // delay in ms while typing when to perform a AJAX search
    			data: function (params) {
      				return {
        				q: params.term, // search query
        				action: 'post_suggestion' // AJAX action for admin-ajax.php
      				};
    			},
    			processResults: function( data ) {
				var options = [];
				if ( data ) {
 
					// data is the array of arrays, and each of them contains ID and the Label of the option
					$.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
						options.push( { id: text[0], text: text[1]  } );
					});
 
				}
				return {
					results: options
				};
			},
			cache: true
		},
		minimumInputLength: 3 // the minimum of symbols to input before perform a search
	});

	$(".select2-suggested-posts").on('select2:clear', function (e){
        var sel = e.currentTarget;
        $(sel).html('<option value="0" selected></option>').select2("val", "0");
    });
});