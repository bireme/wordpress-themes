<?php
/** Breadcrumb NavXT with a simple accessible fallback. */
if ( is_front_page() ) { return; }
?>
<nav class="container site-breadcrumbs" aria-label="<?php esc_attr_e( 'Navegação estrutural', 'observatorio' ); ?>">
<?php if ( function_exists( 'bcn_display' ) ) :
 bcn_display();
else : ?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Início', 'observatorio' ); ?></a><span class="breadcrumb-separator" aria-hidden="true">/</span>
<?php if ( is_singular( 'publicacao' ) ) : ?>
<a href="<?php echo esc_url( get_post_type_archive_link( 'publicacao' ) ); ?>"><?php esc_html_e( 'Publicações', 'observatorio' ); ?></a><span class="breadcrumb-separator" aria-hidden="true">/</span>
<?php elseif ( is_single() && get_post_type() === 'post' ) :
$news_id = (int) get_option( 'page_for_posts' ); ?>
<a href="<?php echo esc_url( $news_id ? get_permalink( $news_id ) : home_url( '/noticias/' ) ); ?>"><?php esc_html_e( 'Notícias', 'observatorio' ); ?></a><span class="breadcrumb-separator" aria-hidden="true">/</span>
<?php endif; ?>
<span aria-current="page"><?php echo esc_html( is_home() ? __( 'Notícias', 'observatorio' ) : ( is_post_type_archive( 'publicacao' ) ? __( 'Publicações', 'observatorio' ) : ( is_archive() ? get_the_archive_title() : get_the_title( get_queried_object_id() ) ) ) ); ?></span>
<?php endif; ?>
</nav>
