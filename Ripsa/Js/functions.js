$(document).ready(function(){
	OpenTopics();
	Print();
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