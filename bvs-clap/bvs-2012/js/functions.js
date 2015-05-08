var imgpath = network_script_vars.imgpath;
var image  = null;

jQuery(document).ready(function($) {
	$('.read_more').on('click', function() {
	   $(this).parent().hide();
	   $(this).closest('div').next().fadeToggle('slow');
	});
	$('.show_excerpt').on('click', function() {
	   $(this).parent().hide();
	   $(this).closest('div').prev().children().fadeToggle('slow');
	});

	function listenWidth() {
	    if($(window).width()<729)
	    {
	        if ($('body').find('.3_columns').length)
	        {
	            $(".column_1").remove().insertAfter($(".column_3"));
	        }
	    } else {
	       $(".column_1").remove().insertBefore($(".column_2"));
	    }
	}
    listenWidth();

    function network(){
		$(".vhl-network").show();
		$(".closed").attr("href", "javascript:void(0)");
		$(".closed").next().hide();
		$(".closed").css({ "background": "url("+ imgpath +"icon_plus.gif) no-repeat scroll 0 5px", "padding-left": "12px" });
		$(".closed").click(function(){
			$(this).next().css("display") == "block" ? image = imgpath + "icon_plus.gif" : image = imgpath + "icon_minus.gif";
			$(this).css({ "background": "url("+ image +") no-repeat scroll 0 5px", "padding-left": "12px" });
			if(jQuery.inArray($(this).next().attr("id"), network_script_vars.group) != -1){
				$(this).next().fadeToggle("slow");
			}
			return false;
		});
	}
	network();

    var width = $(window).width();
    $(window).resize(function(){
        if($(window).width() != width){
            listenWidth();
            network();
            width = $(window).width();
        }
    });
});