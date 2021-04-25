(function ($) {
    var store_url = 'https://www.blueoxstore.com/shop/cart';
    jQuery(document).ready(function ($) {
        jQuery(document).find('.blueox_cart_floting').hide();
        jQuery(document).find('.blueox_cart_qty').text(0);
        var pro_code = jQuery(document).find('.ddiipp_pro_part_id').val();
        /*
         * Check Product Availabily & Update Button
         * 1) On Product Page
         * 2) On Listing Page
         */
//        if (jQuery(document).find('body.single-product').length > 0) {
//            if (pro_code) {
//                productAvailability(pro_code);
//            } else {
//                jQuery(document).find('.single_add_to_cart_button').attr('disabled', 'disabled');
//            }
//        }
        jQuery(document).find('.product-list-item').each(function () {
            var $this = jQuery(this);
            var loop_pro_code = jQuery(this).find('.ddiipp_pro_part_id').val();
            if (loop_pro_code) {
                PartsVia.Cart.availability(loop_pro_code).then(function (res) {
                    if (res.InStock) {
                        //In Stock
                    } else {
                        $this.find('.add_to_cart_button').css('pointer-events', 'none');
                        $this.find('.add_to_cart_button').css('opacity', '0.65');
                    }
                });
            } else {
                $this.find('.add_to_cart_button').css('pointer-events', 'none');
                $this.find('.add_to_cart_button').css('opacity', '0.65');
            }
        });
        /*
         * Add TO Cart Button Product Inner
         */
        jQuery(document).on('click', '.single_add_to_cart_button', function (e) {
            if (jQuery(this).hasClass('alt')) {
                e.preventDefault();
                var pro_code_click = jQuery(document).find('.ddiipp_pro_part_id').val();
                var pro_qty_click = jQuery(document).find('.input-text.qty').val();
                myAddToCart(pro_code_click, pro_qty_click);
                jQuery(this).removeClass('alt');
            }
        });
        /*
         * Add to cart From Listing Page
         */
        jQuery(document).on('click', '.add_to_cart_button.product_type_simple ', function (e) {
            e.preventDefault();
            var pro_code_click = jQuery(this).parents('.product-list-item').find('.ddiipp_pro_part_id').val();
            myAddToCart(pro_code_click, 1);
            jQuery(this).text('View Cart');
            jQuery(this).removeClass('product_type_simple');
            jQuery(this).attr('href', 'https://www.blueoxstore.com/shop/cart');
        });
        /*
         * Cart Redirect to Store Cart 
         */
        jQuery(document).on('click', '.blueox_cart_floting', function (e) {
            e.preventDefault();
            setTimeout(function () {
                jQuery(document).find('.blueox_cart_floting').show();
            }, 500);
            window.open(store_url, '_blank');
        });
        
    });
    /*
     * Load Event
     */
    window.onload = function () {
        /*
         * Check Product Availabily & Update Button
         * 1) On Product Page
         * 2) On Listing Page
         */
        var pro_code = jQuery(document).find('.ddiipp_pro_part_id').val();
        console.log(pro_code);
        if (jQuery(document).find('body.single-product').length > 0) {
            if (pro_code) {
                productAvailability(pro_code);
            } else {
                jQuery(document).find('.single_add_to_cart_button').attr('disabled', 'disabled');
            }
        }
        /*
         * Update Cart Count
         */
        updateCartCount();
        /*
         * Shop Page Design Change
         */
        setTimeout(function () {
            console.log("show trigger");
            jQuery(document).find("#baseplates").show();
        }, 1000);
    }
    productAvailability = function (code) {
        PartsVia.Cart.availability(code).then(function (res) {
            if (res.InStock) {
                //In Stock
                //} else if (res.CanSpecialOrder) {
                //Can Special Order
            } else {
                //Out Of Stock
                jQuery(document).find('.single_add_to_cart_button').attr('disabled', 'disabled');
            }
        });
    }
    /*
     * Add To Cart
     */
    myAddToCart = function (code, qty) {
        PartsVia.Cart.addToCart(code, qty).then(function (res) {
            if (jQuery(document).find('body.single-product').length > 0) {
//                alert(res.Message);
                jQuery(document).find('.single_add_to_cart_button').click();
            }
            var cartQty = res.TotalCount;
            if (cartQty > 0) {
                jQuery(document).find('.blueox_cart_qty').text(cartQty);
                jQuery(document).find('.blueox_cart_floting').show();
            } else {
                jQuery(document).find('.blueox_cart_floting').hide();
            }
        });
    }
    /*
     * Update Cart Count
     */
    updateCartCount = function () {
        PartsVia.Cart.getCartSummary().then(function (res) {
            var cartQty = res.TotalCount;
            if (cartQty > 0) {
                jQuery(document).find('.blueox_cart_qty').text(cartQty);
                jQuery(document).find('.blueox_cart_floting').show();
            } else {
                jQuery(document).find('.blueox_cart_floting').hide();
            }
        });
    }
})(jQuery);