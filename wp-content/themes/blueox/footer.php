<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_4
 */
?>

</div><!-- #content -->

<?php if (is_front_page() && !is_home()) { ?>
    <?php
    if (get_field('affiliation_title', 'options') || get_field('affiliation_images')) {
        $title = get_field('affiliation_title', 'options');
        ?>
        <div class="footer-affilitions">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="footer-affiliations--inner">
                            <?php if ($title) { ?><h2 class="text-blue font-gotham-black"><?php echo $title; ?></h2><?php } ?>
                            <?php if (have_rows('affiliation_images', 'options')) { ?>
                                <div class="d-flex flex-column flex-sm-row justify-content-around align-middle">
                                    <?php
                                    while (have_rows('affiliation_images', 'options')) {
                                        the_row();
                                        $img = get_sub_field('affiliation_image');
                                        ?>
                                        <div class="text-center">
                                            <img src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>" width="200">
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<footer id="colophon" class="site-footer text-center bg-white mt-4 pt-5 text-muted">
    <section class="footer-widgets pt-3">
        <div class="container">
            <div class="row">
                <div class="footer-numbers social-media-big d-flex flex-wrap align-middle ">
                    <div class="col-md-12">
                        <a href="https://www.youtube.com/channel/UCf0xqsm0e4_A0jtSB1deOQw" target="_blank"><i class="fa fa-youtube-play"></i></a>
                        <a href="https://www.instagram.com/blueox_towing/?hl=en" target="_blank"><i class="fa fa-instagram"></i></a>
                        <a href="https://www.facebook.com/BlueOxProducts" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="https://twitter.com/BlueOxProducts" target="_blank"><i class="fa fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="footer-numbers d-flex flex-wrap align-middle ">
                    <div class="pl-5 pr-5">
                        <?php if (get_field('toll_free_phone', 'option')) { ?>
                            <?php $toll = preg_replace("/[^0-9]/", "", get_field('toll_free_phone', 'option')); ?>
                            <h3 class="d-inline-block text-nowrap"><span>Customer Care:</span> <a href="tel:1<?php echo $toll; ?>"><?php the_field('toll_free_phone', 'option'); ?></a></h3>
                        <?php } ?>
                        <?php if (get_field('hours', 'option')) { ?>
                            <h3 class="d-inline-block text-nowrap"><?php the_field('hours', 'option'); ?></h3>
                        <?php } ?>
                    </div>
                    <div class="pl-5 pr-5" style="width: 100%">
                        <?php if (get_field('order-status', 'option')) { ?>
                            <h3 class="d-inline-block text-nowrap"><span>Order Status: </span><a href="tel:<?php the_field('order-status', 'option'); ?>"><?php the_field('order-status', 'option'); ?></a></h3>
                        <?php } ?>
                    </div>
                    <div class="pl-5 pr-5">
                        <?php if (get_field('email-1', 'option')) { ?>
                            <h3 class="d-inline-block text-nowrap"><a href="mailto:<?php the_field('email-1', 'option'); ?>"><?php the_field('email-1', 'option'); ?></a></h3>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="footer-widgets text-left mb-5">
        <div class="container">
            <div class="row">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="w-100 w-md-25">
                        <aside class="widget-area footer-1-area mb-2">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </aside>
                    </div>
                <?php endif; ?>
                <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="w-100 w-md-25">
                        <aside class="widget-area footer-2-area mb-2">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </aside>
                    </div>
                <?php endif; ?>
                <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="w-100 w-md-25">
                        <aside class="widget-area footer-3-area mb-2">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </aside>
                    </div>
                <?php endif; ?>
                <?php if (is_active_sidebar('footer-4')) : ?>
                    <div class="w-100 w-md-25">
                        <aside class="widget-area footer-4-area mb-2">
                            <?php dynamic_sidebar('footer-4'); ?>
                        </aside>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <div class="footer-attr container-fluid">
        <div class="row">
            <div class="container">
                <div class="site-info row text-left pl-3 pr-3 pt-3 pb-3">
                    <div class="col-md-7 col-xs-12 copy-rgt-footer">
                        &copy; 2014 - <?php echo date('Y'); ?> <?php bloginfo('name'); ?><span class="sep"> | </span>All Rights Reserved<span class="sep"> | </span>Designed by <a class="designed-by" href="https://veatechnologies.com/" target="_blank" rel="nofollow">VEA Technologies</a>
                    </div>
                    <div class="col-md-5 col-xs-12 text-right social-icons-bot">
                        <a href="https://www.youtube.com/channel/UCf0xqsm0e4_A0jtSB1deOQw" target="_blank"><i class="fa fa-youtube-play"></i></a>
                        <a href="https://www.instagram.com/blueox_towing/?hl=en" target="_blank"><i class="fa fa-instagram"></i></a>
                        <a href="https://www.facebook.com/BlueOxProducts" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="https://twitter.com/BlueOxProducts" target="_blank"><i class="fa fa-twitter"></i></a>
                    </div>
                </div>
                <!-- .site-info -->
            </div>
        </div>
    </div>
    <!-- /.container -->
</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>
<?php if (get_field('footer-code', 'option')) { ?>
    <?php the_field('footer-code', 'option'); ?>
<?php } ?>
<!--Cart Count HTML-->
<div class="blueox_cart_floting" style="display: none">
    <i class="fa fa-shopping-cart"></i>
    <div class="blueox_cart_qty_wrap">
        <div class="blueox_cart_qty">0</div>
    </div>
</div>
<style>
    .social-media-big { width: 100%; padding-bottom: 1rem; } 
    .social-media-big i { font-size: 40px; padding: 0 40px; }
</style>
<!--Cart Count HTML-->
</body>
</html>
