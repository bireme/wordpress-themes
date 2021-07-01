// Scroll totop button
var toTop = jQuery('#to-top');
jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > 1) {
        toTop.css({
            bottom: '11px'
        });
    } else {
        toTop.css({
            bottom: '-100px'
        });
    }
});

toTop.click(function () {
  jQuery('html, body').animate({scrollTop: '0px'}, 150);
  return false;
});