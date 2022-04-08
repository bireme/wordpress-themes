<?php get_header(); ?>
<div class="container padding1">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo rtrim($home_url, '/'); ?>">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">REVISÕES COMENTADAS (POEMS)</li>
		</ol>
	</nav>
	<?php while(have_posts()) : the_post();
		$questao_clinica 				= get_field('questao_clinica');
		$resposta_baseada_em_evidencia 	= get_field('resposta_baseada_em_evidencia');
		$alertas 						= get_field('alertas');
		$contexto 						= get_field('contexto');
		$referencia 					= get_field('referencia');
		$comentarios 					= get_field('comentarios');
		$data_de_acesso 				= get_field('data_de_acesso');
		$endereco 						= get_field('endereco');
		$numero_data_e_autoria 			= get_field('numero_data_e_autoria');
	endwhile;
	?>
	<b><?php echo get_the_term_list(get_the_ID(), 'categoria-da-evidencia', '', ', '); ?></b>
	<h1><?php the_title(); ?> </h1>

	<?php echo get_the_term_list(get_the_ID(), 'teleconsultor', '', ', '); ?> | 
	<?php echo get_the_date('d M Y', get_the_ID()); ?> | 
	ID: poems-<?php echo get_the_ID(); ?>
	<hr>


	<?php the_content(); ?>


	<div class="margin2">	
		<h4>Área Temática:</h4>
		<b><?php echo get_the_term_list(get_the_ID(), 'categoria-da-evidencia', '', ', '); ?></b>
	</div>
	
	<div class="margin2">
		<h4>Questão Clinica:</h4>
		<?php echo $questao_clinica; ?>
	</div>

	<div class="margin2">
		<b>Resposta Baseada em Evidência:</b>
		<?php echo $resposta_baseada_em_evidencia; ?>
	</div>

	<div class="margin2">
		<h4>Alertas:</h4>
		<?php echo $alertas; ?>
	</div>

	<div class="margin2">
		<b>Contexto:</b>
		<?php echo $contexto; ?>
	</div>

	<div class="margin2">
		<h4>Referencia</h4>
		<?php echo $referencia; ?>
	</div>

	<div class="margin2">
		<h4>Comentários:</h4>
		<?php echo $comentarios; ?>
	</div>

	<div class="margin2">
		<h4>Data de acesso:</h4>
		<?php echo $data_de_acesso; ?>
	</div>

	<div class="margin2">
		<h4>Endereço:</h4>
		<?php echo $endereco; ?>
	</div>

	<div class="margin2">
		<h4>Número, Data e Autoria:</h4>
		<?php echo $numero_data_e_autoria; ?>
	</div>

</div>
<?php get_footer(); ?>