$(document).ready(function() {

    // submit do iahx search
    $(".vhl-search .submit").click(function(){
        // console.log($(".vhl-search form"));
        $("#searchForm").submit();
    });

    // temas
    $("#vhl_themes-3 ul").owlCarousel({
        items : 4
    });

    // encapsula o conteúdo do texto do tema em um obj
    $(".vhl-themes ul li a").each(function(){
        var text = $(this).text();
        var img = $(this).find('img').prop('outerHTML');
        $(this).html(img+'<figcaption>'+text+'</figcaption>');
    });

    // subtemas
    $(".home .vhl-collection").each(function(){
        var title = $(this).find('.widget-title');
        var img = $(this).find('.vhl_collection_thumb');

        img.after(title.prop('outerHTML'));
        title.hide();
    });

    $(".destaques .upw-posts").owlCarousel({
        autoPlay: 4000,
        items : 1
    });
});