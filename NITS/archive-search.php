<!DOCTYPE html>
<?php 

get_header();?> 

<div id="primary" class="col-md-12 archive archive_portfolio">
	<div class="row">
	<div class="search-portfolio">   
			<h3>Buscar em Portfolio</h3>
			<form role="search" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
				<input class="searchInput" type="text" name="s" placeholder="Search Portfolio"/>
				<input type="hidden" name="post_type" value="portfolio" /> 
				<input class="searchButton" type="submit" alt="Search" value="Pesquisar" />
			</form>
		 </div>
	</div>
	<h2>Resultados da pesquisa: <i>"<?php the_search_query(); ?>"</i></h2>
	<div class="row">
		<div class="col-md-9">
			<? include 'portfolio_archive_newpart.php'; ?> 
		</div>
		<div class="col-md-3 filters">
			<div class="themes_list">
				<?php  
				$terms = get_terms('temas');
				 if ( !empty( $terms ) && !is_wp_error( $terms ) ){
					 echo '<h4>Temas</h4>';
					 echo '<ul>';
					 foreach ( $terms as $term ) {
					 echo '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '&nbsp;(' . $term->count . ')' . '</a></li>'; 					 }
					 echo '</ul>';
				 } 
				?> 
			</div>
			<div class="type_list">
				<?php  
				$terms = get_terms('tipos');
				 if ( !empty( $terms ) && !is_wp_error( $terms ) ){
					 echo '<h4>Tipos</h4>';
					 echo '<ul>';
					 foreach ( $terms as $term ) {
					 echo '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '&nbsp;(' . $term->count . ')' . '</a></li>'; 					 }
					 echo '</ul>';
				 } 
				?> 
			</div>
			<div class="nucleos_list">
				<?php  
				$terms = get_terms('nucleos');
				 if ( !empty( $terms ) && !is_wp_error( $terms ) ){
					 echo '<h4>Núcleos</h4>';
					 echo '<ul>';
					 foreach ( $terms as $term ) {
					 echo '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '&nbsp;(' . $term->count . ')' . '</a></li>'; 					 }
					 echo '</ul>';
				 } 
				?> 
			</div>
		</div>
	</div>
</div>
<?php
get_footer(); 
?>