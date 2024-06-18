<?php get_header();?>
<div id="title-vagas">
	<h2 class="text-center">Vagas e Oportunidades na BIREME/OPAS/OMS</h2>
</div>
<main id="main_container">
	<div class="container">
		<p class="text-center" style="font-size:22px;">
			Acreditamos que os nossos colaboradores conformam o capital intelectual fundamental para nosso sucesso. Valorizamos a diversidade e nosso processo seletivo é transparente, aberto e democrático. Se você quer fazer parte dos nossos talentos, envie seu currículo, quando surgirem vagas compatíveis com seu perfil. A data de encerramento do anúncio de vaga é dinâmica, e o horário corresponde à meia-noite em Brasília, Brasil. Após a data de encerramento, seu currículo não será considerado no processo.
		</p>
		<div class="row mt-5">
			<div class="col-md-8">
				<h2 id="vaga-destaque-title">VAGAS EM DESTAQUE</h2>

				<?php 
				$loop = new WP_Query([
					'post_type' => 'vagas_oportunidades',
					'posts_per_page' => -1
				]);
				?>
				<?php while($loop->have_posts()) : $loop->the_post();?>
					<article class="card mb-4">
						<div class="card-body">
							<h3><?php the_title(); ?></h3>
							<hr>
							<?php the_excerpt(); ?>
							<details>
								<summary>Detalhes</summary>
								<hr>
								<?php the_content(); ?>
							</details>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<aside class="col-md-4">
				<div id="dados-bir">	
					<h2>BIREME/OPS/OMS</h2>
					<hr>	
					<p>O Centro Latino-Americano e do Caribe de Informação em Ciências da Saúde, também conhecido pelo seu nome original Biblioteca Regional de Medicina (BIREME), é um centro especializado da Organização Pan-Americana da Saúde / Organização Mundial da Saúde (OPAS/OMS), orientado à cooperação técnica em informação científica em saúde.</p>

					<p>Sua missão é contribuir para o desenvolvimento da saúde nos países da América Latina e Caribe (AL&C) por meio da democratização do acesso, publicação e uso de informação, conhecimento e evidência científica. A Biblioteca VIrtual em Saúde - BVS (http://bvsalud.org) é a principal estratégia e modelo de cooperação técnica em gestão da informação científica e técnica em saúde da AL&C, promovida e coordenada pela BIREME desde 1998. É um bem público regional construído e operado conjuntamente por uma rede de instituições e profissionais de 30 países, que atua na produção, intermediação e uso da informação científica e técnica em saúde. Destaca-se também as suas principais fontes de informação Literatura Latino-Americana e do Caribe em Ciências da Saúde (LILACS) e Descritores em Ciências da Saúde (DeCS). </p>

					<p>Saiba mais: <a href="https://www.paho.org/pt/bireme/sobre-centro-latino-americano-e-do-caribe-informacao-em-ciencias-da-saude" target="_blank">https://www.paho.org/pt/bireme/sobre-centro-latino-americano-e-do-caribe-informacao-em-ciencias-da-saude</a></p>

					<hr>	
					<b>Endereço: </b>Rua Vergueiro 1759 - Vila Mariana <br>
					São Paulo, São Paulo, Brasil <br>
					<b>CEP: </b> 04101-000 <br>
					<b>Site: </b><a href="https://www.paho.org/pt/bireme" target="_blank">https://www.paho.org/pt/bireme</a> <br>
					<b>Setor: </b>Tecnologia da informação e serviços <br>
					<b>Tamanho da empresa: </b>11-50 funcionários <br>
					<b>Sede: </b>São Paulo, São Paulo <br>
					<b>Tipo: </b>Sociedade <br>
					<b>Fundada em: </b>1967

				</div>
			</aside>
		</div>
	</div>
</main>

<?php get_footer();?>