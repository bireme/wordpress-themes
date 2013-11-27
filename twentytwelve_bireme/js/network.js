// Show Hide VHL Network

var vector = [ 'cl_bvs', 'sub_bvs', 'subdev_bvs', 'cl_cvsp', 'cl_scielo', 'sub_scielo', 'subdev_scielo' ];
var plus   = "../icon_plus.gif";
var minus  = "../icon_minus.gif";
var image  = null;

$(document).ready(function(){
	$(".closed").next().hide();
	$(".closed").css({ "background": "url("+ plus +") no-repeat scroll 0 5px", "padding-left": "12px" });
	$(".closed", this).click(function(){
		$(this).next().css("display") == "block" ? image = plus : image = minus;
		$(this).css({ "background": "url("+ image +") no-repeat scroll 0 5px", "padding-left": "12px" });
		if(jQuery.inArray($(this).next().attr("id"), vector) != -1){
			$(this).next().toggle("slow");
			return false;
		}
	});
});
