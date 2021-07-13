<?php
/*
 * Template Name: Product
 */
get_header();
$main_product = get_field('blueoxdev_select_main_product');
$rel_product = get_field('blueoxdev_other_products');
if ( !  empty( $main_product ) ){
    $main_product = $main_product[0];
    $main_product_OBJ = wc_get_product( $main_product );
    $main_product_img = get_the_post_thumbnail_url($main_product);
    $short_description = apply_filters( 'woocommerce_short_description', get_the_excerpt($main_product) );
    $args   = array (
        "post_type"      => 'product',
        "posts_per_page" => 1,
        'post__in'   => array($main_product),
    );
    $main_product_query = new WP_Query ( $args );
}
?>
<div class="contentBlock-wrapper">
    <div class="text-center titleBar">
        <h1><?php the_field('page_title'); ?></h2>
        <h3><?php the_field('subtitle'); ?></h3>
    </div>
    <?php if ( !empty ( $main_product ) ) { ?>
            <div class="productBlock custom_add_to_cart">
                <div class="productImage">
                    <img src="<?php echo $main_product_img; ?>" alt="">
                </div>
                <?php while( $main_product_query->have_posts() ) { $main_product_query->the_post() ?>
                        <div class="productInfo">
                            <h4><?php echo get_the_title($main_product); ?> <span><p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) );?>"><?php echo $main_product_OBJ->get_price_html(); ?></p></span></h4>
                            <?php echo $short_description; ?>
                            <?php woocommerce_template_single_add_to_cart(); ?>
                        </div>
                <?php } wp_reset_postdata(); wp_reset_query(); ?>
            </div>
    <?php } ?>
    <?php if ( !empty ( $rel_product ) ) { ?>
            <div class="related-products">
                <h2 class="text-center"><?php the_field('related_product_title'); ?></h2>
                <div class="related-products-grid">
                    <?php  
                    foreach ( $rel_product as $rel_product_val ) {
                            $args   = array (
                                "post_type"      => 'product',
                                "posts_per_page" => 1,
                                'post__in'   => array($rel_product_val),
                            );
                            $rel_product_query = new WP_Query ( $args );
                            while ( $rel_product_query->have_posts() ) {
                                $rel_product_query->the_post ();
                                $main_product_img  = get_the_post_thumbnail_url ();
                                $short_description = apply_filters ( 'woocommerce_short_description', wp_trim_words ( get_the_excerpt(), 30  ) );
                                $product_tagline   = get_field ( 'product_tagline' );
                                $main_product_OBJ  = wc_get_product( );
                                ?>
                                <div class="prodItem custom_add_to_cart">
                                    <img src="<?php echo $main_product_img; ?>" alt="">
                                    <h3><?php echo $product_tagline; ?></h3>
                                    <p><?php echo $short_description; ?></p>
                                    <h5><?php echo get_the_title(); ?> <span><p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) );?>"><?php echo $main_product_OBJ->get_price_html(); ?></p></span></h5>
                                    <?php woocommerce_template_single_add_to_cart(); ?>
                                    <!--<button type="submit" class="defaultBtn">Add to cart</button>-->
                                </div>
                <?php } wp_reset_postdata(); wp_reset_query(); }  ?>
                </div>
            </div>
    <?php } ?>
    <div class="localDealar">
        <div class="dealarImage">
            <img src="<?php the_field('local_dealer_block_image'); ?>" alt="<?php the_field('local_dealer_block_image_alt'); ?>">
        </div>
        <div class="localDealarContent">
            <h2><?php the_field('local_dealer_block_title'); ?></h2>
            <p><?php the_field('local_dealer_block_description'); ?></p>
            <a href="<?php the_field('local_dealer_block_button_link'); ?>" class="outlineBtn"><?php the_field('local_dealer_block_button_text'); ?></a>
        </div>
    </div>
</div>
<?php get_footer(); ?>