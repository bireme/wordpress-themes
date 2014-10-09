<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Twelve already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
        <?php if ( is_active_sidebar( 'level2_top' ) ) : ?>
                <div class="additional-top">
                        <?php dynamic_sidebar( 'level2_top' ); ?>
                </div>
        <?php endif; ?>
        <section id="primary" class="site-content">
                <div id="content" role="main">

                <?php if ( have_posts() ) : ?>
                        <header class="archive-header">
                                <h1 class="archive-title"><?php
                                        if ( is_day() ) :
                                                printf( __( 'Daily Archives: %s', 'twentytwelve' ), '<span>' . get_the_date() . '</span>' );
                                        elseif ( is_month() ) :
                                                printf( __( 'Monthly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentytwelve' ) ) . '</span>' );
                                        elseif ( is_year() ) :
                                                printf( __( 'Yearly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentytwelve' ) ) . '</span>' );
                                        else :
                                                $tax = get_taxonomy( get_query_var( 'taxonomy' ) );
                                                $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                                                printf( __( $tax->labels->name.': %s', 'twentytwelve' ), '<span>' . $term->name . '</span>' );
                                        endif;
/*
                                        else :
                                                _e( 'Archives', 'twentytwelve' );
                                        endif;
*/
                                ?></h1>
                        </header><!-- .archive-header -->

                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) : the_post();

                                /* Include the post format-specific template for the content. If you want to
                                 * this in a child theme then include a file called called content-___.php
                                 * (where ___ is the post format) and that will be used instead.
                                 */
                                //get_template_part( 'content', get_post_format() );
                        ?>
                                <header class="entry-header">
                                        <?php the_post_thumbnail('list-thumb'); ?>
                                        <div class="category-post">
                                        <h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                                        <?php the_excerpt(); ?>
                                        </div>
                                </header>
                                <hr />
                        <?php
                        endwhile;

                        twentytwelve_content_nav( 'nav-below' );
                        ?>

                <?php else : ?>
                        <?php get_template_part( 'content', 'none' ); ?>
                <?php endif; ?>

                </div><!-- #content -->
                <?php if ( is_active_sidebar( 'level2' ) ) : ?>
                        <div class="single2column">
                                <?php dynamic_sidebar( 'level2' ); ?>
                        </div>
                <?php endif; ?>
        </section><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
