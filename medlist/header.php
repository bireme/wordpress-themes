<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME/OPAS/OMS">
	<meta name="generator" content="Wordpress">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:400,700,900" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<header>
	<div class="tituloPrincipal">
		<div class="container" style="position: relative;">
			<div id="idioma">
				<?php 
				wp_nav_menu( array(
					'theme_location'    => 'linguagem',
					'depth'             => 1,
					'container'         => 'ul',
					'container_class'   => 'navbar-nav mr-auto',
					'container_id'      => '',
					'menu_class'        => 'nav-item',
				) );
				?>
			</div>
			<h3><?php echo pll_e('Listas Anotadas de Medicamentos e Dispositivos'); ?></h3>
		</div>
	</div>
	<!-- <nav class="navbar navbar-expand-lg navbar-dark">
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<?php /*
				wp_nav_menu( array(
					'theme_location' => 'menu',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'depth'          => 2,
					'menu_class'     => 'navbar-nav mr-auto',
					'walker'         => new Bootstrap_NavWalker(),
					'fallback_cb'    => 'Bootstrap_NavWalker::fallback',
				) );
				*/?>
			</div>
			<div class="dropdown-divider"></div>
			<div id="idioma">
				<?php /*
				wp_nav_menu( array(
					'theme_location'    => 'linguagem',
					'depth'             => 1,
					'container'         => 'ul',
					'container_class'   => 'navbar-nav mr-auto',
					'container_id'      => '',
					'menu_class'        => 'nav-item',
				) );
				*/ ?>
			</div>
		</div>
	</nav> -->
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<?php $idioma = pll_current_language(); ?>
				<a href="http://prais.paho.org/"><img src="<?php bloginfo('template_directory') ?>/img/<?php echo $idioma; ?>/topo.png" alt="" class="img-fluid"></a>
			</div>	
		</div>
		<hr>
	</div>
</header>