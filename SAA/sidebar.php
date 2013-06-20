<aside class="s pull-right">
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar') ) : else : ?>
	<?php endif; ?>
				
	<!-- <section class="row-fluid margin-bottom25">
		<h2 class="h2-home">Mais Recentes <a href="#" class="i-vermais"></a></h2>
		<ul class="s-recents">
			<?php query_posts('showposts=2');?>
			<?php if (have_posts()): while (have_posts()) : the_post();?>
				<li class="s-recents-li">
					<h3 class="s-recents-h3"><?php the_category(', ');?></h3>
					<a href="<?php the_Permalink();?>" class="a-link">
						<h4 class="s-recents-h4"><?php the_title();?></h4>
						<span class="s-recents-data"><?php the_time('d/m/Y');?> - <?php the_time('g:i');?></span>
						<p class="s-recents-p"><?php wp_limit_post(115,' [...]',true);?></p>
					</a>
				</li>
			<?php endwhile; else:?>
			<?php endif;?> 
		</ul>
	</section> -->
	
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Enquete') ) : else : ?>
	<?php endif; ?>

	<section class="row-fluid">
		<h2 class="h2-home">Participe!</h2>
		<div class="row-fluid align-center margin-top10 margin-bottom15">
			<span class="azul-bebe">Envie a sua notícia para</span><br>
			<span class="azul-escuro">comunicacao.saa@saude.gov.br</span>
		</div>

		<div class="row-fluid padding-top15 border-top">
			<span class="azul-escuro">Receba o SAA em seu e-mail:</span>
			<div class="padding10">
				<form action="">
					<input type="text" class="s-input" id="txtNome" placeholder="Digite seu nome">
					<input type="text" class="s-input" id="txtEmail" placeholder="Digite seu email">

					<div class="pull-right">
						<button class="i-btEnviar"></button>
					</div>
				</form>
			</div>
		</div>
	</section>
</aside>