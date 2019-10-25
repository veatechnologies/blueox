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


})(jQuery);
