<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Bootstrap_4
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mt-3r' ); ?>>
	<div class="card-body">

		<?php if ( is_sticky() ) : ?>
			<span class="oi oi-bookmark wp-bp-sticky text-muted" title="<?php echo esc_attr__( 'Sticky Post', 'wp-bootstrap-4' ); ?>"></span>
		<?php endif; ?>
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title card-title">', '</h1>' );
			else :
				the_title( '<h2 class="card-title font-gotham-black text-blue">', '</h2>' );
			endif;

			if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta text-muted">
				<?php wp_bootstrap_4_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
			endif; ?>
		</header><!-- .entry-header -->

		<?php wp_bootstrap_4_post_thumbnail(); ?>

		<?php if( is_singular() || get_theme_mod( 'default_blog_display', 'excerpt' ) === 'full' ) : ?>
			<div class="entry-content">
				<?php
					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'wp-bootstrap-4' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-4' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
		<?php else : ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
				<div class="">
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="mt-2 btn-blue d-inline-block"><?php esc_html_e( 'Continue Reading', 'wp-bootstrap-4' ); ?> <small class="oi oi-chevron-right ml-1"></small></a>
				</div>
			</div><!-- .entry-summary -->
		<?php endif; ?>

	</div>
	<!-- /.card-body -->

</article><!-- #post-<?php the_ID(); ?> -->
