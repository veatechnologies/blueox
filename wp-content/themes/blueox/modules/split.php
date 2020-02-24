<?php
/**
* Split CTA Module
*/
$title = get_sub_field('title');
$desc = get_sub_field('content');
$link = get_sub_field('button');
$v_i = get_sub_field('video_or_image');
$layout = get_sub_field('layout');
$img = get_sub_field('image');
?>

<section class="split">

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="split-inner">

                    <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-start align-items-center">

                        <?php if( $v_i['value'] == 'video' ) { ?>

                            <?php if( have_rows('video') ) { ?>

                                <?php while( have_rows('video') ) { the_row();
                                    $img = get_sub_field('image');
                                    $vid = get_sub_field('yt_video');
                                    ?>

                                    <div class="videos-box position-relative ml-3 mr-3 w-100 <?php if( $layout['value'] == 'reverse' ) { echo 'order-md-2'; } ?>">
                                        <img class="videos-img w-100 b-lazy" src="<?php bloginfo('template_directory'); ?>/assets/images/placeholder.png" data-src="<?php if( $img ) { echo $img['url']; } else { echo get_bloginfo('template_directory') . '/assets/images/videos-thumb.png'; } ?>" alt="video thumnail">
                                        <div class="videos-play position-absolute text-white">
                                            <a class="videos-play-button popup-youtube text-white" href="<?php echo $vid; ?>" ><i class="fas fa-play-circle fa-4x"></i></a>
                                        </div>
                                    </div>

                                <?php } ?>

                            <?php } ?>

                        <?php } else { ?>

                                <div class="general-img text-center w-md-50 <?php if( $layout['value'] == 'reverse' ) { echo 'order-md-2'; } ?>">

                                    <img class="b-lazy" src="<?php bloginfo('template_directory'); ?>/assets/images/placeholder.png" data-src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>" width="">

                                </div>

                        <?php } ?>

                        <div class="w-100 w-md-50 mt-4 mb-4 mt-md-0 mb-md-0 text-center">

                            <?php if( $title ) { ?>

                                <h3 class="font-gotham-black <?php echo esc_attr($title_pos['value']); ?> <?php echo esc_attr($title_color['value']); ?>"><?php echo $title; ?></h3>

                            <?php } ?>

                            <?php if( $desc ) { ?>

                                <div class="mt-3 mb-3">

                                    <?php echo $desc; ?>

                                </div>

                            <?php } ?>

                            <?php if( $link ) { ?>

                                <div class="text-center mt-4">

                                    <a class="btn-clear--blue" href="<?php echo $link['url']; ?>" target="<?php if( $link['target'] ) { echo $link['target']; } else { echo '_self'; } ?>"><?php echo $link['title']; ?></a>

                                </div>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
