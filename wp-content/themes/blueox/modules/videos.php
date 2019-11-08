<?php
/**
* Videos Module
*/

$title = get_sub_field('title');
?>

<section class="videos">

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <h2 class="text-blue font-gotham-black mb-3"><?php echo $title; ?></h2>

                <div class="videos-inner">

                    <div class="d-flex flex-column flex-md-row justify-content-md-around align-middle">

                        <?php if( have_rows('video') ) { ?>

                            <?php while( have_rows('video') ) { the_row();
                                $title = get_sub_field('title');
                                $img = get_sub_field('image');
                                $vid = get_sub_field('yt_video');
                                ?>

                                <div class="videos-box position-relative ml-3 mr-3">
                                    <img class="videos-img w-100 b-lazy" src="<?php bloginfo('template_directory'); ?>/assets/images/placeholder.png" data-src="<?php if( $img ) { echo $img['url']; } else { echo get_bloginfo('template_directory') . '/assets/images/videos-thumb.png'; } ?>" alt="video thumnail">
                                    <div class="videos-play position-absolute text-white">
                                        <a class="videos-play-button popup-youtube text-white" href="<?php echo $vid; ?>" ><i class="fas fa-play-circle fa-4x"></i></a>
                                    </div>
                                    <h3 class="font-gotham-thin mt-3 mb-3"><?php echo $title; ?></h3>
                                </div>

                            <?php } ?>

                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
