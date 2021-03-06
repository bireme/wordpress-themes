<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME/OPAS/OMS">
	<meta name="generator" content="Wordpress">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<?php wp_head(); ?>
</head>

<!-- Topo -->
<header class="container">
	<div class="row">
		<div class="col-md-4" id="logo">
			<a href="<?php bloginfo('home'); ?>"><img src="<?php bloginfo( 'template_directory' ); ?>/img/logo.svg" alt="" class="img-fluid"></a>
		</div>
		<div class="col-md-8">
			<div id="idiomas">  
				<?php
				wp_nav_menu( array(
					'theme_location'    => 'linguagem',
					'depth'             => 1,
					'container'         => 'ul',
					'container_class'   => 'list-unstyled',
					'container_id'      => '',
					'menu_class'        => '',
				) );
				?>
			</div>
			<div id="tituloSite"><?php bloginfo('name');?></div>
		</div>
	</div>
</header>
<!-- Menu -->
<nav class="navbar navbar-expand-lg navbar-light navbarblue">
	<div class="container">
		<button class="navbar-toggler navBt" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php
		wp_nav_menu( array(
			'theme_location'    => 'principal',
			'depth'             => 2,
			'container'         => 'div',
			'container_class'   => 'collapse navbar-collapse menuTopo',
			'container_id'      => 'bs-example-navbar-collapse-1',
			'menu_class'        => 'nav navbar-nav',
			// 'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
			// 'walker'            => new WP_Bootstrap_Navwalker(),
		) );
		?>
	</div>
</nav>