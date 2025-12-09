<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till #main div
 *
 * @package Odin
 * @since 2.2.0
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<?php $lang = pll_current_language(); ?>
<?php 
switch ( $lang ) {
	case 'pt':
		$msgTitle = 'Veja o último boletim BIREME';
		$msgDescription ="A BIREME/OPAS/OMS conta com o Boletim BIREME como canal de comunicação para os seus usuários.";
		break;
	case 'es':
		$msgTitle = 'La BIREME/OPS/OMS cuenta con el Boletín BIREME como canal de comunicación para sus usuarios.';
		$msgDescription ="";
		break;
	case 'en':
	default:
		$msgTitle = 'BIREME/PAHO/WHO has the BIREME Bulletin as a communication channel for its users.';
		$msgDescription ="";
		break;
}
?>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- Open Graph -->
	<meta property="og:title" content="<?php echo esc_html( $msgTitle ); ?>" />
	<meta property="og:description" content="<?php echo esc_html( $msgDescription ); ?>" />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/thumb-share.jpg" />

	<meta property="og:url" content="https://boletin.bireme.org/" />
	<meta property="og:type" content="website" />

	<!-- Twitter  -->
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="<?php echo esc_html( $msgTitle ); ?>" />
	<meta name="twitter:description" content="<?php echo esc_html( $msgDescription ); ?>" />
	<meta name="twitter:image" content="<?php bloginfo('template_directory'); ?>/assets/images/thumb-share.jpg" />


	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php /* if ( ! get_option( 'site_icon' ) ) : ?>
		<link href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico" rel="shortcut icon" />
	<?php endif; */ ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<a id="skippy" class="sr-only sr-only-focusable" href="#content">
		<div class="container">
			<span class="skiplink-text"><?php _e( 'Skip to content', 'odin' ); ?></span>
		</div>
	</a>

	<header id="header" role="banner">
		<div class="container">
			<div class="page-header hidden-xs">
				<?php
					if ( function_exists( 'pll_the_languages' ) ) {
						$args = array(
							'dropdown' => 0,
							'show_names' => 1,
							'display_names_as' => 'name',
							'show_flags' => 0,
							'hide_if_empty' => 1,
							'force_home' => 0,
							'echo' => 0,
							'hide_if_no_translation' => 1,
							'hide_current' => 1,
							'post_id' => null,
							'raw' => 0
						);
						echo '<div class="language-switcher">';
						echo '<ul>' . pll_the_languages( $args ) . '</ul>';
						echo '</div>';
					}
				?>

				<div class="logo">
					<?php dynamic_sidebar( 'logo-sidebar' ); ?>
				</div><!-- .container -->

				<?php if ( is_home() ) : ?>
					<h1 class="site-title">
						<!--a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
							<?php bloginfo( 'name' ); ?>
						</a-->
						<?php bloginfo( 'name' ); ?>
					</h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				<?php else : ?>
					<div class="site-title h1">
						<!--a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
							<?php bloginfo( 'name' ); ?>
						</a-->
						<?php bloginfo( 'name' ); ?>
					</div>
					<div class="site-description h2">
						<?php bloginfo( 'description' ); ?>
					</div>
				<?php endif ?>
			</div><!-- .site-header-->

			<div id="main-navigation" class="navbar navbar-default">
				<!--div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-navigation">
					<span class="sr-only"><?php _e( 'Toggle navigation', 'odin' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand visible-xs-block" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</div-->
				<nav class="navbar-collapse navbar-main-navigation" role="navigation">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'main-menu',
								'depth'          => 2,
								'container'      => false,
								'menu_class'     => 'nav navbar-nav',
								'fallback_cb'    => 'Odin_Bootstrap_Nav_Walker::fallback',
								'walker'         => new Odin_Bootstrap_Nav_Walker()
							)
						);
					?>
					<form method="get" class="navbar-form navbar-right" action="<?php echo defined( 'POLYLANG_VERSION' ) ? pll_home_url() : esc_url( home_url( '/' ) ); ?>" role="search">
						<label for="navbar-search" class="sr-only">
							<?php _e( 'Search:', 'odin' ); ?>
						</label>
						<div class="form-group">
							<input type="search" value="<?php echo get_search_query(); ?>" class="form-control" name="s" id="navbar-search" />
						</div>
						<button type="submit" class="btn btn-default"><?php _e( 'Search', 'odin' ); ?></button>
					</form>
				</nav><!-- .navbar-collapse -->
			</div><!-- #main-navigation-->

		</div><!-- .container-->
	</header><!-- #header -->

	<div id="wrapper" class="container">
		<div class="row">
