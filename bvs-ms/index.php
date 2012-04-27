<?php
/**
 * Index.php
 * O index é carregado quando o WordPress não encontra algum arquivo específico no loop
 * Na ausência dos arquivos search.php / archive.php o index é carregado.
 * Caso necessite de um formato de exibição específico para esses comportamentos. 
 * Copie esse arquivo e renomeie de acordo com o objetivo necessário
 * A Apresentação é em formato de lista de resultados em apenas 1 coluna.
 */
get_header(); ?>
			<div class="content index">
				<div class="breadCrumb">
					<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a><span class="active"><?php wp_title('/',true,''); ?></span>
				</div><!--/breadCrumb-->
				<h2><?php wp_title('',true,''); ?></h2>
				<div class="spacer"></div><!--/spacer -->
				
				<ul class="posts_list">
					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h3><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
						<div class="excerpt">
							 <?php the_excerpt(); ?> 
						</div><!-- .entry-content -->
					</li><!-- #post-## -->
					<?php endwhile; // end of the loop. ?>
				</ul><!--/posts_list-->
			</div><!--/content -->
			<div class="footer">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
				<?php endif; ?>
			</div><!--/footer -->
		</div><!-- /container -->
	</body>	
</html>