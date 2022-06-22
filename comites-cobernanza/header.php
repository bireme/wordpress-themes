<!DOCTYPE html>
<html <?php language_attributes() ?> >
<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="generator" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<?php wp_head(); ?>
</head>
<body>
	<?php $language = pll_current_language(); ?>
	<header id="header">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<a href="<?php echo get_option('siteurl'); ?>/<?php echo $language=='es'?'':$language; ?>"><img src="<?php bloginfo('template_directory'); ?>/img/logo-<?php echo $language; ?>.png" alt="" id="logo"></a>
			</div>
			<div class="col-md-6">
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
	
