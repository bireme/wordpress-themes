<?php /* Template Name: Instituições */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h2 class="title1">Diretório de Instituições</h2>
		<p><?php the_content(); ?></p>
		
		<br><hr><br>

		<?php 
		$posts = new WP_Query([
			'post_type' => 'instituicoes',
			'orderby' => 'title',
			'order' => 'ASC',
			'posts_per_page' => '-1'
		]);
		while($posts->have_posts()):$posts->the_post();
			$nome_da_unidade 		= get_field('$nome_da_unidade'); 
			$cnpj 					= get_field('cnpj'); 
			$endereco_completo 		= get_field('endereco_completo'); 
			$cidade 				= get_field('cidade'); 
			$uf 					= get_field('uf'); 
			$cep 					= get_field('cep'); 
			$telefones 				= get_field('telefones_-_ramal'); 
			$email 					= get_field('e-mail'); 
			$home_page 				= get_field('home_page'); 
			$tipo_de_instituicao 	= get_field('tipo_de_instituicao'); 

			nome_do_responsavel_por_este_cadastramento
			?>
			<article>
				<b>Nome da Instituição: </b> <?php echo $nome_da_unidade; ?><br>
				<b>CNPJ: </b><?php echo $cnpj; ?><br>
				<b>Telefone: </b><?php echo $telefones; ?> - <b>E-mail: </b><?php echo $email; ?> <br>
				<b>Link: </b><?php echo $home_page; ?><br>
				<b>Endereço: </b><?php echo $endereco_completo; ?><br>
				<b>Cidade: </b> <?php echo $cidade; ?> - <b>UF: </b><?php echo $uf; ?> - <b>CEP: <?php echo $cep; ?></b> <br>
				<b>Tipo: </b><?php echo $tipo_de_instituicao; ?><br>
				<hr>
			</article>
			<?php
		endwhile;
		?>
	</div>
</main>
<?php get_footer(); ?>