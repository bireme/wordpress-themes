<?php require_once("header.php");?>

		<div id="content">
			<?php if (have_posts()): while (have_posts()) : the_post();?>
			<section class="content-search">
				<div class="padding15-25">
					<?php if(function_exists('bcn_display'))
				    {
				        bcn_display();
				    }?>
				</div>
			</section>

			<div class="padding15-25">
					<div class="single-content">
						<span class="single-tit-cat">
							<?php
							global $post;
							// load all 'category' terms for the post
							$terms = get_the_terms($post->ID, 'category');
							// we will use the first term to load ACF data from
							if( !empty($terms) )
							{
								$term = array_pop($terms);
								$custom_field = get_field('grupo', 'category_' . $term->term_id );
								// do something with $custom_field
							}
							echo  $custom_field . " ";
							the_category();
							?>
						</span>
						<h1 class="single-h1 marginbottom15"><?php $key="prefixo"; echo get_post_meta($post->ID,$key,true);?> - <?php the_title();?> - <?php $key="edicao"; echo get_post_meta($post->ID,$key,true);?></h1>

						<div class="single-topicos">
							<div class="row-fluid">
								<h2 class="single-h2"><span class="single-topics-seta">-</span>Conceituação</h2>
							</div>
							
							<div class="row-fluid single-topicos-open">
								<div class="single-topicos-content">
									<?php $key="conceituacao"; echo get_post_meta($post->ID,$key,true);?>
								</div>
							</div>
						</div>

						<div class="single-topicos">
							<div class="row-fluid">
								<h2 class="single-h2"><span class="single-topics-seta">-</span>Interpretação</h2>
							</div>
							
							<div class="row-fluid single-topicos-open">
								<div class="single-topicos-content">
									<?php $key="interpretacao"; echo get_post_meta($post->ID,$key,true);?>
								</div>
							</div>
						</div>

						<div class="single-topicos">
							<div class="row-fluid">
								<h2 class="single-h2"><span class="single-topics-seta">-</span>Usos</h2>
							</div>
							
							<div class="row-fluid single-topicos-open">
								<div class="single-topicos-content">
									<?php $key="usos"; echo get_post_meta($post->ID,$key,true);?>
								</div>
							</div>
						</div>

						<div class="single-topicos">
							<div class="row-fluid">
								<h2 class="single-h2"><span class="single-topics-seta">-</span>Limitações</h2>
							</div>
							
							<div class="row-fluid single-topicos-open">
								<div class="single-topicos-content">
									<?php $key="limitacoes"; echo get_post_meta($post->ID,$key,true);?>
								</div>
							</div>
						</div>

						<div class="single-topicos">
							<div class="row-fluid">
								<h2 class="single-h2"><span class="single-topics-seta">-</span>Fonte</h2>
							</div>
							
							<div class="row-fluid single-topicos-open">
								<div class="single-topicos-content">
									<?php $key="fonte"; echo get_post_meta($post->ID,$key,true);?>
								</div>
							</div>
						</div>

						<div class="single-topicos" id="calculation">
							<div class="row-fluid">
								<h2 class="single-h2"><span class="single-topics-seta">-</span>Métodos de Cálculo</h2>
							</div>
							
							<div class="row-fluid single-topicos-open">
								<div class="single-topicos-content">
									<?php $key="metodo_de_calculo"; echo get_post_meta($post->ID,$key,true);?>
								</div>
							</div>
						</div>

						<div class="single-topicos">
							<div class="row-fluid">
								<h2 class="single-h2"><span class="single-topics-seta">-</span>Categorias Sugeridas para Análise</h2>
							</div>
							
							<div class="row-fluid single-topicos-open">
								<div class="single-topicos-content">
									<?php $key="categorias_sugeridas_para_analise"; echo get_post_meta($post->ID,$key,true);?>
								</div>
							</div>
						</div>

						<div class="single-topicos">
							<div class="row-fluid">
								<h2 class="single-h2"><span class="single-topics-seta">-</span>Dados Estatísticos e Comentários</h2>
							</div>
							
							<div class="row-fluid single-topicos-open">
								<div class="single-topicos-content">
									<?php $key="dados_estatisticos_e_comentarios"; echo get_post_meta($post->ID,$key,true);?>
								</div>
							</div>
						</div>

						<div class="single-topicos">
                                                        <div class="row-fluid">
                                                                <h2 class="single-h2"><span class="single-topics-seta">-</span>Notas</h2>
                                                        </div>

                                                        <div class="row-fluid single-topicos-open">
                                                                <div class="single-topicos-content">
                                                                        <?php $key="notas"; echo get_post_meta($post->ID,$key,true);?>
                                                                </div>
                                                        </div>
                                                </div>

						<div class="single-topicos">
							<div class="row-fluid">
								<?php $g_section_ttl = get_post_meta($post->ID, 'section-title', true);?>
								<?php
									if (!empty($g_section_ttl)) {
										echo '<h2 class="single-h2"><span class="single-topics-seta">-</span>';
										echo get_post_meta($post->ID, 'section-title', true);
										echo '</h2>';
									}				
								?>
                                                        </div>

                                                        <div class="row-fluid single-topicos-open">
                                                                <div class="single-topicos-content">
									<?php $g_section_cont = get_post_meta($post->ID, 'section-content', true);?>
									<?php
										if (!empty($g_section_cont)) {
											echo get_post_meta($post->ID,'section-content' ,true);
										}
									?>
                                                                </div>
                                                        </div>
                                                </div>

					</div>
				<?php endwhile; else:?>
  				<?php endif;?>

				<aside class="single-sidebar">
					<span class="single-tit-cat text-indent">Sidebar</span>

					<div class="row-fluid single-topics-showall">
						<div class="i-show"></div>
						Expandir todos os tópicos
					</div>
					
					<div class="row-fluid single-topics-hideall">
						<div class="i-hide"></div>
						Fechar todos os tópicos
					</div>

					<div class="row-fluid bg-blue margintop10">
						<div class="padding7">
							<h3 class="row-fluid single-h3">Serviços</h3>
							
							<a href="<?php $key="bases_de_dados"; echo get_post_meta($post->ID,$key,true);?>" class="row-fluid single-servicos">
								<i class="i-basedados"></i><span class="single-servicos-text">Base de Dados</span>
							</a>

							<a href="<?php $key="literatura_scielo"; echo get_post_meta($post->ID,$key,true);?>" class="row-fluid single-servicos">
								<i class="i-scielo"></i><span class="single-servicos-text">Literatura Científica em SCIELO</span>
							</a>

							<a href="<?php $key="literatura_lilacs"; echo get_post_meta($post->ID,$key,true);?>" class="row-fluid single-servicos">
								<i class="i-lilacs"></i><span class="single-servicos-text">Literatura Científica em LILACS</span>
							</a>

							<a href="<?php the_field('ficha_pdf');?>" target="_blank" class="row-fluid single-servicos">
								<i class="i-download"></i><span class="single-servicos-text">Ficha em Formato PDF</span>
							</a>

							<span id="impressao" class="row-fluid single-servicos">
								<i class="i-print"></i><span class="single-servicos-text">Imprimir</span>
							</span>

							<a href="#" class="row-fluid single-servicos">
								<i class="i-send2friend"></i><span class="single-servicos-text">Enviar ficha por e-mail</span>
							</a>

							<a href="#" class="row-fluid single-servicos">
								<i class="i-oldversions"></i><span class="single-servicos-text">Outras Versões</span>
							</a>

							<a href="<?php the_field('comentarios_indicadores');?>" target="_blank" class="row-fluid single-servicos">
								<i class="i-comment"></i><span class="single-servicos-text">Comentários sobre indicadores</span>
							</a>
						</div>
					</div>
				</aside>
			</div>
		</div>

<?php require_once("footer.php");?>		
