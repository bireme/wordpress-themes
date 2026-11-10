<?php
/**
 * Thematic commissions: global homepage content.
 *
 * @package Observatorio
 */
$kicker = get_field( 'commissions_kicker', 'option' );
$title = get_field( 'commissions_title', 'option' );
$description = get_field( 'commissions_description', 'option' );
$image_id = (int) get_field( 'commissions_image', 'option' );
$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : '';
$kicker = $kicker ?: __( 'Articulação e colaboração', 'observatorio' );
$title = $title ?: __( 'Comissões Temáticas', 'observatorio' );
$description = $description ?: '<p>' . esc_html__( 'Grupos de trabalho responsáveis pela produção de análises estratégicas sobre temas prioritários do Observatório.', 'observatorio' ) . '</p><p>' . esc_html__( 'Conheça as atividades, participantes e conteúdos produzidos em cada eixo temático do Observatório.', 'observatorio' ) . '</p>';
?>
<section id="thematic-commissions" class="working-groups-section section-space">
    <div class="container">
        <div class="working-groups-panel">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-6">
                    <div class="working-groups-image<?php echo $image_url ? ' has-background-image' : ''; ?>"
                        <?php if ( $image_url ) : ?>style="--working-groups-image: url('<?php echo esc_url( $image_url ); ?>');"<?php endif; ?>
                        role="img" aria-label="<?php echo esc_attr( $title ); ?>"></div>
                </div>
                <div class="col-lg-6">
                    <div class="working-groups-content h-100 d-flex flex-column justify-content-center">
                        <span class="section-kicker"><?php echo esc_html( $kicker ); ?></span>
                        <h2><?php echo esc_html( $title ); ?></h2>
                        <?php echo wp_kses_post( $description ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
