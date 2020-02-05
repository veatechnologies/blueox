'use strict';
jQuery(document).ready(function ($) {


    $('.vi-ui.checkbox').checkbox();

    vi_wcaio_get_sidebar_offset();

    vi_wcaio_get_sidebar_content_border_radius();


    vi_wcaio_get_img_radio_button();

    vi_wcaio_get_cart_icon_radius();

    vi_wcaio_get_cart_text_border_radius();

    vi_wcaio_get_coupon_enable();

    vi_wcaio_get_footer_button();

    vi_wcaio_get_footer_pro_plus();

    vi_wcaio_get_list_pro_img_radius();
    vi_wcaio_set_menu_cart();


    function vi_wcaio_set_menu_cart() {

        if ($('#customize-control-woo_cart_all_in_one_params-menu_cart_style_one_text select').val() === 'product_counter') {
            $('#customize-control-woo_cart_all_in_one_params-menu_cart_style_one_price').hide();
        } else {
            $('#customize-control-woo_cart_all_in_one_params-menu_cart_style_one_price').show();
        }
        $('#customize-control-woo_cart_all_in_one_params-menu_cart_style_one_text select').change(function () {
            if ($(this).val() === 'product_counter') {
                $('#customize-control-woo_cart_all_in_one_params-menu_cart_style_one_price').hide();
            } else {
                $('#customize-control-woo_cart_all_in_one_params-menu_cart_style_one_price').show();
            }
        });
    }


    //set footer product plus
    function vi_wcaio_get_footer_pro_plus() {
        switch ($('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_enable select').val()) {
            case 'best_selling':
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_best_selling_text').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_text_color').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_number').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_viewed_pro_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_rating_pro_text').hide();
                break;
            case 'viewed_product':
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_best_selling_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_viewed_pro_text').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_number').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_text_color').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_rating_pro_text').hide();
                break;
            case 'product_rating':
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_best_selling_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_viewed_pro_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_number').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_rating_pro_text').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_text_color').show();
                break;
            case 'none':
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_best_selling_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_viewed_pro_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_rating_pro_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_number').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_text_color').hide();
                break;
            default:
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_best_selling_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_viewed_pro_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_rating_pro_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_number').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_text_color').hide();
        }
        $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_enable select').change(function () {
            switch ($(this).val()) {
                case 'best_selling':
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_best_selling_text').show();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_number').show();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_text_color').show();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_viewed_pro_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_rating_pro_text').hide();
                    break;
                case 'viewed_product':
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_best_selling_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_viewed_pro_text').show();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_number').show();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_rating_pro_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_text_color').show();
                    break;
                case 'product_rating':
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_best_selling_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_viewed_pro_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_number').show();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_rating_pro_text').show();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_text_color').show();
                    break;
                case 'none':
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_best_selling_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_viewed_pro_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_rating_pro_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_number').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_text_color').hide();
                    break;
                default:
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_best_selling_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_viewed_pro_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_rating_pro_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_number').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_pro_plus_text_color').hide();
            }
        });
    }

    //set footer button
    function vi_wcaio_get_footer_button() {
        switch ($('#customize-control-woo_cart_all_in_one_params-sidebar_footer_button_enable select').val()) {
            case 'cart':
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_cart_button_text').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_checkout_button_text').hide();
                break;
            case 'checkout':
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_cart_button_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_checkout_button_text').show();
                break;
            default:
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_cart_button_text').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_checkout_button_text').hide();
        }
        $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_button_enable select').change(function () {
            switch ($('#customize-control-woo_cart_all_in_one_params-sidebar_footer_button_enable select').val()) {
                case 'cart':
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_cart_button_text').show();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_checkout_button_text').hide();
                    break;
                case 'checkout':
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_cart_button_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_checkout_button_text').show();
                    break;
                default:
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_cart_button_text').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_footer_checkout_button_text').hide();
            }
        });

        var min = $('#vi_wcaio_customize_sidebar_footer_button_radius').attr('min'),
            max = $('#vi_wcaio_customize_sidebar_footer_button_radius').attr('max'),

            start_button = $('#vi_wcaio_customize_sidebar_footer_button_radius').attr('value'),
            start_button_update = $('#vi_wcaio_customize_sidebar_footer_update_button_radius').attr('value');

        $('#vi_wcaio_customize_sidebar_footer_button_radius').range({
            min: min,
            max: max,
            start: start_button,
            input: $('#vi_wcaio_customize_sidebar_footer_button_radius').next('.vi_wcaio_customize_range_value')
        });
        $('#vi_wcaio_customize_sidebar_footer_button_radius').parent().find('input').click(function () {
            // $(this).keyup(
            //     function () {
            //         console.log($(this).val());
            //
            //     }
            // );

            var setting = $(this).attr('data-customize-setting-link');
            var image = parseInt($(this).val());
            if (image > parseInt(max) || image < parseInt(min)) {
                image = start_button;
            }
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });

        $('#vi_wcaio_customize_sidebar_footer_update_button_radius').range({
            min: min,
            max: max,
            start: start_button_update,
            input: $('#vi_wcaio_customize_sidebar_footer_update_button_radius').next('.vi_wcaio_customize_range_value')
        });
        $('#vi_wcaio_customize_sidebar_footer_update_button_radius').parent().find('input').click(function () {
            var setting = $(this).attr('data-customize-setting-link');
            var image = parseInt($(this).val());
            if (image > parseInt(max) || image < parseInt(min)) {
                image = start_button_update;
            }
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });

    }


    //set coupon enable
    function vi_wcaio_get_coupon_enable() {
        if ($('#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_enable .vi_wcaio_customize_checkbox_content input:checkbox').attr('checked') === 'checked') {
            $('#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_input_radius, ' +
                '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_background, #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_text_color,' +
                '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_hover_background , #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_text_color_hover,' +
                '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_radius, #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_underline_color').show();
        } else {
            $('#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_input_radius, ' +
                '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_background, #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_text_color,' +
                '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_hover_background , #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_text_color_hover,' +
                '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_radius, #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_underline_color').hide();
        }
        $('#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_enable .vi_wcaio_customize_checkbox_content input:checkbox').change(function () {
            if ($(this).attr('checked') === 'checked') {
                $('#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_input_radius, ' +
                    '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_background, #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_text_color,' +
                    '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_hover_background , #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_text_color_hover,' +
                    '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_radius, #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_underline_color').show();
            } else {
                $('#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_input_radius, ' +
                    '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_background, #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_text_color,' +
                    '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_hover_background , #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_text_color_hover,' +
                    '#customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_button_radius, #customize-control-woo_cart_all_in_one_params-sidebar_header_coupon_underline_color').hide();
            }
        });
        var min = $('#vi_wcaio_customize_sidebar_header_coupon_button_radius').attr('min'),
            max = $('#vi_wcaio_customize_sidebar_header_coupon_button_radius').attr('max'),

            start = $('#vi_wcaio_customize_sidebar_header_coupon_button_radius').attr('value'),
            start_input = $('#vi_wcaio_customize_sidebar_header_coupon_input_radius').attr('value');

        $('#vi_wcaio_customize_sidebar_header_coupon_button_radius').range({
            min: min,
            max: max,
            start: start,
            input: $('#vi_wcaio_customize_sidebar_header_coupon_button_radius').next('.vi_wcaio_customize_range_value')
        });
        $('#vi_wcaio_customize_sidebar_header_coupon_button_radius').parent().find('input').click(function () {
            var setting = $(this).attr('data-customize-setting-link');
            var image = parseInt($(this).val());
            if (image > parseInt(max) || image < parseInt(min)) {
                image = start;
            }
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });

        $('#vi_wcaio_customize_sidebar_header_coupon_input_radius').range({
            min: min,
            max: max,
            start: start_input,
            input: $('#vi_wcaio_customize_sidebar_header_coupon_input_radius').next('.vi_wcaio_customize_range_value')
        });
        $('#vi_wcaio_customize_sidebar_header_coupon_input_radius').parent().find('input').click(function () {
            var setting = $(this).attr('data-customize-setting-link');
            var image = parseInt($(this).val());
            if (image > parseInt(max) || image < parseInt(min)) {
                image = start;
            }
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });
    }

    //customize img radio button
    function vi_wcaio_get_img_radio_button() {

        $('.customize-control.customize-control-vi_wcaio_radio_cart_icon .vi_wcaio_radio_button_img').buttonset();
        $('.customize-control.customize-control-vi_wcaio_radio_cart_icon .vi_wcaio_radio_button_img input:radio').change(function () {
            var setting = $(this).attr('data-customize-setting-link');
            var image = $(this).val();
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });
    }


    //cart icon type
    function vi_wcaio_get_cart_icon_type() {
        switch ($('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_type select').val()) {
            case 'default':
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_img').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_icon,#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_style, #customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_color ').show();
                break;
            case 'img':
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_img').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_icon,#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_style, #customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_color ').hide();
                break;
            default:
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_img').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_icon ,#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_style, #customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_color ').hide();


        }
        $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_type select').change(function () {
            switch ($(this).val()) {
                case 'default':
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_img').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_icon,#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_style, #customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_color ').show();
                    break;
                case 'img':
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_img').show();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_icon,#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_style, #customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_color ').hide();
                    break;
                default:
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_img').hide();
                    $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_icon,#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_style, #customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_color ').hide();

            }
        });

    }

    //side bar content radius
    function vi_wcaio_get_sidebar_content_border_radius() {
        var min = $('#vi_wcaio_customize_sidebar_content_radius').attr('min'),
            max = $('#vi_wcaio_customize_sidebar_content_radius').attr('max'),

            start = $('#vi_wcaio_customize_sidebar_content_radius').attr('value');

        $('#vi_wcaio_customize_sidebar_content_radius').range({
            min: min,
            max: max,
            start: start,
            input: $('#vi_wcaio_customize_sidebar_content_radius').next('.vi_wcaio_customize_range_value')
        });
        $('#vi_wcaio_customize_sidebar_content_radius').parent().find('input').click(function () {
            var setting = $(this).attr('data-customize-setting-link');
            var image = parseInt($(this).val());
            if (image > parseInt(max) || image < parseInt(min)) {
                image = start;
            }
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });
    }

    //cart icon text border radius
    function vi_wcaio_get_cart_text_border_radius() {
        var min = $('#vi_wcaio_customize_icon_text_radius').attr('min'),
            max = $('#vi_wcaio_customize_icon_text_radius').attr('max'),

            start = $('#vi_wcaio_customize_icon_text_radius').attr('value');

        $('#vi_wcaio_customize_icon_text_radius').range({
            min: min,
            max: max,
            start: start,
            input: $('#vi_wcaio_customize_icon_text_radius').next('.vi_wcaio_customize_range_value')
        });
        $('#vi_wcaio_customize_icon_text_radius').parent().find('input').click(function () {
            var setting = $(this).attr('data-customize-setting-link');

            var image = parseInt($(this).val());
            if (image > parseInt(max) || image < parseInt(min)) {
                image = start;
            }
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });
    }

    //cart icon  radius
    function vi_wcaio_get_cart_icon_radius() {
        var min = $('#vi_wcaio_customize_cart_icon_radius').attr('min'),
            max = $('#vi_wcaio_customize_cart_icon_radius').attr('max'),

            start = $('#vi_wcaio_customize_cart_icon_radius').attr('value');

        $('#vi_wcaio_customize_cart_icon_radius').range({
            min: min,
            max: max,
            start: start,
            input: $('#vi_wcaio_customize_cart_icon_radius').next('.vi_wcaio_customize_range_value')
        });
        $('#vi_wcaio_customize_cart_icon_radius').parent().find('input').click(function () {
            var setting = $(this).attr('data-customize-setting-link');
            var image = parseInt($(this).val());
            if (image > parseInt(max) || image < parseInt(min)) {
                image = start;
            }
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });
    }


    function vi_wcaio_get_sidebar_offset() {
        var
            min_offset = $('#vi_wcaio_customize_range_horizontal').attr('min'),
            max_offset = $('#vi_wcaio_customize_range_horizontal').attr('max'),

            start_horizontal = $('#vi_wcaio_customize_range_horizontal').attr('value'),
            start_vertical = $('#vi_wcaio_customize_range_vertical').attr('value');

        $('#vi_wcaio_customize_range_horizontal').range({
            min: min_offset,
            max: max_offset,
            start: start_horizontal,
            input: $('#vi_wcaio_customize_range_horizontal').next('.vi_wcaio_customize_range_value')
        });

        $('#vi_wcaio_customize_range_horizontal').parent().find('input').click(function () {
            var setting = $(this).attr('data-customize-setting-link');
            var image = parseInt($(this).val());
            if (image > parseInt(max_offset) || image < parseInt(min_offset)) {
                image = start_horizontal;
            }
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });

        $('#vi_wcaio_customize_range_vertical').range({
            min: min_offset,
            max: max_offset,
            start: start_vertical,
            input: $('#vi_wcaio_customize_range_vertical').next('.vi_wcaio_customize_range_value'),
        });

        $('#vi_wcaio_customize_range_vertical').parent().find('input').click(function () {
            var setting = $(this).attr('data-customize-setting-link');

            var image = parseInt($(this).val());
            if (image > parseInt(max_offset) || image < parseInt(min_offset)) {
                image = start_vertical;
            }
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });

        //cart effect
        if ($('#customize-control-woo_cart_all_in_one_params-sidebar_fly_img input:checkbox').attr('checked') === 'checked') {
            $('#customize-control-woo_cart_all_in_one_params-sidebar_shake_trigger').show();
        } else {
            $('#customize-control-woo_cart_all_in_one_params-sidebar_shake_trigger').hide();
        }
        $('#customize-control-woo_cart_all_in_one_params-sidebar_fly_img input:checkbox').change(function () {
            if ($(this).attr('checked') === 'checked') {
                $('#customize-control-woo_cart_all_in_one_params-sidebar_shake_trigger').show();
            } else {
                $('#customize-control-woo_cart_all_in_one_params-sidebar_shake_trigger').hide();
            }
        });

        if ($('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_style select').val() === '4') {
            $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_color').hide();
            $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_background_color').hide();
            $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_radius').hide();
        } else {

            $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_color').show();
            $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_background_color').show();
            $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_radius').show();
        }
        $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_default_style select').change(function () {
            if ($(this).val() === '4') {
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_color').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_background_color').hide();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_radius').hide();
            } else {

                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_color').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_background_color').show();
                $('#customize-control-woo_cart_all_in_one_params-sidebar_cart_icon_text_radius').show();
            }
        });
    }

    //product img radius
    function vi_wcaio_get_list_pro_img_radius() {
        var min = $('#vi_wcaio_customize_list_pro_image_radius').attr('min'),
            max = $('#vi_wcaio_customize_list_pro_image_radius').attr('max'),

            start = $('#vi_wcaio_customize_list_pro_image_radius').attr('value');
        $('#vi_wcaio_customize_list_pro_image_radius').range({
            min: min,
            max: max,
            start: start,
            input: $('#vi_wcaio_customize_list_pro_image_radius').next('.vi_wcaio_customize_range_value')
        });

        $('#vi_wcaio_customize_list_pro_image_radius').parent().find('input').click(function () {
            var setting = $(this).attr('data-customize-setting-link');

            var image = parseInt($(this).val());
            if (image > parseInt(max) || image < parseInt(min)) {
                image = start;
            }
            wp.customize(setting, function (obj) {
                obj.set(image);
            });
        });
    }

});
