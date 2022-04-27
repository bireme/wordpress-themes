<?php get_header(); ?>
<div class="container padding1">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo rtrim($home_url, '/'); ?>">Home</a></li>
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
		<?php $solicitante =  get_the_term_list(get_the_ID(), 'tipo-de-profissional', '', ', ');?>
		<?php $ciap =  get_the_term_list(get_the_ID(), 'ciap2', '', ', ');?>
		<?php $decs =  get_the_term_list(get_the_ID(), 'decs', '', ', ');?>
		<?php $evidencia =  get_the_term_list(get_the_ID(), 'grau-da-evidencia', '', ', ');?>
		<?php $tematico =  get_the_term_list(get_the_ID(), 'recorte-tematico', '', ', ');?>

		<?php echo $solicitante != "" ? "<b>Solicitante:</b> $solicitante <br>" : ""; ?>
		<?php echo $ciap != "" ? "<b>CIAP2:</b> $ciap <br>" : ""; ?>
		<?php echo $decs != "" ? "<b>DeCS/MeSH:</b> $decs <br>" : ""; ?>
		<?php echo $evidencia != "" ? "<b>Graus da Evidência:</b> $evidencia <br>" : ""; ?>
		<?php echo $tematico != "" ? "<b>Recorte Temático:</b> $tematico <br>" : ""; ?>
		
	</div>
	<hr>
	<?php the_content(); ?>
	<hr>
	<?php echo $observacoes; ?>
	<div class="card">
		<div class="card-body">
			<div class="margin2">
				<h4>Bibliografia Selecionada:</h4>
				<?php echo $bibliografia_selecionada; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>