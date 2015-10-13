<?php

$mlf_options = get_option('mlf_config');
$current_language = strtolower(get_bloginfo('language'));
$site_lang = substr($current_language, 0,2);
if ($current_language != ''){
    $current_language = '_' . $current_language;
}

$top = "header";
if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
    $top .= $current_language;
}

$settings = get_option( "wp_bvs_enfermeria_settings" );
?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:<?php language_attributes(); ?> <?php language_attributes(); ?> >
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">

        <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

        <link rel="stylesheet" href="<?= get_template_directory_uri(); ?>/static/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= get_template_directory_uri(); ?>/style.css">

        <link rel="stylesheet" href="http://owlgraphic.com/owlcarousel/owl-carousel/owl.carousel.css">
        <link rel="stylesheet" href="http://owlgraphic.com/owlcarousel/owl-carousel/owl.theme.css">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <?php wp_head(); ?>

        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <?php vhl_load_dynamic_colors(); ?>

        <?php vhl_extrahead(); ?>
    </head>

    <body>

        <header class='header'>
            <div class='topbar'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-md-3 col-md-offset-9'>
                            <?php if(is_user_logged_in()): ?>
                                <a href="/wp-admin/" class=''>admin</a>
                            <?php endif; ?>
                            <a href="<?php echo get_permalink( vhl_get_contact_page() ); ?>" class='contato'>Contato</a>
                            
                            <?php if(function_exists('mlf_links_to_languages')) { mlf_links_to_languages(); } ?>

                            <?php if (vhl_get_show_header_menu() != true) wp_nav_menu( array( 'fallback_cb' => 'false' ) ); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="topbanner">
                <div class='container'>
                    <div class='row'>
                        
                        <div class='col-md-2'>
                            <div class='logobvs'>
                            <?php if(vhl_get_logo_link()): ?>
                                <a href='<?php vhl_logo_link(); ?>' title="<?php bloginfo('name'); ?>"><img src='<?php vhl_logo_image(); ?>'></a>
                            <?php else: ?>
                                <img src='<?php vhl_logo_image(); ?>'>
                            <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class=''>
                            <?php if(vhl_show_title()): ?>
                                <?php if(vhl_get_banner_link()): ?>
                                    <a href='<?php vhl_banner_link(); ?>'><div class='logo'><?php bloginfo('wp_title'); ?></div></a>
                                <?php else: ?>
                                    <div class='logo'><?php bloginfo('wp_title'); ?></div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class='content'>