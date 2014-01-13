<?php get_header();?>

		<div id="content">
			<section class="content-search">
				<div class="padding15-25">
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
					    	<a href="<?php echo get_category_link( $category->term_id );?>" title="Ver todos os posts da categoria <?php echo $category->name; ?>">
					        	<span class="row-fluid content-catlist-tit"><?php echo $category->name;?></span>
					        	<span class="row-fluid"><?php echo $category->description;?><span>
					        </a>
					    </li>
				    <?php endforeach;?>
				</ul>
			</div>
		</div>

<?php get_footer();?>		
