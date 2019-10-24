<?php get_header(); ?>
<?php get_template_part('includes/search') ?>
<?php get_template_part('includes/banners') ?>
<main id="main_container" class="padding1">
	<section id="consultaServico">
		<div class="container" id="main_container">
			<div class="row">
				
				<div class="col-md-4 homeConsult" data-aos="flip-left" data-aos-delay="300">
					<div class="homeIconeConsulta">
						<i class="fas fa-th iconeCS"></i>
					</div>
					<h4 class="titulo2"><?php pll_e('Meet DeCS'); ?></h4>
					<?php
					wp_nav_menu( array(
						'theme_location'    => 'home1',
						'depth'             => 1,
						'container'         => 'ul',
						'container_class'   => 'list-unstyle',
						'container_id'      => '',
						'menu_class'        => '',
					) );
					?>
				</div>

				<div class="col-md-4 homeConsult" data-aos="flip-left" data-aos-delay="400">
					<div class="homeIconeConsulta">
						<i class="fas fa-envelope-open-text iconeCS"></i>
					</div>
					<h4 class="titulo2"><?php pll_e('Contact us'); ?></h4>
					<?php
					wp_nav_menu( array(
						'theme_location'    => 'home2',
						'depth'             => 1,
						'container'         => 'ul',
						'container_class'   => 'list-unstyle',
						'container_id'      => '',
						'menu_class'        => '',
					) );
					?>
				</div>

				<div class="col-md-4 homeConsult" data-aos="flip-left" data-aos-delay="500">
					<div class="homeIconeConsulta">
						<i class="fas fa-laptop-code iconeCS"></i>
					</div>
					<h4 class="titulo2"><?php pll_e('For Developers'); ?></h4>
					<?php
					wp_nav_menu( array(
						'theme_location'    => 'home3',
						'depth'             => 1,
						'container'         => 'ul',
						'container_class'   => 'list-unstyle',
						'container_id'      => '',
						'menu_class'        => '',
					) );
					?>
				</div>

			</div>
		</div>
	</section>
</main>
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