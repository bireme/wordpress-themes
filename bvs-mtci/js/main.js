(function() {
	$(".form-check-input").click(function () {
		var val = $(this).val();
		if ( 'op1' == val ) {
			$("#filterSearch").attr('name', 'q');
			$('#formHome input:hidden').attr('disabled', false);
		} else {
			$("#filterSearch").attr('name', 's');
			$('#formHome input:hidden').attr('disabled', true);
		}
	});
})();