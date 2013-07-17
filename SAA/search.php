<?php get_header();?>

		<div id="content">
			<div class="c-ajusta">
				<section id="main">
					<div id="category">
						<span class="tit-results">Resultados para:</span><h1 class="h2-home no-float"><?php echo the_search_query(); ?></h1>

						<ul class="m-results">
							<?php if (have_posts()): while (have_posts()) : the_post();?>
								<li class="m-results-li">
									<a href="<?php the_Permalink()?>" class="m-results-lia">
										<figure class="m-results-img">
											<img src="<?php echo get_option('home');?>/<?php $key="img";echo get_post_meta($post->ID,$key,true);?>" alt="<?php the_title();?>" class="list-img">
										</figure>

										<div class="m-results-text">
											<h2 class="s-recents-h4"><?php the_title();?></h2>
											<span class="s-recents-data"><?php the_time('d/m/Y');?> - <?php the_time('g:i');?></span>
											<p class="m-results-text-p">
												<?php wp_limit_post(250,' [...]',true);?>
											</p>
										</div>
									</a>
								</li>

							 <?php endwhile; else:?>
        						<h1 class="h2-home">Desculpe não encontramos o que você procura! Você pode tentar outros termos!</h1>
        					<?php endif;?>
						</ul>

						<!-- PAGINAÇÃO AUTOMÁTICA (5 ITENS POR PÁGINA) -->
						<div class="m-results-pag"></div>
					</div>
				</section>
				
				<?php get_sidebar();?>
			</div>
		</div>

<?php get_footer();?>
