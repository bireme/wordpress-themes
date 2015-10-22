<?php get_header(); ?>

<div class='content intern'>
    <div class='container'>
        
        <?php if(have_posts()): while(have_posts()): the_post(); ?>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='title'>
                        <h2><?php the_title(); ?></h2>
                    </div>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-12'>
                    <div class='content'><?php the_content(); ?></div>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>

<?php get_footer(); ?>