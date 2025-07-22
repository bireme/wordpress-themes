<div class="col-12 col-sm-6 col-md-6 col-lg-3 item-post item-news">
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

            <label class="date-post"><?php echo get_the_date("d/F/Y"); ?></label>
            <h5 class="title-post"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
            <p class="summary-post"><?php the_excerpt_max_charlength(100); ?></p>

            <?php 				
            $categories = get_the_category();					

            $output = '';
            if ( ! empty( $categories ) ) { ?>
            <label class="categories-post">
            <?php
                foreach( $categories as $category ) {
                    $output .= '<a class="btn taxonomy '. esc_attr($category->slug) .'" href="'. esc_url( get_category_link( $category->term_id ) ) .'">'. esc_html( $category->name ) .'</a>';
                }
                echo trim( $output );
            ?>
            </label>
            <?php } ?>
        </div>
        <div class="footer-item-post">
            <?php if ( shortcode_exists( 'posts_like_dislike' ) ) { ?>
                <div class="reactions-group">
                    <?php echo do_shortcode('[posts_like_dislike id='.get_the_ID().']');?>
                </div>
            <?php } ?>

            <a href="<?php the_permalink(); ?>" class="btn btn-icon btn-primary"><i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>