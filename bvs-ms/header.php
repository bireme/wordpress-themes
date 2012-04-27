<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
/**
 * O Header do Tema
 * Traz os elementos principais utilizados nas demais páginas que serão utilizadas no template
 * Incluir em todos arquivos do tema com a chamada
 * get_header();
 */
?>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	    <meta property="og:title" content="<?php bloginfo('name'); ?>"/>
	    <meta property="og:image" content="<?php bloginfo('stylesheet_directory'); ?>/images/og_image.jpg"/>
	    <meta property="og:url" content="<?php bloginfo('url'); ?>"/>
	    <meta property="og:description" content="<?php bloginfo('description'); ?>"/>
	    <meta name="description" content="<?php bloginfo('description'); ?>" /> 
		<meta name="keywords" content="" /> 
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php 
			wp_head();
		?>
	</head>
	<body <?php body_class(); ?>>
		<?php include "barragov.php"; ?>
		<div class="container">
			<div class="header">
				<div class="logoBVS">
					<a href="<?php bloginfo('url'); ?>" alt="<?php bloginfo('name'); ?>"><span><?php bloginfo('name'); ?></span></a>
				</div><!-- /logoBVS -->
				<div class="identification">
					<a href="<?php bloginfo('url'); ?>" alt="<?php bloginfo('name'); ?>"><span><?php bloginfo('name'); ?></span></a>
				</div><!-- /identification -->
				<div class="bar">
					<ul>
						<li class="contact"><a href="/fale-conosco" alt="Fale Conosco"><span>Fale conosco</span></a></li>
						<li class="date">
						<?php
							$meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
							$diasdasemana = array (1 => "Segunda-Feira",2 => "Terça-Feira",3 => "Quarta-Feira",4 => "Quinta-Feira",5 => "Sexta-Feira",6 => "Sábado",0 => "Domingo");
							$hoje = getdate();
							$dia = $hoje["mday"];
							$mes = $hoje["mon"];
							$nomemes = $meses[$mes];
							$ano = $hoje["year"];
							$diadasemana = $hoje["wday"];
							$nomediadasemana = $diasdasemana[$diadasemana];
							echo "$nomediadasemana, $dia de $nomemes de $ano";
						 ?>
	
						</li>
					</ul>
				</div><!-- /bar -->
			</div><!-- /header -->
<? /*
 * end header.php
 * */?>