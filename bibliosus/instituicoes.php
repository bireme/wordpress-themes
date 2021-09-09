<?php /* Template Name: Instituições */ ?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<main id="main_container" class="padding1">
	<div class="container">
		<h2 class="title1">Diretório de Instituições</h2>
		<p><?php the_content(); ?></p>
		<br><hr><br>
		<input class="form-control" id="myInput" type="text" placeholder="Pesquisar..."> <br>
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nome da Instituição</th>
						<th>Contato</th>
						<th>Endereço</th>
						<th>Página Web</th>
					</tr>
				</thead>
				<tbody  id="myTable">
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
							<td><b><?php the_title(); ?></b> <br> <small><?=$cnpj; ?> - <?=$tipo_de_instituicao; ?></small></td>
							<td><i class="fas fa-phone-alt"></i> <?=$telefones; ?> <br> <i class="far fa-envelope"></i> <?=$email; ?></td>
							<td><i class="fas fa-map-marker-alt"></i> <?=$endereco_completo; ?> <br> <?=$cidade; ?> - <?=$uf; ?> - <?=$cep; ?></td>
							<!-- <td><?php echo $home_page !== ""? "<a href='http://$home_page' class='btn btn-sm btn-outline-success' target='_blank'>Link</a>" : ""; ?></td> -->
							<td><?php echo $home_page; ?></td>
						</tr>
						<?php
					endwhile;
					?>
				</tbody>
			</table>
		</div>
		<script>
			$(document).ready(function(){
				$("#myInput").on("keyup", function() {
					var value = $(this).val().toLowerCase();
					$("#myTable tr").filter(function() {
						$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});
				});
			});
		</script>
	</div>
</main>
<?php get_footer(); ?>