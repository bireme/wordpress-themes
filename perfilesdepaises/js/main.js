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

jQuery(document).ready(function(){
    jQuery("select#country").change(function(){
        var selectedCountry = jQuery(this).children("option:selected").val();
    });
});