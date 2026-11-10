<?php
/** Thematic areas archive, using the same visual grid as the news listing. */
get_header();
?>
<main id="main-content" class="site-main thematic-archive">
<?php get_template_part( 'template-parts/components/page-hero', null, array(
 'kicker' => __( 'Observatório', 'observatorio' ),
 'title' => post_type_archive_title( '', false ),
 'description' => __( 'Conheça as áreas temáticas do Observatório.', 'observatorio' ),
) ); ?>

<section class="container section-space">
<?php if ( have_posts() ) : ?>
<div class="news-archive-grid">
<?php while ( have_posts() ) : the_post(); ?>
<article <?php post_class( 'news-archive-card thematic-archive-card' ); ?>>
<?php if ( has_post_thumbnail() ) : ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?></a><?php endif; ?>
<div class="news-archive-card__body">
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<p><?php echo esc_html( wp_trim_words( get_the_excerpt() ?: wp_strip_all_tags( get_the_content() ), 28 ) ); ?></p>
<a class="card-action-arrow" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Acessar área temática: %s', 'observatorio' ), get_the_title() ) ); ?>"><span aria-hidden="true">→</span></a>
</div></article>
<?php endwhile; ?>
</div>
<?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => __( 'Anterior', 'observatorio' ), 'next_text' => __( 'Próxima', 'observatorio' ) ) ); ?>
<?php else : ?><p><?php esc_html_e( 'Nenhuma área temática encontrada.', 'observatorio' ); ?></p><?php endif; ?>
</section></main>
<?php get_footer();
