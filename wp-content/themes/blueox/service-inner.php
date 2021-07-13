<?php
/*
* Template Name: Services Inner
*/
get_header();
$page_category_for_filters = get_field('page_category_for_filters');
?>
<input type="hidden" class="page_cat" value="<?php echo $page_category_for_filters; ?>" />
<div class="contentBlock-wrapper">
	<div class="text-center titleBar">
		<h1><?php the_field('page_title'); ?></h2>
		<h3><?php the_field('subtitle'); ?></h3>
	</div>
	<div class="single-ctaBlock">
		<?php if( get_field('service_image') ): ?>
		<div class="ctaBlock-image-block">
			<img src="<?php the_field('service_image'); ?>" alt="<?php the_field('service_image'); ?>">
		</div>
		<?php endif; ?>
		<?php if( get_field('service_content') ): ?>
			<div class="ctaBlock-content-block">
				<?php the_field('service_content'); ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="contentBlock">
		<?php the_field('middle_content'); ?>
	</div>
	<?php if( get_field('three_column_bottom_cta') ): ?>
		<div class="threeCta">
			<?php $loop=0; $i=0; $rows = get_field('three_column_bottom_cta');
	            if($rows){foreach($rows as $row){ ?>
				<div class="ctaBlock">
					<img src="<?php echo $row['image']; ?>" alt="<?php echo $row['image_alter_text']; ?>">
					<?php echo $row['contents']; ?>
				</div>
			<?php } } ?>
		</div>
	<?php endif; ?>
     <?php // echo do_shortcode('[woocommerce_product_filter_category style="select" taxonomy="hole_shanks" show="all"]'); ?>
     <?php // echo do_shortcode('[woocommerce_product_filter_category style="select" taxonomy="hole_shanks"]'); ?>
	<div class="vehicleWeight">
		<h2><?php the_field('vehicle_weight_block_title'); ?></h2>
		<div class="form">
			<?php // if (is_active_sidebar('sidebar-swaypro-new')) { ?>
                <div class="col-sm-4">
                    <?php // dynamic_sidebar('sidebar-swaypro-new'); ?>
                    <?php
                    $choices = get_terms( array( 'taxonomy' => 'hole_shanks', 'parent' => 0, 'hide_empty' => false ) );
                    $valued_choices = [];
                    if ( !  empty( $choices ) ) {
                        foreach ( $choices as $choices_val ) {
                            $args   = array (
                                "post_type"      => 'product',
                                "posts_per_page" => -1,
                                "post_status"    => 'publish',
                                'tax_query'      => array (
                                    'relation' => 'AND',
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'term_id',
                                        'terms' => $page_category_for_filters
                                    ),
                                    array(
                                        'taxonomy' => 'hole_shanks',
                                        'field' => 'term_id',
                                        'terms' => $choices_val->term_id
                                    ),
                                ),
                            );
                            $products = new WP_Query ( $args );
                            if ( $products->post_count > 0 ) {
                                $valued_choices[] = $choices_val;
                            }
                            wp_reset_postdata();
                            wp_reset_query();
                        }
                    }
                    if ( !  empty( $valued_choices ) ) {
                        echo "<select name='hole_selection' class='hole_selection'><option>Choose Trailer Tongue Weight</option>";
                            foreach ( $valued_choices as $choices_val ) {
                                echo "<option value='".$choices_val->term_id."'>".$choices_val->name."</option>";
                            }
                        echo "</select>";
                    }
                    ?>
                    <?php // echo do_shortcode('[woocommerce_product_filter_category style="select" show_heading="no" hide_empty="true" none_selected="Choose Trailer Tongue Weight" include="420,421,422,423" hierarchical="false" show_parent_navigation="no"]'); ?>
                </div>
            <?php // } ?>
		</div>
	</div>
	<div class="vehicleWeightText text-center">
		<?php the_field('vehicle_weight_block_text'); ?>
               
	</div>
	<section id="swayproTop" class="baseplates mb-5 pb-5">
        <div id="baseplates" class="container">
<!--            <div class="row">
                <div class="col-md-12">
                    <p><a id="scrollResults" href="#baseplates">Hide Products <i class="fas fa-chevron-up"></i></a></p>
                </div>
            </div>-->
            <div class="row">
                <div class="col-md-12 custom_product_list">
                    <?php //echo do_shortcode('[woocommerce_product_filter_context taxonomy="product_cat" term="swaypro"]'); ?>
                    <?php echo do_shortcode('[woocommerce_product_filter_products show_pagination="no" columns="3" per_page="1000" orderby="name" show_catalog_ordering="no" show_result_count="yes"]'); ?>
                </div>
            </div>
        </div>
    </section>
	<div class="contentBlock reduce-top">
		<?php the_field('bottom_content'); ?>
	</div>
	<div class="localDealar">
		<div class="dealarImage">
			<img src="<?php the_field('local_dealer_block_image'); ?>" alt="<?php the_field('local_dealer_block_image_alt'); ?>">
		</div>
		<div class="localDealarContent">
			<h2><?php the_field('local_dealer_block_title'); ?></h2>
			<p><?php the_field('local_dealer_block_description'); ?></p>
			<a href="<?php the_field('local_dealer_block_button_link'); ?>" class="outlineBtn"><?php the_field('local_dealer_block_button_text'); ?></a>
		</div>
	</div>
</div>
<?php get_footer(); ?>