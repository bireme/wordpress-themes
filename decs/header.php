<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="<?php bloginfo('admin_email'); ?>">
	<meta name="generator" content="Wordpress - BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" /> 
	<?php wp_head(); ?>
</head>
<?php $idioma = pll_current_language(); ?>
<?php get_template_part('includes/topAcessibility') ?>
<header id="header">
	<div class="container"  style="position: relative;">
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
		<div class="row">
			<div class="col-10 col-md-6 col-lg-5 offset-1 offset-md-0" id="logoMain">
				<div class="row">
					<div class="col-3 col-md-3">
						<a href="http://www.bvsauld.org"><img src="http://logos.bireme.org/img/pt/bvs_color.svg" alt="Logo BVS" class="img-fluid imgBlack"></a>
					</div>
					<div class="col-9 col-md-9">
						<a href="index.php">
							<img src="http://logos.bireme.org/img/pt/decs_color.svg" alt="Logo DeCS" class="img-fluid imgBlack">
							<div id="versionBeta">Novo sitio beta do DeCS</div>
						</a>
					</div>
				</div>
			</div>
			<div class="col-10 col-md-6 col-lg-7 offset-1 offset-md-0 text-right" id="logosSecond">
				<img src="http://logos.bireme.org/img/pt/v_bir_color.svg" alt="Logo BIREME" class="img-fluid imgBlack">
			</div>
		</div>
	</div>
	</div>
</header>