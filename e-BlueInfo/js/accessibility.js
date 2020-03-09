/*Versão Beta*/
/*Aumentar ou Reduzir Fontes*/
jQuery(document).ready(function(){
	var font14 = 14; var class14 ='#bgBlue p';
	var font16 = 16; var class16 ='#lang, #dataCountries p';
	var font20 = 20; var class20 ='.font20, #headerIn #nav ul li a';
	var font25 = 25; var class25 ='#bgGray, #bgBlue h4';
	var font40 = 40; var class40 ='#standoutTitulo h2, #dataCountries h2';
	jQuery('#fontPlus').click(function(){
		if (font16<40){
			font14 = font14+1; font16 = font16+1; font20 = font20+1; font25 = font25+1; font40 = font40+1;
			jQuery(class16).css({'font-size' : font16+'px'});
			jQuery(class14).css({'font-size' : font14+'px'});
			jQuery(class20).css({'font-size' : font20+'px'});
			jQuery(class25).css({'font-size' : font25+'px'});
			jQuery(class40).css({'font-size' : font40+'px'});
		}
	});
	jQuery('#fontLess').click(function(){
		if (font16>14){
			font16 = font16-1; font14 = font14-1; font20 = font20-1; font25 = font25-1; font40 = font40-1;
			jQuery(class16).css({'font-size' : font16+'px'});
			jQuery(class14).css({'font-size' : font14+'px'});
			jQuery(class20).css({'font-size' : font20+'px'});
			jQuery(class25).css({'font-size' : font25+'px'});
			jQuery(class40).css({'font-size' : font40+'px'});
		}
	});
	jQuery('#fontNormal').click(function(){
		font16 = 16; font14 = 14; font20 = 20; font25 = 25; font40 = 40;
		jQuery(class16).css({'font-size' : 16+'px'});
		jQuery(class14).css({'font-size' : 14+'px'});
		jQuery(class20).css({'font-size' : 20+'px'});
		jQuery(class25).css({'font-size' : 25+'px'});
		jQuery(class40).css({'font-size' : 40+'px'});
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
		window.location.assign("#main_container");
	}
	//Nav ALT + 2
	if((e.which == 50 || e.which == 98) && pressedALT == true) {
		window.location.assign("#nav");
	}
	//Footer ALT + 3
	if((e.which == 52 || e.which == 100) && pressedALT == true) {
		window.location.assign("#footer");
	}
	//Footer ALT + 4
	if((e.which == 51 || e.which == 99) && pressedALT == true) {
		// window.location.assign("#pesquisa");
		jQuery("#fieldSearch").focus();
	}
}
jQuery('a[href="#pesquisa"]').click(function(){
	jQuery("#fieldSearch").focus();
})
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