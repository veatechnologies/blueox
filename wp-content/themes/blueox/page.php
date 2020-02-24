<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Bootstrap_4
 */

get_header(); ?>

<?php if( have_rows('home_content') ) { ?>

    <?php while ( have_rows('home_content') ) { the_row(); ?>

        <?php if( get_row_layout() == 'cta' ) { ?>

            <?php get_template_part( 'modules/cta' ); ?>

        <?php } elseif( get_row_layout() == 'spit_cta' ) { ?>

            <?php get_template_part( 'modules/split' ); ?>

        <?php } elseif( get_row_layout() == 'categories' ) { ?>

            <?php get_template_part( 'modules/categories' ); ?>

        <?php } elseif( get_row_layout() == 'reviews' ) { ?>

            <?php get_template_part( 'modules/reviews' ); ?>

        <?php } elseif( get_row_layout() == 'videos' ) { ?>

            <?php get_template_part( 'modules/videos' ); ?>

        <?php } elseif( get_row_layout() == 'specialty' ) { ?>

            <?php get_template_part( 'modules/specialty' ); ?>

        <?php } elseif( get_row_layout() == 'hero' ) { ?>

            <?php get_template_part( 'modules/hero' ); ?>

        <?php } elseif( get_row_layout() == 'general' ) { ?>

            <?php get_template_part( 'modules/general' ); ?>

        <?php } elseif( get_row_layout() == 'full_width_image' ) { ?>

            <?php get_template_part( 'modules/image' ); ?>

        <?php } //endif; ?>

    <?php } //endwhile; ?>

<?php } else {  ?>

    <div class="container">

        <div class="row">

            <div id="primary" class="content-area">

                <main id="main" class="site-main">

                    <?php while ( have_posts() ) { the_post();

                        get_template_part( 'template-parts/content', 'page' );

                    } ?>

                </main><!-- #main -->

            </div><!-- #primary -->

        </div><!-- /.row -->

    </div><!-- /.container -->

<?php } ?>

<?php if( is_page('14454') ) { ?>
    <script>
    (function($) {
        //Get Job Title from URL and Sanitize
        var getURL = window.location + '';
        var data = getURL.split('=');
        var job = data[1];
        var saniJob = decodeURIComponent(job).replace(/\+/g, " ");

        // Add Job to input field
        $('#wpforms-14415-field_2').val(saniJob);

        // Append <h1> with Job Name
        $('.entry-title').append(' - ' + saniJob);
    })(jQuery);
    </script>
<?php } //endif is_page('14454') aka Application page ?>

<?php get_footer(); ?>
