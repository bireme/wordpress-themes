<?php
/** Reusable sharing links for singular content. */
$url = get_permalink();
$title = get_the_title();
?>
<div class="publication-share content-share"><strong><?php esc_html_e( 'Compartilhar:', 'observatorio' ); ?></strong>
<a class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener noreferrer" href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $url ) ); ?>">LinkedIn</a>
<a class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener noreferrer" href="<?php echo esc_url( 'https://api.whatsapp.com/send?text=' . rawurlencode( $title . ' ' . $url ) ); ?>">WhatsApp</a>
<button type="button" class="btn btn-outline-primary btn-sm publication-copy-link" data-url="<?php echo esc_attr( $url ); ?>"><?php esc_html_e( 'Copiar link', 'observatorio' ); ?></button>
</div>
