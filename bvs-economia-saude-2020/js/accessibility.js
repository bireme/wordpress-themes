/*Versão Beta*/
/*Aumentar ou Reduzir Fontes*/
jQuery(document).ready(function(){
	var font14 = 14; var class14 ='.font14, #footer, .widget-title, .widget-title li, .entry-content li, #menu-menu-principal a, #menu-menu-principal a, .searchItens, .vhl-themes, vhl-themes>strong, .eventos ul a, .noticias a, .vhl-themes>strong, .eventos ul a, .noticias a, #rss-4 a, #rss-4 .rssSummary'; // inserir elementos com fonte 14px
	var font16 = 16; var class16 ='.font16, p, #nav, .navFooter li a, .breadcrumb, .accordion, .accordion button'; // inserir elementos com fonte 16px
	var font20 = 20; var class20 ='.font20'; // inserir elementos com fonte 20px
	// Inserir novos tamanho aqui

	jQuery('#fontPlus').click(function(){
		if (font16<30){// Tamanho maximo com padrão 16px
			font14 = font14+1; font16 = font16+1; font20 = font20+1;
			jQuery(class14).css({'font-size' : font14+'px','line-height' : 1.5+'em'});
			jQuery(class16).css({'font-size' : font16+'px','line-height' : 1.5+'em'});
			jQuery(class20).css({'font-size' : font20+'px','line-height' : 1.5+'em'});
		}
	});
	jQuery('#fontLess').click(function(){
		if (font16>12){// tamanho minino com padrão 16px
			font14 = font14-1; font16 = font16-1; font20 = font20-1;
			jQuery(class14).css({'font-size' : font14+'px'});
			jQuery(class16).css({'font-size' : font16+'px'});
			jQuery(class20).css({'font-size' : font20+'px'});
		}
	});
	jQuery('#fontNormal').click(function(){ // Restaurar
		font14 = 14; font16 = 16; font20 = 20;
		jQuery(class14).css({'font-size' : 14+'px'});
		jQuery(class16).css({'font-size' : 16+'px'});
		jQuery(class20).css({'font-size' : 20+'px'});
	});
})
/*Navegação por atalhos*/
var pressedALT = false;
document.onkeyup=function(e){
	if(e.which == 18){
		pressedALT =false;
	}
}
document.onkeydown=function(e){
	if(e.which == 18){
		pressedALT = true;
	}
	// Main Alt + 1
	if((e.which == 49 || e.which == 97 )&& pressedALT == true) {
		window.location.assign("#primary");
	}
	//Nav ALT + 2
	if((e.which == 50 || e.which == 98) && pressedALT == true) {
		window.location.assign("#menu-menu-principal");
	}
	//Footer ALT + 3
	if((e.which == 52 || e.which == 100) && pressedALT == true) {
		window.location.assign("#footer");
	}
	//Footer ALT + 4
	if((e.which == 51 || e.which == 99) && pressedALT == true) {
		// window.location.assign("#pesquisa");
		jQuery("#vhl-search-input").focus();
	}
}
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