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
			<div style="position: relative;">
				<div id="language">
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
			<div class="row">
				<div id="brand" class="col-md-2 text-center">
					<img src="http://logos.bireme.org/img/pt/bvs_color.svg" alt="" class="img-fluid">
				</div>
				<div class="col-md-10" id="textTop">
					<a href="<?php echo get_option('siteurl'); ?>"><img src="<?php bloginfo('template_directory') ?>/img/logo.svg" class="img-fluid" alt=""></a>
				</div>
			</div>
		</div>
	</header>