<?php
get_header();
$show_sidebar = is_singular() && ! is_front_page() && is_active_sidebar( 'level2' );
?>
<div class="vitrines-frame vitrines-layout<?php echo $show_sidebar ? ' vitrines-layout--sidebar' : ''; ?>">
    <main id="primary" class="site-content" tabindex="-1">
        <?php if ( is_search() ) : ?>
            <h1><?php echo esc_html( get_search_query( false ) ); ?></h1>
        <?php elseif ( is_archive() ) : ?>
            <?php the_archive_title( '<h1>', '</h1>' ); ?>
        <?php endif; ?>
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'vitrines-entry' ); ?>>
                    <?php if ( is_singular() ) : ?>
                        <?php the_title( '<h1>', '</h1>' ); ?>
                    <?php else : ?>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php endif; ?>
                    <div class="entry-content">
                        <?php if ( is_singular() ) : ?>
                            <?php the_content(); ?>
                            <?php wp_link_pages(); ?>
                        <?php else : ?>
                            <?php the_excerpt(); ?>
                        <?php endif; ?>
                    </div>
                </article>
                <?php if ( is_singular() && ( comments_open() || get_comments_number() ) ) : ?>
                    <?php comments_template(); ?>
                <?php endif; ?>
            <?php endwhile; ?>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <?php $copy = vitrines_copy(); ?>
            <p><?php echo esc_html( $copy['empty'] ); ?></p>
        <?php endif; ?>
    </main>
    <?php if ( $show_sidebar ) : ?>
        <aside class="vitrines-sidebar single2column"><?php dynamic_sidebar( 'level2' ); ?></aside>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
