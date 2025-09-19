<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body>
	<header id="hero">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<a href="<?php bloginfo('siteurl'); ?>" class="navbar-brand">
						<img src="<?php bloginfo('template_directory'); ?>/img/brand.png" alt="" id="logo" class="img-fluid">
					</a>
				</div>
				<div class="col-md-9">
					<?php get_template_part('includes/nav') ?>
				</div>
			</div>
			<div id="hero-form">
				<h1 class="title">Faça sua busca no Memorial Digital da Pandemia de Covid-19.</h1>
				<p>Uma ampla coleção de documentos, registros oficiais, relatos pessoais e materiais de pesquisa sobre a pandemia de Covid-19 está disponível para consulta pública em nosso memorial digital.</p>
				<form id="buscaForm" class="row">
					<div class="col-7">
						<input type="text" class="form-control" id="termoBusca" placeholder="Pesquisar">
					</div>
					<div class="col-auto">
						<button type="submit" class="btn btn-primary mb-3">Pesquisar</button>
					</div>
					<div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="colecao" checked>
							<label class="form-check-label" for="inlineRadio1">Coleções</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="documento">
							<label class="form-check-label" for="inlineRadio2">Documentos</label>
						</div>
					</div>
				</form>
			</div>
		</div>
	</header>