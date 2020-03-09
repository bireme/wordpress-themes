<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Language" content="pt-br">
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="generator" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/accessibility.css">
	<link rel="stylesheet" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=DM+Serif+Text&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<?php get_template_part('includes/topAcessibility') ?>
<header id="header">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-lg-6">
				<a href="<?php bloginfo('home'); ?>"><img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="" class="img-fluid"></a>
			</div>
			<div class="col-md-4 col-lg-6">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</header>