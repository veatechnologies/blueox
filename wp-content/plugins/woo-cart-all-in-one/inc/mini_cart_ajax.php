<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vi_WCAIO_Cart_AJAX {

	public static function init() {
		add_filter( 'woocommerce_add_to_cart_fragments', array( __CLASS__, 'wc_mini_cart_ajax_refresh' ) );
		self::add_ajax_events();
	}

	public static function add_ajax_events() {
		$ajax_events = array(
			'vi_wcaio_change_quantity' => true,
			'vi_wcaio_add_to_cart'     => true,
			'vi_wcaio_remove_item'     => true,
			'vi_wcaio_apply_coupon'    => true,
			'vi_wcaio_show_variation'  => true,
		);
		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_woocommerce_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_woocommerce_' . $ajax_event, array( __CLASS__, $ajax_event ) );
				// WC AJAX can be used for frontend ajax requests
				add_action( 'wc_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}


	public static function wc_mini_cart_ajax_refresh( $fragments ) {
		WC()->cart->calculate_totals();
		$total    = WC()->cart->get_total();
		$subtotal = WC()->cart->get_cart_subtotal();
		$count    = WC()->cart->get_cart_contents_count();
		ob_start();
		$list = new VI_WOO_CART_ALL_IN_ONE_Frontend_MiniCart();
		$list->get_list_products_in_cart();
		$list_pro = ob_get_clean();

		ob_start();
		wc_print_notices();
		$notice = ob_get_clean();

		$fragments['vi_wcaio'] = array(
			'total'       => $total,
			'subtotal'    => $subtotal,
			'total_items' => $count,
			'notice'      => $notice,
		);


		ob_start();
		$menu      = new VI_WOO_CART_ALL_IN_ONE_DATA();
		$menu_data = array(
			'menu_cart_style'           => $menu->get_params( 'menu_cart_style' ),
			'menu_cart_style_one_price' => $menu->get_params( 'menu_cart_style_one_price' ),
			'menu_cart_style_one_text'  => $menu->get_params( 'menu_cart_style_one_text' ),
		);
		if ( $menu_data['menu_cart_style_one_price'] == 'total' ) {

			$menu_total = WC()->cart->get_cart_total();
		} else {

			$menu_total = WC()->cart->get_cart_subtotal();
		}
		if ( $menu_data['menu_cart_style'] == 1 ) {
			if ( $menu_data['menu_cart_style_one_text'] == 'product_counter' ) {
				echo $count;
			} elseif ( $menu_data['menu_cart_style_one_text'] == 'price' ) {
				echo $menu_total;
			} elseif ( $menu_data['menu_cart_style_one_text'] == 'all' ) {
				echo $count . ' - ' . $menu_total;
			}
		}
		$menu_cart = ob_get_clean();


		$fragments['.vi_wcaio_menu_cart_text_one'] = '<span class="vi_wcaio_menu_cart_text_one">' . $menu_cart . '</span>';

		$fragments['.vi_wcaio_mini_cart_sidebar_icon_count']        = '<div class="vi_wcaio_mini_cart_sidebar_icon_count">' . $count . '</div>';
		$fragments['#vi_wcaio_mini_cart_sidebar_subtotal_currency'] = '<div id="vi_wcaio_mini_cart_sidebar_subtotal_currency">' . $subtotal . '</div>';
		$fragments['#vi_wcaio_mini_cart_sidebar_total_currency']    = '<div id="vi_wcaio_mini_cart_sidebar_total_currency">' . $total . '</div>';
		$fragments['.vi_wcaio_mini_cart_sidebar_list_products']     = ' <ul class="vi_wcaio_mini_cart_sidebar_list_products">' . $list_pro . '</ul>';

		return $fragments;
	}

	public static function vi_wcaio_change_quantity() {
		$product_info = isset( $_POST['product_info'] ) ? array_map( 'sanitize_text_field',
			$_POST['product_info'] ) : array();
		if ( ! empty( $product_info ) ) {
			foreach ( $product_info as $info => $value ) {
				WC()->cart->set_quantity( strval( $info ), intval( $value ), true );

			}

			WC()->cart->calculate_totals();
			WC_AJAX:: get_refreshed_fragments();
		}
		die();
	}


	public static function vi_wcaio_add_to_cart() {

		WC_AJAX:: get_refreshed_fragments();
		die();
	}

	public static function vi_wcaio_remove_item() {
		ob_start();
		$cart_item_key = isset( $_POST['cart_item_key'] ) ? sanitize_text_field( $_POST['cart_item_key'] ) : '';
		if ( ! empty( $cart_item_key ) ) {
			WC()->cart->remove_cart_item( $cart_item_key );
			WC_AJAX:: get_refreshed_fragments();
		}
		die();
	}

	public static function vi_wcaio_apply_coupon() {
		$coupon_code = isset( $_POST['coupon_code_apply'] ) ? sanitize_text_field( $_POST['coupon_code_apply'] ) : '';
		if ( ! empty( $coupon_code ) ) {

			WC()->cart->add_discount( $coupon_code );

			WC()->cart->calculate_totals();
			WC()->cart->maybe_set_cart_cookies();
			WC_AJAX:: get_refreshed_fragments();
		}
		die();
	}

	public static function vi_wcaio_show_variation() {
		$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';
		$result     = array(
			'status' => '',
			'url'    => '',
			'html'   => '',
		);
		if ( $product_id ) {
			$product = wc_get_product( $product_id );
			if ( $product->is_type( 'variable' ) ) {
				if ( $product->is_in_stock() ) {
					$available_variations = $product->get_available_variations();
					if ( empty( $available_variations ) && false !== $available_variations ) {
						$result['status'] = 'error';
						$result['url']    = esc_attr( esc_url( $product->get_permalink() ) );
						wp_send_json( $result );
					} else {
						$attributes = $product->get_variation_attributes();
						$min_value  = $product->get_min_purchase_quantity() > 0 ? $product->get_min_purchase_quantity() : "";
						$max_value  = $product->get_max_purchase_quantity() > 0 ? $product->get_max_purchase_quantity() : "";
						ob_start();
						?>
                        <div class="vi_wcaio_variation">
                            <div class="vi_wcaio_variation_container">
                                <div class="vi_wcaio_variation_content">
                                    <form class="variations_form cart"
                                          action="<?php echo esc_attr( esc_url( apply_filters( 'woocommerce_add_to_cart_form_action',
										      $product->get_permalink() ) ) ) ?>"
                                          method="post" enctype="multipart/form-data"
                                          data-product_id="<?php echo absint( $product->get_id() ); ?>">
                                        <table class="variations" cellspacing="0">
                                            <tbody>
											<?php
											foreach ( $attributes as $attribute_name => $options ) {
												?>
                                                <tr>
                                                    <td class="label"><label
                                                                for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok.
															?></label></td>
                                                    <td class="value">
														<?php
														wc_dropdown_variation_attribute_options( array(
															'options'   => $options,
															'attribute' => $attribute_name,
															'product'   => $product,
														) );
														//													    echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
														?>
                                                    </td>
                                                </tr>
												<?php
											}
											?>
                                            </tbody>
                                        </table>
                                        <div class="vi_wcaio_variation_quantity">
                                            <div class="vi_wcaio_variation-quantity-subtract">
                                                <span class="dashicons dashicons-arrow-left-alt2"></span>
                                            </div>
                                            <div>
                                                <input type="text"
                                                       class="input-text text vi_wcaio_variation-quantity-input "
                                                       step="1"
                                                       min="<?php echo esc_attr( $min_value ); ?>"
                                                       max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
                                                       pattern="[0-9]*"
                                                       title="Qty" size="4"
                                                       name="quantity"
                                                       inputmode="numeric"
                                                       value="1"/>
                                            </div>
                                            <div class="vi_wcaio_variation-quantity-add">
                                                <span class="dashicons dashicons-arrow-right-alt2"></span>
                                            </div>
                                        </div>

                                        <div class="vi_wcaio_variation_submit">
                                            <button type="button"
                                                    class=" vi_wcaio_variation_add_to_cart_cancel button ">
												<?php esc_html_e( 'Close', 'woo-cart-all-in-one' ) ?>
                                            </button>
                                            <button type="submit"
                                                    class="single_add_to_cart_button vi_wcaio_variation_add_to_cart button alt  wc-variation-selection-needed">
												<?php esc_html_e( ' Add to Cart', 'woo-cart-all-in-one' ) ?>
                                            </button>
                                            <input type="hidden" name="add-to-cart"
                                                   value="<?php echo absint( $product->get_id() ); ?>"/>
                                            <input type="hidden" name="product_id"
                                                   value="<?php echo absint( $product->get_id() ); ?>"/>
                                            <input type="hidden" name="variation_id" class="variation_id" value="0"/>

                                        </div>
                                    </form>
                                </div>
                                <div class="vi_wcaio_variation_bg"></div>
                            </div>
                        </div>
						<?php
						$html                           = ob_get_clean();
						$result['status']               = 'success';
						$result['available_variations'] = $available_variations;
						$result['html']                 = $html;
						wp_send_json( $result );
					}
				} else {
					$result['status'] = 'error';
					$result['url']    = esc_attr( esc_url( $product->get_permalink() ) );
					wp_send_json( $result );
				}
			}
		}

		die();
	}

}


