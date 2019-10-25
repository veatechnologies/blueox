<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_4
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer text-center bg-white mt-4 pt-5 text-muted">

		<section class="footer-widgets pt-3">

			<div class="container">

				<div class="row">

					<div class="footer-numbers d-flex flex-wrap align-middle ">

						<div class="pl-5 pr-5">

							<?php if( get_field('toll_free_phone', 'option') ) { ?>
								<?php $toll = preg_replace( "/[^0-9]/", "", get_field('toll_free_phone', 'option') ); ?>
								<h3 class="d-inline-block"><span>Toll Free:</span> <a href="tel:1<?php echo $toll; ?>"><?php the_field('toll_free_phone', 'option'); ?></a></h3>
							<?php } ?>

							<?php if( get_field('phone-1', 'option') ) { ?>
								<?php $phone = preg_replace( "/[^0-9]/", "", get_field('phone-1', 'option') ); ?>
								<h3 class="d-inline-block"><span>Phone:</span> <a href="tel:1<?php echo $phone; ?>"><?php the_field('phone-1', 'option'); ?></a></h3>
							<?php } ?>

							<?php if( get_field('fax-1', 'option') ) { ?>
								<?php $fax = preg_replace( "/[^0-9]/", "", get_field('toll_free_phone', 'option') ); ?>
								<h3 class="d-inline-block"><span>Fax:</span> <a href="tel:1<?php echo $fax; ?>"><?php the_field('fax-1', 'option'); ?></a></h3>
							<?php } ?>

						</div>

						<div class="pl-5 pr-5">

							<?php if( get_field('hours', 'option') ) { ?>
								<h3 class="d-inline-block"><?php the_field('hours', 'option'); ?></h3>
							<?php } ?>

							<?php if( get_field('email-1', 'option') ) { ?>
								<h3 class="d-inline-block"><a href="mailto:<?php the_field('email-1', 'option'); ?>"><?php the_field('email-1', 'option'); ?></a></h3>
							<?php } ?>

						</div>

					</div>

				</div>

			</div>

		</section>

		<section class="footer-widgets text-left mb-5">
			<div class="container">
				<div class="row">
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<div class="col">
							<aside class="widget-area footer-1-area mb-2">
								<?php dynamic_sidebar( 'footer-1' ); ?>
							</aside>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<div class="col">
							<aside class="widget-area footer-2-area mb-2">
								<?php dynamic_sidebar( 'footer-2' ); ?>
							</aside>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<div class="col">
							<aside class="widget-area footer-3-area mb-2">
								<?php dynamic_sidebar( 'footer-3' ); ?>
							</aside>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
						<div class="col">
							<aside class="widget-area footer-4-area mb-2">
								<?php dynamic_sidebar( 'footer-4' ); ?>
							</aside>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-5' ) ) : ?>
						<div class="col">
							<aside class="widget-area footer-5-area mb-2">
								<?php dynamic_sidebar( 'footer-5' ); ?>
							</aside>
						</div>
					<?php endif; ?>
				</div>
				<!-- /.row -->
			</div>
		</section>

		<div class="footer-attr container-fluid">

			<div class="row">

				<div class="container">

					<div class="site-info text-left pl-3 pr-3 pt-3 pb-3">
						&copy; 2014 - <?php echo date('Y'); ?> <?php bloginfo('name'); ?><span class="sep"> | </span>All Rights Reserved<span class="sep"> | </span>Designed by <a class="designed-by" href="https://veatechnologies.com/" target="_blank" rel="nofollow">VEA Technologies</a>
					</div><!-- .site-info -->

				</div>

			</div>

		</div>
		<!-- /.container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<?php if( get_field('footer-code', 'option') ) { ?>

	<?php the_field( 'footer-code', 'option' ); ?>

<?php } ?>

</body>
</html>
