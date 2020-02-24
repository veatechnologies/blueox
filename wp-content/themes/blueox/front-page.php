<?php

/* Front Page */

get_header();

?>

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

<?php get_footer(); ?>
