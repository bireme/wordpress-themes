<div class="col-12 col-sm-6 col-md-6 col-lg-3 item-post">
    <div class="bg-post">
        <div class="content-item-post">
            <?php if(get_post_type() == 'podcast' && !empty($banner_podcast_url = get_post_meta(get_the_ID(), 'cover_image', true))){ ?>                
                <a href="<?php the_permalink(); ?>">
                    <div class="img-post" style="background-image: url(<?php echo $banner_podcast_url; ?>);"></div>
                </a>
            <?php
            } else if(has_post_thumbnail()){ ?>
                <a href="<?php the_permalink(); ?>">
                    <div class="img-post" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);"></div>
                </a>
            <?php } else{ ?>
                <a href="<?php the_permalink(); ?>">
                    <div class="img-post" style="background-image: url(<?php echo get_default_img_url(); ?>);"></div>
                </a>
            <?php } ?>
            
            <?php if(get_post_type() == 'course'){ ?>
                <label class="date-post"><?php echo get_date_course(); ?></label>
            <?php } ?>

            <h5 class="title-post"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>            
            <p class="summary-post"><?php the_excerpt_max_charlength(100); ?></p>
            
            <?php if(get_post_type() == 'course'){ 
                $location = get_post_meta(get_the_ID(), 'location', true); ?>
                <label class="location-post"><?php echo $location; ?></label>
            <?php } ?>
        </div>
        <div class="footer-item-post">
            <a href="<?php the_permalink(); ?>" class="btn btn-icon btn-primary"><i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>