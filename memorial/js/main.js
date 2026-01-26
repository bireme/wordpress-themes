//Carrossel Coleções Tainacan
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

//Pesquisa IAHx
jQuery(function ($) {
  $("#buscaForm").on("submit", function (e) {
    e.preventDefault();
    const termo = $("#fieldSearch").val().trim();
    const tipo = $("input[name='inlineRadioOptions']:checked").val();

    let url = "";

    // Coleções / Documento no Tainacan
    if (tipo === "colecao") {
      url = "https://teste.memorialdigitalcovid19.org.br/tainacan/?s=" + encodeURIComponent(termo);
    }
    // Produção científica e técnica na BVS
    else if (tipo === "documento") {
      url =
        "https://pesquisa.bvsalud.org/memorialcovid/?output=site&lang=pt&q=" +
        encodeURIComponent(termo) +
        "&search_form_submit=";
    }

    // Se quiser impedir busca vazia, descomente:
    // if (!termo) return;

    window.location.href = url;
  });
});
