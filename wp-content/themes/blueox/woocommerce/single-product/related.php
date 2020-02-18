<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $product;
if(!empty(the_content())){
?>

<div class="paragraph">
	<?php
	the_content();
		
	?> 
	</div>

<?php }

$product_id= get_post_meta(get_the_ID(),'product_id',true);
$product_ids = str_replace(',', '', $product_id);
$product_values = str_replace(' ', '', $product_ids);

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();




if(is_numeric($product_values)){ ?>
<div class="additional-product-wrap">
<?php 
	$values= explode(',',$product_id);
    $args = array('post_type'      => 'product','posts_per_page' => -1,'post__in' => $values, );
	$loop = new WP_Query( $args );
	//$product = new WC_Product( $post->ID );
	
	
	?>
	<h3>This item requires additional parts for install</h3>
	<div class="additional-product-block">
	<?php
    while ( $loop->have_posts() ) : $loop->the_post();
	$price = get_post_meta( get_the_ID(), '_regular_price', true);	
	$price_unit = get_woocommerce_currency_symbol();
	
	?>
	
	<div class="additional-product-item">
	<?php 
	echo '<div class="additional-product-info"><h5><a href="'.get_permalink().'" class="product_title">'.get_the_title().'</a></h5></div>';
	echo '<div class="additional-product-img"><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().'</a><h5>'.$price_unit."".$price.'</h5></div>';
	
	

	?>
	</div>
	<?php 
    endwhile;
	wp_reset_query();
	
?>
	</div>
</div>

<?php } 

?>
	
<?php
if ( $related_products ) : ?>

	<section class="related-products recommended">
		<div class="recommededHeading">
			<!--<span><?php echo wc_get_product_category_list( $product->get_id() ); ?></span>-->
			<h2><?php esc_html_e( 'Related products', 'woocommerce' ); ?></h2>

			<?php woocommerce_product_loop_start(); ?>
				<div class="slider multiple-items">
				<?php foreach ( $related_products as $related_product ) : ?>
					<div class="recommededProduct">
					<?php
						$post_object = get_post( $related_product->get_id() );

						setup_postdata( $GLOBALS['post'] =& $post_object );

						wc_get_template_part( 'content', 'product' ); ?>
					</div>
					
					
				<?php endforeach; ?>
				</div>
			<?php woocommerce_product_loop_end(); ?>
		</div>

	</section>

<?php endif;

wp_reset_postdata();
