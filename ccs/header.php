<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body>
	<?php get_template_part('includes/topAccessibility') ?>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="float-start">
						<img src="http://logos.bireme.org/img/pt/bvs_color.svg" alt="" class="img-fluid" style="width: 90px; margin-right: 10px; background: #fff;">
					</div>
					<h1>Comunicação Científica em Saúde</h1>
				</div>
				<div class="col-md-4">
					<div id="lang">
						<?php 
						wp_nav_menu( array(
							'theme_location'    => 'Language',
							'depth'             => 1,
							'container'         => 'ul',
							'container_class'   => 'list-unstyled',
							'container_id'      => '',
							'menu_class'        => '',
						) );
						?>
					</div>		
				</div>
			</div>
		</div>
	</header>

