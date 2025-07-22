<a href="<?php the_permalink(); ?>" class="item-schedule">
    <h4><?php echo get_the_title(); ?></h4>

    <?php $label = get_date_and_location_course(); ?>
    <label><?php echo $label; ?></label>
</a>