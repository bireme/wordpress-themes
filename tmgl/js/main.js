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


/*
jQuery(document).ready(function() {
    var navOffsetTop = jQuery('header').height();
    // Função para fixar o header e manipular o botão de hambúrguer
    function handleScroll() {
        var scrollTop = jQuery(window).scrollTop();
        var header = jQuery('header');
        var hamburger = jQuery('#hamburger');

        if (scrollTop >= navOffsetTop) {
            header.addClass('headerFixo');
            hamburger.fadeIn(); // Mostra o botão de hambúrguer
        } else {
            header.removeClass('headerFixo');
            hamburger.fadeOut(); // Esconde o botão de hambúrguer
        }
    }
    // Detecta a rolagem da página
    jQuery(window).on('scroll', function() {
        handleScroll();
    });
    // Ação do botão de hambúrguer
    jQuery('#hamburger').on('click', function() {
        var header = jQuery('header');
        var menu = jQuery('#nav-global');

        if (header.hasClass('headerFixo')) {
            header.removeClass('headerFixo');
            menu.slideDown(); // Abre o menu deslizando para baixo
            jQuery(this).html('<i class="bi bi-x-lg"></i>'); // Altera o ícone para "X"
        } else {
            header.addClass('headerFixo');
            menu.slideUp(); // Fecha o menu deslizando para cima
            jQuery(this).html('<i class="bi bi-list"></i>'); // Altera o ícone de volta para "hambúrguer"
            header.classList.add('headerFixo');
        }
    });
    // Inicializa o estado do menu com base na rolagem ao carregar a página
    handleScroll();
});
*/