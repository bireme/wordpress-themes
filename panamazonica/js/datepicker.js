jQuery(document).ready(function(){
			
	// Define os padrões
	jQuery.datepicker.regional['pt'] = {
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho', 'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dateFormat: 'dd/mm/yy',
		firstDay: 0, 
		currentText: 'Este ano',
		closeText: 'Selecionar'
	};
		
	jQuery.datepicker.setDefaults(jQuery.datepicker.regional['pt']);

	// Agenda
	$data_inicial = jQuery('#_pan_data_inicial');
	$data_final = jQuery('#_pan_data_final');
	
	$data_inicial.datepicker({
		dateFormat: 'dd/mm/yy',
		onSelect: function( dateText, inst ) {
			var data_final = $data_final.datepicker( "getDate" );
			
			console.log(data_final);
			
			if ( ! data_final )
				$data_final.val(dateText);
		},
		onClose: function( selectedDate ) {
        	$data_final.datepicker( "option", "minDate", selectedDate );
        }
	});
	
	$data_final.datepicker({
		dateFormat: 'dd/mm/yy',
		onClose: function( selectedDate ) {
            $data_inicial.datepicker( "option", "maxDate", selectedDate );
        }
	});
	

	// Documento
    jQuery(function()
	{   
		// Buscamos a data pra passar como default
		var ano = jQuery('#_pan_ano').attr('value');
		if (ano)
		{
			ano++;
			ano = ano.toString();
			ano = new Date(ano);
		}
		else
			ano = new Date();
		
	    jQuery("#_pan_ano").datepicker({
	        dateFormat: 'yy',
	        changeYear: true,
	        showButtonPanel: true,
	        defaultDate: ano,
	        maxDate: new Date(),
	        yearRange: "-20:+0",
	        onClose: function(dateText, inst) {
	            var month = jQuery("#ui-datepicker-div .ui-datepicker-month :selected").val();
	            var year = jQuery("#ui-datepicker-div .ui-datepicker-year :selected").val();
	            jQuery(this).val(jQuery.datepicker.formatDate('yy', new Date(year, 1)));
	        }
	    });
	
	    // Ao abrirmos, são removidos os controles de data e mês
	    jQuery("#_pan_ano").focus(function () {
	    	jQuery(".ui-datepicker-month").hide();
	    	jQuery(".ui-icon").hide();
	        jQuery(".ui-datepicker-calendar").hide();
	        jQuery("#ui-datepicker-div").position({
	            my: "center top",
	            at: "center bottom",
	            of: jQuery(this)
	        });
	    });
	});

});