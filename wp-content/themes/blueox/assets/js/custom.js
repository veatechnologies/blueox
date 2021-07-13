jQuery.event.special.touchstart = {
    setup: function (_, ns, handle) {
        this.addEventListener('touchstart', handle, {passive: !ns.includes('noPreventDefault')});
    }
};
jQuery.event.special.touchmove = {
    setup: function (_, ns, handle) {
        this.addEventListener('touchmove', handle, {passive: !ns.includes('noPreventDefault')});
    }
};

(function ($) {

    // Unknown
    $('#Product-products input').change(function () {
        $('#Product-products input').prop('checked', false);
        $(this).prop('checked', true);
    });

    // Unknown
    $('#Product-ids input').change(function () {
        $('#Product-ids input').prop('checked', false);
        $(this).prop('checked', true);
    });

    // Unknown
    $('#Product-ids .hndle').append("<span class='question-mark' title='Enter  Coma(,) separated Product Ids.'>?</span>");
    $('#Product-products .hndle').append("<span class='question-mark-products' title='Please check if want to show Related Products'>?</span>");

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
    $(window).load(function () {
//        setTimeout(function () {
//            $('#baseplates').slideToggle();
//        }, 800);
    });

    // On click, hide results
    $('#scrollResults').on('click', function (e) {
        e.preventDefault();
        $('#baseplates').slideUp();
    });

    // On filter, show results
    $(document).on('apply-selectize', function () {
        $('#baseplates').one().stop().slideDown(300);
    });
    
    jQuery(document).on('change','.hole_selection',function(){
        var selected_val = jQuery(this).val();
        var page_cat = jQuery(document).find('.page_cat').val();
        jQuery.ajax({
            url: BLUEOXJS.ajax_url,
            method : 'post',
            data : {
                action      : 'refresh_product_content',
                selected_val   : selected_val,
                page_cat : page_cat
            },
            beforeSend: function() {
                jQuery(document).find('body').css('opacity','0.1');
            },
            success: function (data) {
                jQuery(document).find('body').css('opacity','1');
                if ( data ) {
                    jQuery(document).find('.custom_product_list').html(data);
                }
            },
            error: function(xhr) { // if error occured
                jQuery(document).find('body').css('opacity','1');
            }
        });
    });

})(jQuery);
