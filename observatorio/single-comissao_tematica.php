<?php
/**
 * Single thematic commission template.
 *
 * @package Observatorio
 */

get_header();
?>

<main id="main-content" class="site-main">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'commission-single section-space' ); ?>>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-xl-10">
						<header class="entry-header mb-4">
							<span class="section-kicker"><?php esc_html_e( 'Comissão temática', 'observatorio' ); ?></span>
							<h1 class="entry-title"><?php the_title(); ?></h1>

							<?php if ( has_excerpt() ) : ?>
								<div class="entry-summary lead">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>
						</header>

						<?php if ( has_post_thumbnail() ) : ?>
							<figure class="entry-thumbnail mb-5">
								<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded-4 w-100' ) ); ?>
							</figure>
						<?php endif; ?>

						<?php
						$thematic_area_id = function_exists( 'get_field' ) ? get_field( 'commission_thematic_area' ) : 0;
						if ( $thematic_area_id ) :
							?>
							<div class="commission-related-area mb-4">
								<span class="fw-semibold"><?php esc_html_e( 'Área Temática:', 'observatorio' ); ?></span>
								<a href="<?php echo esc_url( get_permalink( $thematic_area_id ) ); ?>">
									<?php echo esc_html( get_the_title( $thematic_area_id ) ); ?>
								</a>
							</div>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
