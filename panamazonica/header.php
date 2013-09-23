<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
	    <title><?php wp_title( '&mdash;', true, 'right' ); ?></title>
	    <meta name="viewport" content="width=device-width">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>">

		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

    	<div class="site-wrapper">

    		<header class="site-header over cf">

    			<h1 class="site-title">
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                <?php
                // Mostra a logo apenas para blogs filhos que possuem uma imagem cadastrada no theme options
                if ( get_current_blog_id() > 1 ) :
                  $lead = get_theme_option( 'logo' );
                            if ( is_int( $lead ) )
                              echo '<img src="' . wp_get_attachment_thumb_url( $lead ) . '" alt="' . get_bloginfo ( 'name' ) . '" />';
                            else
                              bloginfo( 'name' );
                else :
                  echo '<img src="'. get_template_directory_uri() . '/images/panamazonica.png" alt="' . get_bloginfo ( 'name' ) . '" />';
                endif;
                ?>
              </a>
          </h1>

    			<div class="access">
    				<nav>
    					<ul class="menu">
    						<li class="menu-item menu-item-home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="icon-alone"><span aria-hidden="true" data-icon="&#x2302;"></span><span class="assistive-text"><?php _e( 'Home', 'panamazonica' ); ?></span></a></li>
    						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'items_wrap' => '%3$s', 'fallback_cb' => false ) ); ?>
    						<li class="menu-item menu-item-search"><?php get_search_form(); ?></li>
    					</ul>
    				</nav>
    			</div><!-- /access -->

    		</header><!-- /main-header -->

    		<section class="main cf">
