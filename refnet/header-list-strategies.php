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
?>

<?php
	load_theme_textdomain('refnet', get_stylesheet_directory() . '/languages');
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
	
	<!-- extract the admin configs -->
	<?php include (get_template_directory () . "/bireme_archives/admin_configs.php"); ?>

	<!-- wp_head -->
	<?php wp_head(); ?>

	<!-- block extrahead -->
	<?= stripslashes( $header['extrahead'] ) ?>

	<!-- block extra files -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/network.js"></script>

	</head>

	<body <?php body_class(); ?>>

	<div class="container <?php echo $total_columns;?>_columns">
		<div class="header">
			<div class="bar">
				<div id="otherVersions">
					<?php 
						global $site_lang;
						if(function_exists('mlf_links_to_languages')) { 
							mlf_links_to_languages(); 
						} else {
							create_language_list($site_lang);
						} 
					?>	
				</div>
				<div class="feedback">
					<a href="http://feedback.bireme.org/feedback/?application=queries&version=1.0&lang=<?php echo substr($site_lang,0,2); ?>" title="<?php _e('Leave a comment / Report an error','refnet');?>">

						<?php _e('Leave a comment / Report an error','refnet');?>
					</a>
				</div>
				<!--
				<div id="contact"> 
					<span><a href="<?php echo $contactPage;?>">Contato</a></span>
				</div>
				-->
			</div>
	        	<div class="top top_<?php echo ($current_language);?>">
	            		<div id="parent">
	            			<a href="http://bvsalud.org/<?php echo substr($site_lang, 0, 2);?>" title="<?php _e('VHL Search Portal','refnet');?>">
						<img src="http://bvsalud.org/wp-content/themes/vhl-search-portal/images/<?php echo substr($site_lang,0,2); ?>/logo_bvs.jpg" alt="<?php _e('VHL LOGO','refnet');?>"/>
	       				</a>
	            		</div>
	            		<?php if ($title == true) {	?>
		   		<div class="site_name">
					<h1>
                                                <a style="background: url(http://bvsalud.org/wp-content/themes/vhl-search-portal/images/<?php echo substr($site_lang,0,2); ?>/title.png) no-repeat" title="<?php  _e('VHL Search Portal', 'refnet'); ?>" href="http://bvsalud.org/<?php echo substr($site_lang, 0, 2);?>"></a>
                                        </h1>
				</div>
				<?php } ?>
				<div class="headerWidget">
					<?php dynamic_sidebar( $top ); ?>
				</div>
	        	</div>
			<div class="spacer"></div>
		</div>
		<div class="spacer"></div>
