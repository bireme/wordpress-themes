// cache contraste
var cor = Cookies.get('cor');
// Ao Abrir a pagina 
jQuery( document ).ready(function() {
	if(cor == '' || typeof cor === "undefined"){
		jQuery('body').removeClass('bodyBlack');
	}else{
		jQuery('body').addClass('bodyBlack');
	}
});
//Ao clicar Contraste
jQuery('#contraste').on( "click", function(){
	if(cor == 'bodyBlack'){
		Cookies.set('cor', '', { expires: 1 });
	}else{
		Cookies.set('cor', 'bodyBlack', { expires: 1 });
	}
	jQuery('body').toggleClass('bodyBlack');
});