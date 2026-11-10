<?php
/** Template Name: Sobre o Observatório */
get_header();
while ( have_posts() ) : the_post();
 $hero_image = function_exists( 'get_field' ) ? get_field( 'about_hero_image', 'option' ) : ''; // Legacy fallback.
 $video_url = function_exists( 'get_field' ) ? ( get_field( 'about_video_url_page', get_the_ID() ) ?: get_field( 'about_video_url', 'option' ) ) : ''; // Existing settings remain a fallback.
?>
<main id="main-content" class="site-main about-page">
<?php get_template_part( 'template-parts/components/page-hero', null, array(
 'kicker' => __( 'Sobre o Observatório', 'observatorio' ),
 'title' => __( 'Conhecimento para fortalecer o SUS', 'observatorio' ),
 'description' => __( 'Evidências, experiências e informações estratégicas para apoiar decisões em saúde.', 'observatorio' ),
 'image' => $hero_image,
) ); ?>
<section class="container about-intro section-space"><div class="row g-5 align-items-start">
 <div class="col-lg-12"><span class="section-kicker"><?php esc_html_e( 'O que é', 'observatorio' ); ?></span><h2><?php esc_html_e( 'Uma iniciativa para apoiar decisões em saúde', 'observatorio' ); ?></h2>
 <div class="about-intro__text"><?php if ( trim( get_the_content() ) ) : the_content(); else : ?><p><?php esc_html_e( 'O Observatório reúne e organiza conhecimentos e informações para apoiar a gestão e as políticas públicas de saúde.', 'observatorio' ); ?></p><?php endif; ?></div></div>
</div></section>
<section class="container about-video-section section-space"><div class="row align-items-center g-4"><div class="col-lg-5"><span class="section-kicker"><?php esc_html_e( 'Vídeo institucional', 'observatorio' ); ?></span><h2><?php esc_html_e( 'Conheça o Observatório', 'observatorio' ); ?></h2><p><?php esc_html_e( 'Uma apresentação sobre a proposta e a atuação do Observatório.', 'observatorio' ); ?></p></div><div class="col-lg-7"><div class="about-video-frame"><?php if ( $video_url ) : $embed = wp_oembed_get( esc_url( $video_url ) ); if ( $embed ) { echo $embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
 } else { echo '<a class="btn btn-outline-primary" href="' . esc_url( $video_url ) . '">' . esc_html__( 'Assistir ao vídeo', 'observatorio' ) . '</a>'; } else : ?><div class="about-video-placeholder"><span aria-hidden="true">▶</span><p><?php esc_html_e( 'Vídeo institucional em breve', 'observatorio' ); ?></p></div><?php endif; ?></div></div></div></section>
<?php get_template_part( 'template-parts/home/partners' ); ?>
<?php get_template_part( 'template-parts/components/newsletter-banner' ); ?>
</main>
<?php endwhile; get_footer();
