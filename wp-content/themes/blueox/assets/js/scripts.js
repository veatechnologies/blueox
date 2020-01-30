(function($) {

    // bLazy
    var bLazy = new Blazy({
        // options
        loadInvisible: true,
        error: true
    });

    // matchHeight
    $('.match-height').matchHeight();

    // Magnific
    $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,

        fixedContentPos: false
    });

    // Slick
    $('.hero-slider').slick({
        autoplay: true,
        autoplaySpeed: 3000,
        dots: true
    });
    $('.hero-slider').on('afterChange', function(event, slick, direction){
        bLazy.revalidate();
    });

    // Search Bar
    $('.nav-search').html('<form role="search" method="get" class="searchform wp-bootstrap-4-searchform" action="/"><input type="text" class="s form-control nav-search-input" name="s" placeholder="Search &#xF002;" value=""></form>');

    // Show/Hide message in jobs menu
    var openJob = $('.jobs-menu').find('.sub-menu'),
        jobMenu = $('.jobs-menu > a');
    if( openJob.length ) {
        $(jobMenu).hide();
    } else {
        $(jobMenu).show();
    }



/* CODE ADED BY KELLTON STARTS */
    $('.multiple-items').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        responsive: [
        {
            breakpoint: 991,
            settings: {
                slidesToShow: 2,
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
            }
        }
        ]
    });
/* CODE ADED BY KELLTON ENDS */


})(jQuery);
