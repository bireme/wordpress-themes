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
  }  ,
  {
    breakpoint: 560,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
  }
  ]
});
//mini banners
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