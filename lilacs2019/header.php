<?php
/**
 * Theme LILACS 2019
 */
$mlf_options = get_option('mlf_config');
$current_language = strtolower(get_bloginfo('language'));
$site_lang = substr($current_language, 0,2);
$suffix = ( !defined( 'POLYLANG_VERSION' ) ) ? '_' . $current_language : '';
?>
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
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
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
        <link href="<?php echo get_bloginfo( 'stylesheet_directory' );?>/inc/css/accessibility.css" rel="stylesheet">
        <link href="<?php echo get_bloginfo( 'stylesheet_directory' );?>/inc/css/feedback.css" rel="stylesheet">
		<!-- CSS do Tema -->
		<link href="<?php echo get_bloginfo( 'stylesheet_directory' );?>/style.css" rel="stylesheet">
		<!-- Hotjar Tracking Code for LILACS -->
		<script>
		    (function(h,o,t,j,a,r){
		        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
		        h._hjSettings={hjid:6506797,hjsv:6};
		        a=o.getElementsByTagName('head')[0];
		        r=o.createElement('script');r.async=1;
		        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
		        a.appendChild(r);
		    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
		</script>
	</head>
	<body <?php body_class('bg-white site_'.$site_lang); ?>>
    <?php get_template_part (  'topAccessibility'); ?>
		<div class="col-lg-12 bar">
			<div class="container bar-inner">
				<div class="row">
					<div class="col-6">
						<?php dynamic_sidebar('vhl_menu_1'); ?>
					</div>
					<div class="col-6 text-right">
						<?php if ( has_nav_menu( 'custom-menu-location' ) ) {
    						wp_nav_menu( array( 'theme_location' => 'custom-menu-location', 'container_class' => 'custom-menu-location' ) );
    					} else {
							if ( function_exists( 'mlf_links_to_languages' ) ) {
								mlf_links_to_languages();
							} else {
								language_switcher();
							}
						} ?>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
		<!-- Navigation -->
			<div class="row header header_<?php echo ( $site_lang ); ?>">
				<div class="col-lg-6">
                <a class="bvs_logo" href="https://bvsalud.org/<?php echo ( "pt" == $site_lang ) ? '' : $site_lang; ?>">
						<img src="http://logos.bireme.org/img/<?php echo ( $site_lang ); ?>/bvs_color.svg" 
							 alt="<?php bloginfo('description'); ?>" 
							 title="<?php bloginfo('description'); ?>" />
					</a>
					<a class="lilacs_logo" href="<?php echo site_url(); ?>/<?php echo ( "pt" == $site_lang ) ? '' : $site_lang; ?>">
						<img src="<?php echo get_bloginfo( 'stylesheet_directory' );?>/images/lilacs_logo_<?php echo ( $site_lang ); ?>.png" 
							 alt="<?php bloginfo('description'); ?>" 
							 title="<?php bloginfo('description'); ?>" />
					</a>
					<div class="site_info">
						<h1 class="site_name"><a href="<?php echo site_url(); ?>"><span><?php bloginfo('name'); ?></span></a></h1>
						<span class="site_description"><?php bloginfo('description'); ?></span>
						<span class="site_slogan slogan_pt">Um bem público regional de informação científica</span>
						<span class="site_slogan slogan_es">Un bien público regional de información científica</span>
						<span class="site_slogan slogan_en">A regional public good on scientific information</span>
					</div>
				</div>
				<div class="col-lg-6 institutional">
					<a href="https://www.paho.org/bireme/index.php?lang=<?php echo ( $site_lang ); ?>"><span>BIREME | OPAS | OMS </span></a>
				</div>
			</div>
			<header>
			</header>
		</div>
		<div class="col-lg-12 header_menu" id="nav">
			<?php dynamic_sidebar(  'header_menu'); ?>
		</div>
