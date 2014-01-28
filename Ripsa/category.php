<?php 
	require_once("header.php");
	load_theme_textdomain('Ripsa', get_stylesheet_directory() . '/languages');
?>

		<div id="content">
			<section class="content-search">
				<div class="padding15-25">
					<div class="row-fluid marginbottom10">
						<?php 
							if(function_exists('bcn_display')) {
					        		bcn_display();
					    		} else {
								echo create_bread_crumb(get_the_title());
							}
						?>
					</div>
					
					<form action="">
						<div class="row-fluid">
                                                        <label for="txtSearch"><?php _e( 'Pesquisa', 'Ripsa' ); ?><br/> <?php _e( 'Entre uma ou mais palavras', 'Ripsa' ); ?></label>
                                                </div>

                                                <div class="row-fluid">
                                                        <div class="pull-left">
                                                                <input type="text" class="search-input" id="txtSearch" name="txtSearch">
                                                                <button class="search-btn"><?php _e( 'Pesquisar', 'Ripsa' ); ?></button>
                                                        </div>

                                                        <!--div class="pull-right">
                                                                <label class="search-label" for="txtIndicadores"><?php _e( 'Conjunto de Indicadores:', 'Ripsa' ); ?></label>
                                                                <select name="txtIndicadores" id="txtIndicadores">
                                                                        <option value="2012">IDB 2012</option>
                                                                        <option value="2011">IDB 2011</option>
                                                                        <option value="2010">IDB 2010</option>
                                                                </select>
                                                        </div-->
                                                </div>

						<div class="row-fluid margintop05">
							<div class="pull-left marginright10">
								<input type="radio" name="txtFiltro" id="txtIndicadoresDemograficos">
								<label for="txtIndicadoresDemograficos" class="search-radio-txt"><?php _e( 'Neste grupo', 'Ripsa' ); ?></label>
							</div>
							
							<div class="pull-left">
								<input type="radio" name="txtFiltro" id="txtIndicadoresTodos">
								<label for="txtIndicadoresTodos" class="search-radio-txt"><?php _e( 'Em todos os indicadores', 'Ripsa' ); ?></label>
							</div>
						</div>
					</form>
				</div>
			</section>

			<div class="padding15-25">
				<div class="row-fluid marginbottom15">
					<span class="row-fluid content-catlist-tit">
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
							echo  " " . $custom_field . " - ";
							single_cat_title();
							?>
					</span>
					<span class="row-fluid"><?php echo category_description();?></span>
				</div>
				
				<div class="row-fluid">
					<ul class="category-ul">
						<?php if (have_posts()): while (have_posts()) : the_post();?>
							<li class="category-li">
								<a href="<?php the_Permalink()?>" class="m-results-lia"><?php $key="prefixo"; echo get_post_meta($post->ID,$key,true);?> - <?php the_title();?></a>
							</li>
						<?php endwhile; else:?>
	      				<?php endif;?>
					</ul>
				</div>
			</div>
		</div>

<?php require_once("footer.php");?>		
