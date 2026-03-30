jQuery(function ($) {
  $("#buscaForm").on("submit", function (e) {
    e.preventDefault();
    const termo = $("#fieldSearch").val().trim();
    const tipo = $("input[name='inlineRadioOptions']:checked").val();

    let url = "";
    var urls = window.memorialURLs || {};

    // Coleções / Documento no Tainacan
    if (tipo === "colecao") {
      url = (urls.tainacan || '') + "/colecoes/?s=" + encodeURIComponent(termo);
    }
    // Produção científica e técnica na BVS
    else if (tipo === "documento") {
      url = (urls.bvs || '') + "/?output=site&lang=pt&q=" + encodeURIComponent(termo) + "&search_form_submit=";
    }

    // Se quiser impedir busca vazia, descomente:
    // if (!termo) return;

    window.location.href = url;
  });
});




jQuery(function ($) {
  $('.colecoes-slider').slick({
    slidesToShow: 4,
    slidesToScroll: 4,
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