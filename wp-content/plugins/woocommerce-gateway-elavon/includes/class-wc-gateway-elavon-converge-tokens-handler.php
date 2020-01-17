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
 * @package     WC-Elavon/Gateway
 * @author      SkyVerge
 * @copyright   Copyright (c) 2013-2019, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_5_1 as Framework;

/**
 * Handles the payment tokenization related functionality.
 *
 * @since 2.3.2
 */
class WC_Gateway_Elavon_Converge_Tokens_Handler extends Framework\SV_WC_Payment_Gateway_Payment_Tokens_Handler {


	/**
	 * Returns a custom payment token class instance.
	 *
	 * @see Framework\SV_WC_Payment_Gateway_Payment_Tokens_Handler::build_token()
	 *
	 * @since 2.3.2
	 *
	 * @param string $token
	 * @param array $data
	 * @return \WC_Gateway_Elavon_Converge_Token
	 */
	public function build_token( $token, $data ) {

		return new WC_Gateway_Elavon_Converge_Token( $token, $data );
	}


	/**
	 * Overrides the default remove_token to allow smarter handling of token errors.
	 *
	 * This is copy-pasted from Framework\SV_WC_Payment_Gateway_Payment_Tokens_Handler
	 * in framework v5, and should be removed/refactored when upgrading this plugin to v5.
	 * TODO: Remove/refactor this function when upgrading to framework v5 {JB 2018-06-02}
	 *
	 * @see Framework\SV_WC_Payment_Gateway_Payment_Tokens_Handler::remove_token()
	 *
	 * @since 2.3.2
	 *
	 * @param int $user_id user identifier
	 * @param Framework\SV_WC_Payment_Gateway_Payment_Token|string $token the payment token to delete
	 * @param string $environment_id optional environment id, defaults to plugin current environment
	 * @return bool|int false if not deleted, updated user meta ID if deleted
	 */
	public function remove_token( $user_id, $token, $environment_id = null ) {

		// default to current environment
		if ( is_null( $environment_id ) ) {
			$environment_id = $this->get_environment_id();
		}

		// unknown token?
		if ( ! $this->user_has_token( $user_id, $token, $environment_id ) ) {
			return false;
		}

		// get the payment token object as needed
		if ( ! is_object( $token ) ) {
			$token = $this->get_token( $user_id, $token, $environment_id );
		}

		// for direct gateways that allow it, attempt to delete the token from the endpoint
		if ( $this->get_gateway()->get_api()->supports_remove_tokenized_payment_method() ) {

			try {

				$response = $this->get_gateway()->get_api()->remove_tokenized_payment_method( $token->get_id(), $this->get_gateway()->get_customer_id( $user_id, array( 'environment_id' => $environment_id ) ) );

				if ( ! $response->transaction_approved() ) {
					return false;
				}

			} catch ( Framework\SV_WC_Plugin_Exception $e ) {

				if ( $this->get_gateway()->debug_log() ) {
					$this->get_gateway()->get_plugin()->log( $e->getMessage(), $this->get_gateway()->get_id() );
				}

				// TODO: Refactor to be able to use should_delete_token() instead of relying on the exception code when upgrading to FW v5 {JB 2018-06-03}
				if ( 5085 !== $e->getCode() ) {
					return false;
				}
			}
		}

		return $this->delete_token( $user_id, $token );
	}


	/**
	 * Adds the billing_hash attribute to the list of attributes to merge between local and remote tokens.
	 *
	 * @see Framework\SV_WC_Payment_Gateway_Payment_Tokens_Handler::get_merge_attributes()
	 *
	 * @since 2.3.2
	 *
	 * @return array merge attributes
	 */
	protected function get_merge_attributes() {

		return array_merge( parent::get_merge_attributes(), array( 'billing_hash' ) );
	}


	/**
	 * Helper to get the billing data from an order for use in a token.
	 *
	 * @since 2.3.2
	 *
	 * @param \WC_Order $order
	 * @return array
	 */
	public static function get_billing_token_data_from_order( WC_Order $order ) {

		return array(
			'ssl_first_name'  => $order->get_billing_first_name( 'edit' ),
			'ssl_last_name'   => $order->get_billing_last_name( 'edit' ),
			'ssl_company'     => $order->get_billing_company( 'edit' ),
			'ssl_avs_address' => $order->get_billing_address_1( 'edit' ),
			'ssl_address2'    => $order->get_billing_address_2( 'edit' ),
			'ssl_city'        => $order->get_billing_city( 'edit' ),
			'ssl_state'       => $order->get_billing_state( 'edit' ),
			'ssl_country'     => $order->get_billing_country( 'edit' ),
			'ssl_avs_zip'     => $order->get_billing_postcode( 'edit' ),
			'ssl_phone'       => $order->get_billing_phone( 'edit' ),
			'ssl_email'       => $order->get_billing_email( 'edit' ),
		);
	}


}
