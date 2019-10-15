<?php get_template_part('includes/topAccessibility') ?>
<?php get_header(); ?>
<?php 
$home = new WP_Query([
	'post_type' => 'Home',
	'orderby' => 'title',
	'order' => 'ASC'
]);
?>

<header id="header">
	<div id="man" data-aos="fade-right" data-aos-duration="3000">
		<img src="<?php bloginfo('template_directory') ?>/img/man.png" alt="">
	</div>
	<div id="woman" data-aos="fade-left" data-aos-duration="3000">
		<img src="<?php bloginfo('template_directory') ?>/img/woman.png" alt="">
	</div>
	<div class="container">
		<div class="row" id="main_container">
			<div class="col-12">
				<div id="lang">
					<?php 
					wp_nav_menu( array(
						'theme_location'    => 'Language',
						'depth'             => 1,
						'container'         => 'ul',
						'container_class'   => 'list-unstyled',
						'container_id'      => '',
						'menu_class'        => '',
					) );
					?>
				</div>
			</div>
			<?php 
			while($home->have_posts()):$home->the_post();
				while(have_rows('grupo')):the_row(); 
					$title = get_sub_field('title'); 
					$sub_title = get_sub_field('sub_title'); 
					$description  = get_sub_field('description'); 
					?>
					<div class="col-md-6 offset-md-3 text-center" id="standoutTitulo">
						<img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="" id="logoSite"> <br>
						<h2>
							<?php echo $title ?>
						</h2>
						<h4>
							<?php echo $sub_title ?>
						</h4>
						<span id="iconStore">
							<a href="#" data-toggle="modal" data-target="#googlePlay"><img src="<?php bloginfo('template_directory') ?>/img/googlePlay.png" alt=""></a>
							<a href="#" data-toggle="modal" data-target="#appleStore"><img src="<?php bloginfo('template_directory') ?>/img/appleStore.png" alt=""></a>
						</span>
						<div class="text-center">
							<br><a href="" data-toggle="modal" data-target="#countriesM"><?php pll_e('See more interested countries'); ?></a>
						</div>
					</div>
				<?php endwhile;
			endwhile;?>
		</div>
	</div>
</header>


<section id="bgGray" class="padding50">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-lg-8" data-aos="fade-left" data-aos-duration="1000">
				<?php echo $description ?>
			</div>
			<div class="col-12 offset-md-0 col-md-6 col-lg-4 " id="imgMobile" data-aos="fade-right" data-aos-duration="1000">
				<img src="<?php bloginfo('template_directory') ?>/img/mobile3.png" class="img-fluid" alt="Picture Mobile">
			</div>
		</div>
	</div>
</section>

<?php while(have_rows('grupo2')):the_row(); 
	$health_title = get_sub_field('health_title'); 
	$health_text = get_sub_field('health_text'); 
	$trusted_title  = get_sub_field('trusted_title'); 
	$trusted_text = get_sub_field('trusted_text'); 
	$updated_title = get_sub_field('updated_title'); 
	$updated_text  = get_sub_field('updated_text'); 
	?>
	<section id="bgBlue">
		<div class="container">
			<div class="row">
				<div class="col-md-4 text-center boxIcons" data-aos="fade-left" data-aos-duration="1000">
					<img src="<?php bloginfo('template_directory') ?>/img/icon1.svg" alt="">
					<h4><?php echo $health_title ?></h4>
					<p><?php echo $health_text ?></p>
				</div>
				<div class="col-md-4 text-center boxIcons" data-aos="fade-up" data-aos-duration="1000">
					<img src="<?php bloginfo('template_directory') ?>/img/icon2.svg" alt="">
					<h4><?php echo $trusted_title ?></h4>
					<p><?php echo $trusted_text ?></p>
				</div>
				<div class="col-md-4 text-center boxIcons" data-aos="fade-right" data-aos-duration="1000">
					<img src="<?php bloginfo('template_directory') ?>/img/icon3.svg" alt="">
					<h4><?php echo $updated_title ?></h4>
					<p><?php echo $updated_text ?></p>
				</div>
			</div>
		</div>
	</section>


	<section id="dataCountries">
		<div class="container">
			<div class="row">
				<div class="col-md-6 text-center" data-aos="zoom-out" data-aos-duration="1000">
					<?php dynamic_sidebar('home_widget_left'); ?>
				</div>
				<div class="col-md-6 text-center" data-aos="zoom-in" data-aos-duration="1000">
					<?php dynamic_sidebar('home_widget_right'); ?>
				</div>
			</div>
		</div>
	</section>
	<?php
endwhile;?>

<?php get_footer(); ?>
<?php get_template_part('includes/modais') ?>