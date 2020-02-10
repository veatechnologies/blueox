<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
global $post;

if ( is_product_category() ) {
		
		$queried_object = get_queried_object(); 
		$taxonomy = $queried_object->taxonomy;
		$term_id = $queried_object->term_id;  
		$foto = get_field( 'feature_image', $queried_object );
		$foto = get_field( 'feature_image', $taxonomy . '_' . $term_id );
		if( get_field('feature_image', $taxonomy . '_' . $term_id) ) {
			echo '<div class="cat-banner"><img src="' . $foto['url'] . '"/></div>';
		}
	}
	 
	/*if ( has_term( 'tow-bar', 'product_cat', $product->id ) ) {
	
	$queried_object = get_queried_object(); 
		$taxonomy = $queried_object->taxonomy;
		$term_id = $queried_object->term_id;  
		$foto = get_field( 'feature_image', $queried_object );
		$foto = get_field( 'feature_image', $taxonomy . '_' . $term_id );
		if( get_field('feature_image', $taxonomy . '_' . $term_id) ) {
			echo '<div class="cat-banner"><img src="' . $foto['url'] . '"/></div>';
		}
	 }*/

?>

<!--<img style="height:400px; width:100%;" src="<?php echo $image_src; ?>"/>-->
<?php

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

global $post;



?>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<!-- <h1 class="woocommerce-products-header__title page-title"><?php //woocommerce_page_title(); ?></h1> -->
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	//do_action( 'woocommerce_archive_description' );

	//get category id for products 
	
	$terms_post = get_the_terms( $post->cat_ID , 'product_cat' );
		foreach ($terms_post as $term_cat) { 
		$term_cat_id = $term_cat->term_id; 
	 }
		 $term_id= "product_cat_".$term_cat_id;
		 echo the_field('category_content',  $term_id);
		 
		  
 ?>

	
	           <div class="local-contact">
			   <div class="row">
			   <div class="col-md-4">
			   </div>
			   <div class="col-md-8">
			   
                            <div class="row d-flex align-items-center">
                                <div class="col-md-5">
                                    <h3 class="font-weight-bold">Need a local dealer?</h3>
                                    <p class="mb-0">There are 100s to choose from:</p>
                                </div>
                                <div class="col-md-7">
                                    <a class="btn-clear--blue" href="<?php echo get_site_url() ?>/dealer-locator/">Find A Dealer</a>
                                </div>
                            </div>
							</div>
                        </div>
	</div>				
</header>
<div class="product-category-wrap">
	<div class="product-category-filter">
		<?php 
			/**
			 * Hook: woocommerce_sidebar.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			//do_action( 'woocommerce_sidebar' );
			dynamic_sidebar('cart-items');
		?>
	</div>
	<div class="product-category-list">
		<?php
		if ( woocommerce_product_loop() ) {

			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked woocommerce_output_all_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			//do_action( 'woocommerce_before_shop_loop' );

			//woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Hook: woocommerce_shop_loop.
					 */
					do_action( 'woocommerce_shop_loop' ); ?>
				<div class="product-list-item">
						<div class="product-list-img">
					<?php
						/**
						 * Hook: woocommerce_before_shop_loop_item.
						 *
						 * @hooked woocommerce_template_loop_product_link_open - 10
						 */
						do_action( 'woocommerce_before_shop_loop_item' ); ?>
						<?php

						/**
						 * Hook: woocommerce_before_shop_loop_item_title.
						 *
						 * @hooked woocommerce_show_product_loop_sale_flash - 10
						 * @hooked woocommerce_template_loop_product_thumbnail - 10
						 */
						do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
						</div>
						<div class="product-list-content">
							<?php
								/**
								 * Hook: woocommerce_shop_loop_item_title.
								 *
								 * @hooked woocommerce_template_loop_product_title - 10
								 */
								do_action( 'woocommerce_shop_loop_item_title' );

								/**
								 * Hook: woocommerce_after_shop_loop_item_title.
								 *
								 * @hooked woocommerce_template_loop_rating - 5
								 * @hooked woocommerce_template_loop_price - 10
								 */
								do_action( 'woocommerce_after_shop_loop_item_title' );

								/**
								 * Hook: woocommerce_after_shop_loop_item.
								 *
								 * @hooked woocommerce_template_loop_product_link_close - 5
								 * @hooked woocommerce_template_loop_add_to_cart - 10
								 */
								do_action( 'woocommerce_after_shop_loop_item' );
								?>
								<div class="learn-btn">
									<a href="#" class="btn-blue">Learn More</a>
								</div>
						</div>
					</div>
			<?php	}
			}

			//woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
		}
		?>
	</div>
</div>
<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
//do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
