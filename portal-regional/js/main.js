//Aos Scroll
AOS.init();

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

//Slick
jQuery('.multiple-items').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 3,
    responsive: [
    {
        breakpoint: 1024,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: true
        }
    },
    {
        breakpoint: 600,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
    }
    ]
});

jQuery('.apoio-menu a').click(function(){
    var menu_id = jQuery(this).attr('id').split('-').pop();
    var section_id = 'section-' + menu_class;
    jQuery('.apoio-section').addClass('hide');
    jQuery('#' + section_id).removeClass('hide');
});