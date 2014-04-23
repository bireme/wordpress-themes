<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
$mlf_options = get_option('mlf_config');
//print_r($mlf_options);
$current_language = get_bloginfo('language');
$site_lang = substr($current_language, 0,2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo ( $current_language ); ?>">

<head>
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

	<noscript><?php _e('Enable JavaScript');?></noscript>
	
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="language" content="<?php echo ( $site_lang ); ?>" />
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	
	<link rel="stylesheet" media="screen" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" media="screen" href="<?php bloginfo( 'stylesheet_directory' ); ?>/skin.css" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link href="/favicon.ico" rel="shortcut icon" />
	<?php wp_head(); ?>
</head>

<body>
    <div class="container">
        <div class="bar">
			<div class="barInner">
				<div class="topMenu">
					<?php if ( is_active_sidebar( 'vhl_menu_1_' . $current_language ) ) : ?>
						<?php dynamic_sidebar(  'vhl_menu_1_' . $current_language ); ?>
					<?php endif; ?>
				</div>
				<div id="otherVersions">
					<?php mlf_links_to_languages(); ?>
				</div>
				<div id="contact"> 
					<span><a href="/<?php echo ( $site_lang ); ?>/contact/">Contato</a></span>
				</div>
				<div class="spacer"></div>
			</div>
        </div>
        <div class="top top_<?php echo ($current_language);?>">
            <div id="parent">
                <img src="<?php bloginfo('template_url') ?>/images/<?php echo ( $site_lang ); ?>/logo_bvs.jpg" alt="<?php bloginfo('name'); ?>"/>
            </div>
            <div id="identification_<?php echo ($current_language);?>">
                <h1><span><?php bloginfo('name'); ?></span></h1>
            </div>
			<div class="topSlot">
				<?php if ( is_active_sidebar( 'top_slot_' . $current_language ) ) : ?>
					<?php dynamic_sidebar(  'top_slot_' . $current_language ); ?>
				<?php endif; ?>
			</div>
			<div class="spacer"></div>
        </div>
    
<!-- end header -->
