<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
$mlf_options = get_option('mlf_config');
$current_language = strtolower(get_bloginfo('language'));
$site_lang = substr($current_language, 0,2);
$suffix = ( !defined( 'POLYLANG_VERSION' ) ) ? '_' . $current_language : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo ( $site_lang ); ?>" lang="<?php echo ( $site_lang ); ?>">

<head>
	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

	<noscript><?php _e('Enable JavaScript');?></noscript>
	
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="language" content="<?php echo ( $site_lang ); ?>" />
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	
	<link rel="stylesheet" media="screen" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" media="screen" href="<?php bloginfo( 'stylesheet_directory' ); ?>/skin.css" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link href="/favicon.ico" rel="shortcut icon" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="container">
        <div class="bar">
			<div class="barInner">
				<div class="topMenu">
					<?php if ( is_active_sidebar( 'vhl_menu_1' . $suffix ) ) : ?>
						<?php dynamic_sidebar(  'vhl_menu_1' . $suffix ); ?>
					<?php endif; ?>
				</div>
				<div id="otherVersions">
                    <?php
                        if ( function_exists( 'mlf_links_to_languages' ) )
                            mlf_links_to_languages();
                        else
                            language_switcher();
                    ?>
				</div>
				<?php if ( defined( 'POLYLANG_VERSION' ) ) : ?>
					<div id="contact"> 
						<span><a href="/<?php echo ( $site_lang ); ?>/contact-<?php echo ( $site_lang ); ?>/"><?php pll_e('Contact'); ?></a></span>
					</div>
				<?php endif; ?>
				<div class="spacer"></div>
			</div>
        </div>
        <div class="top top_<?php echo $site_lang; ?>">
            <div id="parent">
                <img src="<?php bloginfo('template_url') ?>/images/<?php echo ( $site_lang ); ?>/logo_bvs.jpg" alt="<?php bloginfo('name'); ?>"/>
            </div>
            <div id="identification_<?php echo $site_lang; ?>">
                <h1><?php bloginfo('name'); ?></h1>
                <h2><?php bloginfo('description'); ?></h2>
            </div>
			<div class="topSlot">
				<?php if ( is_active_sidebar( 'top_slot' . $suffix ) ) : ?>
					<?php dynamic_sidebar(  'top_slot' . $suffix ); ?>
				<?php endif; ?>
			</div>
			<div class="spacer"></div>
        </div>
    
<!-- end header -->
