<?php
/**
 * Customer on-hold order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-on-hold-order.php.
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

defined( 'ABSPATH' ) || exit;

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
 
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<!--<p><?php //printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>-->
<!--<p><?php //esc_html_e( 'Thanks for your order. It’s on-hold until we confirm that payment has been received. In the meantime, here’s a reminder of what you ordered:', 'woocommerce' ); ?></p>-->

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
		<p><span style="text-transform: uppercase;"><strong><?php esc_html_e( 'Order #', 'woocommerce' ); ?></span>: &nbsp;</strong><span class="text-underline"><?php echo $order->get_order_number();?></span></p>
		<p><span style="text-transform: uppercase;"><strong><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>:&nbsp;</strong><span><?php echo $order->get_formatted_order_total(); ?></span></p>
		
		</div>


<?php 		

//to get the product name and image
			echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$order,
				array(
					'show_sku'      => false,
					'show_image'    => true,
					'image_size'    => array( 32, 32 ),
					'plain_text'    => $plain_text,
					'sent_to_admin' => $sent_to_admin,
				)
			);
		



// to get the billing details 
?>

 <table id="m_-7619290845504351853m_-5752730803274925178addresses" cellspacing="0" cellpadding="0" border="0" style="padding-top: 0px !IMPORTANT;width:100%;vertical-align:top;padding:0; padding-top: 20px;">
 <tbody>
 <tr>
 <td valign="top" width="50%" style="text-align:left;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;border:0;padding:0; padding-top:0px;">
 <address class="order_onhold" style="color:#002d62; line-height: 25px;">
<?php do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email ); ?> </address>
 </td>
 </tr>
 </tbody>
</table>
			



		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" >
	
    		<tbody>
				
			<?php
			$item_totals = $order->get_order_item_totals();

			if ( $item_totals ) {
				$i = 0;
				
				?>
				
				<tr>
				<td>
				<table style="width:100%;text-align: left;">
				<tbody>
				<?php
				foreach ( $item_totals as $total ) {
					$i++;
					?>
					<tr><td align="right" style="padding-bottom:10px">
					<div style="max-width:300px;text-align: left;">
						<span style="display: inline-block; padding-right: 32px; color:#002d62;text-transform: uppercase;font-weight: bold; text-align: left;"><?php echo wp_kses_post( $total['label'] ); ?> </span>
						<span style="color:#002d62; float: right;"><?php echo wp_kses_post( $total['value'] ); ?></span>
					</div></td></tr>				
					
					
				
					<?php
				}
				?>
				<tbody>
				</table>
				</td>
				</tr>
				
				
				
				
				<?php
			}
		
			?>

				 </tbody>
 			 </table>

<?php
/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */

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
