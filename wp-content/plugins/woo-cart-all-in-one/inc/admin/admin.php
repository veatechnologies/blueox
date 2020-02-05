<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_CART_ALL_IN_ONE_Admin_Admin {
	protected $settings;

	public function __construct() {
		$this->settings          = new VI_WOO_CART_ALL_IN_ONE_DATA();
		$this->active_components = array();
		add_action( 'init', array( $this, 'init' ) );
	}


	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woo-cart-all-in-one' );
		load_textdomain( 'woo-cart-all-in-one', VI_WOO_CART_ALL_IN_ONE_LANGUAGES . "woo-cart-all-in-one-$locale.mo" );
		load_plugin_textdomain( 'woo-cart-all-in-one', false, VI_WOO_CART_ALL_IN_ONE_LANGUAGES );
	}

	public function init() {

		load_plugin_textdomain( 'woo-cart-all-in-one' );
		$this->load_plugin_textdomain();
	}
}