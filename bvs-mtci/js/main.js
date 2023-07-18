(function() {
	$(".form-check-input").click(function () {
		var val = $(this).val();
		if ( 'op1' == val ) {
			$("#fieldSearch").attr('name', 'q');
			$('#formHome input:hidden').attr('disabled', false);
		} else {
			$("#fieldSearch").attr('name', 's');
			$('#formHome input:hidden').attr('disabled', true);
		}
	});
})();