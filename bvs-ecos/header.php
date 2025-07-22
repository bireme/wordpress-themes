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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php 

    // WordPress 5.2 wp_body_open implementation
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }

?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Pular para o conteúdo', 'bvs-ecos' ); ?></a>

	<header id="masthead" class="site-header navbar-static-top bg-menu <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
        <div class="container-fluid navbar-dark">
            <div class="container">
                <div class="row secondary-menu">
                    <div class="col-md-12">                        
                        <?php if( !is_user_logged_in() ){ 
                            $redirect = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        ?>
                            <a href="<?php echo wp_login_url($redirect); ?>" class="btn btn-outline-primary btn-sm"><?php _e("LOGIN", "bvs-ecos"); ?></a>
                        <?php } else{ ?>
                            <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-outline-primary btn-sm"><?php _e("LOGOUT", "bvs-ecos"); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-menu">
                <div class="navbar-brand">
                    <?php if ( get_theme_mod( 'wp_bootstrap_starter_logo' ) ): ?>
                        <a href="<?php echo esc_url( home_url( '/' )); ?>">
                            <img src="<?php echo esc_url(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        </a>
                    <?php else : ?>
                        <a class="site-title" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
                    <?php endif; ?>

                </div>

                <!-- Botão para abrir o menu lateral no mobile -->
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#main-nav-mobile" aria-controls="main-nav-mobile" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Offcanvas lateral direita para mobile -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="main-nav-mobile" aria-labelledby="main-nav-mobile-label">
                    <div class="menu-background"></div>

                    <div class="offcanvas-header">
                        <h5 id="main-nav-mobile-label">Menu</h5>
                        <button type="button" class="btn-close-menu" data-bs-dismiss="offcanvas" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="offcanvas-body">
                        <?php
                        wp_nav_menu(array(
                            'theme_location'    => 'primary',
                            'container'       => false,
                            'menu_id'         => false,
                            'menu_class'      => 'navbar-nav',
                            'depth'           => 3,
                            'fallback_cb'     => '__return_false',
                            'walker'          => new bs5_Walker()
                        ));
                        ?>
                    </div>
                </div>

                <?php
                wp_nav_menu(array(
                    'theme_location'    => 'primary',
                    'container'       => 'div',
                    'container_id'    => 'main-nav',
                    'container_class' => 'collapse navbar-collapse',
                    'menu_id'         => false,
                    'menu_class'      => 'navbar-nav ms-auto',
                    'depth'           => 3,
                    'fallback_cb'     => '__return_false',
                    'walker'          => new bs5_Walker()
                ));
                ?>

            </nav>
        </div>
	</header><!-- #masthead -->
    
    <?php if( !is_front_page() || (isset($_GET['newsletter']) && $_GET['newsletter'] == 'subscribed') ): ?>

    <?php 
        $container_class = 'container';
        if( (function_exists("bp_is_group") && bp_is_group() ) || (function_exists("bp_is_user") && bp_is_user()) ){
            $container_class = 'container-fluid';

            if( (function_exists("bp_is_activity_component") && bp_is_activity_component()) && 
                (function_exists("bp_is_single_activity") && bp_is_single_activity()) ){
                $container_class = 'container';
            }
            else if ( (function_exists("bp_is_current_component") && bp_is_current_component( 'forums' )) && 
                      (function_exists("bp_is_current_action") && bp_is_current_action( 'bp-member-activity-favorites' )) ) {
                $container_class = 'container';
            }
            else if ( function_exists( 'bp_is_group_create' ) && bp_is_group_create() ) {
                $container_class = 'container';
            }
        }
    ?>

	<div id="content" class="site-content">
		<div class="<?php echo $container_class; ?>">
			<div class="row">

    <?php endif; ?>