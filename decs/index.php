
<?php get_template_part('includes/topAcessibility') ?>
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
		<h2><?php pll_e('How to use DeCS'); ?></h2>
		<div id="linha"></div>
		<div class="row">
			<?php 
				$home = new WP_Query([
					'post_type' => 'Home',
					'orderby' => 'title',
    				'order' => 'ASC'
				]);
				while($home->have_posts()):$home->the_post();
					while(have_rows('group')):the_row(); 
						$texto = get_sub_field('texto'); 
						$video = get_sub_field('video'); 

						?>
					<div class="col-md-5" data-aos="fade-up">
						<div class="embed-responsive embed-responsive-16by9">
							<?php echo $video ?>
						</div>
					</div>
					<div class="col-md-7 marginM1" data-aos="fade-down">
						<?php echo $texto ?>
					</div>
				<?php endwhile;
			endwhile;?>
		</div>
	</div>
</section>
<?php get_template_part('includes/partners') ?>
</section>
<?php get_footer(); ?>