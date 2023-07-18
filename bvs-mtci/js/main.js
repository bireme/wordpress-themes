jQuery(function($){
	var action = $('#formHome').attr('action');
	$(".form-check-input").click(function () {
		var val = $(this).val();
		if ( 'op1' == val ) {
			$("#fieldSearch").attr('name', 'q');
			$('#formHome').attr('action', action);
			$('#formHome input:hidden').attr('disabled', false);
		} else {
			$("#fieldSearch").attr('name', 's');
			$('#formHome').attr('action', '');
			$('#formHome input:hidden').attr('disabled', true);
		}
	});
});