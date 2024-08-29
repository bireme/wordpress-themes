jQuery(document).ready(function(jQuery) {
  jQuery('.trending-slider').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 3,
    adaptiveHeight: true,
    responsive: [
    {
      breakpoint: 992,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    },
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
    ]
  });
});
// bt block x list
jQuery(document).ready(function() {
       jQuery('#trending-blocks').click(function() {
           jQuery('#trend').removeClass('row-cols-md-1').addClass('row-cols-md-3');
           jQuery('#trending-blocks').addClass('disabled');
           jQuery('#trending-list').removeClass('disabled');
        });

       jQuery('#trending-list').click(function() {
           jQuery('#trend').removeClass('row-cols-md-3').addClass('row-cols-md-1');
           jQuery('#trending-list').addClass('disabled');
           jQuery('#trending-blocks').removeClass('disabled');
        });
    });

//Nav
jQuery(document).ready(function() {
    let isHamburgerClicked = false; // Variável de controle

    // Função para monitorar o scroll da página
    jQuery(window).scroll(function() {
        if (!isHamburgerClicked) { // Somente executa se o botão não foi clicado
            if (jQuery(this).scrollTop() > 300) {
                jQuery('#header').addClass('headerFixo');
                jQuery('#hamburger').addClass('hamburger');
            } else {
                jQuery('#header').removeClass('headerFixo');
                jQuery('#hamburger').removeClass('hamburger'); 
            }
        }
    });

    // Função para monitorar o clique no botão #hamburger
    jQuery('#hamburger').click(function() {
        isHamburgerClicked = !isHamburgerClicked; // Inverte o estado da variável

        if (isHamburgerClicked) {
            jQuery('#header').removeClass('headerFixo');
        } else if (jQuery(window).scrollTop() > 10) {
            jQuery('#header').addClass('headerFixo');
        }
        
        // Alterna o ícone dentro do botão #hamburger
        if (jQuery(this).find('i').hasClass('bi-list')) {
            jQuery(this).html('<i class="bi bi-x-lg"></i>');
        } else {
            jQuery(this).html('<i class="bi bi-list"></i>');
        }
    });
});
