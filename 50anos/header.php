<?php
	/**
	*  HEADER DO TEMPLATE
	*
	*
	*/
	
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		<title><?php bloginfo( 'name' ); ?></title>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
		<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bireme50.css" rel="stylesheet">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<?php flush() ?>
		<?php wp_head(); ?>
	</head> 
	<?php 
		$hotsite_lang = pll_current_language(slug); //pega o idioma do template
		include "vars_$hotsite_lang.php";
	?>
	

	<!-- jQuery -->
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
	<body class="index <? echo ( basename(get_permalink()) );?>">
		<div class="wp-site">
			<!-- Navigation -->
			<nav class="navbar navbar-default navbar-fixed-top navbar-custom">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header page-scroll">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span> Menu <span class="fa fa-bars"></span>
						</button>
						<a class="navbar-logo" href="<?php bloginfo( 'url' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
							<img class="img-responsive" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/<?php echo $bir50_logo_img; ?>" alt="<?php echo $bir50_logo_msg; ?>">
						</a>
					</div>
					<div class="navlanguages">
						<ul>
							<?php pll_the_languages(array('hide_current'=>1,'show_names'=>1)); ?>
						</ul>
					</div>
					<div class="navbar-opas page-scrooll">
						<a class="navbar-opas" href="http://www.paho.org/bireme">
							<img class="img-responsive" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/<?php echo $bir50_instituion_img ?>" alt="<?php echo $bir50_institution ?>">
						</a>
					</div>
					<?php 
						if ( is_home() ) {
						$bir50_menu = "home_$hotsite_lang";
						//echo $bir50_menu;
					?>
					<!-- Início Menu Home -->
						<?php
							wp_nav_menu( array(
							'menu'				=> "$bir50_menu", // Menu da Homepage.
							'menu_class'		=> 'nav navbar-nav navbar-right', // Muda a classe do menu.
							'container_class'	=> 'collapse navbar-collapse', // Muda a Classe do container.
							'container_id'		=> 'bs-example-navbar-collapse-1', // Muda o id do container.
							'before'			=> '<li class="page-scroll">', // Insere a li com classe do template.
							'after'				=> '</li>' // Fecha a li com classe do template.
							) );
						?>						
					<!-- Fim Menu Home -->
					<?php } else {
					// Inserir menu para outras páginas
						$bir50_menu = "2level_$hotsite_lang";
						//echo $bir50_menu;
					?>
					<!-- Inicio Menu Não Home -->
						<?php
							wp_nav_menu( array(
							'menu'				=> "$bir50_menu", // Menu da Homepage.
							'menu_class'		=> 'nav navbar-nav navbar-right', // Muda a classe do menu.
							'container_class'	=> 'collapse navbar-collapse', // Muda a Classe do container.
							'container_id'		=> 'bs-example-navbar-collapse-1', // Muda o id do container.
							'before'			=> '<li class="page-scroll">', // Insere a li com classe do template.
							'after'				=> '</li>' // Fecha a li com classe do template.
							) );
						?>						
					<!-- Fim Menu Não Home -->
					<?php } ?>
					<!-- /.navbar-collapse -->
				</div>
				<!-- /.container-fluid -->
			</nav>
			<? 
				/* Header finalizado deixando abertos:
				*  .wp-site - div aberto a ser fechado no footer.php
				*
				*/
				?>