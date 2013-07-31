<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="" /> 
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="all" />

	<title>
	<?php if (is_home()){
		bloginfo('name');
	}elseif (is_category()){
		single_cat_title(); echo ' -  ' ; bloginfo('name');
	}elseif (is_single()){
		single_post_title();
	}elseif (is_page()){
		bloginfo('name'); echo ': '; single_post_title();
	}else {
		wp_title('',true);
	} ?>
	</title>

	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
 
	<!-- Facebook -->
	<meta property="og:title" content="Wesley Amaro"/>
	<meta property="og:site_name" content="Wesley Amaro"/>
	<meta property="og:url" content="http://www.wesleyamaro.com.br"/>
	<meta property="og:image" content="http://www.wesleyamaro.com.br/imagens/fb-share.jpg"/>
	<meta property="og:description" content=""/>

	<!-- FAVICON -->
	<link rel="shortcut icon" href="favicon.ico" />

	<!-- CSS -->
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<?php wp_head(); ?>
</head>
<body>
	<div id="tv">
		<section id="tv-main">
			<header class="tv-main-header">
				<h1 class="tv-main-header-logo">SAA Informa - Boletim Informativo da Subsecretaria de Assuntos Administrativos</h1>
			</header>

			<article id="tv-banner" class="tv-main-banner tv-bg-gray">
				<?php query_posts('showposts=8&category_name=Noticias&offset=0');?>
				<?php if (have_posts()): while (have_posts()) : the_post();?>	
					<div class="banner-automate row-fluid margin-bottom100">
						<div class="tv-main-banner-padding">
							<div class="tv-row-fluid">
								<div class="tv-main-banner-image">
									<?php if ( has_post_thumbnail() ) {
										the_post_thumbnail('medium');
									}else{
										echo "<img src='http://www.kross.pl/sites/default/files/styles/bike_zoom/public/default_images/proj_no_photo.png' alt='No Photo'>";
									} ?>
								</div>

								<div class="tv-main-banner-content">
									<h2 class="tv-categoria">
										<?php
											//exclude these from displaying
											$exclude = array("featured" , "Banners");

											// Set initial counter to limit display of only one category
											$g = 0;

											//set up an empty categorystring
											$catagorystring = '';

											//loop through the categories for this post
											foreach((get_the_category()) as $category)
											{
												//if not in the exclude array
												if (!in_array($category->cat_name, $exclude) && $g < 2)
												{
													//add category with link to categorystring
													$catagorystring .= '<a href="'.get_bloginfo(url).get_option('category_base').'/'.$category->slug.'">'.$category->name.'</a>, ';

											        // Add to counter after category loop
											        $g++;
												}
											}

											//strip off last comma (and space) and display
											echo substr($catagorystring, 0, strrpos($catagorystring, ','));
										?>
									</h2>
									<h1 class="tv-main-banner-content-tit"><?php the_title();?></h1>
									<?php the_excerpt(); ?>
								</div>
							</div>
							<div class="tv-row-fluid">
								<div class="tv-main-banner-qrcode">
									<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Tv-QrCode') ) : else : ?>
									<?php endif; ?>	
									<p class="tv-main-banner-qrcode-p">Leia a matéria completa <br>escaneando o QRcode ao lado</p>
								</div>

								<div class="tv-main-banner-author">
									por: <?php the_author();?><br>
									<?php the_time('d/m/Y');?> - <?php the_time('G\hi'); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; else:?>
				<?php endif;?>
			</article>

			<footer class="tv-main-footer">
				<div class="tv-main-footer-left">
					<span class="font36"><strong>Participe!</strong></span><br>
					Envie a sua notícia ou comentários<br>
					<span class="font29"><strong>comunicacao.saa@saude.gov.br</strong></span>
				</div>

				<div class="tv-main-footer-right">
					<div class="tv-row-fluid">
						<strong>Equipe de Comunicação</strong><br>
						Subsecretaria de Assuntos Administrativos (SAA/SE/MS)<br>
						Ministério da Saúde
					</div>
					
					<div class="tv-row-fluid margin-top10">
						<img src="wp-content/themes/SAA/Imagens/tv-organizadores.png" alt="Organizadores">
					</div>
				</div>
			</footer>
		</section>

		<aside id="tv-sidebar">
			<div class="tv-sidebar-padding">
				<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Tv-Sidebar') ) : else : ?>
				<?php endif; ?>

				<!-- <h2 class="tv-sidebar-tit">Mais Recentes</h2>
				<ul class="tv-sidebar-recents-ul">
					<li>
						<span class="tv-sidebar-recents-categoria">CGDI</span><br>
						<span class="tv-sidebar-recents-h3">Mostra Memória da Loucura é inaugurada<br></span>
						<span class="tv-sidebar-recents-data">24/05/2013 - 14:45hs</span><br>
						Em comemoração ao dia Nacional da Luta Antimanicomial, 18 de maio, o Centro Cultural do Ministério da Saúde (CCMS)/ CGDI/ SAA/ SE inaugurou a exposição Memória da Loucura.
					</li>

					<li>
						<span class="tv-sidebar-recents-categoria">CGMAP</span><br>
						<span class="tv-sidebar-recents-h3">Servidora recebe prêmio em congresso nacional<br></span>
						<span class="tv-sidebar-recents-data">24/05/2013 - 12:17hs</span><br>
						Eurisdete Pereira Lopes, recebeu o “Prêmio 19 de Março”, categoria Pregão 2012, objeto: “REDE CEGONHA”,
					</li>

					<li>
						<span class="tv-sidebar-recents-categoria">CGSG</span><br>
						<span class="tv-sidebar-recents-h3">Transporte noturno tem novos horários<br></span>
						<span class="tv-sidebar-recents-data">24/05/2013 - 11:32hs</span><br>
						A partir desta segunda-feira (12), os horários noturnos do transporte do MS com destino à Rodoviária do Plano Piloto serão das 20h às 24h, com intervalos de 30 minutos.
					</li>

					<li>
						<span class="tv-sidebar-recents-categoria">CGESP</span><br>
						<span class="tv-sidebar-recents-h3">Ginástica Laboral volta com o programa “Geração Saúde”<br></span>
						<span class="tv-sidebar-recents-data">24/05/2013 - 11:15hs</span><br>
						Equipe da ginástica laboral retornou nesta segunda-feira (6). Participe!
					</li>
				</ul> -->
			</div>
		</aside>
	</div>

	<!-- SCRIPTS -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/Js/tv.js"></script>
</body>
</html>