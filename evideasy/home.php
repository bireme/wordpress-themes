<?php
	/*
		template name: Home
	*/
?>
<?php get_header(); ?>
<section class="padding1 bgColor1" id="main_container">
	<div class="container">
		<?php
		$home = new WP_Query([
			'post_type' => 'page',
			'pagename' => 'Home'
		]);
		while($home->have_posts()) : $home->the_post();
			$group = get_field('group_1');
			while( have_rows('group_1') ): the_row(); 
				$title = get_sub_field('title'); 
				$text = get_sub_field('text');
				$image = get_sub_field('image');
				?>
				<h2 class="title1"><?php echo $title; ?></h2>
				<div class="line2"></div>
				<div class="row">
					<div class="col-md-6 font18">
						<?php echo $text; ?>
					</div>
					<div class="col-md-6 text-center">
						<img src="<?php echo $image['url']; ?>" alt="" class="img-fluid">
						<br> <br>
						<?php $idioma = pll_current_language(); ?>
						<a href="https://pesquisa.bvsalud.org/portal/?display_wizard=true&lang=<?php echo $idioma; ?>" target="_blank" class="btn btn-lg btn-warning">
							<?php pll_e('Try EVID@Easy right now!'); ?>
						</a>
					</div>
				</div>
			<?php endwhile;
		endwhile;
		?>
	</div>
</section>
<section class="padding1">
	<div class="container">
		<?php
		$home = new WP_Query([
			'post_type' => 'page',
			'pagename' => 'Home'
		]);
		while($home->have_posts()) : $home->the_post();
			$group = get_field('group_2');
			while( have_rows('group_2') ): the_row(); 
				$title = get_sub_field('title'); 
				$text = get_sub_field('text');
				?>
				<h2 class="title1"><?php echo $title; ?></h2>
				<div class="line"></div>
				<div class="row">

					<div class="col-md-12 font18">
						<?php echo $text; ?>
						<br>
					</div>
					<?php get_template_part('includes/banners') ?>
				</div>
			</div>
		<?php endwhile;
	endwhile;
	?>
</div>
</section>

<section class="padding1 bgColor2">
	<div class="container">
		<?php
		$home = new WP_Query([
			'post_type' => 'page',
			'pagename' => 'Home'
		]);
		while($home->have_posts()) : $home->the_post();
			$group = get_field('group_3');
			while( have_rows('group_3') ): the_row(); 
				$title = get_sub_field('title'); 
				$caption = get_sub_field('caption'); 
				$text = get_sub_field('text');
				?>
				<h2 class="title1"><?php echo $title; ?></h2>
				<div class="line2"></div>
				<div class="text-center font18"><?php echo $caption; ?></div><br>
				<?php echo $text; ?>
			<?php endwhile;
		endwhile;
		?>
	</div>
</section>
<?php get_footer(); ?>