<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="generator" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<link rel="stylesheet" href="css/style.css">
	<?php wp_head(); ?>
</head>
<?php $lang = pll_current_language(); ?>
<body>
	<header id="header">
		<div class="container">
			<div class="row" style="position:relative;">
				<div class="col-md-4" id="brand">
					<a href="<?php echo get_option('siteurl'); ?>/<?php echo $lang=='pt'?'':$lang; ?>"><img src="<?php bloginfo('template_directory'); ?>/img/logo-<?php echo $lang; ?>.svg" alt=""></a>
				</div>
				<div class="col-md-8">
					<?php 
						wp_nav_menu( array(
							'theme_location'    => 'main-nav',
							'depth'             => 1,
							'container'         => 'ul',
							'container_class'   => 'list-unstyled',
							'container_id'      => '',
							'menu_class'        => '',
						) );
						?>
					</div>
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
		</header>