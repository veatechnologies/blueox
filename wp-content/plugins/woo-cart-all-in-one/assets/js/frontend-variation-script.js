jQuery(document).ready(function ($) {

    $('.add_to_cart_button').click(function (e) {
        e.preventDefault();
        var key = $(this).attr('data-product_id'), $button = jQuery(this);
        var data = {
            product_id: key
        };
        $.ajax({
            type: 'post',
            url: wcaio_variation.wc_ajax_url.toString().replace('%%endpoint%%', 'vi_wcaio_show_variation'),
            data: data,
            beforeSend: function () {
                console.log(key);
                $button.addClass('loading');
            },
            success: function (response) {
                // console.log(response);
                if (response.status==='success'){
                    $(document.body).prepend(response.html);
                    var available_variations = response.available_variations,
                        available_attributes = {},variation_id,
                        $select = $('.vi_wcaio_variation').find('form.cart select'),
                        attributes = {};

                    if (available_variations){
                        $.each(available_variations, function (key, value) {
                        available_attributes[key] =  value.attributes ;
                        });
                        $.each($select, function () {
                            attributes[ $(this).attr('data-attribute_name')] = $(this).val();
                        });
                        variation_id = wcaio_get_variation_id(attributes, available_attributes,available_variations);
                        if (variation_id >0){
                            $('.vi_wcaio_variation').find('form.cart .variation_id').val(variation_id);
                            $('.vi_wcaio_variation').find('form.cart .vi_wcaio_variation_add_to_cart').removeClass('vi_wcaio_disabled');
                        }else {
                            $('.vi_wcaio_variation').find('form.cart .vi_wcaio_variation_add_to_cart').addClass('vi_wcaio_disabled');
                        }
                        $select.unbind().change(function () {
                            attributes[ $(this).attr('data-attribute_name')] = $(this).val();
                            variation_id = wcaio_get_variation_id(attributes, available_attributes,available_variations);
                            if (variation_id >0){
                                $('.vi_wcaio_variation').find('form.cart .variation_id').val(variation_id);
                                $('.vi_wcaio_variation').find('form.cart .vi_wcaio_variation_add_to_cart').removeClass('vi_wcaio_disabled');
                            }else {
                                $('.vi_wcaio_variation').find('form.cart .vi_wcaio_variation_add_to_cart').addClass('vi_wcaio_disabled');
                            }
                        });
                    }
                }else if (response.status==='error' && response.url){
                    window.location.href = response.url;
                }
            },
            complete:function () {
                $button.removeClass('loading');
            }
        });
    });

    function wcaio_get_variation_id(attributes, available_attributes,available_variations){
        let variation_id=0, check_attr, i;
        if (!attributes || !available_attributes  || !available_variations  ){
            return variation_id;
        }
        jQuery.each(available_attributes, function (key, value) {
            if (isEqual( attributes, value)){
                check_attr = key;
            }
        });
        if (check_attr){
            variation_id = available_variations[check_attr].variation_id;
        }
        return variation_id;
    }
    $(document).on('click', '.vi_wcaio_variation-quantity-add', function () {

        var form = $(this).closest('form.cart');
        var quantity = form.find('input[name ="quantity"]');
        var max = quantity.attr('max') || 9999;
        max = parseFloat(max);

        if (max && max > 0 && parseFloat(quantity.val()) >= max) {

            quantity.val(max);

        } else {
            quantity.val(parseFloat(quantity.val()) + 1);
        }
    });
    $(document).on('click', '.vi_wcaio_variation-quantity-subtract', function () {

        var form = $(this).closest('form.cart');
        var quantity = form.find('input[name ="quantity"]');
        var min = quantity.attr('min') || 1;
        min = parseFloat(min);

        if (min && min > 0 && parseFloat(quantity.val()) <= min) {
            quantity.val(min);

        } else {
            quantity.val(parseFloat(quantity.val()) - 1);

        }

    });
    $(document).on('click', '.vi_wcaio_variation_add_to_cart_cancel, .vi_wcaio_variation_bg', function () {

        $('.vi_wcaio_variation').remove();

    });
});

function isEqual(objA, objB) {

    let i,
        aProps = Object.getOwnPropertyNames(objA),
        bProps = Object.getOwnPropertyNames(objB);
    if (aProps.length != bProps.length) {
        return false;
    }

    for (i = 0; i < aProps.length; i++) {
        let propName = aProps[i];
        if (objA[propName]==='' ){
            return false;
        }
        if (objB[propName]==='' ){
            continue;
        }
        if (objA[propName] !== objB[propName]) {
            return false;
        }
    }

    return true;
}