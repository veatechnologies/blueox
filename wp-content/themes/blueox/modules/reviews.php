<?php
/**
* Reviews Module
*/

$bg = get_sub_field('background_image');
?>

<section class="reviews <?php if( $bg ) { ?>b-lazy<?php } ?>" <?php if( $bg ) { ?>data-src="<?php echo $bg; ?>"<?php } ?>>

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="reviews-inner match-height">

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

                                <div class="reviews-box w-100 w-lg-33 mt-3 mb-3 mr-lg-3 ml-lg-3">

                                    <?php if( $name ) { ?>

                                        <p class="review-name font-gotham-medium text-blue mb-2"><?php echo $name; ?></p>

                                    <?php } ?>

                                    <?php if( $date ) { ?>

                                        <p class="review-date text-gray mb-2"><?php echo $date; ?></p>

                                    <?php } ?>

                                    <?php if( $loc ) { ?>

                                        <p class="review-location text-blue mb-2"><?php echo $loc; ?></p>

                                    <?php } ?>

                                    <?php if( $title ) { ?>
                                        <p class="review-title text-blue font-gotham-medium text-uppercase mb-2"><?php echo $title; ?></p>
                                    <?php } ?>

                                    <?php if( $star ) { ?>
                                        <p class="review-star text-gray">
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

                                    <?php if( $msg ) { ?>
                                        <div class="review-msg text-gray">
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
