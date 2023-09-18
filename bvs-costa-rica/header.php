<!DOCTYPE html>
<html <?php language_attributes() ?> >
<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME/OPAS/OMS - Márcio Alves">
	<meta name="generator" content="BIREME/OPAS/OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" />
	<?php wp_head(); ?>
	<?php $lang = pll_current_language(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href="<?php echo get_option('siteurl'); ?>"><img src="http://logos.bireme.org/img/<?php echo $lang; ?>/bvs_color.svg" id="header-bvs" class="img-fluid" alt=""></a>
					<a href="<?php echo get_option('siteurl'); ?>"><img src="<?php bloginfo('template_directory') ;?>/img/logo-costa-rica.png" id="logo-costarica" alt=""></a>
				</div>
			</div>
		</div>
	</header>