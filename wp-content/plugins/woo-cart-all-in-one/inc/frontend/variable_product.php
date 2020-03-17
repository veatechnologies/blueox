<?php


if (!defined('ABSPATH')) {
    exit;
}

class VI_WOO_CART_ALL_IN_ONE_Frontend_Variable_Product
{
    protected $settings;

    public function __construct()
    {
        $this->settings = new VI_WOO_CART_ALL_IN_ONE_DATA();

	    if ($this->settings->get_params('show_variation_enable')) {
		    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		    add_action( 'init', array( $this, 'init' ) );
	    }

    }
    public function init(){
	    if ( $this->settings->get_params( 'set_text_select_option_button_enable' ) ) {
		    add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'custom_cart_button_text' ), 10, 2 );
	    }
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('wcaio_frontend_variation-style', VI_WOO_CART_ALL_IN_ONE_CSS . 'frontend-variation-style.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION);
        wp_enqueue_script('wcaio_frontend_variation-script', VI_WOO_CART_ALL_IN_ONE_JS . 'frontend-variation-script.js', array(
            'jquery',
            'wc-cart-fragments'
        ), VI_WOO_CART_ALL_IN_ONE_VERSION);

        $wc_ajax_url = add_query_arg('wc-ajax', '%%endpoint%%', home_url('/'));
        wp_localize_script('wcaio_frontend_variation-script',
            'wcaio_variation', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'wc_ajax_url' => urldecode($wc_ajax_url),
            )
        );
    }

    function custom_cart_button_text($var, $instance)
    {
        $product = wc_get_product(get_the_ID());
        if ($product && $product->is_type('variable')) {
            return $this->settings->get_params('set_text_select_option_button');
        }

        return $var;
    }
}