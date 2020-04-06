<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Bootstrap_4
 */

?>


	<div class="col-md-4" <?php post_class( 'card mt-3r' ); ?> id="post-<?php the_ID(); ?>">
<!--<article> -->
	<div class="card-body">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title card-title"><a href="%s" rel="bookmark" class="text-dark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta text-muted">
				<?php wp_bootstrap_4_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php if ( has_post_thumbnail() ) : ?>
		    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		        <?php wp_bootstrap_4_post_thumbnail(); ?>
		    </a>
		<?php endif; 
		else {


add_action('init', 'custom_fix_thumbnail');

function custom_fix_thumbnail() {
    add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');

    function custom_woocommerce_placeholder_img_src($src) {
       
            global $post;
            $array = get_the_terms($post->ID, 'product_cat');
            reset($array);
            $first_key = key($array);
            $thumbnail_id = get_woocommerce_term_meta($first_key, 'thumbnail_id', true);

            // get the image URL for parent category
            $image = wp_get_attachment_url($thumbnail_id);

            // print the IMG HTML for parent category
            if ($image)
                $src = $image;
     
        return $src;
    }

}



		}

		?>

		<?php //wp_bootstrap_4_post_thumbnail(); ?>

		<!--<div class="entry-summary">
			<?php //the_excerpt(); ?>
		</div> --><!-- .entry-summary -->
	</div>
	<!-- /.card-body -->

	<?php if ( 'post' === get_post_type() ) : ?>
		<footer class="entry-footer card-footer text-muted">
			<?php wp_bootstrap_4_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
<!--</article>--><!-- #post-<?php the_ID(); ?> -->

</div>
