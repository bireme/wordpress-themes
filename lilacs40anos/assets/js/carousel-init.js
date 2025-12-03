jQuery(document).ready(function() {
    jQuery(".logos-carousel").slick({
        infinite: true,
        slidesToShow: 8, // Mostra 8 logos por vez
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        dots: true, // Mostra os pontos de navegação
        arrows: false, // Esconde as setas de navegação
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 6,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 4,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            }
        ]
    });
});
