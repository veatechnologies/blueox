<?php
/*
* Template Name: Careers
*/
get_header();
?>

<div class="container">

	<div class="row">

		<div class="col-md-8 wp-bp-content-width">

			<div id="primary" class="content-area">

				<main id="main" class="site-main mt-5">

					<h1 class="entry-title card-title"><?php the_title(); ?></h1>

					<?php if( have_posts() ) { ?>

						<?php while( have_posts() ) { the_post(); ?>

							<?php the_content(); ?>

						<?php } //endwhile ?>

					<?php } //endif ?>

					<?php
					$args = array(
						'post_type' => 'jobs',
						'orderby' => 'date',
						'posts_per_page' => '10'
					);
					$jobs_query = new WP_Query( $args );
					?>

					<div class="careers-list--box">

						<h2 class="page-title entry-title">Current Job Openings</h2>

						<hr>

						<ul class="careers-list">

							<?php if( $jobs_query->have_posts() ) { ?>

								<?php while( $jobs_query->have_posts() ) { $jobs_query->the_post(); ?>

									<li class="careers-list--entry">

										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><strong><?php the_title(); ?></strong> <span class="careers-list--date">- Posted <?php the_date(); ?></span></a>

									</li>

								<?php } //endwhile ?>

							</ul>

							<div class="pagination">

								<nav class="nav-single">

									<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>

									<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>

								</nav><!-- .nav-single -->

							</div><!--pagination-->

						<?php } else { //endif ?>

							<ul class="careers-list">

								<li class="careers-list--entry">

									There are no current job openings.

								</li>

							</ul>

						<?php } //endif ?>

						<?php wp_reset_postdata(); ?>

					</div>

				</main>

			</div>

		</div>

		<div class="col-md-4 wp-bp-sidebar-width">

			<?php get_sidebar('jobs'); ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>
