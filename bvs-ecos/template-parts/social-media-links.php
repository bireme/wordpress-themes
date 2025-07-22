<div class="social-icons">
    <?php if ( $linkedin_url = get_option('linkedin_url') ) : ?>
        <a target="_blank" href="<?php echo esc_url($linkedin_url); ?>">
            <i class="fa-brands fa-linkedin-in"></i>
        </a>
    <?php endif; ?>

    <?php if ( $twitter_url = get_option('twitter_url') ) : ?>
        <a target="_blank" href="<?php echo esc_url($twitter_url); ?>">
            <i class="fa-brands fa-x-twitter"></i>
        </a>
    <?php endif; ?>

    <?php if ( $facebook_url = get_option('facebook_url') ) : ?>
        <a target="_blank" href="<?php echo esc_url($facebook_url); ?>">
            <i class="fa-brands fa-facebook-f"></i>
        </a>
    <?php endif; ?>

    <?php if ( $instagram_url = get_option('instagram_url') ) : ?>
        <a target="_blank" href="<?php echo esc_url($instagram_url); ?>">
            <i class="fa-brands fa-instagram"></i>
        </a>
    <?php endif; ?>

    <?php if ( $threads_url = get_option('threads_url') ) : ?>
        <a target="_blank" href="<?php echo esc_url($threads_url); ?>">
            <i class="fa-brands fa-threads"></i>
        </a>
    <?php endif; ?>
</div>