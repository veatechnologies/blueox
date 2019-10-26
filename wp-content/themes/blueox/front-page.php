<?php

/* Front Page */

get_header();

// Page Identifier
$id = 'home'; ?>

<?php if( have_rows('home_content') ) { ?>

    <?php while ( have_rows('home_content') ) { the_row(); ?>

        <?php if( get_row_layout() == 'cta' ) {
            $title = get_sub_field('title');
            $link = get_sub_field('button');
            $bg = get_sub_field('background_image');
            ?>

            <section class="<?php echo $id; ?>-cta <?php if( $bg ) { ?>b-lazy<?php } ?>" <?php if( $bg ) { ?>data-src="<?php echo $bg; ?>"<?php } ?>>

                <div class="container">

                    <div class="row">

                        <div class="col-md-8 offset-md-2">

                            <div class="<?php echo $id; ?>-cta-inner pt-5 pb-5">

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

            <section class="<?php echo $id; ?>-categories">

                <div class="container">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="<?php echo $id; ?>-categories-inner">

                                <?php if( $title ) { ?>

                                    <h2 class="font-gotham-medium text-center"><?php echo $title; ?></h2>

                                <?php } ?>

                                <div class="d-flex flex-column flex-md-row justify-content-md-around align-middle mt-5">

                                    <?php if( have_rows('category_box') ) { ?>

                                        <?php while( have_rows('category_box') ) { the_row();
                                            $img = get_sub_field('image');
                                            $link = get_sub_field('button');
                                            ?>

                                            <div class="<?php echo $id; ?>-categories-box text-center m-3">

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

            <section class="<?php echo $id; ?>-reviews <?php if( $bg ) { ?>b-lazy<?php } ?>" <?php if( $bg ) { ?>data-src="<?php echo $bg; ?>"<?php } ?>>

                <div class="container">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="<?php echo $id; ?>-reviews-inner match-height">

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

                                            <div class="<?php echo $id; ?>-reviews-box mt-3 mb-3 mr-md-3 ml-md-3">

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

            <section class="<?php echo $id; ?>-videos">

                <div class="container">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="<?php echo $id; ?>-videos-inner">

                                <div class="d-flex flex-column flex-md-row justify-content-md-around align-middle">

                                    <div class="<?php echo $id; ?>-videos-box">

                                        <div class="position-relative mb-5">
                                            <img class="<?php echo $id; ?>-videos-img w-100 b-lazy" src="<?php bloginfo('template_directory'); ?>/assets/images/placeholder.png" data-src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>">
                                            <div class="<?php echo $id; ?>-videos-play position-absolute text-white">
                                                <a class="<?php echo $id; ?>-videos-play-button popup-youtube text-white" href="<?php echo $vid; ?>" ><i class="fas fa-play-circle fa-4x"></i></a>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="<?php echo $id; ?>-videos-box px-md-5">
                                        <?php if( $title ) { ?>
                                            <h2 class="font-gotham-medium text-white mb-3"><?php echo $title; ?></h2>
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

        <?php } elseif( get_row_layout() == 'specialty' ) {
            $title = get_sub_field('title');
            $sub = get_sub_field('subtitle');
            $msg = get_sub_field('content');
            $img = get_sub_field('image');
            $link = get_sub_field('main_button');
            $btns = get_field('button_series');
            ?>

            <section class="<?php echo $id; ?>-specialty">

                <div class="container">

                    <?php if( $title ) { ?>

                        <div class="row">

                            <div class="col-sm-8 col-md-7 col-lg-6 <?php echo $id; ?>-specialty-heading position-relative p-5 mt-5">

                                <?php if( $sub ) { ?><p class="text-center text-sm-left text-uppercase text-white position-relative mb-0"><?php echo $sub; ?></p><?php } ?>
                                <?php if( $title ) { ?><h2 class="text-center text-sm-left text-white position-relative mt-0"><?php echo $title; ?></h2><?php } ?>

                            </div>

                        </div>

                    <?php } ?>

                    <?php if( $img ) { ?>

                        <div class="row">

                            <div class="col-md-12 text-center">

                                <img class="w-75 b-lazy" src="" data-src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>">

                            </div>

                        </div>

                    <?php } ?>

                    <?php if( $msg ) { ?>

                        <div class="row">

                            <div class="col-md-6 offset-md-6">

                                <div class="<?php echo $id; ?>-specialty-content">

                                    <?php echo $msg; ?>

                                </div>

                            </div>

                        </div>

                    <?php } ?>

                    <?php if( have_rows('button_series') ) { ?>

                        <div class="row mt-5">

                            <div class="col-md-8 text-center text-md-left">

                                <?php while( have_rows('button_series') ) { the_row();
                                    $btns_link = get_sub_field('button');
                                    ?>

                                    <p class="d-inline-block mt-4 mb-4 w-100 w-sm-auto"><a class="<?php echo $id; ?>-specialty-btns btn-gray" href="<?php echo $btns_link['url']; ?>"><?php echo $btns_link['title']; ?></a></p>

                                <?php } ?>

                            </div>

                            <?php if( $link ) { ?>

                                <div class="col-md-4 text-center text-md-right mt-4 mb-4">

                                    <a class="btn-blue" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>

                                </div>

                            <?php } ?>

                        </div>

                    <?php } elseif( $link ) { ?>

                        <div class="row mt-5">

                            <div class="col-md-4 offset-md-8 text-center text-md-right">

                                <a class="btn-blue" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>

                            </div>

                        </div>

                    <?php } ?>

                </div>

            </div>

        </section>

    <?php } elseif( get_row_layout() == 'hero' ) { ?>

        <section class="<?php echo $id; ?>-hero">

            <?php if( have_rows('slider') ) { ?>

                <div class="hero-slider">

                    <?php while( have_rows('slider') ) { the_row();
                        $title = get_sub_field('title');
                        $link = get_sub_field('button');
                        $bg = get_sub_field('background_image');
                        ?>

                        <div class="<?php echo $id; ?>-hero-slider b-lazy" <?php if( $bg ) { ?>data-src="<?php echo $bg; ?>"<?php } ?>>

                            <div class="container">

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="<?php echo $id; ?>-hero-inner">

                                            <div class="d-flex flex-column justify-content-center align-center float-md-right">

                                                <div class="<?php echo $id; ?>-hero-box mt-2 mb-2 text-center text-md-right">

                                                    <?php if( $title ) { ?><h1 class="<?php echo $id; ?>-hero-title text-uppercase text-white font-gotham-medium"><?php echo $title; ?></h1><?php } ?>
                                                    <?php if( $link ) { ?><h3 class="mt-3"><a class="btn-blue" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a></h3><?php } ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php } ?>

                </div>

            <?php } ?>

        </section>

    <?php } //endif; ?>

<?php } //endwhile; ?>

<?php } //endif; ?>

<?php get_footer(); ?>
