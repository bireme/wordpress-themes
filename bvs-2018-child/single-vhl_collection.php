<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-lg-12">
		<main id="main" class="site-main" role="main">

		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
		    	<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>

	    	<?php 
		    	$parent_page = get_post_ancestors(get_the_ID()); 
		    	if( !empty($parent_page) ) : ?>
			    <li class="breadcrumb-item active" aria-current="page">
			    	<a href="<?php echo get_permalink( $parent_page[0] ); ?>">
			    		<?php echo get_the_title( $parent_page[0] ); ?>
			    	</a>
		    	</li>
			<?php else: ?>
				<li class="breadcrumb-item active" aria-current="page">
					<?php the_title(); ?>
				</li>
			<?php endif; ?>

		  	</ol>
		</nav>

		<div class="row justify-content-center content-single">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-md-11">
					<?php if( has_post_thumbnail() ): ?>
					<div class="row">
						<div class="page-thumbnail col-md-2">
							<?php the_post_thumbnail(); ?>
						</div>
						<div class="col-md-10">
							<?php get_template_part( 'template-parts/content', 'vhl' ); ?>
						</div>
					</div>
					<?php else: ?>
						<?php get_template_part( 'template-parts/content', 'vhl' ); ?>
					<?php endif; ?>
				</div>
			<?php endwhile; // End of the loop. ?>
		</div>
		
		<?php 
			$args_child = array(
				'posts_per_page' => -1,
				'post_type'  => 'vhl_collection',
				'post_parent' => get_the_ID(),
				'orderby' => 'menu_order',
				'order'   => 'ASC',
			);
			$childs = new WP_Query( $args_child );
		?>
		<section class="row justify-content-center">
			<div class="col-md-11">
				<div class="row">
				<?php if ( $childs->have_posts() ) : 
					while ( $childs->have_posts() ) : $childs->the_post();
					
						get_template_part( 'template-parts/item', 'vhl' );

					endwhile; 
					wp_reset_postdata();
				endif; ?>
				</div>
			</div>
		</section>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
