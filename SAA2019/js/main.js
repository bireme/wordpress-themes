$ = jQuery;

var $clock = $('#tvFooterHora');
setInterval(function () {
	$clock.html((new Date()).toLocaleString('pt-BR',{hour12:false, timeZone: 'America/Sao_Paulo'}).substr(11, 8));
}, 1000);


/*** News TV ***/
var interval = parseInt($("#tvCarousel").data("interval"));
var articlePlay =  setInterval(articleNext, interval);

function articleNext(){
	if($(".tvNewsLoop.active").next().length){
		$(".tvNewsLoop.active").hide(function(){
			var last_slide = $("#tvNewsNext").find(".tvNewsLoop:last");
			$(this).removeClass("active").next().addClass("active").show();
			$(this).detach().insertAfter(last_slide).show();
		});
	}
}	