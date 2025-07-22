<div class="col-12 col-sm-6 col-md-6 col-lg-6 item-post">
    <div class="bg-post">
        <div class="content-item-post">
            <?php if(has_post_thumbnail()){ ?>
                <a href="<?php the_permalink(); ?>">
                    <div class="img-post" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);"></div>
                </a>
            <?php } else{ ?>
                <a href="<?php the_permalink(); ?>">
                    <div class="img-post" style="background-image: url(<?php echo get_default_img_url(); ?>);"></div>
                </a>
            <?php } ?>

            <h5 class="title-post"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
            <p class="summary-post"><?php the_excerpt_max_charlength(365); ?></p>
        </div>
        <div class="footer-item-post">
            <a href="<?php the_permalink(); ?>" class="btn btn-icon btn-primary"><i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>