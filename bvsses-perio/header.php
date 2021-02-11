<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="author" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="generator" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body>
	<?php get_template_part('includes/topAcessibility') ?>

	<header id="header">
		<div class="container">
			<div id="brand">
				<a href="<?php echo get_option('siteurl'); ?>"><img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="" class="img-fluid imgBlack"></a>
			</div>
			<div id="brandTitle">
				<h1>
					Portal de Revistas Científicas<br>
					<small>da Secretaria da Saúde - SP</small>
				</h1>
			</div>
			<div id="headerConfig">
				<div id="language">
					<?php 
					wp_nav_menu( array(
						'theme_location'    => 'language',
						'depth'             => 1,
						'container'         => 'ul',
						'container_class'   => 'list-unstyled',
						'container_id'      => '',
						'menu_class'        => '',
					) );
					?>
				</div>
				<div id="social">
					<ul class="list-unstyled"><?php dynamic_sidebar('social') ?></ul>
				</div>
			</div>
			<div id="brandGoverno">
				<img src="<?php bloginfo('template_directory') ?>/img/logoGoverno.png" alt="" class="img-fluid imgBlack">
			</div>
		</div>
		<div class="clearfix"></div>
	</header>