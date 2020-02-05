'use strict';
jQuery(document).ready(function ($) {

    $('.vi-ui.vi-ui-coupon.tabular.menu .item').vi_tab();
    $('.vi-ui.vi-ui-main.tabular.menu .item').vi_tab({
        history: true,
        historyType: 'hash'
    });

    /*Setup tab*/
    let tabs,
        tabEvent = false,
        initialTab = 'general',
        navSelector = '.vi-ui.vi-ui-main.menu',
        navFilter = function (el) {

            // return $(el).attr('href').replace(/^#/, '');
        },
        panelSelector = '.vi-ui.vi-ui-main.tab',
        panelFilter = function () {
            $(panelSelector + ' a').filter(function () {
                return $(navSelector + ' a[title=' + $(this).attr('title') + ']').size() != 0;
            });
        };

    // Initializes plugin features
    $.address.strict(false).wrap(true);

    if ($.address.value() == '') {
        //$.address.history(false).value(initialTab).history(true);
    }

    // Address handler
    $.address.init(function (event) {

        // Adds the ID in a lazy manner to prevent scrolling
        $(panelSelector).attr('id', initialTab);

        panelFilter();

        // Tabs setup
        tabs = $('.vi-ui.vi-ui-main.menu')
            .vi_tab({
                history: true,
                historyType: 'hash'
            })

        // Enables the plugin for all the tabs
        $(navSelector + ' a').click(function (event) {
            if ($(this).attr('data-tab') === 'customize') {
                window.open($(this).attr('data-href'), '_blank');
            }
            tabEvent = true;
            $.address.value(navFilter(event.target));
            tabEvent = false;
            return true;
        });

    });
    $('.ui-sortable').sortable({
        placeholder: 'wcaio-place-holder',
    });
    $('.vi-ui.checkbox').checkbox();
    $('.vi-ui.dropdown').dropdown();
    handleDropdownSelect();

    function handleDropdownSelect() {

        /*select set_text_select_option_button_enable*/
        if (jQuery('#set_text_select_option_button_enable').attr('checked') == 'checked') {
            jQuery('.vi_wcaion_set_text_select_option_button').show();
        } else {
            jQuery('.vi_wcaion_set_text_select_option_button').hide();
        }
        jQuery('#set_text_select_option_button_enable').change(function () {
            jQuery('.vi_wcaion_set_text_select_option_button').toggle();
        });
    }

    $('body').click(function () {
        $('.iris-picker').hide();
    });

});

