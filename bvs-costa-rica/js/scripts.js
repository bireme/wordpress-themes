jQuery(function($){
    $(".form-check-input").click(function () {
        var val = $(this).val();
        if ( 'op1' == val ) {
            $('#input-filter').attr('disabled', true);
        } else {
            $('#input-filter').attr('disabled', false);
        }
    });
});