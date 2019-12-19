<?php
/**
* Specialty Module
*/

$title = get_sub_field('title');
$title_color = get_sub_field('title_color');
$text_color = get_sub_field('text_color');
$text_pos = get_sub_field('text_position');
$msg = get_sub_field('content');
$bg = get_sub_field('background_image');
?>

<section class="specialty<?php if( $bg ) { ?> b-lazy<?php } ?>" <?php if( $bg ) { ?>data-src="<?php echo $bg['url']; ?>"<?php } ?>>

    <div class="container">

        <?php if( $title || $msg ) { ?>

            <div class="row">

                <div class="d-flex flex-row justify-content-center align-middle text-center <?php echo esc_attr($text_pos['value']); ?> <?php echo esc_attr($text_color['value']); ?>">

                    <div class="w-100 specialty-content position-relative p-5 mt-5">

                        <?php if( $title ) { ?><h2 class="font-gotham-black position-relative mt-0 <?php echo $title_color; ?>"><?php echo $title; ?></h2><?php } ?>

                        <div class="<?php echo $text_color['value']; ?>">

                            <?php echo $msg; ?>

                        </div>

                        <?php if( have_rows('button_series') ) { ?>

                            <div class="align-middle <?php if( $text_pos['value'] == 'justify-content-md-start text-md-left' ) { echo 'float-none float-md-left'; } elseif( $text_pos['value'] == 'justify-content-md-end text-md-right' ) { echo 'float-none float-md-right'; } else { echo 'text-center'; } ?>">

                                <?php while( have_rows('button_series') ) { the_row();
                                    $btn = get_sub_field('button');
                                    $btn_color = get_sub_field('button_color');
                                    ?>

                                    <p class="d-inline-block mt-4 mb-4 w-100 w-sm-auto"><a class="specialty-btns <?php echo esc_attr($btn_color['value']); ?>" href="<?php echo $btn['url']; ?>"><?php echo $btn['title']; ?></a></p>

                                <?php } ?>

                            </div>

                        <?php } ?>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</section>
