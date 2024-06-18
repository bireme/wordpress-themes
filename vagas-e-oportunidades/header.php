<?php wp_head(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
	
<header id="header">
	<div class="container">
		<a href="<?php echo get_option('siteurl'); ?>"><img src="<?php bloginfo('template_directory') ;?>/img/logo-pt.svg" id="logo" alt=""></a>
	</div>
</header>