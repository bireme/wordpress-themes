<?php get_header(); ?>
<div class="container padding1">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo get_option('siteurl'); ?>">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">SEGUNDA OPINIÃO FORMATIVA – SOF</li>
		</ol>
	</nav>
	<b><?php echo get_the_term_list(get_the_ID(), 'categoria-da-evidencia', '', ', '); ?></b>
	<h1><?php the_title(); ?> </h1>
	<?php echo get_the_term_list(get_the_ID(), 'teleconsultor', '', ', '); ?> | <?php echo get_the_date( 'j F Y' ); ?> | ID: sofs-<?php echo get_the_ID(); ?>
	
	<hr>
	<?php while(have_posts()) : the_post();
		$bibliografia_selecionada 	= get_field('bibliografia_selecionada');
		$revisao 					= get_field('revisao');
		$observacoes 				= get_field('observacoes');
	endwhile;
	?>
	<div class="small">
		<b>Solicitante:</b>  <?php echo get_the_term_list(get_the_ID(), 'tipo-de-profissional', '', ', '); ?> <br>
		<b>CIAP2:</b> <?php echo get_the_term_list(get_the_ID(), 'ciap2', '', ', '); ?> <br>
		<b>DeCS/MeSH:</b> <?php echo get_the_term_list(get_the_ID(), 'decs', '', ', '); ?> <br>
		<b>Graus da Evidência:</b>  <?php echo get_the_term_list(get_the_ID(), 'grau-da-evidencia', '', ', '); ?> <br>
		<b>Recorte Temático:</b>  <?php echo get_the_term_list(get_the_ID(), 'recorte-tematico', '', ', '); ?> <br>
		<!--b>Destaque:</b>  <?php echo get_the_term_list(get_the_ID(), 'highlight', '', ', '); ?> <br-->
	</div>
	<hr>
	<?php the_content(); ?>

	<div class="card">
		<div class="card-body">
			<div class="margin2">
				<h4>Bibliografia Selecionada:</h4>
				<?php echo $bibliografia_selecionada; ?>
			</div>

			<div class="margin2">
				<h4>Revisão:</h4>
				<?php echo $revisao; ?>
			</div>

			<div class="margin2">
				<h4>Oservações:</h4>
				<?php echo $observacoes; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>