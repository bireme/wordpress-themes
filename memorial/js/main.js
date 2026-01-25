jQuery(function ($) {
  $('.colecoes-slider').slick({
    slidesToShow: 2,
    slidesToScroll: 1,
    arrows: true,
    dots: true,
    infinite: false,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 992,
        settings: { slidesToShow: 1 }
      }
    ]
  });
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