<?php 
	
	
	
	// Get information about available Qualification Records editions (years)	
	$site_list = wp_get_sites( array('public' => true) );
	$edition_list = array();	
	
	if ( count($site_list) > 1 ){
		foreach ($site_list as $site){
			if ( preg_match('/\/([0-9]+)\//', $site['path'], $edition_year) ) {
				$edition_list[] = $edition_year[1];
			}
		}				
		sort($edition_list, SORT_NUMERIC);
				
		// Get information about current Qualification Records edition (year)	
		$current_site = get_blog_details();
		preg_match('/\/([0-9]+)\//', $current_site->path, $current_edition_info);
		$current_edition = $current_edition_info[1];
	}
	
	get_header();
	load_theme_textdomain('Ripsa', get_stylesheet_directory() . '/languages');
?>
		<div id="content">
			<section class="content-search">
				<div class="padding15-25">
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
					</form>
				</div>
			</section>
			<div class="padding15-25">	
				<?php
				    $categories = get_categories(array('exclude' => 1));
				    foreach($categories as $cat) {
					$categories_ordered[] = get_field('sort', 'category_' . $cat->term_id);
				    }
				    array_multisort($categories_ordered, $categories);
				?>
				<ul class="content-catlist">
    				<?php foreach($categories as $category) : ?>
					    <li>
					    	<div class="group_key">
								<?php the_field('grupo', 'category_' . $category->term_id); ?>
					    	</div>
					    	<a href="<?php global $site_lang; echo get_category_link( $category->term_id ) . '?l=' . $site_lang;?>" title="<?php echo __('Ver todos os posts da categoria', 'Ripsa') . $category->name; ?>">
					        	<span class="row-fluid content-catlist-tit"><?php echo $category->name;?></span>
					        	<span class="row-fluid"><?php echo $category->description;?><span>
					        </a>
					    </li>
				    <?php endforeach;?>
				</ul>
			</div>
		</div>
<?php get_footer();?>
