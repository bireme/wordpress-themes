<div class="col-12 col-sm-12 col-md-4 item-post">
    <div class="bg-post">
        <div class="content-item-post">
            <h5 class="title-post"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
            <p class="summary-post"><?php the_excerpt_max_charlength(100); ?></p>
        </div>
        <div class="footer-item-post">
            <a href="<?php the_permalink(); ?>" class="btn btn-icon btn-primary"><i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>