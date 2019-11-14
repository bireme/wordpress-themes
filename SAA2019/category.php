<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section class="container">
	<div class="row" id="main_container">
		<div class="col-12">
			<h4 class="title1"><?php single_cat_title() ?></h4>
		</div>
		<div class="col-md-8">
			<div class="row">
				<?php while(have_posts()) : the_post(); ?>
					<article class="col-md-6 categoryHome imEffect">
						<a href="<?php permalink_link(); ?>">
							<?php the_post_thumbnail('medium_large',['class' => 'img-fluid  imgPost']); ?>
							<b><?php the_title(); ?></b> <br>
							<small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></small>
						</a><br><br>
					</article>
					<?php
				endwhile;
				?>
			</div>
		</div>
		<div class="col-md-4">
			<div id="enquete">
				<ul class="list-unstyled"><?php dynamic_sidebar('enquete') ?></ul>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
