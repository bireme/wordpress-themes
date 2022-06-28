<?php
	$site_language = strtolower(get_bloginfo('language'));
	$lang = substr($site_language,0,2);

	if ( function_exists('pll_home_url') ) {
		$home_url = pll_home_url($lang);
	} else {
		$home_url = ( 'en' == $lang ) ? get_option('siteurl') : get_option('siteurl') . '/' . $lang;
	}
?>
<!DOCTYPE html>
<html <?php language_attributes() ?> >
<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME/OPAS/OMS - Márcio Alves">
	<meta name="generator" content="BIREME/OPAS/OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" />
	<?php wp_head(); ?>
</head>
<body>
	<?php // get_template_part('includes/topAccessibility') ?>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<!-- <a href="<?php echo $home_url; ?>"><img src="<?php bloginfo('template_directory'); ?>/img/logo-<?php echo $lang; ?>.svg" alt="" class="img-fluid" id="logo" ></a> -->
					<a href="<?php echo $home_url; ?>" class="logo-header"><img src="<?php bloginfo('template_directory'); ?>/img/120-logo-color-<?php echo $lang; ?>.png" alt="" class="img-fluid" id="logo" ></a>
					<span class="site-title"><?php bloginfo('name'); ?></span>
				</div>
				<div class="col-md-6 d-print-none">
					<div id="lang">
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

	                            echo '<ul>' . pll_the_languages( $args ) . '</ul>';
	                        }
						?>
					</div>
				</div>
			</div>
		</div>
	</header>
	<?php get_template_part('includes/nav') ?>
