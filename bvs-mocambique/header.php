<!DOCTYPE html>
<html <?php language_attributes() ?> >
<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" />
	<?php wp_head(); ?>
</head>
<body>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-8" id="logo">
					<a href="https://bvsalud.org/" target="_blank"><img src="http://logos.bireme.org/img/pt/bvs_color.svg" id="logo-bvs" class="img-fluid" alt="BVS"></a>
					<a href="<?php echo get_option('siteurl'); ?>"><img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="BVS Moçambique" id="logo"></a>
				</div>
				<div class="col-md-12 col-lg-4"></div>
			</div>
		</div>
	</header>