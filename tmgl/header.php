<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<?php wp_head(); ?>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME / PAHO / WHO">
	<meta name="generator" content="BIREME / PAHO / WHO">
</head>
<body>
	
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<a href="<?php echo get_option('siteurl'); ?>"><img src="<?php bloginfo('template_directory'); ?>/img/logo.svg" id="brand-icon" alt=""></a>
					<div id="brand">
						TMGL
						<small>Traditional Medicine Global Library</small>
					</div>
				</div>
				<div class="col-md-8" id="nav">
					<nav id="nav-global">
						<?php //global
						wp_nav_menu(array(
							'theme_location' => 'global-menu',
							'container' => 'div',
							'container_class' => 'global-menu'
						));
						?>
					</nav>
					<nav id="nav-regional">
						<?php // regional
						wp_nav_menu(array(
							'theme_location' => 'regional-menu',
							'container' => 'div',
							'container_class' => 'regional-menu'
						));
						?>
					</nav>
				</div>

			</div>
		</div>
	</header>