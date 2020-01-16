<?php
/*
Template Name: Account */
get_header(); ?>

<?php
	$default_sidebar_position = get_theme_mod( 'default_sidebar_position', 'right' );
?>

	<div class="container">
		<div class="row">

			<?php if ( $default_sidebar_position === 'no' ) : ?>
				<div class="col-md-12 wp-bp-content-width">
			<?php else : ?>
				<div class="col-md-12 wp-bp-content-width">
			<?php endif; ?>

				<div id="primary" class="content-area">
					<main id="main" class="site-main">
						<div class="account-page">
							<h1><?php the_title(); ?></h1>
							<?php
								the_content();
							?>
						</div>
					</main><!-- #main -->
				</div><!-- #primary -->
			</div>
			<!-- /.col-md-8 -->

		
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container -->

<?php
get_footer();
