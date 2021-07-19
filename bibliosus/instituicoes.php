<?php /* Template Name: Instituições */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<main id="main_container" class="padding1">
	<div class="container">
		<h2 class="title1">Diretório de Instituições</h2>
		<p><?php the_content(); ?></p>
		
		<br><hr><br>
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nome da Instituição</th>
						<th>Nome da Unidade</th>
						<th>CNPJ</th>
						<th>Telefone</th>
						<th>E-mail</th>
						<th>Endereço</th>
						<th>Cidade</th>
						<th>UF</th>
						<th>CEP</th>
						<th>Página Web</th>
						<th>Tipo</th>
					</tr>
				</thead>
				<tbody>
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
						?>
						<tr>
							<td><?php the_title(); ?></td>
							<td><?php echo $nome_da_unidade; ?></td>
							<td><?php echo $cnpj; ?></td>
							<td><?php echo $telefones; ?></td>
							<td><?php echo $email; ?></td>
							<td><?php echo $endereco_completo; ?></td>
							<td><?php echo $cidade; ?></td>
							<td><?php echo $uf; ?></td>
							<td><?php echo $cep; ?></td>
							<td><a href="<?php echo $home_page; ?>" target="_blank">Link</a></td>
							<td><?php echo $tipo_de_instituicao; ?></td>
						</tr>
						<?php
					endwhile;
					?>
				</tbody>
			</table>
		</div>
	</div>
</main>
<?php get_footer(); ?>