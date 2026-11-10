<?php
/** Reusable newsletter call-to-action. Supply a real signup URL via theme filter. */
$url = function_exists( 'get_field' ) ? get_field( 'newsletter_signup_url', 'option' ) : '';
$url = apply_filters( 'observatorio_newsletter_url', $url );
?>
<section class="container newsletter-section" aria-label="<?php esc_attr_e( 'Fique por dentro', 'observatorio' ); ?>">
 <div class="newsletter-banner"><div class="newsletter-symbol" aria-hidden="true">✉</div><div class="newsletter-copy">
 <h2><?php esc_html_e( 'Fique por dentro das novas publicações', 'observatorio' ); ?></h2>
 <p><?php esc_html_e( 'Receba avisos sobre novos policy briefs e outros materiais do Observatório.', 'observatorio' ); ?></p>
 </div><?php if ( $url ) : ?><a class="btn btn-primary" href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Quero receber atualizações', 'observatorio' ); ?> →</a><?php endif; ?></div>
</section>
