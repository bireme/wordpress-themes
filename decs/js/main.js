//AOS
AOS.init();
// Scroll totop button
var toTop = jQuery('#to-top');
toTop.click(function () {
  jQuery('html, body').animate({scrollTop: '0px'}, 800);
  return false;
});
// Contador Banner
const tempo_intervalo = 3; //ms -> define a velocidade da animação
const tempo = 2000; //ms -> define o tempo total da animaçao
jQuery('.counter-up').each(function() {  
  let count_to = parseInt(jQuery(this).data('countTo'));
  let intervalos = tempo / tempo_intervalo; //quantos passos de animação tem
  let incremento = count_to / intervalos; //quanto cada contador deve aumentar
  let valor = 0;
  let el = jQuery(this);
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
/*scrool tabs */
jQuery('.navLinkList').click(function(){
  jQuery('html, body').animate({scrollTop: '250px'}, 800);
})

//tootip
jQuery(function () {
  jQuery('[data-toggle="tooltip"]').tooltip()
})

//Buscar
jQuery("#fieldSearch").click(function(){
  jQuery("#navConsultaAvancada").show(200);
  setTimeout(function () {
    jQuery("#navConsultaAvancada").hide(200);
  }, 10000);
});
jQuery("#fieldSearch").focus(function(){
  jQuery("#navConsultaAvancada").show(200);
});

/// Lista / Hierarquico

jQuery('#btnHierarquico').click(function(){
  jQuery('#hierarquico').show();
  jQuery('#lista').hide();
  jQuery('#btnHierarquico').attr('disabled','disabled');
  jQuery('#btnLista').removeAttr('disabled');
})
jQuery('#btnLista').click(function(){
  jQuery('#lista').show();
  jQuery('#hierarquico').hide();
  jQuery('#btnLista').attr('disabled','disabled');
  jQuery('#btnHierarquico').removeAttr('disabled');
})

// popover
jQuery(function () {
  jQuery('[data-toggle="popover"]').popover()
})

// Sliders Parceiros
jQuery('.sliderParceiros').slick({
  slidesToShow: 4,
  slidesToScroll: 2,
  autoplay: true,
  autoplaySpeed: 2000,
  responsive: [
  {
    breakpoint: 1024,
    settings: {
      slidesToShow: 3,
      slidesToScroll: 3,
      infinite: true,
      dots: true
    }
  },
  {
    breakpoint: 768,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
  }
  ]
});

jQuery('#btSearch').click(function(){
  jQuery('#searchInside').toggle();
  jQuery('#btSearch>i').toggleClass('fa-times');
});