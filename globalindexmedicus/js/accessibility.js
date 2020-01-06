/*Versão Beta*/
/*Aumentar ou Reduzir Fontes*/
jQuery(document).ready(function(){
	var font12 = 12; var class12 ='#idiomas';
	var font14 = 14; var class14 ='.widgetColumn a, .widgetColumn';
	var font16 = 16; var class16 ='p, .accordion .collapse, .accordion h2 button, #nav, .sectionBlue h5, .sectionBlue';
	var font20 = 20; var class20 ='.bibliotecaHome h4';
	var font32 = 32; var class32 ='.titulo1';
	jQuery('#fontPlus').click(function(){
		if (font16<30){
			font12 = font12+1; font14 = font14+1; font16 = font16+1; font20 = font20+1; font32 = font32+1;
			jQuery(class12).css({'font-size' : font12+'px'});
			jQuery(class16).css({'font-size' : font16+'px'});
			jQuery(class14).css({'font-size' : font14+'px'});
			jQuery(class20).css({'font-size' : font20+'px'});
			jQuery(class32).css({'font-size' : font32+'px'});
		}
	});
	jQuery('#fontLess').click(function(){
		if (font16>14){
			font12 = font12-1; font16 = font16-1; font14 = font14-1; font20 = font20-1; font32 = font32-1;
			jQuery(class12).css({'font-size' : font12+'px'});
			jQuery(class16).css({'font-size' : font16+'px'});
			jQuery(class14).css({'font-size' : font14+'px'});
			jQuery(class20).css({'font-size' : font20+'px'});
			jQuery(class32).css({'font-size' : font32+'px'});
		}
	});
	jQuery('#fontNormal').click(function(){
		font12 = 12; font16 = 16; font14 = 14; font20 = 20; font32 = 32;
		jQuery(class12).css({'font-size' : 12+'px'});
		jQuery(class16).css({'font-size' : 16+'px'});
		jQuery(class14).css({'font-size' : 14+'px'});
		jQuery(class20).css({'font-size' : 20+'px'});
		jQuery(class32).css({'font-size' : 32+'px'});
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
	if(e.which == 49 && pressedALT == true) {
		window.location.assign("#main_container");
	}
	//Nav ALT + 2
	if(e.which == 50 && pressedALT == true) {
		window.location.assign("#nav");
	}
	//Footer ALT + 3
	if(e.which == 52 && pressedALT == true) {
		window.location.assign("#footer");
	}
	//Footer ALT + 4
	if(e.which == 51 && pressedALT == true) {
		// window.location.assign("#pesquisa");
		jQuery("#buscaInput").focus();
	}
}
jQuery('a[href="#pesquisa"]').click(function(){
	jQuery("#buscaInput").focus();
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
/*Busca por voz*/
window.addEventListener('DOMContentLoaded', function() {
	var speakBtn = document.querySelector('#speakBtn');
    // testa se o navegador suporta o reconhecimento de voz
    if (window.SpeechRecognition || window.webkitSpeechRecognition) {
        // captura a voz
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
        var recognition = new SpeechRecognition();
        // inicia reconhecimento
        speakBtn.addEventListener('click', function(e) {
        	recognition.start();
        }, false);
        // resultado do reconhecimento
        recognition.addEventListener('result', function(e) {
        	// console.log(e);
        	var result = e.results[0][0].transcript;
        	// console.log(result);
        	document.getElementById("buscaInput").value = result;
            // jQuery("#pesquisa").val(result);
            document.getElementById("formBusca").submit();
        }, false);
    } else {
    	// alert('Este navegador não suporta esta funcionalidade ainda!');
    	jQuery('#speakBtn').css('display','none');
    }
}, false);