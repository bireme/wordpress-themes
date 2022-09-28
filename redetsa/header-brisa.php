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
			<div class="row align-items-center">
				<div class="col-12 col-lg-2">
					<div id="bvsbox">
						<img src="http://logos.bireme.org/img/pt/bvs_color.svg" alt="" id="bvs" class="img-fluid">
					</div>
					
				</div>
				<div class="col-12 col-lg-7">
					<div class="text-center">
						<a href="http://pesquisa.bvsalud.org/brisa"><img src="<?php bloginfo('template_directory'); ?>/img/logoBrisa.png" alt="" id="logoBrisa"></a>
					</div>
					
				</div>
				<div class="col-12 col-lg-3">
					<div id="logoRedETSA">
						<a href="<?php echo get_option('siteurl'); ?>/<?php echo $language=='es'?'':$language; ?>"><img src="<?php bloginfo('template_directory'); ?>/img/logoRedETSA.png" alt="" ></a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<?php wp_head(); ?>