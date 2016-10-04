<?php
/**
 * Template Name: Newsletter
 */

get_header(); ?>

<?php
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        //'order' => 'ASC',
        //'orderby' => 'meta_value',
        //'meta_key'  => 'edition',
        'meta_query' => array(
            array(
                'key' => 'level',
                'value' => 1,
                //'compare' => 'LIKE'
            )
        )
    );
    $p_query = new WP_Query( $args );
    //echo "<pre>"; print_r($p_query); echo "</pre>";

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        //'order' => 'ASC',
        //'orderby' => 'meta_value',
        //'meta_key'  => 'edition',
        'meta_query' => array(
            array(
                'key' => 'level',
                'value' => 2,
                //'compare' => 'LIKE'
            )
        )
    );
    $s_query = new WP_Query( $args );
    //echo "<pre>"; print_r($s_query); echo "</pre>";

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        //'order' => 'ASC',
        //'orderby' => 'meta_value',
        //'meta_key'  => 'edition',
        'meta_query' => array(
            array(
                'key' => 'level',
                'value' => 3,
                //'compare' => 'LIKE'
            )
        )
    );
    $t_query = new WP_Query( $args );
?>
    <div class="middle">
        <?php if ( $p_query->have_posts() ) : ?>
        <div class="flexslider">
            <ul class="slides">
            <?php while( $p_query->have_posts()) : $p_query->the_post(); ?>
                <?php $meta = get_field( 'slider_image' ); ?>
                <?php if ( $meta ) : ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $meta; ?>" alt="<?php echo sanitize_title( get_the_title() ); ?>" />
                        <p class="flex-caption">
                            <?php the_title(); ?>
                            <?php if ( has_excerpt() ) : ?>
                            <span class="excerpt">
                                <?php echo get_the_excerpt(); ?>
                            </span>
                            <?php endif; ?>
                        </p>
                    </a>
                </li>
                <?php endif; ?>
            <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if ( $s_query->have_posts() ) : ?>
        <div class="news_secundary"><h2 class="title"><?php _e( 'See also', 'odin' ); ?></h2>
            <?php while( $s_query->have_posts()) : $s_query->the_post(); ?>
            <div id="secundary">
                <a href="<?php the_permalink(); ?>"><h3 class="title"><?php the_title(); ?></h3></a>
                <div id="summary">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <img src="<?php the_post_thumbnail_url(); ?>" class="post-image" alt="<?php echo sanitize_title( get_the_title() ); ?>" />
                    <?php endif; ?>
                    <?php //the_post_thumbnail('thumbnail'); ?>
                    <?php echo mb_strimwidth( wp_strip_all_tags( get_the_excerpt() ), 0, 500, "..." ); ?>
                    <a class="read_more" href="<?php the_permalink(); ?>"><?php echo __( 'read more', 'odin' ); ?></a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
        <?php if ( $t_query->have_posts() ) : ?>
        <div class="news_tertiary">
            <?php while( $t_query->have_posts()) : $t_query->the_post(); ?>
            <div id="tertiary">
                <a href="<?php the_permalink(); ?>"><h3 class="title"><?php the_title(); ?></h3></a>
                <div id="summary">
                    <?php echo mb_strimwidth( wp_strip_all_tags( get_the_excerpt() ), 0, 300, "..." ); ?>
                    <a class="read_more" href="<?php the_permalink(); ?>"><?php echo __( 'read more', 'odin' ); ?></a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
<?php
get_sidebar();
get_footer();