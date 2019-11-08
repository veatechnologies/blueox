<?php
/**
* General Content Module
*/

?>

<section class="general">

    <div class="container">

        <?php if( have_rows('content_box') ) { ?>

            <?php while( have_rows('content_box') ) { the_row();
                $title = get_sub_field('title');
                $title_color = get_sub_field('title_color');
                $desc = get_sub_field('content');
                $img = get_sub_field('image');
                $link = get_sub_field('link');
                $link_color = get_sub_field('button_color');
                $link_pos = get_sub_field('button_position');
                ?>

                <div class="row">

                    <div class="col-12">

                        <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-start align-middle">

                            <?php if( $img ) { ?>

                                <div class="general-img text-center mb-5 w-100 w-md-25">

                                    <img class="b-lazy" src="<?php bloginfo('template_directory'); ?>/assets/images/placeholder.png" data-src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>" width="350">

                                    <?php if( $link && $link_pos['value'] == 'left' ) { ?>

                                        <div class="text-center mt-5">

                                            <a class="<?php echo esc_attr($link_color['value']); ?>" href="<?php echo $link['url']; ?>" target="<?php if( $link['target'] ) { echo $link['target']; } else { echo '_self'; } ?>"><?php echo $link['title']; ?></a>

                                        </div>

                                    <?php } ?>

                                </div>

                            <?php } ?>

                            <?php if( $title || $desc || $link ) { ?>

                                <div class="ml-md-5 w-100 w-md-75">

                                    <?php if( $title ) { ?>

                                        <h3 class="font-gotham-black <?php echo esc_attr($title_color['value']); ?>"><?php echo $title; ?></h3>

                                    <?php } ?>

                                    <?php if( $desc ) { ?>

                                        <div class="mt-3 mb-3">

                                            <?php echo $desc; ?>

                                        </div>

                                    <?php } ?>

                                    <?php if( $link && $link_pos['value'] == 'right' ) { ?>

                                        <div class="text-center text-md-right mt-5">

                                            <a class="<?php echo esc_attr($link_color['value']); ?>" href="<?php echo $link['url']; ?>" target="<?php if( $link['target'] ) { echo $link['target']; } else { echo '_self'; } ?>"><?php echo $link['title']; ?></a>

                                        </div>

                                    <?php } ?>

                                </div>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            <?php } ?>

        <?php } ?>

    </div>

</section>
