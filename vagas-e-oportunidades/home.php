<?php /* Template Name: Home */ ?>
<?php get_header();?>
<div id="title-vagas">
	<h2 class="text-center">Vagas e Oportunidades na BIREME/OPAS/OMS</h2>
</div>
<main id="main_container">
	<div class="container">
		<?php the_content(); ?>
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
					<ul class="list-unstyled"><?php dynamic_sidebar('bireme') ?></ul>
				</div>
			</aside>
		</div>
	</div>
</main>
<?php get_footer();?>