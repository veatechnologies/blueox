//'use strict';
jQuery(document).ready(function ($) {
    //sidebar general

    function addPreviewControl(name, element, style, suffix = '', open_content = false) {
        wp.customize('woo_cart_all_in_one_params[' + name + ']', function (value) {
            value.bind(function (newval) {

                var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
                var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
                var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
                var class_open = sidebar_cart_open_style(parseInt(show_style));
                var class_close = sidebar_cart_close_style(position, parseInt(show_style));

                if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                    sidebar_open_close(class_open, class_close, sidebar_show_type, open_content);

                }


                $('#wcaio_woo_art_all_in_one-preview-' + name.replace(/_/g, '-')).html(element + '{' + style + ':' + newval + suffix + ' ; }');

            })
        })
    }

    wp.customize.preview.bind('active', function () {
        wp.customize.preview.bind('vi_wcaio_open_cart_sidebar_content', function () {
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);

            }

        });
        wp.customize.preview.bind('vi_wcaio_close_cart_sidebar_content', function () {
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_open')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, false);

            }

        });
        wp.customize.preview.bind('vi_wcaio_open_cart_menu_cart_content', function () {


        });
    });

    function sidebar_cart_set_position(position, vertical, horizontal, display_style, class_open, class_close, sibar_show_type) {

        $('.vi_wcaion_mini_cart_sidebar_content').css({'top': '', 'bottom': '', 'left': '', 'right': ''});
        $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': '', 'bottom': '', 'left': '', 'right': ''});
        $('.vi_wcaio_mini_cart_content').css({'top': '', 'bottom': '', 'left': '', 'right': ''});
        if (display_style === '0') {

            switch (position) {
                case 'top_left':
                    $('.vi_wcaion_mini_cart_sidebar_content').css({
                        'top': vertical + 'px',
                        'left': horizontal + 'px'
                    });
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': 0, 'left': 0});
                    $('.vi_wcaio_mini_cart_content').css({'top': 0, 'left': 0});
                    break;
                case 'top_right':
                    $('.vi_wcaion_mini_cart_sidebar_content').css({
                        'top': vertical + 'px',
                        'right': horizontal + 'px'
                    });
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': 0, 'right': 0});
                    $('.vi_wcaio_mini_cart_content').css({'top': 0, 'right': 0});
                    break;
                case 'bottom_left':
                    $('.vi_wcaion_mini_cart_sidebar_content').css({
                        'bottom': vertical + 'px',
                        'left': horizontal + 'px'
                    });
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': 0, 'left': 0});
                    $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'left': 0});
                    break;
                case 'bottom_right':
                    $('.vi_wcaion_mini_cart_sidebar_content').css({
                        'bottom': vertical + 'px',
                        'right': horizontal + 'px'
                    });
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': 0, 'right': 0});
                    $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'right': 0});
                    break;

            }
        } else {
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
            sidebar_open_close(class_open, class_close, sibar_show_type, false);
        }
    }

    function sidebar_cart_open_style(show_style) {
        var class_open;
        switch (show_style) {
            case 1:
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open1';
                break;
            case 2:
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open2';
                break;
            case 3:
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open3';
                break;
            case 4:
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open4';
                break;
            case 5:
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open5';
                break;
            case 6:
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open6';
                break;
            case 7:
                class_open = 'vi_wcaio_mini_cart_content_open vi_wcaio_mini_cart_content_open7';
                break;
        }
        return class_open;
    }

    function sidebar_cart_close_style(position, show_style) {
        var class_close;
        switch (show_style) {
            case 1:
                if (position === 'top_left' || position === 'bottom_left') {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close1 vi_wcaio_mini_cart_content_close1_left';
                } else {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close1 vi_wcaio_mini_cart_content_close1_right';
                }
                break;
            case 2:
                class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close2 ';
                break;
            case 3:
                if (position === 'top_left' || position === 'top_right') {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close3 vi_wcaio_mini_cart_content_close3_top';
                } else {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close3 vi_wcaio_mini_cart_content_close3_bottom';
                }
                break;
            case 4:
                class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close4 ';
                break;
            case 5:
                class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close5';
                break;
            case 6:
                class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close6 ';
                break;
            case 7:
                if (position === 'top_left' || position === 'bottom_left') {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close7 vi_wcaio_mini_cart_content_close7_left';
                } else {
                    class_close = 'vi_wcaio_mini_cart_content_close vi_wcaio_mini_cart_content_close7 vi_wcaio_mini_cart_content_close7_right';
                }
                break;
        }
        return class_close;
    }

    function sidebar_open_close(class_open, class_close, sibar_show_type, open = false) {

        // console.log($('.vi_wcaio_mini_cart_content').attr('class'));

        var display_style = wp.customize('woo_cart_all_in_one_params[sidebar_content_display]').get();

        if (open) {
            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_open')) {
                $('.vi_wcaio_mini_cart_content').attr('class', 'vi_wcaio_mini_cart_content vi_wcaio_mini_cart_content_template_one ' + class_open);
            } else {
                $('.vi_wcaio_mini_cart_content').attr('class', 'vi_wcaio_mini_cart_content vi_wcaio_mini_cart_content_template_one ' + class_open);
                $('.vi_wcaio_mini_cart_sidebar_icon').hide('300');
                $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_close').addClass('vi_wcaion_mini_cart_sidebar_open');
            }


        } else {
            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_open')) {
                $('.vi_wcaio_mini_cart_content').removeClass(class_open).addClass(class_close);
                $('.vi_wcaio_mini_cart_sidebar_icon').show('300');
                $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_open').addClass('vi_wcaion_mini_cart_sidebar_close');
            } else {
                $('.vi_wcaio_mini_cart_content').attr('class', 'vi_wcaio_mini_cart_content vi_wcaio_mini_cart_content_template_one ' + class_close);
            }
        }
        if (display_style === '0') {

            $('.vi_wcaio_mini_cart_content').removeClass('vi_wcaio_mini_cart_content_template_one2').addClass('vi_wcaio_mini_cart_content_template_one1');

        } else {

            $('.vi_wcaio_mini_cart_content').removeClass('vi_wcaio_mini_cart_content_template_one1').addClass('vi_wcaio_mini_cart_content_template_one2');

        }
        switch (sibar_show_type) {
            case 'click':
                $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_icon').click(function () {
                    $('.vi_wcaio_mini_cart_content').attr('class', 'vi_wcaio_mini_cart_content vi_wcaio_mini_cart_content_template_one ' + class_open);
                    $('.vi_wcaio_mini_cart_sidebar_icon').hide('300');
                    $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_close').addClass('vi_wcaion_mini_cart_sidebar_open');
                    if (display_style === '0') {

                        $('.vi_wcaio_mini_cart_content').removeClass('vi_wcaio_mini_cart_content_template_one2').addClass('vi_wcaio_mini_cart_content_template_one1');

                    } else {

                        $('.vi_wcaio_mini_cart_content').removeClass('vi_wcaio_mini_cart_content_template_one1').addClass('vi_wcaio_mini_cart_content_template_one2');

                    }
                });

                break;
            case 'hover':

                $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_icon').mouseover(function () {
                    $('.vi_wcaio_mini_cart_content').attr('class', 'vi_wcaio_mini_cart_content vi_wcaio_mini_cart_content_template_one ' + class_open);
                    $('.vi_wcaio_mini_cart_sidebar_icon').hide('300');
                    $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_close').addClass('vi_wcaion_mini_cart_sidebar_open');
                    if (display_style === '0') {

                        $('.vi_wcaio_mini_cart_content').removeClass('vi_wcaio_mini_cart_content_template_one2').addClass('vi_wcaio_mini_cart_content_template_one1');

                    } else {

                        $('.vi_wcaio_mini_cart_content').removeClass('vi_wcaio_mini_cart_content_template_one1').addClass('vi_wcaio_mini_cart_content_template_one2');

                    }

                });

                break;

        }
        $('.vi_wcaio_mini_cart_content .vi_wcaio_mini_cart_sidebar_title i, .vi_wcaion_mini_cart_sidebar ').click(function () {
            $('.vi_wcaio_mini_cart_content').attr('class', 'vi_wcaio_mini_cart_content vi_wcaio_mini_cart_content_template_one ' + class_close);
            $('.vi_wcaio_mini_cart_sidebar_icon').show('300');

            $('.vi_wcaion_mini_cart_sidebar').removeClass('vi_wcaion_mini_cart_sidebar_open').addClass('vi_wcaion_mini_cart_sidebar_close');
            if (display_style === '0') {

                $('.vi_wcaio_mini_cart_content').removeClass('vi_wcaio_mini_cart_content_template_one2').addClass('vi_wcaio_mini_cart_content_template_one1');

            } else {

                $('.vi_wcaio_mini_cart_content').removeClass('vi_wcaio_mini_cart_content_template_one1').addClass('vi_wcaio_mini_cart_content_template_one2');

            }
        });


    }

    addPreviewControl('sidebar_cart_content_radius', '.vi_wcaio_mini_cart_content', 'border-radius', 'px', true);
    wp.customize('woo_cart_all_in_one_params[sidebar_content_display]', function (value) {
        value.bind(function (newval) {
            var sidebar_position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var horizontal = wp.customize('woo_cart_all_in_one_params[sidebar_horizontal]').get();
            var vertical = wp.customize('woo_cart_all_in_one_params[sidebar_vertical]').get();


            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(sidebar_position, parseInt(show_style));
            var sibar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();

            sidebar_cart_set_position(sidebar_position, vertical, horizontal, newval, class_open, class_close, sibar_show_type);

            sidebar_open_close(class_open, class_close, sibar_show_type, true);
        });
    });

    wp.customize('woo_cart_all_in_one_params[sidebar_position]', function (value) {
        value.bind(function (newval) {
            var horizontal = wp.customize('woo_cart_all_in_one_params[sidebar_horizontal]').get();
            var vertical = wp.customize('woo_cart_all_in_one_params[sidebar_vertical]').get();
            var display_style = wp.customize('woo_cart_all_in_one_params[sidebar_content_display]').get();


            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(newval, parseInt(show_style));
            var sibar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();

            sidebar_cart_set_position(newval, vertical, horizontal, display_style, class_open, class_close, sibar_show_type);

            sidebar_open_close(class_open, class_close, sibar_show_type, true);
        });
    });


    wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]', function (value) {
        value.bind(function (newval) {
            var sidebar_position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var vertical = wp.customize('woo_cart_all_in_one_params[sidebar_vertical]').get();
            var horizontal = wp.customize('woo_cart_all_in_one_params[sidebar_horizontal]').get();
            var display_style = wp.customize('woo_cart_all_in_one_params[sidebar_content_display]').get();

            var class_open = sidebar_cart_open_style(parseInt(newval));
            var class_close = sidebar_cart_close_style(sidebar_position, parseInt(newval));

            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();

            sidebar_cart_set_position(sidebar_position, vertical, horizontal, display_style, class_open, class_close, sidebar_show_type);
            sidebar_open_close(class_open, class_close, sidebar_show_type, true);
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_horizontal]', function (value) {
        value.bind(function (newval) {
            var sidebar_position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var vertical = wp.customize('woo_cart_all_in_one_params[sidebar_vertical]').get();

            var display_style = wp.customize('woo_cart_all_in_one_params[sidebar_content_display]').get();
            $('.vi_wcaion_mini_cart_sidebar_content').css({'top': '', 'bottom': '', 'left': '', 'right': ''});
            $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': '', 'bottom': '', 'left': '', 'right': ''});
            $('.vi_wcaio_mini_cart_content').css({'top': '', 'bottom': '', 'left': '', 'right': ''});

            if (display_style === '0') {
                switch (sidebar_position) {
                    case 'top_left':
                        $('.vi_wcaion_mini_cart_sidebar_content').attr('style', 'top: ' + vertical + 'px ; left: ' + newval + 'px ;');
                        $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': 0, 'left': 0});
                        $('.vi_wcaio_mini_cart_content').css({'top': 0, 'left': 0});
                        break;
                    case 'top_right':
                        $('.vi_wcaion_mini_cart_sidebar_content').attr('style', 'top: ' + vertical + 'px ; right: ' + newval + 'px ;');
                        $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': 0, 'right': 0});
                        $('.vi_wcaio_mini_cart_content').css({'top': 0, 'right': 0});
                    case 'bottom_left':
                        $('.vi_wcaion_mini_cart_sidebar_content').attr('style', 'bottom: ' + vertical + 'px; left: ' + newval + 'px ;');
                        $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': 0, 'left': 0});
                        $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'left': 0});
                        break;
                    case 'bottom_right':
                        $('.vi_wcaion_mini_cart_sidebar_content').attr('style', 'bottom: ' + vertical + 'px ; right:' + newval + 'px ;');
                        $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': 0, 'right': 0});
                        $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'right': 0});
                        break;

                }
            } else {
                if (sidebar_position === 'top_left') {
                    $('.vi_wcaion_mini_cart_sidebar_content').css({'top': 0, 'left': 0});
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': vertical + 'px', 'left': newval + 'px'});
                    $('.vi_wcaio_mini_cart_content').css({'top': 0, 'left': 0});
                } else if (sidebar_position === 'top_right') {
                    $('.vi_wcaion_mini_cart_sidebar_content').css({'top': 0, 'right': 0});
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': vertical + 'px', 'right': newval + 'px'});
                    $('.vi_wcaio_mini_cart_content').css({'top': 0, 'right': 0});
                } else if (sidebar_position === 'bottom_left') {
                    $('.vi_wcaion_mini_cart_sidebar_content').css({'bottom': 0, 'left': 0});
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': vertical + 'px', 'left': newval + 'px'});
                    $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'left': 0});

                } else if (sidebar_position === 'bottom_right') {
                    $('.vi_wcaion_mini_cart_sidebar_content').css({'bottom': 0, 'right': 0});
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': vertical + 'px', 'right': newval + 'px'});
                    $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'right': 0});
                }
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_vertical]', function (value) {
        value.bind(function (newval) {
            var sidebar_position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_horizontal = wp.customize('woo_cart_all_in_one_params[sidebar_horizontal]').get();
            var display_style = wp.customize('woo_cart_all_in_one_params[sidebar_content_display]').get();

            $('.vi_wcaion_mini_cart_sidebar_content').css({'top': '', 'bottom': '', 'left': '', 'right': ''});
            $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': '', 'bottom': '', 'left': '', 'right': ''});
            $('.vi_wcaio_mini_cart_content').css({'top': '', 'bottom': '', 'left': '', 'right': ''});

            if (display_style === '0') {
                switch (sidebar_position) {
                    case 'top_left':
                        $('.vi_wcaion_mini_cart_sidebar_content').attr('style', 'top: ' + newval + 'px ; left: ' + sidebar_horizontal + 'px ;');
                        $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': 0, 'left': 0});
                        $('.vi_wcaio_mini_cart_content').css({'top': 0, 'left': 0});
                        break;
                    case 'top_right':
                        $('.vi_wcaion_mini_cart_sidebar_content').attr('style', 'top: ' + newval + 'px ; right: ' + sidebar_horizontal + 'px ;');
                        $('.vi_wcaio_mini_cart_sidebar_icon').css({'top': 0, 'right': 0});
                        $('.vi_wcaio_mini_cart_content').css({'top': 0, 'right': 0});
                        break;
                    case 'bottom_left':
                        $('.vi_wcaion_mini_cart_sidebar_content').attr('style', 'bottom: ' + newval + 'px; left: ' + sidebar_horizontal + 'px ;');
                        $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': 0, 'left': 0});
                        $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'left': 0});
                        break;
                    case 'bottom_right':
                        $('.vi_wcaion_mini_cart_sidebar_content').attr('style', 'bottom: ' + newval + 'px ; right:' + sidebar_horizontal + 'px ;');
                        $('.vi_wcaio_mini_cart_sidebar_icon').css({'bottom': 0, 'right': 0});
                        $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'right': 0});
                        break;

                }
            } else {
                if (sidebar_position === 'top_left') {
                    $('.vi_wcaion_mini_cart_sidebar_content').css({'top': 0, 'left': 0});
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({
                        'top': newval + 'px',
                        'left': sidebar_horizontal + 'px'
                    });
                    $('.vi_wcaio_mini_cart_content').css({'top': 0, 'left': 0});
                } else if (sidebar_position === 'top_right') {
                    $('.vi_wcaion_mini_cart_sidebar_content').css({'top': 0, 'right': 0});
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({
                        'top': newval + 'px',
                        'right': sidebar_horizontal + 'px'
                    });
                    $('.vi_wcaio_mini_cart_content').css({'top': 0, 'right': 0});
                } else if (sidebar_position === 'bottom_left') {
                    $('.vi_wcaion_mini_cart_sidebar_content').css({'bottom': 0, 'left': 0});
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({
                        'bottom': newval + 'px',
                        'left': sidebar_horizontal + 'px'
                    });
                    $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'left': 0});

                } else if (sidebar_position === 'bottom_right') {
                    $('.vi_wcaion_mini_cart_sidebar_content').css({'bottom': 0, 'right': 0});
                    $('.vi_wcaio_mini_cart_sidebar_icon').css({
                        'bottom': newval + 'px',
                        'right': sidebar_horizontal + 'px'
                    });
                    $('.vi_wcaio_mini_cart_content').css({'bottom': 0, 'right': 0});
                }
            }
        });
    });

    // sidebar loading
    // addPreviewControl('mini_cart_loading', '.vi_wcaio_mini_cart_content', 'border-radius', 'px');
    wp.customize('woo_cart_all_in_one_params[mini_cart_loading]', function (value) {
        value.bind(function (newval) {
            $.ajax({
                type: 'POST',
                url: woo_cart_all_in_one_params.ajaxurl,
                data: {
                    action: 'woo_cart_all_in_one_loading',
                    loading_id: newval
                },
                success: function (response) {
                    $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_loading').html(response);
                    $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_loading').show();
                },
                error: function (err) {
                    console.log(err);
                }
            });

            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });

    wp.customize('woo_cart_all_in_one_params[mini_cart_loading_color]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_sidebar .vi_wcaio_mini_cart_sidebar_loading').show();
            $('#wcaio_woo_art_all_in_one-preview-mini-cart-loading').html(
                '.vi_wcaio_sidebar .vi_wcaio_loading-lds-default div,' +
                '.vi_wcaio_sidebar .vi_wcaio_loading-lds-facebook div,' +
                '.vi_wcaio_sidebar .vi_wcaio_loading-lds-roller div:after,' +
                '.vi_wcaio_sidebar .vi_wcaio_loading-lds-ellipsis div,' +
                '.vi_wcaio_sidebar .vi_wcaio_loading-lds-spinner div:after,' +
                '.vi_wcaio_sidebar .vi_wcaio_loading-lds-ellipsis-balls2 div,' +
                '.vi_wcaio_sidebar .vi_wcaio_loading-lds-ellipsis-balls3 div,' +
                '.vi_wcaio_sidebar .vi_wcaio_loading-lds-facebook2 div{' +
                '       background: ' + newval + ';' +
                '}' +
                ' .vi_wcaio_sidebar .vi_wcaio_loading-lds-dual-ring:after{' +
                '      border: 5px solid ' + newval + ';  ?>;' +
                '       border-color: ' + newval + ' transparent ' + newval + '  transparent;' +
                ' }' +
                '.vi_wcaio_sidebar .vi_wcaio_loading-lds-ring div{' +
                '      border: 6px solid ' + newval + ';' +
                '       border-color: ' + newval + '  transparent transparent transparent;' +
                '}' +
                '.vi_wcaio_sidebar .vi_wcaio_loading-lds-ripple  div{\n' +
                '       border: 4px solid  ' + newval + ' ;\n' +
                ' }'
            );

            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });

    //sidebar cart icon

    addPreviewControl('sidebar_cart_icon_background', '.vi_wcaio_mini_cart_sidebar_icon', 'background-color', '');
    addPreviewControl('sidebar_cart_icon_radius', '.vi_wcaio_mini_cart_sidebar_icon', 'border-radius', 'px');

    wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_radius]', function (value) {
        value.bind(function (newval) {
            if (parseInt(newval) > 30) {
                $('.vi_wcaio_mini_cart_sidebar_icon').find('.vi_wcaio_mini_cart_sidebar_icon_count_one').attr('class', 'vi_wcaio_mini_cart_sidebar_icon_count_one vi_wcaio_mini_cart_sidebar_icon_count_one2');

            } else {
                $('.vi_wcaio_mini_cart_sidebar_icon').find('.vi_wcaio_mini_cart_sidebar_icon_count_one').attr('class', 'vi_wcaio_mini_cart_sidebar_icon_count_one vi_wcaio_mini_cart_sidebar_icon_count_one1');
            }
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_open')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type);

            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_box_shadow]', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('#wcaio_woo_art_all_in_one-preview-sidebar-cart-icon-box-shadow').html(
                    ' .vi_wcaio_mini_cart_sidebar_icon {\n' +
                    '                    box-shadow: inset 0 0 2px rgba(0, 0, 0, 0.03), 0 4px 30px rgba(0, 0, 0, 0.17);\n' +
                    '                }\n' +
                    '\n' +
                    '                .vi_wcaio_mini_cart_sidebar_icon:hover {\n' +
                    '                    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);\n' +
                    '                }'
                );
            } else {
                $('#wcaio_woo_art_all_in_one-preview-sidebar-cart-icon-box-shadow').html(
                    '.vi_wcaio_mini_cart_sidebar_icon, .vi_wcaio_mini_cart_sidebar_icon:hover  { box-shadow: unset ;}'
                );
            }

            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_open')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type);

            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_scale]', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('#wcaio_woo_art_all_in_one-preview-sidebar-cart-icon-scale').html(
                    ' .vi_wcaio_mini_cart_sidebar_icon { transform: scale(' + newval + ');}'
                );
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_hover_scale]', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('#wcaio_woo_art_all_in_one-preview-sidebar-cart-icon-hover-scale').html(
                    ' .vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_hover1 { transform: scale(' + newval + ');}'
                );
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_default_style]', function (value) {
        value.bind(function (newval) {
            switch (newval) {
                case '1':
                    $('.vi_wcaion_mini_cart_sidebar_content').find('.vi_wcaio_mini_cart_sidebar_icon').attr('class', 'vi_wcaio_mini_cart_sidebar_icon vi_wcaio_mini_cart_sidebar_icon_default vi_wcaio_mini_cart_sidebar_icon_default_one');
                    break;
                case '2':
                    $('.vi_wcaion_mini_cart_sidebar_content').find('.vi_wcaio_mini_cart_sidebar_icon').attr('class', 'vi_wcaio_mini_cart_sidebar_icon vi_wcaio_mini_cart_sidebar_icon_default vi_wcaio_mini_cart_sidebar_icon_default_two');

                    break;
                case '3':
                    $('.vi_wcaion_mini_cart_sidebar_content').find('.vi_wcaio_mini_cart_sidebar_icon').attr('class', 'vi_wcaio_mini_cart_sidebar_icon vi_wcaio_mini_cart_sidebar_icon_default vi_wcaio_mini_cart_sidebar_icon_default_three');

                    break;
                case '4':
                    $('.vi_wcaion_mini_cart_sidebar_content').find('.vi_wcaio_mini_cart_sidebar_icon').attr('class', 'vi_wcaio_mini_cart_sidebar_icon vi_wcaio_mini_cart_sidebar_icon_default vi_wcaio_mini_cart_sidebar_icon_default_one');

                    break;
            }
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_open')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type);

            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_default_icon]', function (value) {
        value.bind(function (newval) {
            var cart_icon_style = wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_default_style]').get();
            var sidebar_cart_icon_radius = wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_radius]').get();
            $.ajax({
                type: 'POST',
                url: woo_cart_all_in_one_params.ajaxurl,
                data: {
                    action: 'woo_cart_all_in_one_select_cart_icon',
                    cart_icon_id: newval,
                    cart_icon_style: cart_icon_style,
                },
                success: function (response) {
                    $('.vi_wcaion_mini_cart_sidebar_content').find('.vi_wcaio_mini_cart_sidebar_icon').html(response);
                    if (parseInt(sidebar_cart_icon_radius) > 30) {
                        $('.vi_wcaio_mini_cart_sidebar_icon').find('.vi_wcaio_mini_cart_sidebar_icon_count_one').attr('class', 'vi_wcaio_mini_cart_sidebar_icon_count_one vi_wcaio_mini_cart_sidebar_icon_count_one2');

                    } else {
                        $('.vi_wcaio_mini_cart_sidebar_icon').find('.vi_wcaio_mini_cart_sidebar_icon_count_one').attr('class', 'vi_wcaio_mini_cart_sidebar_icon_count_one vi_wcaio_mini_cart_sidebar_icon_count_one1');
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_open')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type);

            }
        });
    });

    addPreviewControl('sidebar_cart_icon_default_color', '.vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_default i,' +
        ' .vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_default i :before ,' +
        '.vi_wcaio_mini_cart_sidebar_icon.vi_wcaio_mini_cart_sidebar_icon_default i :after ', 'color', '');
    wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_default_style]', function (value) {
        value.bind(function (newval) {
            var cart_icon = wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_default_icon]').get();
            var sidebar_cart_icon_radius = wp.customize('woo_cart_all_in_one_params[sidebar_cart_icon_radius]').get();
            $.ajax({
                type: 'POST',
                url: woo_cart_all_in_one_params.ajaxurl,
                data: {
                    action: 'woo_cart_all_in_one_cart_icon_default_style',
                    cart_icon_id: cart_icon,
                    cart_icon_style: newval,
                },
                success: function (response) {
                    $('.vi_wcaion_mini_cart_sidebar_content').find('.vi_wcaio_mini_cart_sidebar_icon').html(response);
                    if (parseInt(sidebar_cart_icon_radius) > 30) {
                        $('.vi_wcaio_mini_cart_sidebar_icon').find('.vi_wcaio_mini_cart_sidebar_icon_count_one').attr('class', 'vi_wcaio_mini_cart_sidebar_icon_count_one vi_wcaio_mini_cart_sidebar_icon_count_one2');

                    } else {
                        $('.vi_wcaio_mini_cart_sidebar_icon').find('.vi_wcaio_mini_cart_sidebar_icon_count_one').attr('class', 'vi_wcaio_mini_cart_sidebar_icon_count_one vi_wcaio_mini_cart_sidebar_icon_count_one1');
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
    });


    addPreviewControl('sidebar_cart_icon_text_background_color', '.vi_wcaio_mini_cart_sidebar_icon_count_one, .vi_wcaio_mini_cart_sidebar_icon_count_three, .vi_wcaio_mini_cart_sidebar_icon_count_two', 'background-color', '');
    addPreviewControl('sidebar_cart_icon_text_color', '.vi_wcaio_mini_cart_sidebar_icon_count_one, .vi_wcaio_mini_cart_sidebar_icon_count_three, .vi_wcaio_mini_cart_sidebar_icon_count_two', 'color', '');
    addPreviewControl('sidebar_cart_icon_text_radius', '.vi_wcaio_mini_cart_sidebar_icon_count_one, .vi_wcaio_mini_cart_sidebar_icon_count_three, .vi_wcaio_mini_cart_sidebar_icon_count_two', 'border-radius', 'px');


    addPreviewControl('sidebar_header_background_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title', 'background-color', '', true);

    wp.customize('woo_cart_all_in_one_params[sidebar_header_border]', function (value) {
        value.bind(function (newval) {
            var color = wp.customize('woo_cart_all_in_one_params[sidebar_header_border_color]').get();
            $('#wcaio_woo_art_all_in_one-preview-sidebar-header-border').html(
                '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title{\n' +
                '                border-bottom: 1px ' + newval + ' ' + color + ';\n' +
                '            }'
            );
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_header_border_color]', function (value) {
        value.bind(function (newval) {
            var border = wp.customize('woo_cart_all_in_one_params[sidebar_header_border]').get();
            $('#wcaio_woo_art_all_in_one-preview-sidebar-header-border').html(
                '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title{\n' +
                '                border-bottom: 1px ' + border + ' ' + newval + ';\n' +
                '            }'
            );
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });

    wp.customize('woo_cart_all_in_one_params[sidebar_header_title]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title h5').html(newval);
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    addPreviewControl('sidebar_header_title_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title h5 ', 'color', '', true);

    wp.customize('woo_cart_all_in_one_params[sidebar_header_coupon_enable]', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.vi_wcaio_mini_cart_sidebar_coupon').show();
            } else {
                $('.vi_wcaio_mini_cart_sidebar_coupon').hide();
            }
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });


    // addPreviewControl('sidebar_header_coupon_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title a.vi_wcaio_hide-coupon', 'color', '',true);

    addPreviewControl('sidebar_header_coupon_input_radius', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  input#coupon_code.vi_wcaio_input_coupon-code ', 'border-radius', 'px', true);

    addPreviewControl('sidebar_header_coupon_button_background', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button', 'background-color', '', true);
    addPreviewControl('sidebar_header_coupon_button_text_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button', 'color', '');
    addPreviewControl('sidebar_header_coupon_button_hover_background', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button:hover', 'background-color', '', true);
    addPreviewControl('sidebar_header_coupon_button_text_color_hover', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button:hover', 'color', '', true);
    addPreviewControl('sidebar_header_coupon_button_radius', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_coupon  button.vi_wcaio_input_coupon-button', 'border-radius', 'px', true);

    wp.customize('woo_cart_all_in_one_params[sidebar_header_coupon_underline_color]', function (value) {
        value.bind(function (newval) {
            var border = wp.customize('woo_cart_all_in_one_params[sidebar_header_coupon_underline]').get();
            $('#wcaio_woo_art_all_in_one-preview-sidebar-header-coupon-underline').html(
                '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_title a.vi_wcaio_hide-coupon{\n' +
                '                border-bottom: 1px ' + border + ' ' + newval + ';\n' +
                '            }'
            );
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });


//sidebar footer
    addPreviewControl('sidebar_footer_background_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-footer', 'background-color', '', true);
    addPreviewControl('sidebar_footer_pro_plus_text_color', '  .vi_wcaio_list_product_plus_title ', 'color', '', true);
    wp.customize('woo_cart_all_in_one_params[sidebar_footer_border]', function (value) {
        value.bind(function (newval) {
            var color = wp.customize('woo_cart_all_in_one_params[sidebar_footer_border_color]').get();
            $('#wcaio_woo_art_all_in_one-preview-sidebar-footer-border').html(
                '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-footer{\n' +
                '                border-top: 1px ' + newval + ' ' + color + ';\n' +
                '            }'
            );
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_footer_border_color]', function (value) {
        value.bind(function (newval) {
            var border = wp.customize('woo_cart_all_in_one_params[sidebar_footer_border]').get();
            $('#wcaio_woo_art_all_in_one-preview-sidebar-footer-border').html(
                '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-footer{\n' +
                '                border-top: 1px ' + border + ' ' + newval + ';\n' +
                '            }'
            );
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });

    wp.customize('woo_cart_all_in_one_params[sidebar_footer_price_enable]', function (value) {
        value.bind(function (newval) {
            switch (newval) {
                case 'subtotal':
                    $('.vi_wcaio_mini_cart_sidebar_total').hide();
                    $('.vi_wcaio_mini_cart_sidebar_subtotal').show();
                    break;
                case 'total':
                    $('.vi_wcaio_mini_cart_sidebar_total').show();
                    $('.vi_wcaio_mini_cart_sidebar_subtotal').hide();
                    break;
            }
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    addPreviewControl('sidebar_footer_total_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_coupon-total .vi_wcaio_mini_cart_sidebar_total-subtotal .vi_wcaio_mini_cart_sidebar_subtotal div:first-child, ' +
        ' .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_coupon-total .vi_wcaio_mini_cart_sidebar_total-subtotal .vi_wcaio_mini_cart_sidebar_total div:first-child', 'color', '', true);
    addPreviewControl('sidebar_footer_price_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_coupon-total .vi_wcaio_mini_cart_sidebar_total-subtotal .vi_wcaio_mini_cart_sidebar_subtotal span.amount,' +
        ' .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_coupon-total .vi_wcaio_mini_cart_sidebar_total-subtotal .vi_wcaio_mini_cart_sidebar_total span.amount', 'color', '', true);

    wp.customize('woo_cart_all_in_one_params[sidebar_footer_button_enable]', function (value) {
        value.bind(function (newval) {
            switch (newval) {
                case 'cart':
                    $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a:nth-child(3)').hide();
                    $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a:nth-child(2)').show();
                    break;
                case 'checkout':
                    $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a:nth-child(3)').show();
                    $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a:nth-child(2)').hide();
                    break;
            }
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_footer_cart_button_text]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a:nth-child(2) input').val(newval);
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_footer_checkout_button_text]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a:nth-child(3) input').val(newval);
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    addPreviewControl('sidebar_footer_button_background', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input', 'background-color', '', true);
    addPreviewControl('sidebar_footer_button_text_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input', 'color', '', true);
    addPreviewControl('sidebar_footer_button_hover_background', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input:hover', 'background-color', '', true);
    addPreviewControl('sidebar_footer_button_text_color_hover', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input:hover', 'color', '', true);
    addPreviewControl('sidebar_footer_button_radius', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button a input', 'border-radius', 'px', true);

    addPreviewControl('sidebar_footer_update_button_background', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update', 'background-color', '', true);
    addPreviewControl('sidebar_footer_update_button_text_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update', 'color', '', true);
    addPreviewControl('sidebar_footer_update_button_hover_background', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update:hover', 'background-color', '', true);
    addPreviewControl('sidebar_footer_update_button_text_color_hover', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update:hover', 'color', '', true);
    addPreviewControl('sidebar_footer_update_button_radius', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update', 'border-radius', 'px', true);

    wp.customize('woo_cart_all_in_one_params[sidebar_footer_update_button_background]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update').attr('style', 'opacity: 1;');
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_footer_update_button_text_color]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update').attr('style', 'opacity: 1;');
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_footer_update_button_hover_background]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update').attr('style', 'opacity: 1;');
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_footer_update_button_text_color_hover]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar-button input#vi_wcaio_mini_cart_update').attr('style', 'opacity: 1;');
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_footer_pro_plus_enable]', function (value) {
        value.bind(function (newval) {
            if ($('.vi_wcaio_products_plus_product').hasClass('slick-initialized')) {
                $('.vi_wcaio_products_plus_product').slick('unslick');
            }
            $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '', 'min-height': ''});
            switch (newval) {
                case 'none':
                    $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '340px', 'min-height': '325px'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_best-selling').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_products-viewed').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_product-rating').css({'display': 'none'});
                    break;
                case 'best_selling':
                    $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '230px', 'min-height': '225px'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_best-selling').css({'display': 'block'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_products-viewed').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_product-rating').css({'display': 'none'});
                    break;
                case 'viewed_product':
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_best-selling').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_products-viewed').css({'display': 'block'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_product-rating').css({'display': 'none'});
                    if ($('.vi_wcaio_mini_cart_sidebar_product-plus_products-viewed').find('.vi_wcaio_list_product_plus').length) {

                        $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '230px', 'min-height': '225px'});
                    } else {
                        $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '340px', 'min-height': '325px'});

                    }
                    break;
                case 'product_rating':
                    $('.vi_wcaio_mini_cart_sidebar_content').css({'max-height': '230px', 'min-height': '225px'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_best-selling').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_products-viewed').css({'display': 'none'});
                    $('.vi_wcaio_mini_cart_sidebar_product-plus_product-rating').css({'display': 'block'});
                    break;
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
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });

    wp.customize('woo_cart_all_in_one_params[sidebar_footer_best_selling_text]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_list_product_plus_title.vi_wcaio_list_product_plus_title_best_selling').html(newval);
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_footer_viewed_pro_text]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_list_product_plus_title.vi_wcaio_list_product_plus_title_viewed_pro').html(newval);
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[sidebar_footer_rating_pro_text]', function (value) {
        value.bind(function (newval) {
            $('.vi_wcaio_list_product_plus_title.vi_wcaio_list_product_plus_title_rating_pro').html(newval);
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });

    //sidebar list pro
    addPreviewControl('list_pro_background_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content', 'background-color', '', true);
    addPreviewControl('list_pro_name_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content .vi_wcaio_sidebar_product-name-product a', 'color', '', true);
    addPreviewControl('list_pro_hover_name_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content .vi_wcaio_sidebar_product-name-product a:hover', 'color', '', true);
    addPreviewControl('list_pro_price_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_content', 'color', '', true);

    wp.customize('woo_cart_all_in_one_params[list_pro_image_box_shadow]', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('#wcaio_woo_art_all_in_one-preview-list-pro-image-box-shadow').html(
                    '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img{\n' +
                    '                box-shadow:  0 4px 10px rgba(0,0,0,0.07);\n' +
                    '            }\n' +
                    '            .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img:hover{\n' +
                    '                box-shadow: 0 4px 30px rgba(0,0,0,0.3);\n' +
                    '            }'
                );

            } else {

                $('#wcaio_woo_art_all_in_one-preview-list-pro-image-box-shadow').html(
                    '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img, ' +
                    '   .vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img:hover{' +
                    ' box-shadow: unset; }'
                );
            }
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });
    addPreviewControl('list_pro_image_radius', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product_img img', 'border-radius', 'px', true);

    wp.customize('woo_cart_all_in_one_params[list_pro_remove_icon_style]', function (value) {
        value.bind(function (newval) {
            $.ajax({
                type: 'POST',
                url: woo_cart_all_in_one_params.ajaxurl,
                data: {
                    action: 'woo_cart_all_in_oneremove_icon_style',
                    trash_icon_id: newval,
                },
                success: function (response) {
                    $('.vi_wcaio_sidebar_product-delete-product').find('a').html(response);
                    ;
                },
                error: function (err) {
                    console.log(err);
                }
            });
            var show_style = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_style]').get();
            var position = wp.customize('woo_cart_all_in_one_params[sidebar_position]').get();
            var sidebar_show_type = wp.customize('woo_cart_all_in_one_params[sidebar_show_cart_type]').get();
            var class_open = sidebar_cart_open_style(parseInt(show_style));
            var class_close = sidebar_cart_close_style(position, parseInt(show_style));

            if ($('.vi_wcaio_mini_cart_content').hasClass('vi_wcaio_mini_cart_content_close')) {
                sidebar_open_close(class_open, class_close, sidebar_show_type, true);
            }
        });
    });

    addPreviewControl('list_pro_remove_icon_color', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product-delete-product a i', 'color', '', true);
    addPreviewControl('list_pro_remove_icon_color_hover', '.vi_wcaio_mini_cart_content.vi_wcaio_mini_cart_content_template_one .vi_wcaio_mini_cart_sidebar_list_products li .vi_wcaio_sidebar_product-delete-product a i:hover', 'color', '', true);

    //menu cart
    wp.customize('woo_cart_all_in_one_params[menu_cart_icon]', function (value) {
        value.bind(function (newval) {
            $.ajax({
                type: 'POST',
                url: woo_cart_all_in_one_params.ajaxurl,
                data: {
                    action: 'woo_cart_all_in_one_menu_cart_icon',
                    cart_icon_id: newval,
                },
                success: function (response) {
                    $('.vi_wcaio_menu_cart').find('.vi_wcaio_mini_cart_menu_icon').html(response);
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
    });


    wp.customize('woo_cart_all_in_one_params[menu_cart_icon_color]', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('#wcaio_woo_art_all_in_one-preview-menu-cart-icon-color').html(
                    ' .vi_wcaio_mini_cart_menu_icon i,.vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i :before ,.vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i :after {\n' +
                    '                    color: ' + newval + ' !important ;\n' +
                    '                }'
                );
            } else {
                $('#wcaio_woo_art_all_in_one-preview-menu-cart-icon-color').html(
                    ' .vi_wcaio_mini_cart_menu_icon i,.vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i :before ,.vi_wcaio_menu_cart .vi_wcaio_mini_cart_menu_icon i :after {\n' +
                    '                    color: inherit !important;\n' +
                    '                }'
                );
            }
        });
    });

    wp.customize('woo_cart_all_in_one_params[menu_cart_icon_color_hover]', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('#wcaio_woo_art_all_in_one-preview-menu-cart-icon-color-hover').html(
                    '.vi_wcaio_menu_cart:hover .vi_wcaio_mini_cart_menu_icon i{\n' +
                    '               color:  ' + newval + ' ;' +
                    '            }\n'
                );
            } else {
                $('#wcaio_woo_art_all_in_one-preview-menu-cart-icon-color-hover').html(
                    '.vi_wcaio_menu_cart:hover .vi_wcaio_mini_cart_menu_icon i{\n' +
                    '               color:  inherit ;' +
                    '            }\n'
                );
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[menu_cart_style_one_text]', function (value) {
        value.bind(function (newval) {
            var total = wp.customize('woo_cart_all_in_one_params[menu_cart_style_one_price]').get();
            $.ajax({
                type: 'POST',
                url: woo_cart_all_in_one_params.ajaxurl,
                data: {
                    action: 'woo_cart_all_in_one_menu_text_type',
                    text_type: newval,
                    total: total
                },
                success: function (response) {
                    $('.vi_wcaio_menu_cart').find('.vi_wcaio_menu_cart_text_one').html(response);
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
    });
    wp.customize('woo_cart_all_in_one_params[menu_cart_style_one_price]', function (value) {
        value.bind(function (newval) {
            var style = wp.customize('woo_cart_all_in_one_params[menu_cart_style_one_text]').get();
            $.ajax({
                type: 'POST',
                url: woo_cart_all_in_one_params.ajaxurl,
                data: {
                    action: 'woo_cart_all_in_one_menu_text_type',
                    text_type: style,
                    total: newval
                },
                success: function (response) {
                    $('.vi_wcaio_menu_cart').find('.vi_wcaio_menu_cart_text_one').html(response);
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
    });
    wp.customize('woo_cart_all_in_one_params[menu_cart_style_one_text_color]', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('#wcaio_woo_art_all_in_one-preview-menu-cart-style-one-text-color').html(
                    '.vi_wcaio_menu_cart_text_one, .vi_wcaio_menu_cart_text_one span.amount{\n' +
                    '               color:  ' + newval + ' !important ;' +
                    '            }\n'
                );
            } else {
                $('#wcaio_woo_art_all_in_one-preview-menu-cart-style-one-text-color').html(
                    '.vi_wcaio_menu_cart_text_one, .vi_wcaio_menu_cart_text_one span.amount{\n' +
                    '               color:  inherit !important; ' +
                    '            }\n'
                );
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[menu_cart_style_one_text_color_hover]', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('#wcaio_woo_art_all_in_one-preview-menu-cart-style-one-text-color-hover').html(
                    '            .vi_wcaio_menu_cart:hover  .vi_wcaio_menu_cart_text_one,.vi_wcaio_menu_cart:hover  .vi_wcaio_menu_cart_text_one span.amount{\n' +
                    '               color:  ' + newval + '  ;\n' +
                    '            }'
                );
            } else {
                $('#wcaio_woo_art_all_in_one-preview-menu-cart-style-one-text-color-hover').html(
                    '            .vi_wcaio_menu_cart:hover  .vi_wcaio_menu_cart_text_one,.vi_wcaio_menu_cart:hover  .vi_wcaio_menu_cart_text_one span.amount{\n' +
                    '               color:  inherit  ;\n' +
                    '            }'
                );
            }
        });
    });
    wp.customize('woo_cart_all_in_one_params[menu_cart_show_content]', function (value) {
        value.bind(function (newval) {
            if (newval) {
                $('.vi_wcaio_menu_cart').addClass('vi_wcaio_menu_cart_dropdown');
                $('.vi_wcaio_menu_cart').hover(function () {
                    $(this).addClass('vi_wcaio_menu_cart_dropdown');
                });
                $('.vi_wcaio_menu_cart').mouseleave(function () {
                    $('.vi_wcaio_menu_cart').attr('class', ' vi_wcaio_menu_cart');

                });
            } else {
                $('.vi_wcaio_menu_cart').attr('class', ' vi_wcaio_menu_cart');
                $('.vi_wcaio_menu_cart').hover(function () {
                    $('.vi_wcaio_menu_cart').attr('class', ' vi_wcaio_menu_cart');
                });
            }
        });
    });


    wp.customize('woo_cart_all_in_one_params[custom_css]', function (value) {
        value.bind(function (newval) {
            $('#wcaio_woo_art_all_in_one-preview-custom-css').html(newval);
        })
    });


});

