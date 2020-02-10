<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<!--<p><?php //printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>-->
<?php /* translators: %s: Site title */ ?>
<!--<p><?php //esc_html_e( 'We have finished processing your order.', 'woocommerce' ); ?></p>-->
<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
//do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

?>
		<div class="col mb-4 pb-3">
		<p><span><strong><?php esc_html_e( 'Order #', 'woocommerce' ); ?>: &nbsp;<strong></span><span class="text-underline"><?php echo $order->get_order_number();?></span></p>
		<p><span><strong><?php esc_html_e( 'Total', 'woocommerce' ); ?>: &nbsp;</strong></span><span><?php echo $order->get_formatted_order_total(); ?></span></p>
		<p><span><strong><?php esc_html_e( 'Shipping', 'woocommerce' ); ?>:  &nbsp;</strong></span><span class="font-weight-bold">Delivered</span></p>
		</div>
				
	
		<?php
			echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$order,
				array(
					'show_sku'      => false,
					'show_image'    => true,
					'image_size'    => array(64, 64 ),
					'plain_text'    => $plain_text,
					'sent_to_admin' => $sent_to_admin,
				)
			);
			
			

			$item_totals = $order->get_order_item_totals();

			if ( $item_totals && $show_image) {
				$i = 0;
				foreach ( $item_totals as $total ) {
					$i++;
					?>
					<div class="final-Products">
						<?php 
						echo '<div class="product-thumbnail"><img src="'. get_site_url() . ( $product->get_image_id() ? current( wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' ) ) : wc_placeholder_img_src() ) . '" alt="' . esc_attr__( 'Product image', 'woocommerce' ) . '" height="' . esc_attr( $image_size[1] ) . '" width="' . esc_attr( $image_size[0] ) . '" style="vertical-align:middle; margin-' . ( is_rtl() ? 'left' : 'right' ) . ': 10px;" /></div>'; ?> 

						<div class="cart-product-info">
								<div class="product-name" data-title="Product">
									<div class="productQuantity"><?php echo wp_kses_post( $total['label'] ); ?></div>
									<div class="productTitle">SKU-SKUHERE</div>
								</div>
								<div class="productPrice"><?php echo wp_kses_post( $total['value'] ); ?></div>
							
						</div>
					</div>
					<?php
				}
			}
		
			?>

<?php

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
