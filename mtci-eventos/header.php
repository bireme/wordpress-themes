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
<?php while(have_posts()) : the_post();
	$logo 			= get_field('logo');
endwhile;
?>
<body>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-6" id="header-paho">
					<a href="<?php echo get_option('siteurl'); ?>"><img src="<?php bloginfo('template_directory'); ?>/img/header-paho-<?php echo $lang; ?>.png" alt=""></a>
				</div>

				<div class=" col-md-6" id="header-logo-evento">
					<img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>" class="img-fluid border">
				</div>
			</div>
		</div>		
	</header>