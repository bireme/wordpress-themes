<?php
/**
 * Single content template.
 *
 * @package Observatorio
 */

get_header();
?>

<main id="main-content" class="site-main section-space">
	<?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header mb-4">
					<h1><?php the_title(); ?></h1>
				</header>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
                <?php get_template_part( 'template-parts/components/share-links' ); ?>
                <?php
                $categories = wp_get_post_categories( get_the_ID() );
                $related = $categories ? new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'post__not_in' => array( get_the_ID() ), 'category__in' => $categories, 'ignore_sticky_posts' => true ) ) : null;
                if ( $related && $related->have_posts() ) : ?>
                <section class="related-news-section" aria-labelledby="related-news-heading">
                    <h2 id="related-news-heading"><?php esc_html_e( 'Notícias relacionadas', 'observatorio' ); ?></h2>
                    <div class="news-archive-grid">
                    <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                        <article <?php post_class( 'news-archive-card' ); ?>>
                            <?php if ( has_post_thumbnail() ) : ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a><?php endif; ?>
                            <div class="news-archive-card__body"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p><a class="card-action-arrow" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ler notícia: %s', 'observatorio' ), get_the_title() ) ); ?>">&rarr;</a></div>
                        </article>
                    <?php endwhile; ?>
                    </div>
                </section>
                <?php wp_reset_postdata(); endif; ?>
			</article>
		<?php endwhile; ?>
	</div>
</main>

<?php
get_footer();
