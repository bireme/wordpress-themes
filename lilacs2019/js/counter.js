$('.count').each(function() {
    $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
    }, {
        duration: 1000,
        easing: 'swing',
        step: function(now) {
            //$(this).text(Math.ceil(now));
			if (now >= 1000) {
				$(this).text(parseFloat(Math.round(now) / 1000).toFixed(3));
			} else {
				$(this).text(Math.ceil(now));
			}
        }
    });
});

jQuery(document).ready(function($) {
	
    setInterval(function() {
        updateValue();
    }, 6000);

});

function updateValue() {

    $('#count').html(Math.floor(Math.random() * (1000 - 1)) + 1);
	$('#count').each(function() {

        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 1000,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
}
