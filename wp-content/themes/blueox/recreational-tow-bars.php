<?php
/*
 * Template Name: Services
 */
get_header();
$cat_products_title = get_field('product_listing_from_category_title');
?>
<div class="contentBlock-wrapper">
    <div class="text-center titleBar">
        <h1><?php the_field('page_title'); ?></h2>
            <h3><?php the_field('subtitle'); ?></h3>
    </div>
    <div class="threeCta">
        <?php
        $loop = 0;
        $i    = 0;
        $rows = get_field('three_column_cta');
        if ($rows) {
            foreach ($rows as $row) {
                ?>
                <div class="ctaBlock">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['image_alter_text']; ?>">
                    <?php echo $row['contents']; ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="contentBlock pb-0">
        <?php the_field('middle_content'); ?>
    </div>
    <?php if (get_field('three_column_bottom_cta')): ?>
        <div class="threeCta">
            <?php
            $loop = 0;
            $i    = 0;
            $rows = get_field('three_column_bottom_cta');
            if ($rows) {
                foreach ($rows as $row) {
                    ?>
                    <div class="ctaBlock">
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['image_alter_text']; ?>">
                        <?php echo $row['contents']; ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    <?php endif; ?>
    <?php /*
    <div class="vehicleWeight">
        <h2><?php the_field('vehicle_weight_block_title'); ?></h2>
        <div class="form">
            <?php if (is_active_sidebar('sidebar-swaypro-new')) { ?>
                <div class="col-sm-4">
                    <?php dynamic_sidebar('sidebar-swaypro-new'); ?>
                </div>
            <?php } ?>
            <!--<button class="goBtn">Go.</button>-->
        </div>
    </div>
    
    <div class="vehicleWeightText text-center">
        <?php the_field('vehicle_weight_block_text'); ?>
    </div>
    
    <section id="swayproTop" class="baseplates mb-5 pb-5">
        
        <div class="container">
            <div class="row">
                <?php if (is_active_sidebar('sidebar-swaypro-new')) { ?>
                    <div class="col-sm-4">
                        <?php dynamic_sidebar('sidebar-swaypro-new'); ?>
                    </div>
                <?php } ?>

            </div>
        </div>
          <div class="container">
          <div class="row">
          <div class="col-md-5 offset-md-1">
          <h5 class="text-blue font-gotham-black">Or Search by Blue Ox&reg; Part Number</h5>
          </div>
          <div class="col-md-5">
          <?php echo do_shortcode('[woocommerce_product_search]'); ?>
          </div>
          </div>
          </div>
          <?php */ ?>
          <?php /*
        <div id="baseplates" class="container mt-1">
            <div class="row">
                <div class="col-md-12">
                    <p><a id="scrollResults" href="#baseplates">Hide Products <i class="fas fa-chevron-up"></i></a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php //echo do_shortcode('[woocommerce_product_filter_context taxonomy="product_cat" term="swaypro"]'); ?>
                    <?php echo do_shortcode('[woocommerce_product_filter_products columns="3" per_page="9" show_pagination="true" orderby="name" show_catalog_ordering="no" show_result_count="yes"]'); ?>
                </div>
            </div>
        </d iv>
         
    </section>
    */?>
    <?php if ( !empty ( $cat_products_title ) ) { ?>
            <div class="contentBlock reduce-top">
                <h2><?php echo $cat_products_title; ?></h2>
            </div>
    <?php } ?>
    <section id="swayproTop" class="baseplates mb-5 pb-5">
        <div id="baseplates" class="container mt-1">
            <div class="row">
                <div class="col-md-12">
                    <?php //echo do_shortcode('[woocommerce_product_filter_context taxonomy="product_cat" term="swaypro"]'); ?>
                    <?php echo do_shortcode('[woocommerce_product_filter_products taxonomy="product_cat" columns="3" show_pagination="false" orderby="name" show_catalog_ordering="no" show_result_count="false"]'); ?>
                </div>
            </div>
        </div>
         
    </section>
    <div class="contentBlock reduce-top">
        <?php the_field('bottom_content'); ?>
    </div>
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