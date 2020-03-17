jQuery(function ($) {
    // wc_cart_fragments_params is required to continue, ensure the object exists
    if (typeof wc_cart_fragments_params === 'undefined') {
        return false;
    }

    /* Storage Handling */
    // var $supports_html5_storage = true,
    //     cart_hash_key = wcaio_mini_cart.cart_hash_key;

    // try {
    //     $supports_html5_storage = ('sessionStorage' in window && window.sessionStorage !== null);
    //     window.sessionStorage.setItem('wc', 'test');
    //     window.sessionStorage.removeItem('wc');
    //     window.localStorage.setItem('wc', 'test');
    //     window.localStorage.removeItem('wc');
    // } catch (err) {
    //     $supports_html5_storage = false;
    // }

    /* Cart session creation time to base expiration on */
    // function set_cart_creation_timestamp() {
    //     if ($supports_html5_storage) {
    //         sessionStorage.setItem('wc_cart_created', (new Date()).getTime());
    //     }
    // }

    // /** Set the cart hash in both session and local storage */
    // function set_cart_hash(cart_hash) {
    //     if ($supports_html5_storage) {
    //         localStorage.setItem(cart_hash_key, cart_hash);
    //         sessionStorage.setItem(cart_hash_key, cart_hash);
    //     }
    // }

    //store jQuery objects
    var wooNotices = $('.woocommerce-notices-wrapper');
    var cartWrapper = $('.vi_wcaio_sidebar');
    var singleAddToCartBtn, cartContent, cartList, cartTotal, cartSubtotal, cartTrigger, cartCount;
    var updatingWCAIO = false;


    function initVars() {

        singleAddToCartBtn = $('form .single_add_to_cart_button, .variations .single_add_to_cart_button');
        wooNotices = $('.woocommerce-notices-wrapper');
        cartWrapper = $('.vi_wcaio_sidebar');
        cartContent = cartWrapper.find('.vi_wcaio_mini_cart_content ');
        cartList = cartContent.find('ul').eq(0);
        cartTotal = cartWrapper.find('#vi_wcaio_mini_cart_sidebar_total_currency');
        cartSubtotal = cartWrapper.find('#vi_wcaio_mini_cart_sidebar_subtotal_currency');
        cartTrigger = cartWrapper.find('.vi_wcaio_mini_cart_sidebar_icon');
        cartCount = cartTrigger.find('.vi_wcaio_mini_cart_sidebar_icon_count');
    }

    var isMobile = false;

    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
        isMobile = true;
    }

    function check_cart_device_enable() {

        switch (wcaio_mini_cart.sidebar_cart_enable_device) {
            case 'all':
                cartWrapper.show();
                break;
            case 'desktop':
                if (isMobile === true) {
                    cartWrapper.hide();
                } else {
                    cartWrapper.show();
                }
                break;
            case 'mobile':
                if (isMobile === false) {
                    cartWrapper.hide();
                } else {
                    cartWrapper.show();
                }
                break;

        }
        switch (wcaio_mini_cart.menu_cart_enable_device) {
            case 'all':
                $('.vi_wcaio_menu_cart').show();
                break;
            case 'desktop':
                if (isMobile === true) {
                    $('.vi_wcaio_menu_cart').hide();
                } else {
                    $('.vi_wcaio_menu_cart').show();
                }
                break;
            case 'mobile':
                if (isMobile === false) {
                    $('.vi_wcaio_menu_cart').hide();
                } else {
                    cartWrapper.show();
                    $('.vi_wcaio_menu_cart').show();
                }
                break;

        }

    }

    function sidebar_cart_position(position, vertical, horizontal, open_style) {

        if (isMobile === true) {
            vertical = 20;
            horizontal = 20;

        }
        if (wcaio_mini_cart.sidebar_content_display === '0') {
            $('.vi_wcaio_mini_cart_content').removeClass('vi_wcaio_mini_cart_content_template_one2').addClass('vi_wcaio_mini_cart_content_template_one1');
            if (position === 'top_left') {
                $('.vi_wcaion_mini_cart_sidebar_content').css({'top': vertical + 'px', 'left': horizontal + 'px'});
                $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': 0, 'left': 0});
                $('.vi_wcaio_mini_cart_content').css({'top': 0, 'left': 0});
            } else if (position === 'top_right') {
                $('.vi_wcaion_mini_cart_sidebar_content').css({'top': vertical + 'px', 'right': horizontal + 'px'});
                $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': 0, 'right': 0});
                $('.vi_wcaio_mini_cart_content').css({'top': 0, 'right': 0});
            } else if (position === 'bottom_left') {
                $('.vi_wcaion_mini_cart_sidebar_content').css({'bottom': vertical + 'px', 'left': horizontal + 'px'});
                $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': 0, 'left': 0});
                $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'left': 0});

            } else if (position === 'bottom_right') {
                $('.vi_wcaion_mini_cart_sidebar_content').css({'bottom': vertical + 'px', 'right': horizontal + 'px'});
                $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': 0, 'right': 0});
                $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'right': 0});
            }
        } else {
            $('.vi_wcaio_mini_cart_content').removeClass('vi_wcaio_mini_cart_content_template_one1').addClass('vi_wcaio_mini_cart_content_template_one2');

            if (position === 'top_left') {
                $('.vi_wcaion_mini_cart_sidebar_content').css({'top': 0, 'left': 0});
                $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': vertical + 'px', 'left': horizontal + 'px'});
                $('.vi_wcaio_mini_cart_content').css({'top': 0, 'left': 0});
            } else if (position === 'top_right') {
                $('.vi_wcaion_mini_cart_sidebar_content').css({'top': 0, 'right': 0});
                $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': vertical + 'px', 'right': horizontal + 'px'});
                $('.vi_wcaio_mini_cart_content').css({'top': 0, 'right': 0});
            } else if (position === 'bottom_left') {
                $('.vi_wcaion_mini_cart_sidebar_content').css({'bottom': 0, 'left': 0});
                $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': vertical + 'px', 'left': horizontal + 'px'});
                $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'left': 0});

            } else if (position === 'bottom_right') {
                $('.vi_wcaion_mini_cart_sidebar_content').css({'bottom': 0, 'right': 0});
                $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': vertical + 'px', 'right': horizontal + 'px'});
                $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'right': 0});
            }
        }

        var class_close = sidebar_cart_close_style(position, open_style);
        $('.vi_wcaio_mini_cart_content').addClass(class_close);

    }

    function sidebar_cart_open_style(show_style) {
        var class_open;
        switch (show_style) {
            case '1':
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open1';
                break;
            case '2':
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open2';
                break;
            case '3':
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open3';
                break;
            case '4':
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open4';
                break;
            case '5':
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open5';
                break;
            case '6':
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open6';
                break;
            case '7':
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open7';
                break;
        }
        return class_open;
    }

    function sidebar_cart_close_style(position, show_style) {
        var class_close;
        switch (show_style) {
            case '1':
                if (position === 'top_left' || position === 'bottom_left') {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close1 vi_wcaio_mini_cart_content_close1_left';
                } else {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close1 vi_wcaio_mini_cart_content_close1_right';
                }
                break;
            case '2':
                class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close2 ';
                break;
            case '3':
                if (position === 'top_left' || position === 'top_right') {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close3 vi_wcaio_mini_cart_content_close3_top';
                } else {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close3 vi_wcaio_mini_cart_content_close3_bottom';
                }
                break;
            case '4':
                class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close4 ';
                break;
            case '5':
                class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close5';
                break;
            case '6':
                class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close6 ';
                break;
            case '7':
                if (position === 'top_left' || position === 'bottom_left') {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close7 vi_wcaio_mini_cart_content_close7_left';
                } else {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close7 vi_wcaio_mini_cart_content_close7_right';
                }
                break;
        }
        return class_close;
    }

    function setsidebar_cart_open(position, show_type, show_style) {
        var class_close = sidebar_cart_close_style(position, show_style);
        var class_open = sidebar_cart_open_style(show_style);
        switch (show_type) {
            case 'click':
                $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_icon').click(function () {
                    if ($('.vi_wcaio_mini_cart_content').hasClass(class_open)) {
                        $('.vi_wcaio_mini_cart_content').removeClass(class_open).addClass(class_close);
                        $('.vi_wcaio_mini_cart_sidebar_icon').show('300');
                    } else {

                        $('.vi_wcaio_mini_cart_content').removeClass(class_close).addClass(class_open);
                        $('.vi_wcaio_mini_cart_sidebar_icon').hide('300');
                    }
                    if ($('.vi_wcaion_mini_cart_sidebar').hasClass('vi_wcaion_mini_cart_sidebar_close')) {
                        $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_close').addClass('vi_wcaion_mini_cart_sidebar_open');
                    } else {
                        $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_open').addClass('vi_wcaion_mini_cart_sidebar_close');
                    }
                });
                $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_icon').mouseover(function () {
                    $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_icon ').addClass('vi_wcaio_mini_cart_sidebar_icon_hover1');
                    $('.vi_wcaio_mini_cart_sidebar_icon_count_one').addClass('vi_wcaio_mini_cart_sidebar_icon_count_one_hover1');
                    $('.vi_wcaio_mini_cart_sidebar_icon_count_two').addClass('vi_wcaio_mini_cart_sidebar_icon_count_two_hover1');
                    $('.vi_wcaio_mini_cart_sidebar_icon_default_three').removeClass('vi_wcaio_mini_cart_sidebar_icon_hover1').addClass('vi_wcaio_mini_cart_sidebar_icon_default_three_hover1');
                });
                $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_icon').mouseout(function () {
                    $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_icon ').removeClass('vi_wcaio_mini_cart_sidebar_icon_hover1');
                    $('.vi_wcaio_mini_cart_sidebar_icon_count_one').removeClass('vi_wcaio_mini_cart_sidebar_icon_count_one_hover1');
                    $('.vi_wcaio_mini_cart_sidebar_icon_count_two').removeClass('vi_wcaio_mini_cart_sidebar_icon_count_two_hover1');
                    $('.vi_wcaio_mini_cart_sidebar_icon_default_three').removeClass('vi_wcaio_mini_cart_sidebar_icon_default_three_hover1');

                });

                $('.vi_wcaio_mini_cart_content .vi_wcaio_mini_cart_sidebar_title i, .vi_wcaion_mini_cart_sidebar ').click(function () {

                    $('.vi_wcaio_mini_cart_content').removeClass(class_open).addClass(class_close);
                    $('.vi_wcaio_mini_cart_sidebar_icon').show('300');


                    $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_open').addClass('vi_wcaion_mini_cart_sidebar_close');

                });
                break;
            case 'hover':

                $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_icon').mouseover(function () {
                    $('.vi_wcaio_mini_cart_content').removeClass(class_close).addClass(class_open);
                    $('.vi_wcaio_mini_cart_sidebar_icon').hide('300');
                    $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_close').addClass('vi_wcaion_mini_cart_sidebar_open');


                });
                $(' .vi_wcaion_mini_cart_sidebar, .vi_wcaio_mini_cart_content .vi_wcaio_mini_cart_sidebar_title i ').click(function () {

                    $('.vi_wcaio_mini_cart_content').removeClass(class_open).addClass(class_close);
                    $('.vi_wcaio_mini_cart_sidebar_icon').show('300');


                    $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_open').addClass('vi_wcaion_mini_cart_sidebar_close');


                });

                break;
        }
        if ($('.vi_wcaio_products_plus_product').hasClass('slick-initialized')) {
            $('.vi_wcaio_products_plus_product').slick('unslick');
            $('.vi_wcaio_products_plus_product').slick({
                prevArrow: "<button type='button' class='slick-prev '><span class=\"dashicons dashicons-arrow-left-alt2\"></span></button>",
                nextArrow: "<button type='button' class='slick-next '><span class=\"dashicons dashicons-arrow-right-alt2\"></span></button>",
                dots: false,
                autoplay: false,
                arrows: true,
                slidesToShow: 2,
                slidesToScroll: 2,
                autoplaySpeed: 5000
            });
        }
    }

    function show_menu_cart_content() {
        if (wcaio_mini_cart.menu_cart_show_content === '1') {
            // if (isMobile === true) {
            //     $('.vi_wcaio_menu_cart a').click(function (e) {
            //         e.preventDefault();
            //     });
            // }
            $('.vi_wcaio_menu_cart').hover(function () {
                $(this).addClass('vi_wcaio_menu_cart_dropdown');
            });
            $('.vi_wcaio_menu_cart').mouseleave(function () {
                $('.vi_wcaio_menu_cart').attr('class', ' vi_wcaio_menu_cart');

            });

        }
    }

    function init() {
        var sidebar_position = wcaio_mini_cart.sidebar_position,
            sidebar_horizontal = wcaio_mini_cart.sidebar_horizontal,
            sidebar_vertical = wcaio_mini_cart.sidebar_vertical,

            sidebar_fly_img = wcaio_mini_cart.sidebar_fly_img,
            sidebar_show_cart_type = wcaio_mini_cart.sidebar_show_cart_type,
            sidebar_show_cart_style = wcaio_mini_cart.sidebar_show_cart_style,
            sidebar_shake_trigger = wcaio_mini_cart.sidebar_shake_trigger,
            sidebar_open = wcaio_mini_cart.sidebar_open,


            sidebar_footer_price_enable = wcaio_mini_cart.sidebar_footer_price_enable,
            sidebar_footer_pro_plus_enable = wcaio_mini_cart.sidebar_footer_pro_plus_enable;
        initVars();
        check_cart_device_enable();
        check_cart_empty();
        show_menu_cart_content();
        sidebar_cart_position(sidebar_position, sidebar_vertical, sidebar_horizontal, sidebar_show_cart_style);


        if (wcaio_mini_cart.sidebar_header_coupon_enable) {
            $('.vi_wcaio_mini_cart_sidebar_coupon').show();
        } else {
            $('.vi_wcaio_mini_cart_sidebar_coupon').hide();
        }

        if (parseInt(wcaio_mini_cart.sidebar_cart_icon_radius) > 30) {
            $('.vi_wcaio_mini_cart_sidebar_icon').find('.vi_wcaio_mini_cart_sidebar_icon_count_one').removeClass('.vi_wcaio_mini_cart_sidebar_icon_count_one1').addClass(' vi_wcaio_mini_cart_sidebar_icon_count_one2');
        } else {
            $('.vi_wcaio_mini_cart_sidebar_icon').find('.vi_wcaio_mini_cart_sidebar_icon_count_one').removeClass('.vi_wcaio_mini_cart_sidebar_icon_count_one2').addClass(' vi_wcaio_mini_cart_sidebar_icon_count_one1');

        }
        switch (sidebar_footer_price_enable) {
            case 'total':

                $('.vi_wcaio_mini_cart_sidebar_subtotal').css({'display': 'none'});
                break;
            case 'subtotal':
                $('.vi_wcaio_mini_cart_sidebar_total').css({'display': 'none'});

                break;
            default:
                $('.vi_wcaio_mini_cart_sidebar_total').css({'display': 'none'});
                $('.vi_wcaio_mini_cart_sidebar_subtotal').css({'display': 'none'});
        }

        if ($('.vi_wcaio_products_plus_product').length) {
            switch (sidebar_footer_pro_plus_enable) {
                case 'none':
                    if ($('.vi_wcaio_products_plus_product').hasClass('slick-initialized')) {
                        $('.vi_wcaio_products_plus_product').slick('unslick');
                    }
                    $('.vi_wcaio_products_plus_product').slick({
                        prevArrow: "<button type='button' class='slick-prev '><span class=\"dashicons dashicons-arrow-left-alt2\"></span></button>",
                        nextArrow: "<button type='button' class='slick-next '><span class=\"dashicons dashicons-arrow-right-alt2\"></span></button>",
                        dots: false,
                        autoplay: false,
                        arrows: true,
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        autoplaySpeed: 5000
                    });
                    if (wcaio_mini_cart.sidebar_content_display === '0') {
                        $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '', 'min-height': ''});
                        $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '340px', 'min-height': '325px'});
                    }
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_best-selling').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_products-viewed').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_product-rating').css({'display': 'none'});
                    break;
                case 'best_selling':
                    if ($('.vi_wcaio_products_plus_product').hasClass('slick-initialized')) {
                        $('.vi_wcaio_products_plus_product').slick('unslick');

                    }
                    $('.vi_wcaio_products_plus_product').slick({
                        prevArrow: "<button type='button' class='slick-prev '><span class=\"dashicons dashicons-arrow-left-alt2\"></span></button>",
                        nextArrow: "<button type='button' class='slick-next '><span class=\"dashicons dashicons-arrow-right-alt2\"></span></button>",
                        dots: false,
                        autoplay: false,
                        arrows: true,
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        autoplaySpeed: 5000
                    });
                    // $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '', 'min-height': ''});
                    // $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '230px', 'min-height': '225px'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_best-selling').css({'display': 'block'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_products-viewed').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_product-rating').css({'display': 'none'});
                    break;
                case 'viewed_product':
                    if ($('.vi_wcaio_products_plus_product').hasClass('slick-initialized')) {
                        $('.vi_wcaio_products_plus_product').slick('unslick');

                    }
                    $('.vi_wcaio_products_plus_product').slick({
                        prevArrow: "<button type='button' class='slick-prev '><span class=\"dashicons dashicons-arrow-left-alt2\"></span></button>",
                        nextArrow: "<button type='button' class='slick-next '><span class=\"dashicons dashicons-arrow-right-alt2\"></span></button>",
                        dots: false,
                        autoplay: false,
                        arrows: true,
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        autoplaySpeed: 5000
                    });
                    $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '', 'min-height': ''});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_best-selling').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_products-viewed').css({'display': 'block'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_product-rating').css({'display': 'none'});
                    if (wcaio_mini_cart.sidebar_content_display === '0') {
                        if ($('.vi_wcaio_mini_cart_sidebar_product-plus_products-viewed').find('.vi_wcaio_list_product_plus').length) {

                            $('.vi_wcaio_mini_cart_sidebar_content').css({
                                'max-height': '230px',
                                'min-height': '225px'
                            });
                        } else {
                            $('.vi_wcaio_mini_cart_sidebar_content').css({
                                'max-height': '340px',
                                'min-height': '325px'
                            });

                        }
                    }
                    break;
                case 'product_rating':
                    if ($('.vi_wcaio_products_plus_product').hasClass('slick-initialized')) {
                        $('.vi_wcaio_products_plus_product').slick('unslick');

                    }
                    $('.vi_wcaio_products_plus_product').slick({
                        prevArrow: "<button type='button' class='slick-prev '><span class=\"dashicons dashicons-arrow-left-alt2\"></span></button>",
                        nextArrow: "<button type='button' class='slick-next '><span class=\"dashicons dashicons-arrow-right-alt2\"></span></button>",
                        dots: false,
                        autoplay: false,
                        arrows: true,
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        autoplaySpeed: 5000
                    });
                    // $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '', 'min-height': ''});
                    // $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '230px', 'min-height': '225px'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_best-selling').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_products-viewed').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_product-rating').css({'display': 'block'});
                    break;
            }
        }

        setsidebar_cart_open(sidebar_position, sidebar_show_cart_type, sidebar_show_cart_style);

        // Update Cart List Obj
        $(document.body).on('wc_fragments_refreshed', function () {
            initVars();
            if ($(document.body).hasClass('woocommerce-checkout')) {
                $(document.body).trigger('update_checkout');
            }

            check_cart_empty();
        });

        set_add_to_cart();
        set_change_quantity();
        set_remove_item();
        set_apply_coupon();

        vi_set_added_to_cart_event(sidebar_fly_img, sidebar_open, sidebar_position, sidebar_shake_trigger);

        if ($('.vi_wcaio_products_plus_product').length) {
            if ($('.vi_wcaio_products_plus_product').hasClass('slick-initialized')) {
                $('.vi_wcaio_products_plus_product').slick('unslick');

            }
            $('.vi_wcaio_products_plus_product').slick({
                prevArrow: "<button type='button' class='slick-prev '><span class=\"dashicons dashicons-arrow-left-alt2\"></span></button>",
                nextArrow: "<button type='button' class='slick-next '><span class=\"dashicons dashicons-arrow-right-alt2\"></span></button>",
                dots: false,
                autoplay: false,
                arrows: true,
                slidesToShow: 2,
                slidesToScroll: 2,
                autoplaySpeed: 5000
            });
        }
    }


    function check_cart_empty() {
        if (wcaio_mini_cart.sidebar_cart_enable_empty !== '1') {
            if (cartWrapper.find('.vi_wcaio_mini_cart_sidebar_cart_empty').length) {
                cartWrapper.hide();
            }
        }
        if (wcaio_mini_cart.menu_cart_enable_empty !== '1') {
            if (cartWrapper.find('.vi_wcaio_mini_cart_sidebar_cart_empty').length) {
                $('.vi_wcaio_menu_cart').hide();
            }

        }
        // cartWrapper.show();
        // $('.vi_wcaio_menu_cart').show();
    }

    function set_update_cart_counter(quantity) {
        var emptyCart = cartWrapper.find('.vi_wcaio_mini_cart_sidebar_cart_empty').length;

        if (emptyCart) {
            cartCount.text(0);

        } else {


            setTimeout(function () {
                cartCount.text(quantity);
            }, 200);


        }

    }

    function set_update_cart_total(total, subtotal) {
        cartTotal.html(total);
        cartSubtotal.html(subtotal);
    }

    /*
    set apply coupon
     */

    function set_apply_coupon() {
        $(document).on('click', '.vi_wcaio_coupon button:submit', function (e) {
            e.preventDefault();
            var $thisbutton = $(this);
            if ($thisbutton.is('.vi_wcaio_input_coupon-button')) {
                var key = $('.vi_wcaio_coupon .vi_wcaio_input_coupon-code').val();
                var data = {
                    coupon_code_apply: key
                };
                $.ajax({
                    type: 'post',
                    url: wcaio_mini_cart.wc_ajax_url.toString().replace('%%endpoint%%', 'vi_wcaio_apply_coupon'),
                    data: data,
                    beforeSend: function (response) {
                        //add loading

                        $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_bg').show();
                        $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_loading').show();
                    },
                    complete: function (response) {
                        //remove loading

                        $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_bg').hide();
                        $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_loading').hide();
                    },
                    success: function (response) {
                        setTimeout(function () {
                            jQuery('body').trigger("wc_fragment_refresh");
                            jQuery('body').trigger("update_checkout");
                        }, 300);

                        $.each(response.fragments, function (key, value) {

                            if (key === 'vi_wcaio') {

                                //update total price
                                set_update_cart_total(value.total, value.subtotal);

                                //update number of items
                                set_update_cart_counter(value.total_items);

                                $('.vi_wcaio_mini_cart_content').append('<div  class="vi_wcaio_mini_cart_sidebar_noitce" ><div  class="vi_wcaio_mini_cart_sidebar_noitce_content" >' + value.notice + '</div></div>');

                                $('.vi_wcaio_sidebar').click(function () {
                                    $('.vi_wcaio_mini_cart_sidebar_noitce').remove();
                                });

                            } else if ((key.search('.vi_wcaio') !== -1)) {

                                $(key).replaceWith(value);
                            }
                        });

                    },
                });
            }
        });
    }

    function set_remove_item() {
        $(document).on('click', 'a.vi_wcaio_sidebar_product-remove', function (e) {
            e.preventDefault();
            var $thisbutton = $(this);
            if ($thisbutton.is('.vi_wcaio_sidebar_product-remove')) {
                var key = $thisbutton.data('cart_item_key');

                var data = {
                    cart_item_key: key
                };
                $.ajax({
                    type: 'post',
                    url: wcaio_mini_cart.wc_ajax_url.toString().replace('%%endpoint%%', 'vi_wcaio_remove_item'),
                    data: data,
                    beforeSend: function (response) {
                        //add loading

                        $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_bg').show();
                        $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_loading').show();
                    },
                    complete: function (response) {
                        //remove loading
                        $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_loading').hide();
                        $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_bg').hide();

                    },
                    success: function (response) {
                        setTimeout(function () {
                            jQuery('body').trigger("wc_fragment_refresh");
                            jQuery('body').trigger("update_checkout");
                        }, 300);
                    },
                });

            }
        });


    }

    function set_add_to_cart() {
        if (wcaio_mini_cart.ajax_add_to_cart_single_page === '1') {
            $(document).on('click', 'form .single_add_to_cart_button, .variations .single_add_to_cart_button', function (e) {
                if (jQuery(this).hasClass('disabled')) {
                    return false;
                }
                if (jQuery(this).closest('.variations_form').length) {
                    let variation_id_check = parseInt(jQuery(this).closest('.variations_form').find('input[name=variation_id]').val());
                    if (!variation_id_check || variation_id_check <= 0) {
                        return false;
                    }
                }
                e.preventDefault();
                let $thisbutton = $(this),
                    $form = $thisbutton.closest('form.cart'), data;
                data = $form.serialize();
                if (data.search('add-to-cart') === -1) {
                    data += '&add-to-cart=' + $form.find('[name=add-to-cart]').val();
                }
                $.ajax({
                    type: 'post',
                    url: wcaio_mini_cart.wc_ajax_url.toString().replace('%%endpoint%%', 'vi_wcaio_add_to_cart'),
                    data: data,
                    beforeSend: function (response) {
                        $thisbutton.removeClass('added').addClass('loading');
                    },
                    complete: function (response) {
                        $thisbutton.removeClass('loading').addClass('added');
                        $('.vi_wcaio_variation').remove();
                    },
                    success: function (response) {

                        if (response.error && response.product_url) {
                            window.location = response.product_url;
                            return;
                        } else {
                            $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                            $(document.body).trigger('wc_fragments_refreshed');
                            $(document.body).trigger("update_checkout");
                        }

                    },
                });

            });
        }
    }

    function set_change_quantity() {


        var product_info = {};
        $(document).on('change', '.vi_wcaio_sidebar_product-number-product input', function () {

            $('input#vi_wcaio_mini_cart_update').removeClass('hidden').addClass('show');

            var min = parseFloat($(this).attr('min'));
            var max = parseFloat($(this).attr('max'));

            if (min && min > 0 && parseFloat($(this).val()) < min) {

                $(this).val(min);

            } else if (max && max > 0 && parseFloat($(this).val()) > max) {

                $(this).val(max);

            }

            var product = $(this).closest('.vi_wcaio_sidebar_product');
            var qty = $(this).val();
            var key = product.data('key');
            product_info[key] = qty;


        });
        if ($('body').hasClass('woocommerce-cart')) {

            if (updatingWCAIO) {
                return false;
            }
            updatingWCAIO = true;
        }
        $(document).on('click', 'input#vi_wcaio_mini_cart_update', function () {
            var data = {
                product_info: product_info
            };

            $.ajax({
                type: 'post',
                url: wcaio_mini_cart.wc_ajax_url.toString().replace('%%endpoint%%', 'vi_wcaio_change_quantity'),
                data: data,
                beforeSend: function (response) {
                    //add loading

                    $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_bg').show();
                    $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_loading').show();
                },
                complete: function (response) {
                    //remove loading

                    $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_loading').hide();
                    $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_bg').hide();
                },
                success: function (response) {
                    setTimeout(function () {
                        jQuery('body').trigger("wc_fragment_refresh");
                        jQuery('body').trigger("update_checkout");
                    }, 300);
                    $('input#vi_wcaio_mini_cart_update').removeClass('show').addClass('hidden');

                },
            });
        });
    }

    /*
    added to cart 
     */

    function vi_set_added_to_cart_event(fly_img, sidebar_open, sidebar_position, shake_trigger) {
        $(document.body).on('added_to_cart', function (evt, fragments, cart_hash, btn) {

            var total_item = fragments['vi_wcaio']['total_items'];
            var class_open = sidebar_cart_open_style(wcaio_mini_cart.sidebar_show_cart_style);
            var class_close = sidebar_cart_close_style(sidebar_position, wcaio_mini_cart.sidebar_show_cart_style);
            if (total_item === 1) {
                $('.vi_wcaio_menu_cart').show();
                cartWrapper.show();
                if (sidebar_open === '1') {

                    $('.vi_wcaio_mini_cart_content').removeClass(class_close).addClass(class_open);

                    $('.vi_wcaio_mini_cart_sidebar_icon ').hide('300');
                    $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_close').addClass('vi_wcaion_mini_cart_sidebar_open');

                } else {

                    $('.vi_wcaio_mini_cart_content').removeClass(class_open);
                    $('.vi_wcaio_mini_cart_content').addClass(class_close);

                    $('.vi_wcaio_mini_cart_sidebar_icon ').show('300');
                    $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_open').addClass('vi_wcaion_mini_cart_sidebar_close');
                }
                $('.vi_wcaio_products_plus_product').slick('unslick');
                $('.vi_wcaio_products_plus_product').slick({
                    prevArrow: "<button type='button' class='slick-prev '><span class=\"dashicons dashicons-arrow-left-alt2\"></span></button>",
                    nextArrow: "<button type='button' class='slick-next '><span class=\"dashicons dashicons-arrow-right-alt2\"></span></button>",
                    dots: false,
                    autoplay: false,
                    arrows: true,
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    autoplaySpeed: 5000
                });

            }

            if (fly_img === '1' && total_item > 0) {

                annimate_img_product(btn, sidebar_open, sidebar_position, shake_trigger, total_item);

            }


        });

    }


    function annimate_img_product(btnclick, sidebar_open, sidebar_position, shake_trigger, total_item) {

        var img_product = null,
            sidebar_cart_icon = $('.vi_wcaio_mini_cart_sidebar_icon');

        img_product = find_img_product(btnclick);
        if (!img_product || img_product.length === 0) {
            return false;
        }


        var options = {
            position: {
                origin: {
                    // get initial position on document
                    initial: img_product.offset(),
                    // amout of pixels to move the cloned element from the original before flying to the basket
                    offset: {x: 5, y: 15}
                },
                destination: {
                    // get initial position on document
                    initial: sidebar_cart_icon.offset()
                }
            }
        };
        if (img_product.length && sidebar_cart_icon.length) {

            // clone original element and set initial position
            img_product
                .clone()
                .attr('id', 'vi_wcaio_fly-to-cart')
                .appendTo('body')
                .css('position', 'absolute')
                .css('z-index', '100')
                .css('top', options.position.origin.initial.top)
                .css('left', options.position.origin.initial.left);

            // make it fly!
            if (total_item > 0) {
                $('#vi_wcaio_fly-to-cart').animate(
                    {
                        top: options.position.origin.initial.top - options.position.origin.offset.y,
                        left: options.position.origin.initial.left - options.position.origin.offset.x
                    }, 400,
                    function () {
                        $('#vi_wcaio_fly-to-cart').delay(100).animate(
                            {
                                top: options.position.destination.initial.top,
                                left: options.position.destination.initial.left,
                                width: '20px',
                                height: '20px'
                            }, 750, 'easeInOutExpo',
                            function () {
                                $('#vi_wcaio_fly-to-cart').fadeOut(500, function () {
                                    if (sidebar_open === '1') {
                                        var class_open = sidebar_cart_open_style(wcaio_mini_cart.sidebar_show_cart_style);
                                        var class_close = sidebar_cart_close_style(sidebar_position, wcaio_mini_cart.sidebar_show_cart_style);
                                        $('.vi_wcaio_mini_cart_content').removeClass(class_close).addClass(class_open);
                                        $('.vi_wcaio_mini_cart_sidebar_icon ').hide('300');
                                        $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_close').addClass('vi_wcaion_mini_cart_sidebar_open');
                                    } else {
                                        sidebar_cart_icon.effect(shake_trigger, 'slow');
                                    }
                                });
                                $(this).detach();
                            }
                        );
                    }
                );
            }
        }


    }

    function find_img_product(btntrigger) {
        var img_product = null;

        // If Woo Product Table, Find Row Image
        if (btntrigger.closest('.wc-product-table').length) {
            if (btntrigger.closest('.product-row').find('.product-table-image').length) {

                img_product = btntrigger.closest('.product-row').find('.product-table-image');

                // If Woo Product Table, Mobile View Find Row Image
            } else if (btntrigger.closest('tr').prev('.product-row').find('.product-table-image').length) {

                img_product = btntrigger.closest('tr').prev('.product-row').find('.product-table-image');
            }

            // If Woo Product Table, Find Row Image
        } else if (btntrigger.closest('.variations').find('.image_link img').length) {

            img_product = trigger.closest('.variations').find('.image_link img');

            // Find image in Woo Quick View Modal
        } else if (btntrigger.closest('.product-quick-view-container').length) {
            if (btntrigger.closest('.product-quick-view-container').find('.slide.first img').length) {
                img_product = btntrigger.closest('.product-quick-view-container').find('.slide.first img');
            } else if (btntrigger.closest('.product-quick-view-container').find('.slide.first').length) {
                img_product = btntrigger.closest('.product-quick-view-container').find('.slide.first ');
            } else if (btntrigger.closest('.product-quick-view-container').find('.flickity-slider').length) {
                img_product = btntrigger.closest('.product-quick-view-container').find('.flickity-slider');
            }

            img_product.css('z-index', '');
            img_product.css('z-index', '999999');

            // Find image in single product page
        } else if (btntrigger.closest('.vi_wse_suggest_product').find('img').length) {
            img_product = btntrigger.closest('.vi_wse_suggest_product').find('img');
        } else if (btntrigger.closest('.product').length) {

            var product = btntrigger.closest('.product');

            if (product.find('.images img.attachment-shop_single').length) {

                img_product = product.find('.images img.attachment-shop_single').first();

            } else if (product.find('.magic-slide').length) {

                img_product = product.find('.magic-slide');

            } else if (product.find('.woocommerce-product-gallery .woocommerce-product-gallery__image').length) {

                img_product = product.find('.woocommerce-product-gallery .woocommerce-product-gallery__image').first();

            } else if (product.find('.images img').length) {

                img_product = product.find('.images img').first();

                //find img in loop
            } else if (product.find('.attachment-woocommerce_thumbnail').length) {


                img_product = product.find('.attachment-woocommerce_thumbnail');

            } else if (product.find('.wp-post-image').length) {
                img_product = product.find('.wp-post-image');
            } else {

                img_product = product;
            }

        }
        return img_product;
    }

    $(document).ready(function ($) {
        init();
    });
});
