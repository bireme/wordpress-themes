<?php wp_head(); ?>
<!DOCTYPE html>
<html <?php language_attributes() ?> >
<head>
	<meta charset="UTF-8">
	<meta name="author" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="generator" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<title>Evid@Easy</title>
	<link rel="stylesheet" href="css/style.css">
	<?php wp_head(); ?>
</head>
<body>
	<?php $idioma = pll_current_language(); ?>
	<?php get_template_part('includes/topAcessibility') ?>
	<header id="header">
		<div class="container">
			<div class="row">
				<div id="logoBir" class="col-3 col-md-2">
					<a href="https://bvsalud.org/<?php echo $idioma=='pt'?'':$idioma; ?>" target="_blank"><img src="http://logos.bireme.org/img/<?php echo $idioma?>/bvs_color.svg" alt="BIREME / OPAS / OMS" class="img-fluid imgBlack"></a>
				</div>
				<div id="logo" class="col-9 col-md-9">
					<a href="<?php echo get_option('siteurl'); ?>/<?php echo $idioma=='pt'?'':$idioma; ?>"><img src="<?php bloginfo('template_directory') ?>/img/logo-<?php echo $idioma?>.png" class="img-fluid"></a>
				</div>
			</div>
			<div class="lang">
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
	</header>