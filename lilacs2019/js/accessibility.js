/*Versão Beta*/ 
/*Aumentar ou Reduzir Fontes*/
jQuery(document).ready(function(){
	var font12 = 12; var class12 ='';
	var font14 = 14; var class14 ='.font14, #footer';
	var font16 = 16; var class16 ='p, .font16';
	var font20 = 20; var class20 ='.font20';
	var font24 = 24; var class24 ='h4, .font24';
	var font30 = 30; var class30 ='h5, .font30, .count, .Num_label'; 
	jQuery('#fontPlus').click(function(){ 
		if (font16<40){// tamanho maximo com padrão 16px
			font12 = font12+1; font14 = font14+1; font16 = font16+1; font20 = font20+1; font24 = font24+1; font30 = font30+1;
			jQuery(class12).css({'font-size' : font12+'px'});
			jQuery(class14).css({'font-size' : font14+'px'}); 
			jQuery(class16).css({'font-size' : font16+'px'});
			jQuery(class20).css({'font-size' : font20+'px'});
			jQuery(class24).css({'font-size' : font24+'px'});
			jQuery(class30).css({'font-size' : font30+'px'});
		}
	});
	jQuery('#fontLess').click(function(){
		if (font16>14){// tamanho minino com padrão 16px
			font12 = font12-1; font14 = font14-1; font16 = font16-1; font20 = font20-1; font24 = font24-1; font30 = font30-1;
			jQuery(class12).css({'font-size' : font12+'px'});
			jQuery(class14).css({'font-size' : font14+'px'});
			jQuery(class16).css({'font-size' : font16+'px'});
			jQuery(class20).css({'font-size' : font20+'px'});
			jQuery(class24).css({'font-size' : font24+'px'});
			jQuery(class30).css({'font-size' : font30+'px'});
		}
	});
	jQuery('#fontNormal').click(function(){ // Restaurar
		font12 = 12; font14 = 14; font16 = 16; font20 = 20; font24 = 24; font30 = font30-1;
		jQuery(class12).css({'font-size' : 12+'px'});
		jQuery(class14).css({'font-size' : 14+'px'});
		jQuery(class16).css({'font-size' : 16+'px'});
		jQuery(class20).css({'font-size' : 20+'px'});
		jQuery(class24).css({'font-size' : 24+'px'});
		jQuery(class30).css({'font-size' : 30+'px'});
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
		jQuery("#textEntry1").focus();
	}
}
jQuery('a[href="#btnSearch"]').click(function(){
	jQuery("#textEntry1").focus();
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
        	document.getElementById("textEntry1").value = result;
            // jQuery("#pesquisa").val(result);
        }, false);
    } else {
    	// alert('Este navegador não suporta esta funcionalidade ainda!');
    	jQuery('#speakBtn').css('display','none');
    }
}, false);