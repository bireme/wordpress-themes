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
<?php elseif ( is_singular( 'evento' ) ) : ?>
<a href="<?php echo esc_url( get_post_type_archive_link( 'evento' ) ); ?>"><?php esc_html_e( 'Agenda', 'observatorio' ); ?></a><span class="breadcrumb-separator" aria-hidden="true">/</span>
<?php elseif ( is_singular( 'area_tematica' ) ) : ?>
<a href="<?php echo esc_url( get_post_type_archive_link( 'area_tematica' ) ); ?>"><?php esc_html_e( 'Áreas temáticas', 'observatorio' ); ?></a><span class="breadcrumb-separator" aria-hidden="true">/</span>
<?php elseif ( is_single() && get_post_type() === 'post' ) :
$news_page = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'page-templates/news-list.php', 'number' => 1 ) );
$news_id = $news_page ? (int) $news_page[0]->ID : 0; ?>
<a href="<?php echo esc_url( $news_id ? get_permalink( $news_id ) : home_url( '/noticias/' ) ); ?>"><?php esc_html_e( 'Notícias', 'observatorio' ); ?></a><span class="breadcrumb-separator" aria-hidden="true">/</span>
<?php endif; ?>
<span aria-current="page"><?php echo esc_html( is_home() ? __( 'Notícias', 'observatorio' ) : ( is_post_type_archive( 'publicacao' ) ? __( 'Publicações', 'observatorio' ) : ( is_post_type_archive() ? post_type_archive_title( '', false ) : ( is_archive() ? single_term_title( '', false ) : get_the_title( get_queried_object_id() ) ) ) ) ); ?></span>
<?php endif; ?>
</nav>
