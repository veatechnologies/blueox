<?php
/**
* Full Width Image Module
*/

$img = get_sub_field('image');
?>

<section class="full-width-image">

    <div class="container_fluid">

        <div class="row">

            <div class="col-md-12">

                <img class="w-100 b-lazy" src="<?php bloginfo('template_directory'); ?>/assets/images/placeholder.png" data-src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>">

            </div>

        </div>

    </div>

</section>
