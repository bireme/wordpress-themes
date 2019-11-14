var $clock = jQuery('#tvFooterHora');
setInterval(function () {
    $clock.html((new Date).toLocaleString().substr(11, 8));
}, 1000);