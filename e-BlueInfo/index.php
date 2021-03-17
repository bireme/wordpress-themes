<?php get_header(); ?>

<header id="header">
	<div id="man" data-aos="fade-right" data-aos-duration="3000">
		<img src="<?php bloginfo('template_directory') ?>/img/man.png" alt="">
	</div>
	<div id="woman" data-aos="fade-left" data-aos-duration="3000">
		<img src="<?php bloginfo('template_directory') ?>/img/woman.png" alt="">
	</div>
	<div class="container" tabindex="11">
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
			<?php $home = new WP_Query([ 'post_type' => 'Home']);
			while($home->have_posts()):$home->the_post();
				while(have_rows('grupo')):the_row(); 
					$title = get_sub_field('title'); 
					$sub_title = get_sub_field('sub_title'); 
					$description  = get_sub_field('description'); 
					?>
					<div class="col-md-6 offset-md-3 col-lg-8 offset-lg-2 text-center" id="standoutTitulo" role="logo" tabindex="12">
						<img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="Logo E-BlueInfo" id="logoSite"> <br>
						<h2>
							<?php echo $title ?>
						</h2>
						<div class="text-center" tabindex="13">
							<h5><a href="" data-toggle="modal" data-target="#countriesM"><?php pll_e('See more interested countries'); ?></a></h5>
						</div>
						<h4>
							<?php echo $sub_title ?>
						</h4>
						<span id="iconStore">
							<a href="#" data-toggle="modal" data-target="#googlePlay" role="button"><img src="<?php bloginfo('template_directory') ?>/img/googlePlay.png" alt="Google Play"></a>
							<a href="#" data-toggle="modal" data-target="#appleStore" role="button"><img src="<?php bloginfo('template_directory') ?>/img/appleStore.png" alt="Apple Store" ></a>
						</span>
					</div>
				<?php endwhile;
			endwhile;?>
		</div>
	</div>
</header>

<?php get_template_part('includes/banners'); ?>

<?php 
while($home->have_posts()):$home->the_post();?>
	<section id="bgGray" class="padding50" tabindex="14">
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
<?php endwhile; ?>

<?php 
while(have_rows('grupo3')):the_row(); 
	$image_section 	= get_sub_field('image_section'); 
	$text_section	= get_sub_field('text_section'); 
	$image_card_1 	= get_sub_field('image_card_1'); 
	$title_card_1 	= get_sub_field('title_card_1'); 
	$text_card_1 	= get_sub_field('text_card_1'); 
	$image_card_2 	= get_sub_field('image_card_2'); 
	$title_card_2 	= get_sub_field('title_card_2'); 
	$text_card_2 	= get_sub_field('text_card_2'); 
	?>
	<section id="guide" class="padding50">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<img src="<?php echo esc_url($image_section['url']); ?>" alt="<?php echo $image_card_2['alt'] ?>" class="img-fluid rounded">
				</div>
				<div class="col-md-7">
					<?php echo $text_section ?>
				</div>
			</div>
		</div>
	</section>
<?php endwhile;?>



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
				<div class="col-md-4 text-center boxIcons" data-aos="fade-left" data-aos-duration="1000" tabindex="16">
					<img src="<?php bloginfo('template_directory') ?>/img/icon1.svg" alt="">
					<h4><?php echo $health_title ?></h4>
					<p><?php echo $health_text ?></p>
				</div>
				<div class="col-md-4 text-center boxIcons" data-aos="fade-up" data-aos-duration="1000" tabindex="17">
					<img src="<?php bloginfo('template_directory') ?>/img/icon2.svg" alt="">
					<h4><?php echo $trusted_title ?></h4>
					<p><?php echo $trusted_text ?></p>
				</div>
				<div class="col-md-4 text-center boxIcons" data-aos="fade-right" data-aos-duration="1000" tabindex="18">
					<img src="<?php bloginfo('template_directory') ?>/img/icon3.svg" alt="">
					<h4><?php echo $updated_title ?></h4>
					<p><?php echo $updated_text ?></p>
				</div>
			</div>
		</div>
	</section>

<?php endwhile;?>

<section id="dataCountries">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="card mb-3 shadow ">
					<div class="row no-gutters">
						<div class="col-md-4 cardImg">
							<img src="<?php echo esc_url($image_card_1['sizes']['sizecard']); ?>" alt="<?php echo $image_card_2['alt'] ?>" >
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title"><?php echo $title_card_1; ?></h5>
								<p class="card-text"><?php echo $text_card_1; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card mb-3 shadow ">
					<div class="row no-gutters">
						<div class="col-md-4 cardImg">
							<img src="<?php echo esc_url($image_card_2['sizes']['sizecard']); ?>" alt="<?php echo $image_card_2['alt'] ?>" >
						</div>
						<div class="col-md-8">
							<div class="card-body">
								<h5 class="card-title"><?php echo $title_card_2; ?></h5>
								<p class="card-text"><?php echo $text_card_2; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
<?php get_template_part('includes/modais') ?>