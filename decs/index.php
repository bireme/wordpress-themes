<?php get_header(); ?>

<section class="container" id="main_container">
	<div class="row padding2">
		<div class="col-12">
			<?php get_template_part('includes/search') ?>
		</div>
	</div>
</section>

<?php get_template_part('includes/banners') ?>

<section id="countHome" class="d-none">
	<div class="container containerAos">
		<div class="row">
			<div class="col-12">	
				<h2 class="title1"><?php pll_e('Numbers'); ?></h2>
				<div class="line"></div>
			</div>
			<div class="col-md-4" data-aos="fade-up">
				<div class="boxHome">
					<h3 class="title2">34294</h3>
					<hr class="lineWhite">
					<p data-aos="fade-left" data-aos-delay="300"><?php pll_e('Descriptors and Qualifiers'); ?></p>
				</div>
			</div>
			<div class="col-md-4" data-aos="fade-down">
				<div class="boxHome">
					<h3 class="title2">4378</h3>
					<hr class="lineWhite">
					<p data-aos="fade-left" data-aos-delay="300"><?php pll_e('Unique DeCS Descriptors and Qualifiers'); ?></p>
				</div>
			</div>
			<div class="col-md-4" data-aos="fade-up">
				<div class="boxHome">
					<h3 class="title2">1844</h3>
					<hr class="lineWhite">
					<p data-aos="fade-left" data-aos-delay="300"><?php pll_e('Hierarchical Codes in DeCS categories'); ?></p>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="padding2 d-none">
	<div class="container containerAos">
		<h2 class="title1"><?php pll_e('About DeCS'); ?></h2>
		<div class="line"></div>
		<div class="row">
			<?php 
			$home = new WP_Query([
				'post_type' => 'Home',
				'orderby' => 'title',
				'order' => 'ASC'
			]);
			while($home->have_posts()):$home->the_post();
				while(have_rows('group')):the_row(); 
					$video = get_sub_field('video'); 
					$texto = get_sub_field('texto'); 
					?>
					<div class="col-md-6" data-aos="fade-left">
						<?php echo $texto; ?>
					</div>
					<div class="col-md-6 " data-aos="fade-right">
						<?php echo $video; ?>	
					</div>
				<?php endwhile;
			endwhile;
			?>
		</div>
	</div>
</section>

<section class="padding2 bgColor1 d-none">
	<div class="container containerAos">
		<h2 class="title1"><?php pll_e('DeCS in Numbers'); ?></h2>
		<div class="line"></div>
		<div class="row">
			<?php 
			$home = new WP_Query([
				'post_type' => 'Home',
				'orderby' => 'title',
				'order' => 'ASC'
			]);
			while($home->have_posts()):$home->the_post();
				while(have_rows('group2')):the_row(); 
					$image_left = get_sub_field('image_left'); 
					$image_right = get_sub_field('image_right'); 
					?>
					<div class="col-md-6" data-aos="fade-left">

						<img src="<?php echo $image_left['url']; ?>" alt="<?php echo $image_left['alt']; ?>" class="img-fluid">
					</div>
					<div class="col-md-6 " data-aos="fade-right">
						<img src="<?php echo $image_right['url']; ?>" alt="<?php echo $image_right['alt']; ?>" class="img-fluid">	
					</div>
				<?php endwhile;
			endwhile;
			?>
		</div>
	</div>
</section>
<section class="container padding2">
	<?php
		$home = new WP_Query([
				'post_type' => 'home',
				'orderby' => 'title',
				'order' => 'ASC'
		]);
	?>
	<?php while($home->have_posts()):$home->the_post();
		the_content();
	endwhile;
	?>
</section>
<?php get_template_part('includes/partners') ?>
<?php get_footer(); ?>