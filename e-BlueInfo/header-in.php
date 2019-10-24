<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="<?php bloginfo('admin_email'); ?>">
	<meta name="generator" content="Wordpress - BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<?php wp_head(); ?>
</head>
<?php $idioma = pll_current_language(); ?>
<header class="" id="headerIn">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-4" id="logoIn">
				<a href="<?php echo get_option('siteurl'); ?>/<?php echo $idioma=='pt'?'':$idioma; ?>"><img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="Brand e-BlueInfo"></a>
			</div>
			<div class="col-12 col-md-12 col-lg-8">
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
				<nav id="nav">
					<?php
					wp_nav_menu( array(
						'theme_location'    => 'main-nav',
						'depth'             => 1,
						'container'         => 'ul',
						'container_class'   => 'list-unstyle',
						'container_id'      => '',
						'menu_class'        => '',
					) );
					?>
				</nav>
			</div>
		</div>
	</div>
</header>