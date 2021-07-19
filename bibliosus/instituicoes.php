<?php /* Template Name: Instituições */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h2 class="title1">Diretório de Instituições</h2>
		
		<div class="row">
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
				$email 				= get_field('e-mail'); 
				?>
				<article>
					<b>Nome da Instituição: </b> <?php echo $texto; ?><br>
					<b>CNPJ: </b><?php echo $cnpj; ?><br>
					<b>Endereço: </b><?php echo $cnpj; ?><br>
					<b>Cidade: </b> <?php echo $cidade; ?> - <b>UF: <?php echo $uf; ?></b> - <b>CEP: <?php echo $cep; ?></b> <br>
					<b>Telefone: </b><?php echo $telefones; ?> - <b>E-mail: </b><?php echo $email; ?> <br>
					<hr>
				</article>
				<?php
			endwhile;
			?>
		</div>
	</div>
</main>
<?php get_footer(); ?>