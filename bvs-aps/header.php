<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php wp_head(); ?>
	</head>
	<body>
		<header id="header">
			<div class="container">
				<div class="row">
					<div class="col-md-1">
						<a href="<?php echo get_option('siteurl'); ?>"><img src="http://logos.bireme.org/img/pt/bvs_color.svg" class="img-fluid" id="logoBVS" alt=""></a>
					</div>
					<div class="col-md-7" id="header-site">
						<b><?php echo get_option('blogname'); ?></b> <br>
						<?php echo get_option('blogdescription'); ?>
					</div>
				</div>
			</div>
		</header>
