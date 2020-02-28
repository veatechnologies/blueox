(function($) {

	$('#Product-products input').change(function(){
        $('#Product-products input').prop('checked', false);
        $(this).prop('checked', true);
    });


    $('#Product-ids input').change(function(){
        $('#Product-ids input').prop('checked', false);
        $(this).prop('checked', true);
    });

	$('#Product-ids .hndle').append("<span class='question-mark' title='Enter separated coma for product Ids.'>?</span>");
	$('#Product-products .hndle').append("<span class='question-mark-products' title='Please check if want to show Related products'>?</span>");
	
	
	
	
})(jQuery);
