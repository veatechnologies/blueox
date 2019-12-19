<?php get_header(); ?>

<div class="container">

	<div class="row">

		<div class="col-md-8 wp-bp-content-width">

			<div id="primary" class="content-area">

				<main id="main" class="site-main mt-5">

					<?php if( have_posts() ) { ?>

						<?php while( have_posts() ) { the_post(); ?>

							<?php
							$team = get_field('team');
							$super = get_field('supervisor');
							$salary = get_field('salary');
							$job_sum = get_field('job_summary');
							$job_dut = get_field('job_duties');
							$job_equip = get_field('equipment_tools_used');
							$work = get_field('work_center');
							$job_specs = get_field('job_specifications');
							$link = get_field('job_link');
							$bennys = get_field('benefits');

							$job = get_the_title();
							$the_job = urlencode( $job ); ?>

							<h1 class="entry-title card-title"><?php the_title(); ?></h1>

							<p class="entry-meta text-muted">Posted <?php the_date(); ?><?php if( $team ) { echo ' | <strong>Team</strong> - ' . $team; } ?><?php if( $super ) { echo ' | <strong>Supervisor</strong> - ' . $super; } ?> | <a href="<?php bloginfo('url'); ?>/about-us/careers/">Back to Listings <i class="fa fa-undo"></i></a></p>

							<section class="job-posting">

								<?php if( $link ) { ?><p><a class="job-link" href="<?php echo $link . '?job=' . $the_job; ?>">Apply For This Job</a></p><?php } //endif $link ?>

								<?php if( $job_sum || $salary ) { ?>
									<div class="job-section job-summary">
										<h3>Summary</h3>
										<?php echo $job_sum; ?>

										<?php if( $salary ) { ?>
											<h3>Salary</h3>
											<p><?php echo $salary; ?></p>
										<?php } //endif $salary ?>
									</div>
								<?php } //endif $job_sum ?>
								<?php if( $job_dut ) { ?>
									<div class="job-section job-duties">
										<h3>Duties</h3>
										<?php echo $job_dut; ?>
									</div>
								<?php } //endif $job_dut ?>
								<?php if( $job_equip ) { ?>
									<div class="job-section job-equip">
										<h3>Equipment / Tools Used</h3>
										<?php echo $job_equip; ?>
									</div>
								<?php } //endif $job_equip ?>
								<?php if( $work ) { ?>
									<div class="job-section job-work">
										<h3>Work Center</h3>
										<?php echo $work; ?>
									</div>
								<?php } //endif $work ?>
								<?php if( $job_specs ) { ?>
									<div class="job-section job-specs">
										<h3>Specifications</h3>
										<?php echo $job_specs; ?>
									</div>
								<?php } //endif $job_specs ?>
								<?php if( $bennys ) { ?>
									<div class="job-section job-benefits">
										<h3>Benefits</h3>
										<?php echo $bennys; ?>
									</div>
								<?php } //endif $bennys ?>

								<?php if( $link ) { ?><p><a class="job-link" href="<?php echo $link . '?job=' . $the_job; ?>">Apply For This Job</a></p><?php } //endif $link ?>

							</section>

						<?php } //endwhile ?>

					<?php } //endif ?>

				</main>

			</div><!-- #content -->

		</div>

		<div class="col-md-4 wp-bp-sidebar-width">

			<?php get_sidebar('jobs'); ?>

		</div>

	</div>

</div>

<?php get_footer(); ?>
