jQuery('.btnPlus').click(function(){
  jQuery(this).children('i').toggleClass("menos");
});
jQuery.fn.dropdown.Constructor.prototype._addEventListeners = function _addEventListeners() {
    var _this = this;
    jQuery(this._element).on('click.bs.dropdown', function(event) {
        event.preventDefault();
        _this.toggle();
    });
};



function countryRedirect (url) {
    jQuery(function () {
            // var country = jQuery('#country option').filter(':selected').val();
            var country = jQuery('#country').val();
            var href = url + "?country=" + encodeURIComponent(country);
            window.location.href = href;
        });
}