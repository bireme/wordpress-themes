<?php /* Template Name: Archive */

$is_page = false;
$is_vhl = false;
get_header(); ?>


<?php if(have_posts()): while(have_posts()): the_post(); ?>

    <div class='content intern'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='breadcrumb'>
                        <a href="<?php bloginfo('wpurl'); ?>">Home</a> >
                        <a href="<?php the_permalink(); ?>" class='active'><?php the_title(); ?></a> 
                    </div>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-12'>
                    <div class='title'>
                        <h2><?php the_title(); ?></h2>
                    </div>
                </div>
            </div>

            <?php $posts = new WP_Query('post_type=post'); ?>
            <?php while ( $posts->have_posts() ): $posts->the_post(); ?>
                
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='title'>
                            <h3><a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></h3>
                        </div>
                        <div class='except'>
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>
    </div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>