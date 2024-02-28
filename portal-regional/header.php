<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600&display=swap" rel="stylesheet">
</head>
<?php $lang = pll_current_language(); ?>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header id="header">
		<div class="container">
			<div class="row" style="position:relative;">
				<div class="col-lg-6" id="logo-bvs">
					<a href="<?php echo get_option('siteurl'); ?>/<?php echo $lang=='pt'?'':$lang; ?>">
						<img src="http://logos.bireme.org/img/<?php echo $lang; ?>/bvs_color.svg" alt="BVS" id="header-bvs" class="float-start">
					</a>
					<h1>
						<?php echo get_option('blogname'); ?><br>
						<small><?php echo get_option('blogdescription'); ?></small>
					</h1>
				</div>
				<div class="col-lg-6">
					<div id="bt-login"><a href="https://minhabvs.bvsalud.org/client/controller/authentication/?lang=<?php echo $lang; ?>" target="_blank" class="btn btn-sm btn-outline-primary"> <i class="bi bi-person-circle"></i> <?php pll_e('Access My VHL'); ?></a></div>
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
			</div>
		</div>
	</header>
	<?php wp_head(); ?>