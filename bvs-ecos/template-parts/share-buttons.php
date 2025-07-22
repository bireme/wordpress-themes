<?php
$share_link = get_the_permalink();
$post_title = get_the_title();
?>
<div class="btn-group">
    <button class="btn btn-share btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <?php _e("Share", "bvs-ecos"); ?> <i class="bi bi-share"></i>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a target="_blank" class="dropdown-item" href="https://www.facebook.com/share.php?u=<?php echo $share_link; ?>">
                <i class="fa-brands fa-facebook fa-lg m-r-5"></i> Facebook
            </a>
        </li>
        <li>
            <a target="_blank" class="dropdown-item" href="http://twitter.com/share?text=<?php echo urlencode($post_title); ?>&url=<?php echo $share_link; ?>">
                <i class="fa-brands fa-x-twitter fa-lg m-r-5"></i> Twitter
            </a>
        </li>
        <li>
            <a target="_blank" class="dropdown-item" href="https://api.whatsapp.com/send?text=<?php echo esc_html($post_title) . ' - ' . urlencode($share_link); ?>">
                <i class="fa-brands fa-whatsapp fa-lg m-r-5"></i> WhatsApp
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="mailto:?body=<?php echo urlencode($share_link); ?>&subject=<?php echo esc_html($post_title); ?>">
                <i class="fa-solid fa-envelope fa-lg m-r-5"></i> Email
            </a>
        </li>
        <li>
            <a target="_blank" class="dropdown-item" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($share_link); ?>">
                <i class="fa-brands fa-linkedin fa-lg m-r-5"></i> Linkedin</a>
        </li>
        <li>
            <a target="_blank" class="dropdown-item" href="tg://msg_url?url=<?php echo urlencode($share_link); ?>">
                <i class="fa-brands fa-telegram fa-lg m-r-5"></i> Telegram
            </a>
        </li>
    </ul>
</div>