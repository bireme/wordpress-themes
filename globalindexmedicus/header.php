<!DOCTYPE html>
<html <?php language_attributes() ?> >
<head>
	<meta http-equiv="Content-Language" content="pt-br, en, es, zh, ry, fr">
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME/OPAS/OMS">
	<meta name="generator" content="Wordpress">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<?php wp_head(); ?>
</head>
<!-- Topo -->
<?php get_template_part('includes/topAccessibility') ?>
<header class="container">
	<div class="row">
		<?php $idioma = pll_current_language(); ?>
		<div class="col-md-4 <?php //echo $idioma=='ar'?'order-last':''; ?>" id="logo">
			<a href="<?php echo get_option('siteurl'); ?>/<?php echo $idioma=='en'?'':$idioma; ?>"><img src="<?php bloginfo('template_directory') ?>/img/<?php echo $idioma; ?>/logo.svg" alt="<?php bloginfo('name');?>" class="img-fluid"></a>
		</div>
		<div class="col-md-8 <?php //echo $idioma=='ar'?'order-first':''; ?>" id="logo2">
			<div id="idiomas">  
				<?php 
				wp_nav_menu( array(
					'theme_location'    => 'linguagem',
					'depth'             => 1,
					'container'         => 'ul',
					'container_class'   => 'list-unstyled',
					'container_id'      => '',
					'menu_class'        => '',
				) );
				?>
				<?php // echo do_shortcode('[gtranslate]'); ?>
			</div>
			<div class="clearfix"></div>
			<div id="tituloSite"><?php bloginfo('name');?></div>
		</div>
	</div>
</header>
<!-- Menu -->
<nav class="navbar navbar-expand-lg navbar-light navbarblue" id="nav">
	<div class="container">
		<button class="navbar-toggler navBt" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php
		wp_nav_menu( array(
			'theme_location'    => 'principal',
			'depth'             => 2,
			'container'         => 'div',
			'container_class'   => 'collapse navbar-collapse menuTopo',
			'container_id'      => 'bs-example-navbar-collapse-1',
			'menu_class'        => 'nav navbar-nav',
			// 'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
			// 'walker'            => new WP_Bootstrap_Navwalker(),
		) );
		?>
	</div>
</nav>