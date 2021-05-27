<?php

/**
* SwayPro Module
*/

$title = get_sub_field('title_swaypro');
$align = get_sub_field('text_align_swaypro');
$content = get_sub_field('content_swaypro');
$finder = get_sub_field('show_swaypro');
?>

<section id="swayproTop" class="baseplates mb-5 pb-5">

    <div class="container">

        <div class="row">

            <div class="col-md-12 <?php if( $align ) { echo $align['value']; } ?>">

                <?php if( $title ) { ?><h4 class="text-blue font-gotham-black mb-3"><?php echo $title; ?></h4><?php } ?>

                <?php if( $content ) { ?>

                    <div class="baseplates-inner">

                        <?php echo $content; ?>

                    </div>

                <?php } ?>

            </div>

        </div>

    </div>

    <?php if( $finder['value'] == 'show' ) { ?>

        <div class="container">

            <div class="row">

                <?php if ( is_active_sidebar( 'sidebar-swaypro-1' ) ) { ?>

                    <div class="col-sm-4">

                        <?php dynamic_sidebar( 'sidebar-swaypro-1' ); ?>

                    </div>

                <?php } ?>

                <?php if ( is_active_sidebar( 'sidebar-swaypro-2' ) ) { ?>

                    <div class="col-sm-4">

                        <?php dynamic_sidebar( 'sidebar-swaypro-2' ); ?>

                    </div>

                <?php } ?>

                <?php if ( is_active_sidebar( 'sidebar-swaypro-3' ) ) { ?>

                    <div class="col-sm-4">

                        <?php dynamic_sidebar( 'sidebar-swaypro-3' ); ?>

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

        <div id="baseplates" class="container mt-5">

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

        </div>

    <?php } ?>

</section>
