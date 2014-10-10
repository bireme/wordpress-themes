<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
$current_language = get_bloginfo('language');
$site_lang = substr($current_language, 0, 2);
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

    <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

    <style type="text/css" media="screen">
        @import url( <?php bloginfo('stylesheet_url'); ?> );
    </style>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />   
    <?php wp_head(); ?>
</head>

<body>
	<?php //include "barragov.php"; ?>
    <div class="container">

        <div class="bar">
            <?php if (function_exists('mlf_links_to_languages')) { ?>
                <div id="otherVersions">
                    <?php mlf_links_to_languages(); ?>
                </div>
            <?php } ?>    
            <div id="contact"> 
                <span><a href="/contato">Contato</a></span>
            </div>
        </div>
        <div class="top top_<?php echo ($current_language); ?>">
            <div id="parent">
                <img src="<?php bloginfo('template_url') ?>/images/<?php echo $site_lang ?>/logobvs.gif" alt="Biblioteca Virtual em Saúde"/>
            </div>
            <div id="identification">
                <h1><span><?php bloginfo('name'); ?></span></h1>
            </div>
            <!--div id="institutionList">
                <ul>
                    <li><img src="<?php bloginfo('template_url') ?>/images/pt/logoOpas.gif" alt="BIREME | OPAS | OMS logo"/></li>
                    <li><a href="http://www.bireme.br/" target="_blank">BIREME</a></li>
                    <li><a href="http://www.paho.org/" target="_blank">OPAS</a></li>
                    <li><a href="http://www.who.int/" target="_blank">OMS</a></li>
                </ul>
            </div-->
        </div>
    
<!-- end header -->
