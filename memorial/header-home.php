<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body>
	<?php wp_body_open(); ?>
	<header id="header-home">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<a href="<?php bloginfo('siteurl'); ?>" class="navbar-brand">
						<img src="<?php bloginfo('template_directory'); ?>/img/brand-home.png" alt="" id="logo" class="img-fluid">
					</a>
				</div>
				<div class="col-md-9">
					<?php get_template_part('includes/nav-home') ?>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-md-12">
					<?php echo do_shortcode('[wpcode id="380"]'); ?>
				</div>
				<div class="col-md-4 offset-md-2 d-none" id="header-social">
					<p>Preservando memórias, <br>
						honrandovidas, <br>
					valorizando histórias</p>
					<hr>
					<a href=""><img src="<?php bloginfo('template_directory'); ?>/img/instagram.png" alt="" id="logo" class="img-fluid"></a>
					<a href=""><img src="<?php bloginfo('template_directory'); ?>/img/facebook.png" alt="" id="logo" class="img-fluid"></a>
					<a href=""><img src="<?php bloginfo('template_directory'); ?>/img/x.png" alt="" id="logo" class="img-fluid"></a>
					<a href=""><img src="<?php bloginfo('template_directory'); ?>/img/email.png" alt="" id="logo" class="img-fluid"></a>
				</div>
			</div>
		</div>
	</header>