<!DOCTYPE html>
<html <?php language_attributes() ?> >
<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="generator" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<?php wp_head(); ?>
</head>
<body>
	<?php $language = pll_current_language(); ?>
	<?php get_template_part('includes/topAccessibility') ?>
	<header id="hearderBrisa">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-9">
					<div class="float-start" id="bvsbox">
						<img src="http://logos.bireme.org/img/pt/bvs_color.svg" alt="" id="bvs" class="img-fluid">
					</div>
					<img src="<?php bloginfo('template_directory'); ?>/img/logoBrisa.png" alt="" id="logoBrisa">
					<img src="<?php bloginfo('template_directory'); ?>/img/logoRedETSA.png" alt="" id="logoRedETSA">
				</div>
				<div class="col-12 col-lg-3">
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
			</div>
		</div>
	</header>
	<?php wp_head(); ?>