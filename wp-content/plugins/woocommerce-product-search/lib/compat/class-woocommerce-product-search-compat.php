<?php
/**
 * class-woocommerce-product-search-compat.php
 *
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 *
 * @author itthinx
 * @package woocommerce-product-search
 * @since 2.9.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Compatibility loader.
 */
class WooCommerce_Product_Search_Compat {

	/**
	 * Loads compatibility resources.
	 */
	public static function init() {

		if ( class_exists( 'Jetpack' ) ) {
			if ( apply_filters( 'woocommerce_product_search_compat', true, 'plugin', 'jetpack' ) ) {
				require_once WOO_PS_COMPAT_LIB . '/class-woocommerce-product-search-compat-jetpack.php';
			}
		}

		$theme = wp_get_theme();
		if ( $theme instanceof WP_Theme ) {
			if ( $theme->exists() ) {
				$name = $theme->name;
				$parent_theme = $theme->parent_theme;

				if ( $name === 'Storefront' || $parent_theme === 'Storefront' && $name !== 'StoreSearch' ) {
					if ( apply_filters( 'woocommerce_product_search_compat', true, 'theme', 'storefront' ) ) {
						require_once WOO_PS_COMPAT_LIB . '/class-woocommerce-product-search-compat-storefront.php';
					}
				}
			}
		}
	}
}
WooCommerce_Product_Search_Compat::init();
