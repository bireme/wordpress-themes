// Show Hide VHL Network

var vector = [ 'cl_bvs', 'sub_bvs', 'subdev_bvs', 'cl_cvsp', 'cl_scielo', 'sub_scielo', 'subdev_scielo' ];
var imgpath = "./wp-content/plugins/bvs-site/bvs-themes/bvs-2012/bireme_archives/default/";
var image  = null;

$(document).ready(function(){
        $(".vhl-network").show();
	$(".closed").next().hide();
	$(".closed").css({ "background": "url("+ imgpath +"icon_plus.gif) no-repeat scroll 0 5px", "padding-left": "12px" });
	$(".closed", this).click(function(){
		$(this).next().css("display") == "block" ? image = imgpath + "icon_plus.gif" : image = imgpath + "icon_minus.gif";
		$(this).css({ "background": "url("+ image +") no-repeat scroll 0 5px", "padding-left": "12px" });
		if(jQuery.inArray($(this).next().attr("id"), vector) != -1){
			$(this).next().toggle("slow");
			return false;
		}
	});
});
