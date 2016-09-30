jQuery(document).ready(function($) {
	// fitVids.
	$( '.entry-content' ).fitVids();

	// Responsive wp_video_shortcode().
	$( '.wp-video-shortcode' ).parent( 'div' ).css( 'width', 'auto' );

	/**
	 * Odin Core shortcodes
	 */

	// Tabs.
	$( '.odin-tabs a' ).click(function(e) {
		e.preventDefault();
		$(this).tab( 'show' );
	});

	// Tooltip.
	$( '.odin-tooltip' ).tooltip();

	// FlexSlider
	$('.flexslider').flexslider({
		animation: "slide"
	});

	$( '.year' ).click(function(e) {
		e.preventDefault();
		var year = $(this).attr('data-year');
		$('.year-'+year).toggle();
	});

	$( '.month' ).click(function(e) {
		e.preventDefault();
		var month = $(this).attr('data-month');
		var year = $(this).attr('data-year');
		$('.month-'+month).toggle().toggleClass('year-'+year);
	});
});