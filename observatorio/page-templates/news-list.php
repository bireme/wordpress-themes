<?php
/**
 * Template Name: Listagem de Notícias
 * Description: Página independente de notícias; não requer Página de posts.
 */
get_header();
$page_number = max( 1, absint( get_query_var( 'paged' ) ), absint( get_query_var( 'page' ) ) );
$news_args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 15,
    'paged' => $page_number,
    'orderby' => 'date',
    'order' => 'DESC',
    'ignore_sticky_posts' => true,
);
// Polylang filters WP_Query by current language automatically when active.
$news_query = new WP_Query( $news_args );
?>
<main id="main-content" class="site-main news-archive">
<?php
?>
<header class="page-hero unified-inner-hero section-space">
 <div class="container">
  <span class="section-kicker"><?php esc_html_e( 'Notícias', 'observatorio' ); ?></span>
  <h1><?php echo esc_html( get_the_title( get_queried_object_id() ) ); ?></h1>
  <p class="lead"><?php esc_html_e( 'Acompanhe as novidades e iniciativas do Observatório.', 'observatorio' ); ?></p>
 </div>
</header>
<?php get_template_part( 'template-parts/components/breadcrumbs' );

?>
<section class="container section-space">
<?php if ( $news_query->have_posts() ) : ?>
<div class="news-archive-grid">
<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
<article <?php post_class( 'news-archive-card' ); ?>>
<?php if ( has_post_thumbnail() ) : ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a><?php endif; ?>
<div class="news-archive-card__body">
<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
<a class="card-action-arrow" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ler notícia: %s', 'observatorio' ), get_the_title() ) ); ?>"><span aria-hidden="true">→</span></a>
</div></article>
<?php endwhile; ?>
</div>
<?php if ( $news_query->max_num_pages > 1 ) : ?>
<nav class="archive-pagination mt-5" aria-label="<?php esc_attr_e( 'Paginação', 'observatorio' ); ?>">
<?php
$pagination_base = get_pagenum_link( 999999999 );
echo wp_kses_post( paginate_links( array(
    'base' => str_replace( '999999999', '%#%', esc_url( $pagination_base ) ),
    'format' => '?paged=%#%',
    'current' => $page_number,
    'total' => (int) $news_query->max_num_pages,
    'mid_size' => 2,
    'prev_text' => __( 'Anterior', 'observatorio' ),
    'next_text' => __( 'Próxima', 'observatorio' ),
) ) );
?>
</nav>
<?php endif; ?>
<?php else : ?>
<p><?php esc_html_e( 'Nenhuma notícia encontrada.', 'observatorio' ); ?></p>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
</section></main>
<?php get_footer();
