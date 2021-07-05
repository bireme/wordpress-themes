jQuery(function () {
    jQuery('#inlineRadio2').on('click', function(){
        jQuery('#formHome').attr('action', '');
        jQuery("#fieldSearch").attr('name', 's');
    });
    jQuery('#inlineRadio1').click(function(){
        jQuery('#formHome').attr('action', 'https://pesquisa.bvsalud.org/brasil/');
        jQuery("#fieldSearch").attr('name', 'q');
    });
});
// Sliders Parceiros
jQuery('.slideTemas').slick({
  slidesToShow: 2,
  slidesToScroll: 2,
  arrows:true,
  dots:true,
  autoplay: true,
  autoplaySpeed: 2000,
  responsive: [
  {
    breakpoint: 768,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
  }
  ]
});

// Sliders News
jQuery('.slideNews').slick({
 slidesToShow: 4,
  slidesToScroll: 4,
  arrows:false,
  dots:true,
  autoplay: true,
  autoplaySpeed: 5000,
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
    breakpoint: 768,
    settings: {
      slidesToShow: 2,
      slidesToScroll: 1
    }
  }
  ]
});

// Sliders News
jQuery('.interesse').slick({
  slidesToShow: 4,
  slidesToScroll: 4,
  arrows:true,
  dots:false,
  autoplay: true,
  autoplaySpeed: 10000,
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
    breakpoint: 768,
    settings: {
      slidesToShow: 2,
      slidesToScroll: 1
    }
  }
  ]
});