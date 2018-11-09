<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */
$taxonomy = get_queried_object();
get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-lg-9">
		<main id="main" class="site-main" role="main">

		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
		    	<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?php _e('Segunda Opinião Formativa', 'bvs_lang'); ?></li>
		  	</ol>
		</nav>		

		<div class="row justify-content-center">
			<div class="col-md-11">
				<header class="page-header-taxonomy">
					<?php echo $taxonomy->name; ?>
				</header><!-- .page-header-taxonomy -->

				<header class="page-header-taxonomy-mobile">
					<div class="row">
						<div class="col-12">
							<button type="button" class="btn btn-link" data-toggle="modal" data-target="#modal-taxonomy-mobile">
								<img class="img-fluid" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icons/areas-tematicas.png'; ?>" alt="<?php _e('Quais as Áreas Temáticas', 'bvs_lang'); ?>?">
							</button>
							
							<span><?php _e('SOF', 'bvs_lang'); ?>: <br> <?php echo $taxonomy->name; ?></span>
						</div>
					</div>
				</header>

				<div id="modal-taxonomy-mobile" class="modal fade" tabindex="-1" role="dialog">
				  <div class="modal-dialog modal-dialog-centered" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title">
				        	<img class="img-fluid" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icons/areas-tematicas.png'; ?>" alt="<?php _e('Quais as Áreas Temáticas', 'bvs_lang'); ?>?">
				        </h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				      	<h2 class="title-taxonomy"><?php _e('Quais as Áreas Temáticas', 'bvs_lang'); ?>?</h2>
			        	
			        	<?php
						$terms = get_terms($taxonomy->taxonomy, array(
						    'orderby'    => 'count',
						    'order' => 'DESC',
						    'hide_empty' => true
						));

						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
						    echo '<ul class="list-terms">';

						    foreach ( $terms as $term ) {
						        echo "<li><a href='".get_term_link($term->term_id)."'>$term->name <span>($term->count)</span></a></li>";
						    }

						    echo '</ul>';
						}
						?>
				      </div>
				    </div>
				  </div>
				</div>

				<?php
				if ( have_posts() ) : ?>			
					
					<div class="row">
						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();
							
							get_template_part( 'template-parts/item', 'sof' );

						endwhile; 
						?>
					</div>

					<?php
					get_template_part( 'template-parts/navigation' );

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
			</div>
		</div>
		
		

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_template_part( 'template-parts/sidebar', 'taxonomy' ); ?>

<div class="row">
	<?php get_template_part('template-parts/last', 'sofs'); ?>
</div>

<?php
get_footer();
