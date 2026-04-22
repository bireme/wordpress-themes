<!DOCTYPE html>
<html <?php language_attributes() ?> >
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<?php $lang = pll_current_language(); ?>
<body>
	<?php wp_body_open(); ?>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<a href="<?php bloginfo('siteurl'); ?>" class="navbar-brand">
						<img src="<?php bloginfo('template_directory'); ?>/img/brand-<?php echo $lang; ?>.png" alt="" id="logo" class="img-fluid">
					</a>
				</div>
				<div class="col-md-9" style="position: relative;">
					<?php get_template_part('includes/nav-lang') ?>
					<?php get_template_part('includes/nav') ?>
				</div>
			</div>
		</div>
	</header>