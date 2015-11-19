jQuery(document).ready(function($){
	OpenTopics();
	Print();

        // get your select element and listen for a change event on it
        $('#select_edition').change(function() {
            // set the window's location property to the value of the option the user has selected
            href = $(location).attr('href');
			explode = href.split('/');
			if (explode[4] == 'category') {
				href = href.split(explode[3]);
				window.location = href[0] + $(this).find(":selected").text() + href[1];
			}
			else {
            	window.location = $bloginfo_url + '/' +  $(this).find(":selected").text() + '/' + $(location).attr('search');
			}
        });
});

function OpenTopics(){
	$(".single-topicos-open").show();
	$(".single-topics-seta").text("-");

	$(".single-h2").on("click", function(){
		if( $(this).parent().siblings(".single-topicos-open").css("display") == "block" ){
			$(this).parent().siblings(".single-topicos-open").hide();
			$(this).find(".single-topics-seta").text("+");
		}else{
			$(this).parent().siblings(".single-topicos-open").show();
			$(this).find(".single-topics-seta").text("-");
		}
	});

	$(".single-topics-showall").on("click", function(){
		$(".single-topicos-open").show();
		$(".single-topics-seta").text("-");
	});

	$(".single-topics-hideall").on("click", function(){
		$(".single-topicos-open").hide();
		$(".single-topics-seta").text("+");
	});
}

function Print(){
	$("#impressao").on("click", function(){
		if (!window.print){
		    alert("Use o Netscape  ou Internet Explorer \n nas versões 4.0 ou superior!")
		    return
		}
		window.print();
	});
}
