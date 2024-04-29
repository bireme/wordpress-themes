<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="author" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="generator" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<link rel="stylesheet" href="css/style.css">
	<?php wp_head(); ?>
</head>
<body>
	<?php get_template_part('includes/topAcessibility') ?>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-9" id="logo">
					<div id="logoBVS">
						<a href="https://bvsalud.org/" target="_blank">
							<img src="http://logos.bireme.org/img/pt/bvs_color.svg" alt="" class="img-fluid" >
						</a>
					</div>
					<h1>
						<a href="<?php echo get_option('siteurl'); ?>">
							<b>Biblioteca Virtual em Saúde</b> <br>
							<small>MINISTÉRIO DA SAÚDE</small>
						</a>
					</h1>
				</div>
				<div class="col-md-3" id="headerSocial">
					<ul class="list-unstyled"><?php dynamic_sidebar('header') ?></ul>
				</div>
			</div>
		</div>
	</header>