jQuery('.btnLimit,.limitTransparente').click(function(){
  jQuery(this).parent().find(".fa-angle-down").toggleClass("fa-angle-up");
  jQuery('#textLimit1').toggleClass("textLimit2");
})
