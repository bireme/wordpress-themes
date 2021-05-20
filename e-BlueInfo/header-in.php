<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="<?php bloginfo('admin_email'); ?>">
	<meta name="generator" content="Wordpress - BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" />
	<?php wp_head(); ?>
</head>

<?php $idioma = pll_current_language(); ?>

<?php if ( strpos($_SERVER['HTTP_USER_AGENT'], 'gonative') === false ) : ?>
	<?php get_template_part('includes/topAccessibility') ?>
	<header class="" id="headerIn" role="banner">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-4" id="logoIn" role="logo">
					<a href="<?php echo get_option('siteurl'); ?>/<?php echo $idioma=='pt'?'':$idioma; ?>"><img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="Brand e-BlueInfo"></a>
				</div>	
				<div class="col-12 col-md-12 col-lg-8" role="navigation">
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
				<div class="col-12 d-sm-block d-md-none">
					<nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light">
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
							<?php
							wp_nav_menu( array(
								'theme_location'    => 'main-nav',
							'depth'             => 1,
								'container'         => 'div',
								'container_class'   => 'collapse navbar-collapse',
								'container_id'      => 'navbarSupportedContent',
								'menu_class'        => 'navbar-nav mr-auto',
							) );
							?>
					</nav>
				</div>
				<div class="col-12 d-none d-md-block">
					<nav id="nav" role="navigation">
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
<?php endif; ?>