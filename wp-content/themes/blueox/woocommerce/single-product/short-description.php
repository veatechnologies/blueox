<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post, $product;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
	return;
}

?>
<div class="woocommerce-product-details__short-description">
<?php echo $short_description; // WPCS: XSS ok.

// For Attributes
$class = $product->get_attribute( 'class' );
$baseplate_year = $product->get_attribute( 'baseplate_year' );
$make = $product->get_attribute( 'make' );
$material = $product->get_attribute( 'material' );
$models = $product->get_attribute( 'models' );
$weight = $product->get_attribute( 'weight' );

if(!empty($class)){?><p class="product-attributes-parent"> <span class="product-attributes"> Class: </span><?php echo $class;?>
</p><?php }
if(!empty($baseplate_year)){?><p class="product-attributes-parent"> <span class="product-attributes"> Year: </span> 
<?php echo $baseplate_year;?></p> <?php }
if(!empty($make)){?><p class="product-attributes-parent"><span class="product-attributes"> Make: </span><?php echo $make;?> </p><?php } 
if(!empty($material)){?><p class="product-attributes-parent"><span class="product-attributes"> Material: </span> <?php echo $material ?></p> <?php } 
if(!empty($models)){?><p class="product-attributes-parent"><span class="product-attributes"> Model: <?php echo $models;?> </p><?php }
if(!empty($weight)){?><p class="product-attributes-parent"><span class="product-attributes"> Weight: <?php echo $weight;?></p> <?php }

//For Install instruction

$productID = $product->get_id();
$install_instruction_pdf= get_field('install_instruction', $productID);
$warrenty= get_field('warrenty', $productID);
if(!empty($install_instruction_pdf)){ ?>
	<a class="install-instruction-link" target="_blank" href="<?php echo $install_instruction_pdf; ?>">installation instruction</a>
	<?php }
if(!empty($warrenty)){ ?>
	<a class="warrenty-link" target="_blank" href="<?php echo $warrenty; ?>">warrenty</a>
	<?php }
	?>

</div>

