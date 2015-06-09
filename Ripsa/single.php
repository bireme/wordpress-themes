<?php 
	require_once("header.php");
	// $ezLaTeX = new EzLaTeX();
	load_theme_textdomain('Ripsa', get_stylesheet_directory() . '/languages');
?>
	<div id="content">
		<?php if (have_posts()): while (have_posts()) : the_post();?>
		<section class="content-search">
			<div class="padding15-25">
				<?php
                                	if(function_exists('bcn_display')) {
                 	                       bcn_display();
                                        } else {
              	   	                       echo create_bread_crumb(get_the_title());
                                        }
       				?>
			</div>
		</section>
		<div class="padding15-25">
			<div class="single-content print-only">
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
					$category = get_the_category();
					echo '<a href="' . site_url() . '/category/' . $category[0]->slug . '/' . '?l=' . $site_lang . '">' . $category[0]->cat_name . '</a>';
					?>
				</span>
				<h1 class="single-h1 marginbottom15"><?php $key="prefixo"; echo get_post_meta($post->ID,$key,true);?> - <?php the_title();?> - <?php $key="edicao"; echo get_post_meta($post->ID,$key,true);?></h1>
				<?php $subtitle = get_post_meta($post->ID, 'subtitulo', true);?>
				<?php
            				if (!empty($subtitle)) {
            				echo '<div class="subtitle">';
					echo get_post_meta($post->ID, 'subtitulo', true);
					echo '</div>';
					}	
				?>
				<?php
					$alerta = $ezLaTeX->parseTex(get_field('alertas'));
				?>
				<?php if (!empty($alerta)) { ?>
					<div class="warning">
						<?php echo $alerta; ?>
					</div>
				<?php } ?>
				<div class="single-topicos">
					<div class="row-fluid">
						<h2 class="single-h2"><span class="single-topics-seta">-</span> <?php _e( 'Conceituação', 'Ripsa' ); ?></h2>
					</div>
					<div class="row-fluid single-topicos-open">
						<div class="single-topicos-content">
							<?php $key="conceituacao"; echo $ezLaTeX->parseTex(get_field($key));?>
						</div>
					</div>
				</div>
				<div class="single-topicos">
					<div class="row-fluid">
						<h2 class="single-h2"><span class="single-topics-seta">-</span> <?php _e( 'Interpretação', 'Ripsa' ); ?></h2>
					</div>
					<div class="row-fluid single-topicos-open">
						<div class="single-topicos-content">
							<?php $key="interpretacao"; echo $ezLaTeX->parseTex(get_field($key));?>
						</div>
					</div>
				</div>
				<div class="single-topicos">
					<div class="row-fluid">
						<h2 class="single-h2"><span class="single-topics-seta">-</span> <?php _e( 'Usos', 'Ripsa' ); ?></h2>
					</div>
					<div class="row-fluid single-topicos-open">
						<div class="single-topicos-content">
							<?php $key="usos"; echo $ezLaTeX->parseTex(get_field($key));?>
						</div>
					</div>
				</div>
				<div class="single-topicos">
					<div class="row-fluid">
						<h2 class="single-h2"><span class="single-topics-seta">-</span> <?php _e( 'Limitações', 'Ripsa' ); ?></h2>
					</div>
					<div class="row-fluid single-topicos-open">
						<div class="single-topicos-content">
							<?php $key="limitacoes"; echo $ezLaTeX->parseTex(get_field($key));?>
						</div>
					</div>
				</div>
				<div class="single-topicos">
					<div class="row-fluid">
						<h2 class="single-h2"><span class="single-topics-seta">-</span> <?php _e( 'Fonte', 'Ripsa' ); ?></h2>
					</div>
					<div class="row-fluid single-topicos-open">
						<div class="single-topicos-content">
							<?php $key="fonte"; echo $ezLaTeX->parseTex(get_field($key));?>
						</div>
					</div>
				</div>
				<div class="single-topicos" id="calculation">
					<div class="row-fluid">
						<h2 class="single-h2"><span class="single-topics-seta">-</span> <?php _e( 'Métodos de Cálculo', 'Ripsa' ); ?></h2>
					</div>
					<div class="row-fluid single-topicos-open">
						<div class="single-topicos-content">
							<?php 
								$key="metodo_de_calculo";
								echo $ezLaTeX->parseTex(get_field($key));
							?>
						</div>
					</div>
				</div>
				<div class="single-topicos">
					<div class="row-fluid">
						<h2 class="single-h2"><span class="single-topics-seta">-</span> <?php _e( 'Categorias Sugeridas para Análise', 'Ripsa'); ?></h2>
					</div>
					<div class="row-fluid single-topicos-open">
						<div class="single-topicos-content">
							<?php $key="categorias_sugeridas_para_analise"; echo $ezLaTeX->parseTex(get_field($key));?>
						</div>
					</div>
				</div>
				<div class="single-topicos">
					<div class="row-fluid">
						<h2 class="single-h2"><span class="single-topics-seta">-</span> <?php _e( 'Dados Estatísticos e Comentários', 'Ripsa' ); ?></h2>
					</div>
					<div class="row-fluid single-topicos-open">
						<div class="single-topicos-content">
							<?php $key="dados_estatisticos_e_comentarios"; echo $ezLaTeX->parseTex(get_field($key));?>
						</div>
					</div>
				</div>
				<?php $notes = get_post_meta($post->ID, 'notas', true);?>
				<?php
            		if (!empty($notes)) {
            			echo '<div class="single-topicos">';
            			echo '<div class="row-fluid">';
						echo '<h2 class="single-h2"><span class="single-topics-seta">-</span>';
						_e( 'Notas', 'Ripsa');
						echo '</h2>';
						echo '</div>';
						echo '<div class="row-fluid single-topicos-open">';
						echo '<div class="single-topicos-content">';
						$key="notas"; echo $ezLaTeX->parseTex(get_field($key));
						echo '</div>';
						echo '</div>';
						echo '</div>';
					}	
				?>
				<?php $g_section_ttl = get_post_meta($post->ID, 'section-title', true);?>
				<?php
					if (!empty($g_section_ttl)) {
						echo '<div class="single-topicos">';
            			echo '<div class="row-fluid">';
            			echo '<h2 class="single-h2"><span class="single-topics-seta">-</span>';
						echo get_post_meta($post->ID, 'section-title', true);
						echo '</h2>';
						echo '</div>';
            		}
				?>
				<?php $g_section_cont = get_post_meta($post->ID, 'section-content', true);?>
				<?php
					if (!empty($g_section_cont)) {
						echo '<div class="row-fluid single-topicos-open">';
						echo '<div class="single-topicos-content">';
						echo get_post_meta($post->ID,'section-content' ,true);
						echo '</div>';
						echo '</div>';
					}
				?>
				<?php
					if (!empty($g_section_ttl)) {
						echo '</div>';
            		}
				?>
				<?php if (!empty($alerta)) { ?>
                    <div class="warning">
						<?php echo $alerta; ?>
                    </div>
				<?php } ?>
			</div>
			<?php endwhile; else:?>
			<?php endif;?>
			<aside class="single-sidebar">
				<span class="single-tit-cat text-indent">Sidebar</span>
				<div class="row-fluid single-topics-showall">
					<div class="i-show"></div>
					<?php _e( 'Expandir todos os tópicos','Ripsa'); ?>
				</div>
				<div class="row-fluid single-topics-hideall">
					<div class="i-hide"></div>
					<?php _e( 'Fechar todos os tópicos', 'Ripsa'); ?>
				</div>
				<div class="row-fluid bg-blue margintop10">
					<div class="padding7">
						<h3 class="row-fluid single-h3"><?php _e( 'Serviços', 'Ripsa'); ?></h3>
						<a href="<?php $key="bases_de_dados"; echo get_post_meta($post->ID,$key,true);?>" target="_blank" class="row-fluid single-servicos">
							<i class="i-basedados"></i><span class="single-servicos-text"><?php _e( 'Base de Dados', 'Ripsa'); ?></span>
						</a>
						<a href="<?php $key="literatura_scielo"; echo get_post_meta($post->ID,$key,true);?>" target="_blank" class="row-fluid single-servicos">
							<i class="i-scielo"></i><span class="single-servicos-text"><?php _e( 'Literatura Científica em SCIELO', 'Ripsa'); ?></span>
						</a>
						<a href="<?php $key="literatura_lilacs"; echo get_post_meta($post->ID,$key,true);?>" target="_blank" class="row-fluid single-servicos">
							<i class="i-lilacs"></i><span class="single-servicos-text"><?php _e( 'Literatura Científica em LILACS', 'Ripsa'); ?></span>
						</a>
						<?php 
							$indicador = get_the_title($post->ID);
							$edicao = get_post_meta($post->ID,"edicao",true);
							include("lista_ficha_versions.php"); 
		 				?>
						<span id="impressao" class="row-fluid single-servicos">
							<?php if(function_exists('pf_show_link')){echo pf_show_link();} ?>
							<?php if ( function_exists( 'pdfprnt_show_buttons_for_custom_post_type' ) ) echo pdfprnt_show_buttons_for_custom_post_type( $custom_query ); ?> 
						</span>
						<?php $comment_ficha = get_post_meta($post->ID, 'comentarios_indicadores', true);?>
						<?php if (!empty($comment_ficha)) { ?>
							<a href="<?php the_field('comentarios_indicadores');?>" target="_blank" class="row-fluid single-servicos">
								<i class="i-comment"></i><span class="single-servicos-text"><?php _e( 'Comentários sobre indicadores', 'Ripsa'); ?></span>
							</a>
						<?php } ?>
					</div>
				</div>
			</aside>
		</div>
	</div>
<?php require_once("footer.php");?>		
