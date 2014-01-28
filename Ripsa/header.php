<?php
    load_theme_textdomain('Ripsa', get_stylesheet_directory() . '/languages');
?>
<!doctype html>
<html lang="<?php echo bloginfo('language');?>">
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
	<meta property="og:title" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:description" content=""/>

	<!-- FAVICON -->
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />

	<!-- CSS -->
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>
	<link rel="stylesheet" type="text/css" media="print" href="<?php bloginfo('stylesheet_directory'); ?>/print.css" />

	<?php wp_head(); ?>
</head>
<body>
	<div id="box">
		<header class="header lang-<?php bloginfo('language');?>">
			<a href="<?php echo get_settings('home') . '/?l=' . get_bloginfo('language');?>">
				<h1 class="header-logo">Portal de Fichas de Qualificação</h1>
			</a>
			<div class="header-desenho"></div>

			<nav class="header-idiomas">
				<?php 
					global $site_lang;
					if(function_exists('mlf_links_to_languages')) { 
						mlf_links_to_languages(); 
					} else {
						create_language_list($site_lang);
					} 
				?>
			</nav>
		</header>
