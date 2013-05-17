<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
$mlf_options = get_option('mlf_config');
//print_r($mlf_options);
$current_language = get_bloginfo('language');
$site_lang = substr($current_language, 0,2);
?>
<!DOCTYPE html>
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
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<noscript>Your browser does not support JavaScript!</noscript>
	<?php 
		$settings = get_option( "wp_bvs_theme_settings" );
		$layout = $settings['layout'];
		$header = $settings['header'];
		$colors = $settings['colors'];
		$total_columns = $layout['total'];
		$languages = $header['language'];//$settings['header'][language];
		$title = $header['title_view'];//$settings['header'][title_view];
		$logo = $header['logo'];//$settings['header']['logo'];
		$general_background = $colors['general-background'];//$settings['colors']['general-background'];
		$general_container = $colors['general-container'];//$settings['colors']['general-container'];
		$general_title_first = $colors['general-title-first'];//$settings['colors']['general-title-first'];
		$general_title_second = $colors['general-title-second'];//$settings['colors']['general-title-second'];
		$general_title_third = $colors['general-title-third'];//$settings['colors']['general-title-third'];
		$general_background_img = $layout['background'];//$settings['layout']['background'];
		$general_color = $colors['general-text'];//$settings['colors']['general-text'];
		$general_link_active = $colors['general-link-active'];//$settings['colors']['general-link-active'];
		$general_link_visited = $colors['general-link-visited'];//$settings['colors']['general-link-visited'];
		$header_banner = $header['banner'];//$settings['header']['banner'];
		$header_background_color = $colors['header-background'];//$settings['colors']['header-background'];	
		$header_title_color = $colors['header-title-frist'];//$settings['colors']['header-title-first'];
		$header_link_color = $colors['header-link-active'];//$settings['colors']['header-link-active'];
		$top_sidebar = $layout['top-sidebar'];//$settings['layout']['top-sidebar'];
		$footer_sidebar = $layout['footer-sidebar'];//$settings['layout']['footer-sidebar'];
		$language_position = $header['language-position'];//$settings['header']['language-position'];
		//layout[top-sidebar]
		//print_r($colors);
		//echo $language_position;
	?>
	<link rel='stylesheet' id='generic_css'  href='<?php echo get_template_directory_uri(); ?>/bireme_archives/css/generic.css' type='text/css' media='all' />
	<link rel='stylesheet' id='columns'  href='<?php echo get_template_directory_uri(); ?>/bireme_archives/css/<?php echo $total_columns; ?>_columns.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/bireme_archives/custom/custom.css' type='text/css' media='all' />
	<?php wp_head(); ?>
	<style>
		body {
			background: #<?php echo $general_background;?> !important;	
			color: #<?php echo $general_color;?>;
			background-image: url('<?php echo $general_background_img;?>') !important;
			background-position: top center !important;
		}
		a {
			color: #<?php echo $general_link_active;?>;		
			}
		a:visited {
			color: #<?php echo $general_link_visited;?>;		
			}
		.container {
			background: #<?php echo $general_container;?> !important;	
		}
		.bar a {
			color: #<?php echo $header_link_color;?>;	
		}
		.header {
			background: #<?php echo $header_background_color;?> url(<?php echo $header_banner;?>)top left no-repeat;	
		}
		.header h1 a {
			color: #<?php echo $header_title_color;?>;
		}
		#content h1, .content h1 a {
			color: #<?php echo $general_title_first;?> !important;
		}
		#content h2, .content h2 a {
			color: #<?php echo $general_title_second;?> !important;
		}
		#content h3, .content h3 a {
			color: #<?php echo $general_title_third;?> !important;
		}
	<?php 
		if ($language_position == 2) {
	?>
		.bar {
			margin-top: 96px;
			position: absolute;
			width: 1000px;	
		}
	<?php
		}
	?>			
	</style>
	</head>

	<body <?php body_class(); ?>>

	<div class="container <?php echo $total_columns;?>_columns">
		<div class="header">
			<div class="bar">
				<div id="otherVersions">
					<?php mlf_links_to_languages(); ?>	
				</div>
				<div id="contact"> 
					<span><a href="/<?php echo ( $site_lang ); ?>/contact/">Contato</a></span>
				</div>
			</div>
	        <div class="top top_<?php echo ($current_language);?>">
	            <div id="parent">
	            	<a href="http://regional.bvsalud.org/php/index.php?lang=<?php echo ( $site_lang ) ?>" alt="Portal Regional da BVS">
		                <img src="<?php echo $logo;?>" alt="BVS LOGO"/>
	        		</a>
	            </div>
	           	<?php if ($title == true) {	?>
		            <div class="site_name">
						<h1><a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" href="<?php echo esc_url( home_url( '/'.( $site_lang ) ) ); ?>"><span><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span></a></h1>            
		            </div>
				<?php } ?>
				<div class="headerWidget">
					<?php dynamic_sidebar( 'header' ); ?>
				</div>
	        </div>
			<div class="spacer"></div>	
		</div>
