<?php
/**
 * Plugin Name: Cart All In One For WooCommerce
 * Plugin URI: https://villatheme.com/extensions/woocommerce-cart-all-in-one/
 * Description: Cart All In One For WooCommerce helps your customers view cart effortlessly.
 * Author: VillaTheme
 * Author URI:https://villatheme.com
 * Version: 1.0.8.2
 * Text Domain: woo-cart-all-in-one
 * Domain Path: /languages
 * Copyright 2019 VillaTheme.com. All rights reserved.
 * Requires at least: 4.4
 * Tested up to: 5.3
 * WC requires at least: 3.0.0
 * WC tested up to: 4.0
 */

if (!defined('ABSPATH')) {
	exit();
}

define('VI_WOO_CART_ALL_IN_ONE_VERSION', '1.0.8.2');
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

if (is_plugin_active('woocommerce/woocommerce.php')) {
	$init_file = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "woo-cart-all-in-one" . DIRECTORY_SEPARATOR . "inc" . DIRECTORY_SEPARATOR . "define.php";
	require_once $init_file;
}


class WOO_CART_ALL_IN_ONE
{
	public function __construct()
	{
		add_action('admin_notices', array($this, 'global_note'));
	}

	/**
	 * Notify if WooCommerce is not activated
	 */
	function global_note()
	{
		if (!is_plugin_active('woocommerce/woocommerce.php')) {
			?>
            <div id="message" class="error">
                <p><?php _e('Please install and activate WooCommerce to use Cart All In One For Woocommerce.', 'woo-cart-all-in-one'); ?></p>
            </div>
			<?php
			if (is_plugin_active('woo-cart-all-in-one/woo-cart-all-in-one.php')) {
				deactivate_plugins('woo-cart-all-in-one/woo-cart-all-in-one.php');
				unset($_GET['activate']);
			}
		}
	}
}

new WOO_CART_ALL_IN_ONE();