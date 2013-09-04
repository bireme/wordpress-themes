<?php get_header();?>
	<div id="content" class="row-fluid">
		<div class="ajusta2">
			<div class="row-fluid">
				<section class="header-search">
					<form role="search" method="get" id="searchform" action="<?php echo get_option('home'); ?>">
						<input value="" name="s" class="input-search" id="s" type="text" placeholder="Pesquisar...">
	          			<input id="searchsubmit" value="" type="submit" class="b-search">
					</form>
				</section>

				<div class="pull-right">
					<a href="enviar-colaboracion" class="header-colabore">Indique um site</a>
				</div>
			</div>
				
			<section id="conteudo">
				<header class="row-fluid border-bottom">
					<h1 class="h1-header">Más Recientes</h1>
					<div class="pull-right">
						<a href="#" class="ico-feeds"></a>
						<form action="">
							<select name="txtRegistros" id="txtRegistros" class="select-input-home">
								<option value="10 Registros">10 registros</option>
								<option value="20 Registros">20 registros</option>
								<option value="50 Registros">50 registros</option>
							</select>

							<select name="txtOrder" id="txtOrder" class="select-input-home">
								<option value="">Ordenar por</option>
								<option value="Mais Recentes">Mais Recentes</option>
								<option value="Mais Lidas">Mais Lidas</option>
							</select>
						</form>
					</div>
				</header>
					
				<?php if (have_posts()): while (have_posts()) : the_post();?>
					<div class="row-fluid">
						<article class="conteudo-loop">
							<div class="row-fluid">
								<h2 class="h2-loop-tit"><?php the_title();?></h2>
							</div>

							<div class="conteudo-loop-rates">
								<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
							</div>

							<span class="row-fluid margintop05">
								<a href="<?php the_Permalink();?>"><?php echo the_Permalink();?></a>	
							</span>

							<p class="row-fluid">
								<?php the_excerpt(); ?>
							</p>
							
							<div id="conteudo-loop-data" class="row-fluid margintop05">
								<span class="conteudo-loop-data-tit">Sugerido em:</span>
								<?php the_time('d/m/Y');?> - <?php the_time('G\hi'); ?>
							</div>

							<div id="conteudo-loop-idiomas" class="row-fluid">
								<span class="conteudo-loop-idiomas-tit">Idiomas disponíveis:</span>
								Português, English, Español
							</div>

							<div id="conteudo-loop-tags" class="row-fluid margintop10">
								<i class="ico-tags"></i>
								<?php the_tags('',', ','<br />'); ?>
							</div>

							<footer class="row-fluid margintop5">
								<ul class="conteudo-loop-icons">
									<li class="conteudo-loop-icons-li">
										<span class="compartilhar-open">
											<i class="ico-compartilhar"></i>
											Compartilhar
										</span>

										<div class="compartilhar">	
											<div class="compartilhar-close">[X]</div>
											<span class="compartilhar-tit">Compartilhar</span>
											
											<div class="row-fluid margintop05">
												<a href="#" class="row-fluid compartilhar-list">
													<span class="ico-fb"></span>
													<span class="compartilhar-text">Facebook</span>
												</a>
												<a href="#" class="row-fluid compartilhar-list">
													<span class="ico-tt"></span>
													<span class="compartilhar-text">Twitter</span>
												</a>
												<a href="#" class="row-fluid compartilhar-list">
													<span class="ico-lk"></span>
													<span class="compartilhar-text">Linkedin</span>
												</a>

												<div class="row-fluid compartilhar-border"></div>

												<a href="#" class="row-fluid compartilhar-list">
													<span class="ico-at"></span>
													<span class="compartilhar-text">Add This</span>
												</a>
											</div>
										</div>
									</li>

									<li class="conteudo-loop-icons-li">
										<a href="#">
											<i class="ico-rank"></i>
											Rank
										</a>
									</li>

									<li class="conteudo-loop-icons-li">
										<span class="sugerir-tag-open">
											<i class="ico-tag"></i>
											Sugerir Tag
										</span>

										<div class="sugerir-tag">	
											<form action="">
												<div class="sugerir-tag-close">[X]</div>
												<span class="sugerir-tag-tit">Sugerir Tag</span>
												
												<div class="row-fluid margintop05 marginbottom10">
													<input type="text" name="txtTag" class="sugerir-tag-input" id="txtTag">
												</div>


												<div class="row-fluid margintop05">
													<span class="sugerir-tag-keywords">
														<span class="pull-left sugerir-tag-keywords-text">Keyword 01</span>
														<span class="sugerir-tag-keywords-remove">X</span>
													</span>
												</div>
											</form>
										</div>
									</li>

									<li class="conteudo-loop-icons-li">
										<span class="reportar-erro-open">
											<i class="ico-reportar"></i>
											Reportar Erro
										</span>

										<div class="reportar-erro">	
											<form action="">
												<div class="reportar-erro-close">[X]</div>
												<span class="reportar-erro-tit">Motivo</span>

												<div class="row-fluid margintop05">
													<input type="radio" name="txtMotivo" id="txtMotivo1">
													<label class="reportar-erro-lbl" for="txtMotivo1">Motivo 01</label>
												</div>

												<div class="row-fluid">
													<input type="radio" name="txtMotivo" id="txtMotivo2">
													<label class="reportar-erro-lbl" for="txtMotivo2">Motivo 02</label>
												</div>

												<div class="row-fluid">
													<input type="radio" name="txtMotivo" id="txtMotivo3">
													<label class="reportar-erro-lbl" for="txtMotivo3">Motivo 03</label>
												</div>

												<div class="row-fluid margintop05">
													<textarea name="txtArea" id="txtArea" class="reportar-erro-area" cols="20" rows="2"></textarea>
												</div>

												<div class="row-fluid border-bottom2"></div>

												<span class="reportar-erro-tit margintop05">Nueva URL (Opcional)</span>
												<div class="row-fluid margintop05">
													<textarea name="txtUrl" id="txtUrl" class="reportar-erro-area" cols="20" rows="2"></textarea>
												</div>

												<div class="row-fluid border-bottom2"></div>
												
												<div class="row-fluid margintop05">
													<button class="pull-right reportar-erro-btn">Enviar</button>
												</div>
											</form>
										</div>
									</li>

									<li class="conteudo-loop-icons-li">
										<a href="#">
											<i class="ico-comentar"></i>
											Comentar
										</a>
									</li>
								</ul>
							</footer>
						</article>
					</div>
				<?php endwhile; else:?>
				<?php endif;?> 
			</section>
			
			<aside id="sidebar">
				<?php get_sidebar();?>
			</aside>

		</div>
	</div>
<?php get_footer();?>