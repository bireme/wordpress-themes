// AOS
AOS.init();

// Contador Banner
const tempo_intervalo = 3; //ms -> define a velocidade da animação
const tempo = 2000; //ms -> define o tempo total da animaçao
$('.counter-up').each(function() {  
	let count_to = parseInt($(this).data('countTo'));
	let intervalos = tempo / tempo_intervalo; //quantos passos de animação tem
	let incremento = count_to / intervalos; //quanto cada contador deve aumentar
	let valor = 0;
	let el = $(this);
	let timer = setInterval(function() {
	   if (valor >= count_to){ //se já contou tudo tem de parar o timer
	   	valor = count_to;
	   	clearInterval(timer);
	   }
	   let texto = valor.toFixed(0).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
	   el.text(texto);
	   valor += incremento;      
   }, tempo_intervalo);
});

//
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})