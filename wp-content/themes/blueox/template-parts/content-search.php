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
		<header class="entry-header test">
			<?php the_title( sprintf( '<h2 class="entry-title card-title"><a href="%s" rel="bookmark" class="text-dark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta text-muted">
				<?php wp_bootstrap_4_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

<?php if(function_exists('wp_bootstrap_4_post_thumbnail')){


	if( has_post_thumbnail()){

		wp_bootstrap_4_post_thumbnail();
	}

	elseif(! has_post_thumbnail()){

		//function wc_custom_thumbnail() { 
	function wc_custom_placeholder_img( $src ) { 
		$src = get_stylesheet_directory_uri().'/assets/images/Logo_800x600-1'; 
		return $src; 
	}
	add_filter('woocommerce_placeholder_img_src', 'wc_custom_placeholder_img'); 
//} 
//add_action( 'init', 'wc_custom_thumbnail' );

echo $src."test123";
	}


}

	 ?>

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
