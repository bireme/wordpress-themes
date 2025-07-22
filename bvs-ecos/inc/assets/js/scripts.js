jQuery(document).ready(function($){
    console.log("document ready");

    //on change engine search form bvs
    $('#form-search-bvs').find('input[type=radio][name=engine]').change(function(){
        let filter_db = this.value;
        $('#form-search-bvs').find('input[id=filter_db]').val(filter_db);
    });

    //change like icon
    if($('.pld-like-trigger i').length){
        $('.pld-like-trigger i').remove();
        $('.pld-like-trigger').append('<i class="fa-solid fa-thumbs-up"></i>');
    }

    //change dislike icon
    if ($('.pld-dislike-trigger i').length){
        $('.pld-dislike-trigger i').remove();
        $('.pld-dislike-trigger').append('<i class="fa-solid fa-heart"></i>');
    }

    //clone secondary menu to mobile menu
    $('#main-nav-mobile .offcanvas-body').append($('.secondary-menu').clone());

    //tagify init
    var inputTag = document.querySelector('input[id=bbp_topic_tags]');
    if(inputTag !== null){
        new Tagify(inputTag, {
            originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(', ')
        });
    }
});