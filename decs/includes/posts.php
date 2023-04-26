<section id="blog" class="padding1">
    <div class="container">
        <h2 class="title1">BLOG</h2>
        <div class="row list-posts">
            <?php 
            $posts = new WP_Query(['post_type' => 'post','posts_per_page' => '4']);
            while($posts->have_posts()) : $posts->the_post(); ?>
                <div class="col-6 blog-box">
                    <a href="<?php permalink_link(); ?>" >
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail('full', ['class' => 'img-fluid ']);
                                } else { ?>
                                    <img src="<?php bloginfo('template_directory'); ?>/img/indisponivel.jpg" alt="x" class="img-fluid">
                                <?php } ?>
                            </div>
                            <div class="col-lg-6">
                                <h4><?php the_title(); ?></h4>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>