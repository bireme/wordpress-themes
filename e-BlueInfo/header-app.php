<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="author" content="<?php bloginfo('admin_email'); ?>">
	<meta name="generator" content="Wordpress - BIREME / OPAS / OMS - Márcio Alves">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=1" />
	<?php wp_head(); ?>
</head>
<?php $idioma = pll_current_language(); ?>
<header  id="headerApp">
	<a href="<?php echo get_option('siteurl'); ?>/<?php echo $idioma=='pt'?'':$idioma; ?>"><img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="Brand e-BlueInfo"></a>
</header>