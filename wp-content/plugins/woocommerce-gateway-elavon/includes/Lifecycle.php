<?php
/**
 * WooCommerce Elavon Converge
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Elavon Converge to newer
 * versions in the future. If you wish to customize WooCommerce Elavon Converge for your
 * needs please refer to http://docs.woocommerce.com/document/elavon-vm-payment-gateway/
 *
 * @package     WC-Elavon
 * @author      SkyVerge
 * @copyright   Copyright (c) 2013-2019, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

namespace SkyVerge\WooCommerce\Elavon_Converge;

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_5_1 as Framework;

/**
 * Plugin lifecycle handler.
 *
 * @since 2.4.0
 *
 * @method \WC_Elavon_Converge get_plugin()
 */
class Lifecycle extends Framework\Plugin\Lifecycle {


	/**
	 * Runs every time. Used since the activation hook is not executed when updating a plugin.
	 *
	 * @since 2.4.0
	 *
	 * @see Framework\SV_WC_Plugin::install()
	 */
	protected function install() {

		// check for a pre 1.2 version
		if ( $legacy_version = get_option( 'wc_gateway_elavon_vm' ) ) {
			$this->upgrade( $legacy_version );
		}
	}


	/**
	 * Runs when the plugin version number changes.
	 *
	 * @since 2.4.0
	 *
	 * @param string $installed_version installed version
	 */
	protected function upgrade( $installed_version ) {

		// delete legacy option if it exists
		delete_option( 'wc_gateway_elavon_vm' );

		// if installed version is less than 1.0.4, set the correct account type, if needed
		if ( version_compare( $installed_version, "1.0.4", '<' ) ) {

			// Can't think of a great way of grabbing this from the abstract WC_Settings_API class
			$plugin_id = 'woocommerce_';

			$form_field_settings = (array) get_option( $plugin_id . \WC_Elavon_Converge::PLUGIN_ID . '_settings' );

			// for existing installs, configured prior to the introduction of the 'account' setting
			if ( $form_field_settings && ! isset( $form_field_settings['account'] ) ) {

				if ( isset( $form_field_settings['testmode'] ) && 'yes' == $form_field_settings['testmode'] ) {
					$form_field_settings['account'] = 'demo';
				} else {
					$form_field_settings['account'] = 'production';
				}

				// set the account type
				update_option( $plugin_id . \WC_Elavon_Converge::PLUGIN_ID . '_settings', $form_field_settings );
			}
		}

		// standardize debug_mode setting
		if ( version_compare( $installed_version, "1.1.1", '<' ) && ( $settings = get_option( 'woocommerce_' . \WC_Elavon_Converge::PLUGIN_ID . '_settings' ) ) ) {

			// previous settings
			$log_enabled   = isset( $settings['log'] )   && 'yes' == $settings['log']   ? true : false;
			$debug_enabled = isset( $settings['debug'] ) && 'yes' == $settings['debug'] ? true : false;

			// logger -> debug_mode
			if ( $log_enabled && $debug_enabled ) {
				$settings['debug_mode'] = 'both';
			} elseif ( ! $log_enabled && ! $debug_enabled ) {
				$settings['debug_mode'] = 'off';
			} elseif ( $log_enabled ) {
				$settings['debug_mode'] = 'log';
			} else {
				$settings['debug_mode'] = 'checkout';
			}

			unset( $settings['log'] );
			unset( $settings['debug'] );

			update_option( 'woocommerce_' . \WC_Elavon_Converge::PLUGIN_ID . '_settings', $settings );
		}

		// upgrade to 2.0.0
		if ( version_compare( $installed_version, '2.0.0', '<' ) ) {

			$this->get_plugin()->log( sprintf( 'Upgrading from %1$s to %2$s', $installed_version, '2.0.0' ) );

			// upgrade settings
			if ( $settings = get_option( 'woocommerce_' . \WC_Elavon_Converge::PLUGIN_ID . '_settings' ) ) {

				$gateway          = $this->get_plugin()->get_gateway();
				$settings_fields  = $gateway->get_form_fields();

				// these option values can be updated 1:1
				$updated_keys = array(
					'cvv'                  => 'enable_csc',
					'cardtypes'            => 'card_types',
					'testmode'             => 'test_mode',
					'sslmerchantid'        => 'merchant_id',
					'ssluserid'            => 'user_id',
					'sslpin'               => 'pin',
					'demo_ssl_merchant_id' => 'demo_merchant_id',
					'demo_ssl_user_id'     => 'demo_user_id',
					'demo_ssl_pin'         => 'demo_pin',
				);

				foreach ( $updated_keys as $old_key => $new_key ) {

					if ( isset( $settings[ $old_key ] ) ) {

						$value = $settings[ $old_key ];

						unset( $settings[ $old_key ] );

					} elseif ( isset( $settings_fields[ $new_key ]['default'] ) ) {

						$value = $settings_fields[ $new_key ]['default'];
					}

					$settings[ $new_key ] = $value;
				}

				// the remaining settings need a little massaging
				$settings['environment']      = isset( $settings['account'] ) && 'demo' === $settings['account'] ? \WC_Gateway_Elavon_Converge::ENVIRONMENT_DEMO : \WC_Gateway_Elavon_Converge::ENVIRONMENT_PRODUCTION;
				$settings['transaction_type'] = isset( $settings['settlement'] ) && 'yes' === $settings['settlement'] ? \WC_Gateway_Elavon_Converge::TRANSACTION_TYPE_CHARGE : \WC_Gateway_Elavon_Converge::TRANSACTION_TYPE_AUTHORIZATION;

				// remove old settings
				unset( $settings['account'], $settings['settlement'] );

				$settings['inherit_settings'] = 'no';

				// we're only concerned about the credit card gateway settings
				// since the eCheck gateway didn't exist prior to 2.0.0
				update_option( 'woocommerce_' . \WC_Elavon_Converge::PLUGIN_ID . '_settings', $settings );

				delete_option( 'woocommerce_' . \WC_Elavon_Converge::PLUGIN_ID . '_settings' );

				$this->get_plugin()->log( 'Settings updated' );
			}

			global $wpdb;

			/** Update meta values for order payment method */

			// meta key: _payment_method
			// old value: elavon_vm
			// new value: elavon_converge_credit_card
			$rows = $wpdb->update( $wpdb->postmeta, array( 'meta_value' => \WC_Elavon_Converge::PLUGIN_ID ), array( 'meta_key' => '_payment_method', 'meta_value' => \WC_Elavon_Converge::PLUGIN_ID ) );

			$this->get_plugin()->log( sprintf( '%d orders updated for payment method meta', $rows ) );

			// upgrade complete
			$this->get_plugin()->log( sprintf( 'Finished upgrading from %1$s to %2$s', $installed_version, '2.0.0' ) );
		}

	}

}
