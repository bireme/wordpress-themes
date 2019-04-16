jQuery(document).ready(function($){
    if($("#search-op1").is(":checked")) {
            $(".vhl-search-form").css({ "display": "block" });
            $(".default-search-form").css({ "display": "none" });
    }
    else if($("#search-op2").is(":checked")) {
            $(".vhl-search-form").css({ "display": "none" });
            $(".default-search-form").css({ "display": "block" });
    }
    $("#search-op1").click(function () {
            $(".vhl-search-form").css({ "display": "block" });
            $(".default-search-form").css({ "display": "none" });
            $("#vhl-search-input").val($("#s").val());
    });
    $("#search-op2").click(function () {
            $(".vhl-search-form").css({ "display": "none" });
            $(".default-search-form").css({ "display": "block" });
            $("#s").val($("#vhl-search-input").val());
    });
    $("#defaultSearchForm").submit(function(e){
            if($("#s").val() == "") {
                    $("#s").focus();
                    $("#s").blur();
                    return false;
            }
    });
});