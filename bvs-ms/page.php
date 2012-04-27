<?php
/**
 * page.php
 * O page.php tem a mesma forma de exibição do single.
 * Caso necessite de uma formatação específica para uma página é necessário copiar esse arquivo 
 * e renomea-lo como $custom.php para tipos de páginas / page-$slug.php ou page-$id.php para uma página específica
 * A Apresentação é em 1 coluna com BreadCrumb
 */
get_header(); ?>
			<div class="content index">
				<div class="breadCrumb">
					<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a><span class="active"><?php wp_title('/',true,''); ?></span>
				</div><!--/breadCrumb-->
				<div class="spacer"></div><!--/spacer -->
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h2><?php the_title(); ?></h3>
						<div class="the_content">
							 <?php the_content(); ?> 
						</div><!-- .the_contentt -->
					</div><!-- #post-## -->
					<?php endwhile; // end of the loop. ?>
			</div><!--/content -->
			<div class="footer">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
				<?php endif; ?>
			</div><!--/footer -->
		</div><!-- /container -->
	</body>	
</html>