<?php get_header();?>

		<div id="content">
			<div class="c-ajusta">
				<section id="main">
					<h2 class="h2-home">Destaques SAA Informa</h2>
					<article class="m-banners">
						<?php LenSlider::lenslider_output_slider('5b4bb7bbe0'); ?>
					</article>

					<article class="m-blocs">
						<h2 class="h2-home">Categorias <a href="#" class="i-vermais"></a></h2>
						<ul class="m-categorias">
							<?php
								wp_list_categories('sort_column=name&number=4&title_li=');
							?>
						</ul>
					</article>

					<article class="m-blocs pull-right">
						<h2 class="h2-home">Acesso Rápido <a href="#" class="i-vermais"></a></h2>
						<ul class="m-categorias">
							<li class="m-categorias-li">
								<a href="#" class="m-categorias-lia">
									Canal de Serviços
									<span class="quantity">43</span>
								</a>
							</li>

							<li class="m-categorias-li">
								<a href="#" class="m-categorias-lia">
									Pamais e Contatos
									<span class="quantity">32</span>
								</a>
							</li>

							<li class="m-categorias-li">
								<a href="#" class="m-categorias-lia">
									Modelos de Documentos
									<span class="quantity">27</span>
								</a>
							</li>

							<li class="m-categorias-li">
								<a href="#" class="m-categorias-lia">
									Processos Eletrônicos de Compras
									<span class="quantity">12</span>
								</a>
							</li>
						</ul>
					</article>

					<article class="m-featured">
						<?php query_posts('showposts=1&category_name=featured&meta_key=position&meta_value=1');?>
						<?php if (have_posts()): while (have_posts()) : the_post();?>
						<a href="<?php the_Permalink()?>">
							<h2 class="h2-home"><?php the_title();?></h2>
							<div class="m-featured-part1">
								<img src="<?php echo get_settings('home');?>/<?php $key="img"; echo get_post_meta($post->ID,$key,true);?>" alt="<?php the_title();?>">
								<?php wp_limit_post(540,' [...]',true);?>
							</div>
						</a>
						<?php endwhile; else:?>
						<?php endif;?>

						<div class="m-featured-part2">
							<?php //query_posts('showposts=2&category_name=featured&meta_key=position&meta_value=2&meta_key=position&meta_value=3');?>
							<?php query_posts(array('showposts' => '2', 'category_name' => 'featured', 'meta_key' => 'position', 'meta_value' => array('2','3')));?>
							<?php if (have_posts()): while (have_posts()) : the_post();?>
								<a href="<?php the_Permalink()?>" class="row-fluid margin-bottom10">
									<div class="m-featured-part2-image">
										<img src="<?php echo get_settings('home');?>/<?php $key="img"; echo get_post_meta($post->ID,$key,true);?>" alt="<?php the_title();?>">
									</div>
									<div class="m-featured-part2-txt">
										<h3 class="h3-home"><?php the_title();?></h3>
									</div>
								</a>
							<?php endwhile; else:?>
							<?php endif;?>
							
							<?php query_posts('showposts=2&category_name=featured&meta_key=position&meta_value=4,5');?>
							<?php if (have_posts()): while (have_posts()) : the_post();?>
								<a href="<?php the_Permalink()?>" class="row-fluid margin-top10 margin-bottom10">
									<i class="i-list"></i>
									<?php the_title();?>
								</a>
							<?php endwhile; else:?>
							<?php endif;?>
						</div>
					</article>
				</section>
				
				<?php get_sidebar();?>
			</div>
		</div>

<?php get_footer();?>