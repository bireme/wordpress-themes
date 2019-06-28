	<!--[if IE 7]>
	<html class="ie ie7" <?php language_attributes(); ?>>
	<![endif]-->
	<!--[if IE 8]>
	<html class="ie ie8" <?php language_attributes(); ?>>
	<![endif]-->
	<!--[if !(IE 7) | !(IE 8)  ]><!-->
	<html <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head>
		<title><?php wp_title('|', true, 'right'); ?> | <?php echo get_bloginfo('name') ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="author" content="AUTHOR">
		<meta name="<?php bloginfo( 'name' ); ?>" content="<?php bloginfo('description'); ?>">
		<meta name="keywords" content="KeyWords WordPress">
		<meta name="viewport" content="width=device-width" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->
		
		<!-- wp_head -->
		<?php wp_head(); ?>

		<!-- block extrahead -->
		<?= stripslashes( $header['extrahead'] ) ?>

		<!-- block extra files -->

		<!-- Bootstrap core CSS -->
		<link href="<?php echo get_bloginfo( 'stylesheet_directory' );?>/inc/css/bootstrap.min.css" rel="stylesheet">
		<!-- CSS do Tema -->
		<link href="<?php echo get_bloginfo( 'stylesheet_directory' );?>/style.css" rel="stylesheet">
	</head>
	<body <?php body_class( 'bg-white' ); ?> >
		<div class="container">
		<!-- Navigation -->
		<div class="row headerTop">
			<?php echo do_shortcode('[google-translator]'); ?>
			<div class="">
				<h1 class="logo"><a href="<?php echo site_url(); ?>"><span><?php bloginfo('name'); ?></span></a></h1>	
			</div>
			<div class="col-lg-7 desktop-version"> <!-- versão do menu para dispositivos com resolução maior que 1200px -->
				<nav class="navbar navbar-default">
					<?php
						wp_nav_menu( array(
							'menu'              => 'header-menu',
							'theme_location'    => 'header-menu',
							'depth'             => 2,
							'container'         => 'div',
							'container_class'   => 'menu-home1200',
							'container_id'      => 'bbb',
							'menu_class'        => 'nav navbar-nav',
							'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
							'walker'            => new wp_bootstrap_navwalker())
						);
					?>
				</nav>
			</div><!-- /desktop-version -->
		</div>
			<header>
			</header>
		</div>
		<div class="mobile col-lg-12"> <!-- Versão do menu para mobile ou resolução menor que 1200px -->
			<nav class="navbar menu-home-mobile">
				<ul>
					<li>
						<a href="#" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							MENU
						</a>
					</li>
				</ul>
				<?php
					wp_nav_menu( array(
						'menu'              => 'header-menu-mobile',
						'theme_location'    => 'header-menu-mobile',
						'depth'             => 2,
						'container'         => 'div',
						'container_class'   => 'collapse navbar-collapse',
						'container_id'      => 'bs-example-navbar-collapse-1',
						'menu_class'        => 'nav navbar-nav',
						'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
						'walker'            => new wp_bootstrap_navwalker())
					);
				?>
			</nav>
		</div> <!-- Fim da versão para mobile do menu -->
		<div class="container">