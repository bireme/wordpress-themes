<?php get_header(); ?>
<?php get_template_part('navHome') ?>



<main id="main_container" class="padding1">

<?php get_template_part('includes/search') ?>

</main>

	<section id="countHome">
		<div class="container containerAos">
			<div class="row">
				<div class="col-12">	
					<h2 class="title1">Números</h2>
					<div class="line"></div>
				</div>
				<div class="col-md-4" data-aos="fade-up">
					<div class="boxHome">
						<h3 class="title2 counter-up" data-count-to="33558"><span></span></h3>
						<hr class="lineWhite">
						<p data-aos="fade-left" data-aos-delay="300">Descritores e Qualificadores</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-down">
					<div class="boxHome">
						<h3 class="title2 counter-up" data-count-to="29018"><span></span>29.018</h3>
						<hr class="lineWhite">
						<p data-aos="fade-left" data-aos-delay="300">Descritores e Qualificadores exclusivos do DeCS</p>
					</div>
				</div>
				<div class="col-md-4" data-aos="fade-up">
					<div class="boxHome">
						<h3 class="title2 counter-up" data-count-to="7741"><span></span></h3>
						<hr class="lineWhite">
						<p data-aos="fade-left" data-aos-delay="300">Códigos Hierárquicos em categorias DeCS</p>
					</div>
				</div>
			</div>
		</div>
	</section>


<section class="padding1 bgColor1">
	<div class="container">
		<h2><?php pll_e('DeCS in Numbers'); ?></h2>
		<div id="linha"></div>
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
					<div class="col-md-6" data-aos="fade-up">
						<td><img src="<?php echo $image_left['url']; ?>" alt="<?php echo $image_left['alt']; ?>" class="img-fluid"></td>
					</div>
					<div class="col-md-6 " data-aos="fade-down">
						<img src="<?php echo $image_right['url']; ?>" alt="<?php echo $image_right['alt']; ?>" class="img-fluid">
					</div>
				<?php endwhile;
			endwhile;?>
		</div>
	</div>
</section>





<?php get_template_part('includes/partners') ?>
</section>
<?php get_footer(); ?>