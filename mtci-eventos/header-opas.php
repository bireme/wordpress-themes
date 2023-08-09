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
	<header id="header-opas">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<img src="<?php bloginfo('template_directory'); ?>/img/header-opas-<?php echo $lang; ?>.png" class="img-fluid" alt="">
				</div>
				<div class="col-md-4" id="logo-event">
					<?php the_post_thumbnail('full', ['class' => 'img-fluid rounded ']);  ?>
				</div>
			</div>
		</div>
	</header>