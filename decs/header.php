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
						<a href="http://www.bvsalud.org/" target="_blank"><img src="http://logos.bireme.org/img/<?php echo $idioma; ?>/bvs_color.svg" alt="Logo BVS" class="img-fluid"></a>
					</div>
					<div class="col-9 col-md-9">
						<a href="<?php echo get_option('siteurl'); ?>/<?php echo $idioma=='pt'?'':$idioma; ?>"><img src="http://logos.bireme.org/img/<?php echo $idioma; ?>/decs_white.svg" alt="Logo DeCS" class="img-fluid"></a>
					</div>
				</div>
			</div>
			<div class="col-10 col-md-6 col-lg-7 offset-1 offset-md-0 text-right" id="logosSecond">
				<!-- <img src="img/logoOpas.svg" alt="" class="img-fluid"> -->
				<img src="http://logos.bireme.org/img/<?php echo $idioma; ?>/v_bir_white.svg" alt="Logo BIREME" class="img-fluid">
			</div>
		</div>
	</div>
</header>