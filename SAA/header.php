<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="" /> 
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="all" />

	<title>
	<?php if (is_home()){
		bloginfo('name');
	}elseif (is_category()){
		single_cat_title(); echo ' -  ' ; bloginfo('name');
	}elseif (is_single()){
		single_post_title();
	}elseif (is_page()){
		bloginfo('name'); echo ': '; single_post_title();
	}else {
		wp_title('',true);
	} ?>
	</title>

	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

	<!-- FAVICON -->
	<link rel="shortcut icon" href="favicon.ico" />

	<!-- CSS -->
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<?php wp_head(); ?>
</head>
<body>
	<div class="barra-gov">
		<div class="ajusta height-gov">
			<a href="#content" class="barra-gov-acess-content" title="Acesso a informação"></a>
			<div class="barra-gov-brazil"></div>
		</div>
		<div class="line-yellow"></div>
	</div>
	<div class="row-fluid" id="container">
	<div id="box">
		<header class="h">
			<a href="<?php echo get_settings('home'); ?>">
				<h1 class="h-logo">
					<img src="<?php bloginfo('template_directory'); ?>/Imagens/saa-informa-logo.png" alt="">
				</h1>
			</a>
			
			<section class="h-search">
				<form role="search" method="get" id="searchform" action="<?php echo get_option('home'); ?>">
					<input value="" name="s" class="input-search" id="s" type="text" placeholder="Pesquisa no SAA Informa...">
					<input id="searchsubmit" value="" type="submit" class="b-search">
				</form>
			</section>
			<div id="navMobile">
				<div class="navMobileBar1"></div>
				<div class="navMobileBar2"></div>
				<div class="navMobileBar3"></div>
			</div>
			<nav id="site-navigation" class="h-nav site-navigation" role="navigation">
				<?php wp_nav_menu( array('theme_location' => 'primary', 'menu_class' => 'h-nav-ul' ) );?>
				<div class="pull-right">
					<span class="h-nav-border-right"></span>
					<a href="contato" class="pull-left">
						<i class="i-mail"><img src="<?php bloginfo('template_directory'); ?>/Imagens/mail.png" alt=""></i>
						<span class="i-mail-txt">Contato</span>
					</a>
					<a href="#" class="i-amaior"><img src="<?php bloginfo('template_directory'); ?>/Imagens/plus.png" alt=""></a>
					<a href="#" class="i-amenor"><img src="<?php bloginfo('template_directory'); ?>/Imagens/less.png" alt=""></a>
				</div>
			</nav><!-- #site-navigation -->
		</header>