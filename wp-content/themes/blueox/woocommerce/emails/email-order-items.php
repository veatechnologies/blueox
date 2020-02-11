<?php
/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$text_align  = is_rtl() ? 'right' : 'left';
$margin_side = is_rtl() ? 'left' : 'right';

foreach ( $items as $item_id => $item ) :
	$product       = $item->get_product();
	$sku           = '';
	$purchase_note = '';
	$image         = '';

	if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		continue;
	}

	if ( is_object( $product ) ) {
		$sku           = $product->get_sku();
		$purchase_note = $product->get_purchase_note();
		$image         = $product->get_image( $image_size );
	}

	?>

  <tr>
                                  <td style=" padding: 0 32px; ">
                                           <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="margin-bottom:5px;  border-bottom:1px solid #bfbfbf; padding-bottom: 20px; border-top: 1px solid #bfbfbf;">
                                                            
												<tr>
          <td style="width: 30%;border-bottom:1px solid #bfbfbf; padding-bottom: 20px;padding-top:20px;  ">
		<div style="border: 1px solid #bfbfbf; width: 90px; height: 90px;    padding: 20px;">
                                                                        
																	<?php if ( $show_image ) {
																				////echo wp_kses_post( apply_filters( 'woocommerce_order_item_thumbnail', $image, $item ) );
																	echo '<img  height="32" width="32" style="width: 100%; max-width: 100%; height: auto; display:inline-block;" src="'. get_site_url() . ( $product->get_image_id() ? current( wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' ) ) : wc_placeholder_img_src() ) . '" alt="' . esc_attr__( 'Product image', 'woocommerce' ) . '" height="' . esc_attr( $image_size[1] ) . '" width="' . esc_attr( $image_size[0] ) . '" style="width: 100%; max-width: 100%; height: auto; display:inline-block;" />'; 

																			} ?>


                                                                    </div>
                                                                </td>
 <td style="width: 70%; border-bottom:1px solid #bfbfbf; padding-bottom: 20px; padding-top:20px; " valign="top">
                                                 <div style="max-width: 67.66%; float: left;">
     <div style="color:#002d62; font-weight: bold; padding-bottom: 10px;">
	 <?php echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) ); ?> </div>
                                                                      <?php  if ( $show_sku && $sku ) { ?>
<div style="color:#002d62;  padding-bottom: 30px;"> <?php echo wp_kses_post( ' (#' . $sku . ')' ); ?> </div>
													<?php	} ?>
                    <div style="font-weight: bold; color:#002d62;"><span><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
																</span></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>



	<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
		<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word;">
		<?php

		// Show title/image etc.
		/*if ( $show_image ) {
			////echo wp_kses_post( apply_filters( 'woocommerce_order_item_thumbnail', $image, $item ) );
/*echo apply_filters( 'woocommerce_order_item_thumbnail', '<img src="' . ( $product->get_image_id() ? 
current( wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail') ) : wc_placeholder_img_src() ) .'" alt="' 
. __( 'Product Image', 'woocommerce' ) . '" height="' . esc_attr( $image_size[1] ) . '" width="' . 
esc_attr( $image_size[0] ) . '" style="vertical-align:middle; margin-right: 10px;" />', $item );*/


////echo apply_filters( 'woocommerce_order_item_thumbnail', '<div style="margin-bottom: 5px"><img src="' . ( $product->get_image_id() ? current( wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' ) ) : wc_placeholder_img_src() ) . '" alt="' . esc_attr__( 'Product image', 'woocommerce' ) . '" height="' . esc_attr( $image_size[1] ) . '" width="' . esc_attr( $image_size[0] ) . '" style="vertical-align:middle; margin-' . ( is_rtl() ? 'left' : 'right' ) . ': 10px;" /></div>', $item ); 
//echo '<div style="border: 1px solid #bfbfbf; width: 90px; height: 90px;    padding: 20px;"><img  height="32" width="32" style="width: 100%; max-width: 100%; height: auto; display:inline-block;" src="'. get_site_url() . ( $product->get_image_id() ? current( wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' ) ) : wc_placeholder_img_src() ) . '" alt="' . esc_attr__( 'Product image', 'woocommerce' ) . '" height="' . esc_attr( $image_size[1] ) . '" width="' . esc_attr( $image_size[0] ) . '" style="vertical-align:middle; margin-' . ( is_rtl() ? 'left' : 'right' ) . ': 10px;" /></div>'; 


			
		// }

		// Product name.
		//echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );

		// SKU.
		/*if ( $show_sku && $sku ) {
			echo wp_kses_post( ' (#' . $sku . ')' );
		}*/

		// allow other plugins to add additional product information here.
		do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text );

		wc_display_item_meta(
			$item,
			array(
				'label_before' => '<strong class="wc-item-meta-label" style="float: ' . esc_attr( $text_align ) . '; margin-' . esc_attr( $margin_side ) . ': .25em; clear: both">',
			)
		);

		// allow other plugins to add additional product information here.
		do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text );?>
	<?php //echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>

		
		</td>
		<!--<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
			<?php
			$qty          = $item->get_quantity();
			$refunded_qty = $order->get_qty_refunded_for_item( $item_id );

			/*if ( $refunded_qty ) {
				$qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
			} else {
				$qty_display = esc_html( $qty );
			}
			echo wp_kses_post( apply_filters( 'woocommerce_email_order_item_quantity', $qty_display, $item ) );
			*/ ?>
		</td>-->
		<!--<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
			
		</td>-->
	</tr>
	<?php

	if ( $show_purchase_note && $purchase_note ) {
		?>
		<tr>
			<td colspan="3" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
				<?php
				echo wp_kses_post( wpautop( do_shortcode( $purchase_note ) ) );
				?>
			</td>
		</tr>
		<?php
	}
	?>

<?php endforeach; ?>
