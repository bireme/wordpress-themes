<!DOCTYPE html>
<html <?php language_attributes() ?> >
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body>
	<?php $language = pll_current_language(); ?>
	<?php get_template_part('includes/topAccessibility') ?>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="float-start">
						<img src="http://logos.bireme.org/img/<?php echo $idioma; ?>/bvs_color.svg" alt="Logo BVS" class="img-fluid" style="width: 90px; margin-right: 10px; background: #fff;">
					</div>
					<h1><?php bloginfo('name');?></h1>
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

