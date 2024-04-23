<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header id="header">
		<div class="container">
			<div class="row" style="position:relative;">
				<div class="col-lg-6" id="logo-bvs">
					<a href="<?php echo get_option('siteurl'); ?>">
						<img src="http://logos.bireme.org/img/es/bvs_color.svg" alt="BVS" id="header-bvs" class="float-start">
					</a>

					<h1>
						<small><?php echo get_option('blogdescription'); ?></small><br>
						<img src="<?php bloginfo('template_directory') ?>/img/flag.svg" alt=""  id="flag"><?php echo get_option('blogname'); ?>
					</h1>
				</div>
				<div class="col-md-6" id="img-bvsuru">
					<img src="<?php bloginfo('template_directory') ?>/img/bvsuru.png" alt="">
				</div>
			</div>
		</div>
	</header>
	<?php wp_head(); ?>

