<?php
$related_posts = array();

$related_post_1 = get_post_meta( get_the_ID(), 'suggested_footer_post_1', true );
if(!empty($related_post_1)){
    $related_posts[] = $related_post_1;
}

$related_post_2 = get_post_meta( get_the_ID(), 'suggested_footer_post_2', true );
if(!empty($related_post_2)){
    $related_posts[] = $related_post_2;
}

$related_post_3 = get_post_meta( get_the_ID(), 'suggested_footer_post_3', true );
if(!empty($related_post_3)){
    $related_posts[] = $related_post_3;
}

$related_post_4 = get_post_meta( get_the_ID(), 'suggested_footer_post_4', true );
if(!empty($related_post_4)){
    $related_posts[] = $related_post_4;
}

$total_posts = count($related_posts);

if($total_posts > 0){
    $size_column = 12/$total_posts;
?>
<section class="related-posts">
    <h5 class="title-section"><?php _e("Você pode se interessar:", "bvs-ecos"); ?></h5>
    
    <div class="row">
        
        <?php foreach( $related_posts as $post_id ){ ?>            
        <div class="col-12 col-sm-12 col-md-12 col-lg-<?php echo $size_column; ?> item-post">
            <div class="bg-post">
                <div class="content-item-post">
                    <h5 class="title-post"><a href="<?php the_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h5>
                    <p class="summary-post"><?php the_excerpt_max_charlength(100, $post_id); ?></p>
                </div>
                <div class="footer-item-post">
                    <a href="<?php the_permalink($post_id); ?>" class="btn btn-icon btn-primary"><i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>
</section>
<?php } ?>