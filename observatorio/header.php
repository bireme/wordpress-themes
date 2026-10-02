<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header" class="site-header fixed-top">
	<nav class="navbar navbar-expand-lg navbar-dark" aria-label="<?php esc_attr_e( 'Navegação principal', 'observatorio' ); ?>">
		<div class="container">
			<a class="navbar-brand d-flex align-items-center gap-3" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="site-title d-none d-md-inline">
					<?php esc_html_e( 'Observatório', 'observatorio' ); ?><br>
					<small><?php esc_html_e( 'de Políticas, Sistemas e Inovação em Saúde', 'observatorio' ); ?></small>
				</span>
			</a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Abrir menu', 'observatorio' ); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="primary-menu">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'navbar-nav ms-auto align-items-lg-center gap-lg-2',
					'fallback_cb'    => false,
					'depth'          => 2,
				) );
				?>
			</div>
		</div>
	</nav>
</header>
