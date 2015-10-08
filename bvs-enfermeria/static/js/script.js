$(document).ready(function() {

    // submit do iahx search
    $(".vhl-search .submit").click(function(){
        // console.log($(".vhl-search form"));
        $("#searchForm").submit();
    });

    // temas
    $(".content .temas ul").owlCarousel({
        items : 4
    });

    // encapsula o conteúdo do texto do tema em um obj
    $(".vhl-themes ul li a").each(function(){
        var text = $(this).text();
        var img = $(this).find('img').prop('outerHTML');
        $(this).html(img+'<figcaption>'+text+'</figcaption>');
    });

    // // subtemas
    // $(".home .vhl-collection").each(function(){
    //     var title = $(this).find('.widget-title');
    //     var img = $(this).find('.vhl_collection_thumb');

    //     img.after(title.prop('outerHTML'));
    //     title.hide();
    // });

    $(".destaques .upw-posts").owlCarousel({
        autoPlay: 4000,
        items : 1
    });

    // ajuste para tirar a tag da parte de baixo e mandar para a parte de cima, em noticia
    $(".noticias .upw-posts article").each(function(){

        tags = $(this).find('footer')
        // tags.hide();

        tags.insertBefore($(this).find('header'));
        console.log($(this).find('header'));
    });
});