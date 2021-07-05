<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="author" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="generator" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
	<?php wp_head(); ?>
</head>
<body>
	<?php get_template_part('includes/topAcessibility') ?>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-8" id="logo">
					<a href="<?php echo get_option('siteurl'); ?>"><img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="" class="img-fluid"></a>
				</div>
				<div class="col-md-4" id="headerSocial">

				</div>
			</div>
		</div>
	</header>