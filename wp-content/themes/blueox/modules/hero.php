<?php
/**
* Hero Module
*/
?>

<section class="hero">

    <?php if( have_rows('slider') ) { ?>

        <div class="hero-slider">

            <?php while( have_rows('slider') ) { the_row();
                $title = get_sub_field('title');
                $text_color = get_sub_field('title_color');
                $link = get_sub_field('button');
                $btn_color = get_sub_field('button_color');
                $text_pos = get_sub_field('text_position');
                $bg = get_sub_field('background_image');
                ?>

                <div class="hero-slider-wrapper<?php if( $bg ) { ?> b-lazy<?php } ?>" <?php if( $bg ) { ?>data-src="<?php echo $bg; ?>"<?php } ?>>

                    <div class="container">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="hero-inner">

                                    <div class="d-flex flex-column justify-content-center align-middle text-center <?php echo esc_attr($text_pos['value']); ?>">

                                        <div class="hero-box mt-2 mb-2">

                                            <?php if( $title ) { ?><h1 class="hero-title <?php echo esc_attr($text_color['value']); ?> font-gotham-black"><?php echo $title; ?></h1><?php } ?>
                                            <?php if( $link ) { ?><h3 class="mt-3"><a class="<?php echo esc_attr($btn_color['value']); ?>" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a></h3><?php } ?>

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
