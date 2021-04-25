<?php
/**
* Categories Module
*/

$title = get_sub_field('title');
?>

<section class="categories">

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="categories-inner">

                    <?php if( $title ) { ?>

                        <h2 class="font-gotham-black text-blue text-center"><?php echo $title; ?></h2>

                    <?php } ?>

                    <?php if( have_rows('category_box') ) { ?>

                        <div class="d-flex flex-column flex-md-row justify-content-md-around align-top mt-5">

                            <?php while( have_rows('category_box') ) { the_row();
                                $img = get_sub_field('image');
                                $link = get_sub_field('link');
                                $title = get_sub_field('title');
                                $desc = get_sub_field('description');
                                ?>

                                <div class="categories-box w-md-33 m-4 m-md-3">

                                    <?php if( $img ) { ?>

                                        <div class="text-center mb-3">
                                            <?php if( $link ) { ?><a class="categories-link position-relative" href="<?php echo $link['url']; ?>"><?php } ?>
                                                <img class="categories-box-img w-100 w-md-auto" src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>" width="500">
                                                <div class="categories-overlay position-absolute"><i class="text-white fas fa-link fa-4x"></i><br><span class="font-gotham-medium text-uppercase text-white fa-2x"><?php echo $link['title']; ?></span></div>
                                            <?php if( $link ) { ?></a><?php } ?>
                                        </div>

                                    <?php } ?>

                                    <?php if( $desc ) { ?>

                                        <h3 class="font-gotham-thin"><?php echo $title; ?></h3>

                                    <?php } ?>

                                    <?php if( $desc ) { ?>

                                        <hr class="mb-3">

                                        <div><?php echo $desc; ?></div>

                                    <?php } ?>

                                </div>

                            <?php } ?>

                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>

    </div>

</section>
