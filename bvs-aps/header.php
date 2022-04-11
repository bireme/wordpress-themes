<?php global $home_url; ?>
<?php $config = get_option('bvs_aps_config'); ?>
<?php $home_url = ( empty($config['home_url']) ) ? get_option('siteurl') : rtrim($config['home_url'], '/'); ?>
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
						<a href="<?php echo rtrim($home_url, '/'); ?>"><img src="http://logos.bireme.org/img/pt/bvs_color.svg" class="img-fluid" id="logoBVS" alt=""></a>
					</div>
					<div class="col-md-7" id="header-site">
						<b><?php echo get_option('blogname'); ?></b> <br>
						<?php echo get_option('blogdescription'); ?>
					</div>
				</div>
			</div>
		</header>
