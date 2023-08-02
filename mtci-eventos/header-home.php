<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="BIREME / OPAS / OMS - Márcio Alves">
	<meta name="generator" content="BIREME / OPAS / OMS - Márcio Alves">
	<?php wp_head(); ?>
</head>
<?php $lang = pll_current_language(); ?>
<?php while(have_posts()) : the_post();
	$logo 			= get_field('logo');
endwhile;
?>
<body>
	<header id="header">
		<div class="container">
			<div class="text-center" id="header-paho">
				<img src="<?php bloginfo('template_directory'); ?>/img/header-paho-<?php echo $lang; ?>.png" alt="">
			</div>
		</div>		
		<div id="lang">
			<?php 
			wp_nav_menu( array(
				'theme_location'    => 'Language',
				'depth'             => 1,
				'container'         => 'ul',
				'container_class'   => 'list-unstyled',
				'container_id'      => '',
				'menu_class'        => '',
			) );
			?>
		</div>
	</header>