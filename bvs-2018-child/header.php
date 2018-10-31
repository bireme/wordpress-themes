<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>
    <?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
	<header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
        <div id="logo-wrap">
            <div class="container">            
                <div class="row">
                    <div class="col-md-12">
                        <div class="brand-logo">
                            <?php if ( get_theme_mod( 'wp_bootstrap_starter_logo' ) ): ?>
                                <a href="<?php echo esc_url( home_url( '/' )); ?>">
                                    <img src="<?php echo esc_attr(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                                </a>
                            <?php else : ?>
                                <a class="site-title" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
                            <?php endif; ?>                            
                        </div>
                        <div class="brand-info">
                            <h2>Secretaria de Estado da Saúde de São Paulo</h2>
                            <h2>Biblioteca Virtual em Saúde.</h2>
                            <h1 class="d-block d-sm-block d-md-none">BVS-RIC</h1>
                            <h1>Rede de Informação e Conhecimento<span class="d-none d-sm-none d-md-inline"> | BVS-RIC</span></h1>
                        </div>
                        <div class="lang-social-networks">
                            <?php if ( is_active_sidebar( 'header_widget_area' ) ) : ?>
                                <?php dynamic_sidebar( 'header_widget_area' ); ?>
                            <?php endif; ?>
                        </div>
                        <div class="institution-logo">
                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/img/secretaria-saude.png'; ?>" alt="Secretária da Saúde" class="img-fluid" />
                        </div>
                    </div>
                </div>            
            </div>
        </div>
        <div id="menu-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-xl p-0">
                            <?php
                            wp_nav_menu(array(
                            'theme_location'    => 'primary',
                            'container'       => 'div',
                            'container_id'    => 'main-nav',
                            'container_class' => 'collapse navbar-collapse justify-content-start',
                            'menu_id'         => false,
                            'menu_class'      => 'navbar-nav',
                            'depth'           => 3,
                            'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
                            'walker'          => new wp_bootstrap_navwalker()
                            ));
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
	</header><!-- #masthead -->
    <?php if(is_front_page() && !get_theme_mod( 'header_banner_visibility' )): ?>
        <div id="page-sub-header" <?php if(has_header_image()) { ?>style="background-image: url('<?php header_image(); ?>');" <?php } ?>>
            <div class="container">
                <h1>
                    <?php
                    if(get_theme_mod( 'header_banner_title_setting' )){
                        echo get_theme_mod( 'header_banner_title_setting' );
                    }else{
                        echo 'Wordpress + Bootstrap';
                    }
                    ?>
                </h1>
                <p>
                    <?php
                    if(get_theme_mod( 'header_banner_tagline_setting' )){
                        echo get_theme_mod( 'header_banner_tagline_setting' );
                }else{
                        echo esc_html__('To customize the contents of this header banner and other elements of your site, go to Dashboard > Appearance > Customize','wp-bootstrap-starter');
                    }
                    ?>
                </p>
                <a href="#content" class="page-scroller"><span class="fa fa-fw fa-angle-down"></span></a>
            </div>
        </div>
    <?php endif; ?>
	<div id="content" class="site-content">
		<div class="container">
			<div class="row">
                <?php endif; ?>