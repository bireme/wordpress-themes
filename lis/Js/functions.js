$(window).load(function(){
	regExp();
	reportarErro();
	sugerirTag();
	compartilhar();
});

function regExp(){
	if($(".cat-item").length){
		$("#categories-3 .cat-item").each(function(e){
			i = e+1;
			element = $(this);

			var cat_text = element.html();
			var cat_link = element.children("a").attr("href");
			var cat_nome = element.children("a").text();
			var cat_new  = "<a href='"+cat_link+"' title='Ver todos os posts arquivados em "+cat_nome+"'>"+cat_nome+"</a>";

			var regex    = /(.*)(\()(.*)(\))/;
			var result   = cat_text.replace(regex, "<span class='cat-item-count'>$3</span>");
			element.text("").append(cat_new+result);
		});
	}
}

function reportarErro(){
	$(".reportar-erro-open").on("click", function(){
		$(".reportar-erro").hide();
		$(".compartilhar").hide();
		$(".sugerir-tag").hide();
		$(this).siblings(".reportar-erro").show();
	});

	$(".reportar-erro-close").on("click", function(){
		$(this).parent().parent().hide();
	});
}

function compartilhar(){
	$(".compartilhar-open").on("click", function(){
		$(".compartilhar").hide();
		$(".sugerir-tag").hide();
		$(".reportar-erro").hide();
		$(this).siblings(".compartilhar").show();
	});

	$(".compartilhar-close").on("click", function(){
		$(this).parent().hide();
	});
}

function sugerirTag(){
	$(".sugerir-tag-open").on("click", function(){
		$(".reportar-erro").hide();
		$(".compartilhar").hide();
		$(".sugerir-tag").hide();
		$(this).siblings(".sugerir-tag").show();
	});

	$(".sugerir-tag-close").on("click", function(){
		$(this).parent().parent().hide();
	});
}