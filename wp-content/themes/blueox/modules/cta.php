<?php
/**
* CTA Module
*/

$title = get_sub_field('title');
$link = get_sub_field('button');
$bg = get_sub_field('background_image');
?>

<section class="cta <?php if( $bg ) { ?>b-lazy<?php } ?>" <?php if( $bg ) { ?>data-src="<?php echo $bg; ?>"<?php } ?>>

    <div class="container">

        <div class="row">

            <div class="col-md-8 offset-md-2 cta-inner">

                <div class="pt-5 pb-5">

                    <div class="d-flex flex-column align-middle">

                        <?php if( $title ) { ?>

                            <h2 class="font-gotham-black text-blue text-center"><?php echo $title; ?></h2>

                        <?php } ?>

                        <?php if( $link ) { ?>

                            <div class="text-center mt-3">

                                <a class="btn-clear--blue" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>

                            </div>

                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
