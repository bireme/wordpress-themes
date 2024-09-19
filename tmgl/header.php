<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<?php wp_head(); ?>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME / PAHO / WHO">
	<meta name="generator" content="BIREME / PAHO / WHO">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
	<header id="header" class="sticky-top">
		<div class="container">
			<button id="hamburger" class="">
				<i class="bi bi-list"></i>
			</button>	
			<div class="row">
				<div class="col-lg-5">
					<a href="<?php echo get_option('siteurl'); ?>">
						<img src="<?php bloginfo('template_directory'); ?>/img/logo.svg" id="brand-icon" alt="">
						<div id="brand">
							TMGL
							<small>The WHO Traditional Medicine Global Library</small>
						</div>
					</a>
				</div>
				<div class="col-lg-7" id="nav">
					<nav id="nav-global">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'global-menu',
							'container' => 'div',
							'container_class' => 'global-menu'
						));
						?>
					</nav>
					<nav id="nav-regional">
						<?php
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
</body>
</html>
