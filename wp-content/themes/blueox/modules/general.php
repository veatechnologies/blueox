<?php
/**
* General Content Module
*/

?>

<section class="general">

    <div class="container">

        <?php if( have_rows('content_box') ) { ?>

            <?php while( have_rows('content_box') ) { the_row();
                $big = get_sub_field('big_title');
                $title = get_sub_field('title');
                $title_color = get_sub_field('title_color');
                $title_pos = get_sub_field('title_position');
                $desc = get_sub_field('content');
                $layout = get_sub_field('content_layout');
                $img = get_sub_field('image');
                $link = get_sub_field('link');
                $link_color = get_sub_field('button_color');
                $link_pos = get_sub_field('button_position');
                ?>

                <div class="row">

                    <div class="col-12">

                        <?php if( $big ) { ?>

                            <h2 class="mb-5 font-gotham-black <?php echo esc_attr($title_pos['value']); ?> <?php echo esc_attr($title_color['value']); ?>"><?php echo $big; ?></h2>

                        <?php } ?>

                        <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-start align-items-center">

                            <?php if( $img ) { ?>

                                <div class="general-img text-center pb-5 <?php if( $layout['value'] == 'whole' ) { echo 'w-100'; } elseif( $layout['value'] == 'half' ) { echo 'w-100 w-md-50'; } else { echo 'w-100 w-md-25'; } ?>">

                                    <img class="b-lazy" src="<?php bloginfo('template_directory'); ?>/assets/images/placeholder.png" data-src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>" width="">

                                    <?php if( $link && $link_pos['value'] == 'left' ) { ?>

                                        <div class="text-center mt-5">

                                            <a class="<?php echo esc_attr($link_color['value']); ?>" href="<?php echo $link['url']; ?>" target="<?php if( $link['target'] ) { echo $link['target']; } else { echo '_self'; } ?>"><?php echo $link['title']; ?></a>

                                        </div>

                                    <?php } ?>

                                </div>

                            <?php } ?>

                            <?php if( $title || $desc || $link ) { ?>

                                <div class="<?php if( $layout['value'] == 'whole' ) { echo 'w-100'; } elseif( $layout['value'] == 'half' ) { echo 'ml-md-5 w-100 w-md-50'; } else { echo 'ml-md-5 w-100 w-md-75'; } ?>">

                                    <?php if( $title ) { ?>

                                        <h3 class="font-gotham-black <?php echo esc_attr($title_pos['value']); ?> <?php echo esc_attr($title_color['value']); ?>"><?php echo $title; ?></h3>

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
