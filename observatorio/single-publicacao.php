<?php
/**
 * Single publication template.
 *
 * @package Observatorio
 */

get_header();
?>

<main id="main-content" class="site-main single-publication">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$publication_type = get_field( 'publication_type' );
		$publication_file = get_field( 'publication_file' );
		$external_link    = get_field( 'publication_external_link' );
		$thematic_area    = get_field( 'publication_thematic_area' );
		?>

		<article <?php post_class( 'publication-detail' ); ?>>
			<header class="page-hero section-space">
				<div class="container">
					<span class="section-kicker"><?php echo esc_html( $publication_type ?: __( 'Publicação', 'observatorio' ) ); ?></span>
					<h1><?php the_title(); ?></h1>

					<?php if ( has_excerpt() ) : ?>
						<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>
				</div>
			</header>

			<div class="container section-space pt-0">
				<div class="row g-5">
					<div class="col-lg-8">
						<?php if ( has_post_thumbnail() ) : ?>
							<figure class="publication-featured-image mb-4">
								<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid rounded-4' ) ); ?>
							</figure>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</div>

					<aside class="col-lg-4">
						<div class="publication-info-card">
							<h2 class="h4"><?php esc_html_e( 'Sobre a publicação', 'observatorio' ); ?></h2>

							<?php if ( $publication_type ) : ?>
								<p><strong><?php esc_html_e( 'Tipo:', 'observatorio' ); ?></strong><br><?php echo esc_html( $publication_type ); ?></p>
							<?php endif; ?>

							<?php if ( $thematic_area ) : ?>
								<p><strong><?php esc_html_e( 'Área Temática:', 'observatorio' ); ?></strong><br><a href="<?php echo esc_url( get_permalink( $thematic_area ) ); ?>"><?php echo esc_html( get_the_title( $thematic_area ) ); ?></a></p>
							<?php endif; ?>

							<?php if ( $publication_file && ! empty( $publication_file['url'] ) ) : ?>
								<a class="btn btn-primary w-100 mb-2" href="<?php echo esc_url( $publication_file['url'] ); ?>" target="_blank" rel="noopener noreferrer">
									<?php esc_html_e( 'Abrir arquivo', 'observatorio' ); ?>
								</a>
							<?php endif; ?>

							<?php if ( $external_link && ! empty( $external_link['url'] ) ) : ?>
								<a class="btn btn-outline-primary w-100" href="<?php echo esc_url( $external_link['url'] ); ?>"<?php echo ! empty( $external_link['target'] ) ? ' target="' . esc_attr( $external_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>>
									<?php echo esc_html( $external_link['title'] ?: __( 'Acessar publicação', 'observatorio' ) ); ?>
								</a>
							<?php endif; ?>
						</div>
					</aside>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
