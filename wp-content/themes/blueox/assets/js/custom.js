jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ) {
        this.addEventListener('touchstart', handle, { passive: !ns.includes('noPreventDefault') });
    }
};
jQuery.event.special.touchmove = {
    setup: function( _, ns, handle ) {
        this.addEventListener('touchmove', handle, { passive: !ns.includes('noPreventDefault') });
    }
};

(function(jQuery) {

	// Unknown
	jQuery('#Product-products input').change(function(){
        jQuery('#Product-products input').prop('checked', false);
        jQuery(this).prop('checked', true);
    });

    // Unknown
	jQuery('#Product-ids input').change(function(){
        jQuery('#Product-ids input').prop('checked', false);
        jQuery(this).prop('checked', true);
    });

	// Unknown
	jQuery('#Product-ids .hndle').append("<span class='question-mark' title='Enter  Coma(,) separated Product Ids.'>?</span>");
	jQuery('#Product-products .hndle').append("<span class='question-mark-products' title='Please check if want to show Related Products'>?</span>");

	/* Smooth Scrolling to Baseplate and SwayPro finder results
	jQuery('#scrollResults, #resultsFinder').on('click', function(e) {
        e.preventDefault()

        jQuery('html, body').animate({
            scrollTop: jQuery(jQuery(this).attr('href')).offset().top,
        }, 500, 'linear');
    });*/

	/***
	* Baseplate finder functions
	***/

	// Hide product results to start
	jQuery(window).load(function() {
		jQuery('#baseplates').slideUp();
	});

	// On click, hide results
	jQuery('#scrollResults').on('click', function(e) {
		e.preventDefault();
		jQuery('#baseplates').slideUp();
	});

	// On filter, show results
	jQuery(document).on('apply-selectize', function() {
		jQuery('#baseplates').one().stop().slideDown(300);
	});

})(jQuery);
