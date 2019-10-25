<?php

if ( 'posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() );
} else {
    if ( ! is_page_template() ) {
        get_header();

        get_template_part( 'template-parts/front-page/cover' );
        get_template_part( 'template-parts/front-page/services' );

        ?>

    <?php } ?>

<?php } ?>

<?php if( have_rows('home_content') ) { ?>

    <?php while ( have_rows('home_content') ) { the_row(); ?>

        <?php if( get_row_layout() == 'cta' ) {
            $title = get_sub_field('title');
            $link = get_sub_field('button');
            $bg = get_sub_field('background_image');
            ?>

            <section class="home-cta<?php if( $bg ) { ?> b-lazy<?php } ?>" <?php if( $bg ) { ?>data-src="<?php echo $bg; ?>"<?php } ?>>

                <div class="container">

                    <div class="row">

                        <div class="col-md-8 offset-md-2">

                            <div class="home-cta-inner pt-5 pb-5">

                                <div class="d-flex flex-column align-middle">

                                    <?php if( $title ) { ?>

                                        <h1 class="font-gotham-medium text-white text-center"><?php echo $title; ?></h1>

                                    <?php } ?>

                                    <?php if( $link ) { ?>

                                        <div class="text-center mt-5">

                                            <a class="btn-white" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>

                                        </div>

                                    <?php } ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        <?php } elseif( get_row_layout() == 'categories' ) {
            $title = get_sub_field('title');
            ?>

            <section class="home-categories">

                <div class="container">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="home-categories-inner">

                                <?php if( $title ) { ?>

                                    <h2 class="font-gotham-medium text-center"><?php echo $title; ?></h2>

                                <?php } ?>

                                <div class="d-flex flex-column flex-md-row justify-content-md-around align-middle mt-5">

                                    <?php if( have_rows('category_box') ) { ?>

                                        <?php while( have_rows('category_box') ) { the_row();
                                            $img = get_sub_field('image');
                                            $link = get_sub_field('button');
                                            ?>

                                            <div class="home-categories-box text-center m-3">

                                                <?php if( $img ) { ?><p><img class="b-lazy" src="<?php bloginfo('template_directory'); ?>/assets/images/placeholder.png" data-src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>"></p><?php } ?>

                                                <?php if( $link ) { ?><p class="mt-5"><a class="btn-blue w-100 text-nowrap d-block" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a></p><?php } ?>

                                            </div>

                                        <?php } ?>

                                    <?php } ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        <?php } elseif( get_row_layout() == 'reviews' ) {
            $bg = get_sub_field('background_image');
            ?>

            <section class="home-reviews<?php if( $bg ) { ?> b-lazy<?php } ?>" <?php if( $bg ) { ?>data-src="<?php echo $bg; ?>"<?php } ?>>

                <div class="container">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="home-reviews-inner match-height">

                                <div class="d-flex flex-column flex-lg-row justify-content-md-around align-middle">

                                    <?php if( have_rows('review_box') ) { ?>

                                        <?php while( have_rows('review_box') ) { the_row();
                                            $name = get_sub_field('name');
                                            $loc = get_sub_field('location');
                                            $date =  get_sub_field('date');
                                            $star =  get_sub_field('star_review');
                                            $title = get_sub_field('title');
                                            $msg = get_sub_field('review_content');
                                            ?>

                                            <div class="home-reviews-box mt-3 mb-3 mr-md-3 ml-md-3">

                                                <?php if( $name ) { ?>

                                                    <p class="review-name mb-2"><?php echo $name; ?> <i class="fas fa-check-circle"></i></p>

                                                <?php } ?>

                                                <?php if( $date ) { ?>

                                                    <p class="review-date mb-2"><?php echo $date; ?></p>

                                                <?php } ?>

                                                <?php if( $loc ) { ?>

                                                    <p class="review-location mb-2"><?php echo $loc; ?></p>

                                                <?php } ?>

                                                <?php if( $star ) { ?>
                                                    <p class="review-star text-black">
                                                        <?php if( $star == 'one' ) {
                                                            echo '<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
                                                        } elseif( $star == 'two' ) {
                                                            echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
                                                        } elseif( $star == 'three' ) {
                                                            echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
                                                        } elseif( $star == 'four' ) {
                                                            echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>';
                                                        } elseif( $star == 'five' ) {
                                                            echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
                                                        } ?>
                                                    </p>

                                                <?php } ?>

                                                <?php if( $title ) { ?>
                                                    <p class="review-title font-gotham-medium text-uppercase mb-2"><?php echo $title; ?></p>
                                                <?php } ?>

                                                <?php if( $msg ) { ?>
                                                    <div class="review-msg">
                                                        <?php echo $msg; ?>
                                                    </div>
                                                <?php } ?>

                                            </div>

                                        <?php } ?>

                                    <?php } ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        <?php } elseif( get_row_layout() == 'videos' ) {
            $title = get_sub_field('title');
            $msg = get_sub_field('content');
            $img = get_sub_field('image');
            $vid = get_sub_field('yt_video');
            $link = get_sub_field('button');
            ?>

            <section class="home-videos">

                <div class="container">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="home-videos-inner">

                                <div class="d-flex flex-column flex-md-row justify-content-md-around align-middle">

                                    <div class="home-videos-box">

                                        <div class="position-relative mb-5">
                                            <img class="home-videos-img w-100 b-lazy" src="<?php bloginfo('template_directory'); ?>/assets/images/placeholder.png" data-src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>">
                                            <div class="home-videos-play position-absolute text-white">
                                                <a class="home-videos-play-button popup-youtube text-white" href="<?php echo $vid; ?>" ><i class="fas fa-play-circle fa-4x"></i></a>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="home-videos-box px-md-5">
                                        <?php if( $title ) { ?>
                                            <h2 class="text-white mb-3"><?php echo $title; ?></h2>
                                        <?php } ?>
                                        <?php if( $msg ) { ?>
                                            <div class="text-white mb-5">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php } ?>
                                        <?php if( $link ) { ?>
                                            <p class="mt-5"><a class="btn-white" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a></p>
                                        <?php } ?>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        <?php } //endif; ?>

    <?php } //endwhile; ?>

<?php } //endif; ?>

<?php get_footer(); ?>
