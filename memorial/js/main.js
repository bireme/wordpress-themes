
jQuery('.home-products').slick({
  dots: true,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 4,
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
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});




jQuery('.home-profiles').slick({
  dots: true,
  infinite: false,
  arrows: false,
  autoplay: true,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 4,
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
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});



jQuery(function() {
  jQuery("#buscaForm").on("submit", function(e) {
    e.preventDefault();

    let termo = jQuery("#termoBusca").val().trim();

    let tipo = jQuery("input[name='inlineRadioOptions']:checked").val();
    let url = "";

    if (tipo === "colecao") {
      url = "https://memorialpandemia.teste.bvs.br/tainacan/?s=" + encodeURIComponent(termo);
    } else if (tipo === "documento") {
      url = "https://pesquisa.bvsalud.org/portal/?output=site&lang=pt&q=" + encodeURIComponent(termo) + "&search_form_submit=";
    }

    window.location.href = url;
  });
});