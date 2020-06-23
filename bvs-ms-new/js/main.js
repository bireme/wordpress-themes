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

// Scroll totop button
var toTop = $('#to-top');
$(window).scroll(function() {
    if ($(this).scrollTop() > 1) {
        toTop.css({
            bottom: '11px'
        });
    } else {
        toTop.css({
            bottom: '-100px'
        });
    }
});
toTop.click(function() {
    $('html, body').animate({
        scrollTop: '0px'
    }, 800);
    return false;
})