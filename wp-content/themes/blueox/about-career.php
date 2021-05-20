<?php
/*
* Template Name: About Career
*/
get_header();
?>
<?php if( get_field('image') ): ?>
	<div class="fullWidth-img">
			<img src="<?php the_field('image'); ?>" alt="<?php the_field('image'); ?>">
	</div>
<?php endif; ?>
<div class="contentBlock-wrapper">
	<?php if( get_field('middle_contents') ): ?>
		<div class="contentBlock">
			<?php the_field('middle_contents'); ?>
		</div>
	<?php endif; ?>
	<?php if( get_field('middle_contents') ): ?>
		<div class="threeCta">
			<?php $loop=0; $i=0; $rows = get_field('cta');
	            if($rows){foreach($rows as $row){ ?>
				<div class="ctaBlock">
					<img class="logo" src="<?php echo $row['logo']; ?>" alt="<?php echo $row['logo_alt']; ?>">
					<img class="photo" src="<?php echo $row['photo']; ?>" alt="<?php echo $row['photo_alt']; ?>">
					<?php echo $row['description']; ?>
				</div>
			<?php } } ?>
		</div>
	<?php endif; ?>
</div>
<?php get_footer(); ?>