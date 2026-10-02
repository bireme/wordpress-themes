<?php
/**
 * Thematic commissions section.
 *
 * @package Observatorio
 */

$commissions = new WP_Query(
	array(
		'post_type'      => 'comissao_tematica',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
		'order'          => 'ASC',
	)
);

if ( ! $commissions->have_posts() ) {
	return;
}

$commission_ids = wp_list_pluck( $commissions->posts, 'ID' );
$cover_image    = '';

foreach ( $commission_ids as $commission_id ) {
	if ( has_post_thumbnail( $commission_id ) ) {
		$cover_image = get_the_post_thumbnail_url( $commission_id, 'large' );
		break;
	}
}
?>
<section id="thematic-commissions" class="working-groups-section section-space">
	<div class="container">
		<div class="working-groups-panel">
			<div class="row g-0 align-items-stretch">
				<div class="col-lg-6">
					<div
						class="working-groups-image<?php echo $cover_image ? ' has-background-image' : ''; ?>"
						<?php if ( $cover_image ) : ?>
							style="--working-groups-image: url('<?php echo esc_url( $cover_image ); ?>');"
						<?php endif; ?>
						role="img"
						aria-label="<?php echo esc_attr__( 'Comissões temáticas do Observatório', 'observatorio' ); ?>"
					></div>
				</div>

				<div class="col-lg-6">
					<div class="working-groups-content h-100 d-flex flex-column justify-content-center">
						<span class="section-kicker"><?php esc_html_e( 'Articulação e colaboração', 'observatorio' ); ?></span>
						<h2><?php esc_html_e( 'Comissões Temáticas', 'observatorio' ); ?></h2>
						<p><?php esc_html_e( 'Grupos de trabalho responsáveis pela produção de análises estratégicas sobre temas prioritários do Observatório.', 'observatorio' ); ?></p>
						<p class="text-secondary"><?php esc_html_e( 'Conheça as atividades, participantes e conteúdos produzidos em cada eixo temático do Observatório.', 'observatorio' ); ?></p>

						<div class="commission-links d-flex flex-wrap gap-2 mt-3">
							<?php while ( $commissions->have_posts() ) : ?>
								<?php $commissions->the_post(); ?>
								<a class="btn btn-accent-teal rounded-pill" href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();
