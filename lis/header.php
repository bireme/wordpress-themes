<!doctype html>
<html lang="pt-br">
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
 
	<!-- Facebook -->
	<meta property="og:title" content="Wesley Amaro"/>
	<meta property="og:site_name" content="Wesley Amaro"/>
	<meta property="og:url" content="http://www.wesleyamaro.com.br"/>
	<meta property="og:image" content="http://www.wesleyamaro.com.br/imagens/fb-share.jpg"/>
	<meta property="og:description" content=""/>

	<!-- FAVICON -->
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />

	<!-- CSS -->
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<?php wp_head(); ?>
</head>
<body>		
	<header class="header">
		<div id="header-barra-topo" class="row-fluid">
			<div class="ajusta">
				<div class="pull-right">
					<ul class="header-idiomas">
						<li class="header-idiomas-li"><a class="header-idiomas-li-a" href="#">English</a></li>
						<li class="header-idiomas-li"><a class="header-idiomas-li-a" href="#">Español</a></li>
						<li class="header-idiomas-li"><a class="header-idiomas-li-a header-idiomas-ativo" href="#">Português</a></li>
					</ul>

					<a class="header-contato" href="contato"><i class="ico-contato"></i>Contato</a>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="ajusta">
				<div class="row-fluid border-bottom">
					<a href="<?php echo get_settings('home');?>" class="pull-left"><h1 class="header-logo">Biblioteca Virtual da Saúde - BVS</h1></a>
				</div>
			</div>
		</div>
	</header>