<?php 
	$site_list = wp_get_sites( array('public' => true) );

	if ( count($site_list) > 1 ){
		foreach ($site_list as $site){
			if ( preg_match('/\/([0-9]+)\//', $site['path'], $edition_year) ) {
				$edition_list[] = $edition_year[1];
			}
		}
		sort($edition_list, SORT_NUMERIC);
		
		$category_filter['A'] = 'indicadores_demograficos';
		$category_filter['B'] = 'indicadores_socioeconomicos';
		$category_filter['C'] = 'indicadores_mortalidade';
		$category_filter['D'] = 'indicadores_morbidade_fatores_risco';
		$category_filter['E'] = 'indicadores_recursos';
		$category_filter['F'] = 'indicadores_cobertura';
		
		// Get information about current Qualification Records edition (year)	
		$current_site = get_blog_details();
		preg_match('/\/([0-9]+)\//', $current_site->path, $current_edition_info);
		$current_edition = $current_edition_info[1];
	}

	// load all 'category' terms for the post
	$terms = get_the_terms($post->ID, 'category');
	// we will use the first term to load ACF data from
	if( !empty($terms) )
	{
		$term = array_pop($terms);
		$current_category_group = get_field('grupo', 'category_' . $term->term_id );
		// do something with $custom_field
	}
	
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
					
					<form action="http://pesquisa.bvsalud.org/ripsa/">
						<input type="hidden" name="where" value="FICHAS" />
						<div class="row-fluid">
							<label for="txtSearch"><?php _e( 'Pesquisa', 'Ripsa' ); ?><br/> <?php _e( 'Entre uma ou mais palavras', 'Ripsa' ); ?></label>
						</div>

						<div class="row-fluid">
							<div class="pull-left">
								<input type="text" class="search-input" id="txtSearch" name="txtSearch">
								<button class="search-btn"><?php _e( 'Pesquisar', 'Ripsa' ); ?></button>
							</div>
							<?php if ( count($site_list) > 1 ) : ?>
								<div class="pull-right">
									<?php _e( 'Conjunto de indicadores', 'Ripsa' ); ?>
									<select name="filter_chain[]">
										<option value=""><?php echo _e('Todas edições', 'Ripsa'); ?></option>
										<?php 
											foreach ($edition_list as $edition){
												echo '<option value="year_cluster:' . $edition . '"' . ($edition == $current_edition ? 'selected="1"' : '') .  '>' . $edition . '</option>';
											}
										?>
									</select>
								</div>
							<?php endif; ?>
						</div>
						<div class="row-fluid margintop05">
							<div class="pull-left marginright10">
								<input type="radio" name="filter_chain[]" id="txtIndicadoresDemograficos" checked="true" value="ripsa_indicadores:<?php echo $category_filter[$current_category_group] ?>">
								<label for="txtIndicadoresDemograficos" class="search-radio-txt"><?php _e( 'Neste grupo', 'Ripsa' ); ?></label>
							</div>
							
							<div class="pull-left">
								<input type="radio" name="filter_chain[]" id="txtIndicadoresTodos" value="">
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
							echo  " " . $current_category_group . " - ";
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
