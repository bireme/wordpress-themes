jQuery( document ).ready( function( $ ) {
	// icon Accordion
	$('.collapse').on('shown.bs.collapse', function(){
		$(this).parent().find(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
	}).on('hidden.bs.collapse', function(){
		$(this).parent().find(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
	});
});
// aos scroll
 AOS.init();

  // Sliders Mini Baner
 jQuery('.sliderMiniBanner').slick({
  slidesToShow: 3,
  slidesToScroll: 3,
  dots: true,
  autoplay: true,
  autoplaySpeed: 2000,
  responsive: [
  {
    breakpoint: 1024,
    settings: {
      slidesToShow: 2,
      slidesToScroll: 2,
      infinite: true,
      dots: true
    }
  },
  {
    breakpoint: 567,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
  }
  ]
 });