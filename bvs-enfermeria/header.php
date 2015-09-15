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

        <style>
            header .topbanner {
                background-image: url(<?= $settings['header']['banner-' . $site_lang]; ?>);
            }
        </style>
    </head>

    <body>

        <header>
            <div class='topbar'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-md-3 col-md-offset-9'>
                            <?php if(is_user_logged_in()): ?>
                                <a href="/wp-admin/" class=''>admin</a>
                            <?php endif; ?>
                            <a href="<?php echo get_permalink( get_page_by_path( 'contato' ) ); ?>" class='contato'>Contato</a>
                            <?php if(function_exists('mlf_links_to_languages')) { mlf_links_to_languages(); } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="topbanner">
                <div class='container'>
                    <div class='row'>
                        
                        <div class='col-md-2'>
                            <div class='logobvs'>
                                <a href="#"><img src='<?= $settings['header']['logo-' . $site_lang]; ?>'></a>
                            </div>
                        </div>
                        
                        <div class=''>
                            <div class='logo'><?php bloginfo('wp_title'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
<!-- 
            <div class="searchbox">
                <div class='container'>
                    <div class='row'>
                        <?php dynamic_sidebar( $top ); ?>

                        <form action="<?= $settings['iahx_url']; ?>" method="get" id="searchForm">
                            <div id="vhl_search-4" class="   col-md-6 col-md-offset-3">
                                
                                <input type="hidden" name="lang" value="pt">
                                <input type="hidden" name="home_url" value="<?php bloginfo('home'); ?>">   
                                <input type="hidden" name="home_text" value="<?php bloginfo('name'); ?>">   
                                
                                <input type="text" id="vhl-search-input" class="vhl-search-input" name="q" placeholder='Entre com uma ou mais palavras...'>

                                <div class="submit">
                                    <a href="#"><img src="<?= get_template_directory_uri(); ?>/static/img/ico-search.png"></a>
                                </div>
                            </div>

                            <div class='radio col-md-6 col-md-offset-3'>
                                <input type='radio' name='filter[db][]' value='' checked='checked'> BVS Enfermeria
                                <input type='radio' name='filter[db][]' value='BDENF'> BDENF
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->

        </header>

        <div class='content'>