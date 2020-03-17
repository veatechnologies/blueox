<?php
/**
* Baseplate Module
*/

$title = get_sub_field('title');
$align = get_sub_field('text_align');
$content = get_sub_field('content');
$finder = get_sub_field('show_baseplate');
?>

<section id="baseplatesTop" class="baseplates mt-5 mb-5 pt-5 pb-5">

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

                <?php if ( is_active_sidebar( 'sidebar-baseplate-1' ) ) { ?>

                    <div class="col-sm-4">

                        <?php dynamic_sidebar( 'sidebar-baseplate-1' ); ?>

                    </div>

                <?php } ?>

                <?php if ( is_active_sidebar( 'sidebar-baseplate-2' ) ) { ?>

                    <div class="col-sm-4">

                        <?php dynamic_sidebar( 'sidebar-baseplate-2' ); ?>

                    </div>

                <?php } ?>

                <?php if ( is_active_sidebar( 'sidebar-baseplate-3' ) ) { ?>

                    <div class="col-sm-4">

                        <?php dynamic_sidebar( 'sidebar-baseplate-3' ); ?>

                    </div>

                <?php } ?>

            </div>

        </div>

        <div class="container">

            <div class="row">

                <div class="col-md-5 offset-md-1">

                    <h5 class="text-blue font-gotham-black">Or Search by Blue Ox&reg; Part Number</h5>

                    <p><a id="scrollResults" href="#baseplates">Scroll to Results <i class="fas fa-chevron-down"></i></a></p>

                </div>

                <div class="col-md-5">

                    <?php echo do_shortcode('[woocommerce_product_search]'); ?>

                </div>

            </div>

        </div>

    <?php } ?>

</section>
