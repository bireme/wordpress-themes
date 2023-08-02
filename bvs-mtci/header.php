<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="generator" content="BIREME / OPAS / OMS - Márcio Alves">
	<?php wp_head(); ?>
</head>
<?php $lang = pll_current_language(); ?>
<body>
	<header id="header">
		<div class="container">
			<div class="row" id="lang-row">
				<div class="col-3 col-md-2" id=logo-bvs>
					<a href="https://bvsalud.org/<?php echo $lang=='pt'?'':$lang; ?>" target="_blank"><img src="http://logos.bireme.org/img/<?php echo $lang; ?>/bvs_color.svg" id="header-bvs" class="img-fluid" alt=""></a>
				</div>
				<div class="col-6 col-md-2" id="logo-mtci">
					<a href="<?php echo get_option('siteurl'); ?>/<?php echo $lang=='es'?'':$lang; ?>"><img src="<?php bloginfo('template_directory'); ?>/img/logo-<?php echo $lang; ?>.png" id="header-mtci" alt=""></a>
				</div>
				<div class="col-3 col-md-2 offset-md-6 text-end" id="logo-red-mtci">
					<img src="<?php bloginfo('template_directory'); ?>/img/red-mtci-<?php echo $lang; ?>.png" id="header-red" alt="">
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
					#'walker' => new description_walker(),
					) );
					?>
				</div>
			</div>
		</div>
	</header>