(function($) {

	// Unknown
	$('#Product-products input').change(function(){
        $('#Product-products input').prop('checked', false);
        $(this).prop('checked', true);
    });

    // Unknown
	$('#Product-ids input').change(function(){
        $('#Product-ids input').prop('checked', false);
        $(this).prop('checked', true);
    });

	// Unknown
	$('#Product-ids .hndle').append("<span class='question-mark' title='Enter  Coma(,) separated Product Ids.'>?</span>");
	$('#Product-products .hndle').append("<span class='question-mark-products' title='Please check if want to show Related Products'>?</span>");

	// Smooth Scrolling to Baseplate and SwayPro finder results
	$('#scrollResults, #resultsFinder').on('click', function(e) {
        e.preventDefault()

        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top,
        }, 500, 'linear');
    });

})(jQuery);
