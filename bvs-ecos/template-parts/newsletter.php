<?php 
$lang = get_current_language(); 
$type_btn_newsletter = get_option($lang . '_type_btn_newsletter');
$content_newsletter = get_option($lang . '_section_newsletter_shortcode_link');

if(!empty($content_newsletter)){
?>
<section id="section-newsletter" class="py-5 text-center">
    <div class="container">
        <h3 class="title-section">
            <?php 
                $newsletter_title = get_option( $lang .'_section_newsletter_title'); 
                echo esc_html($newsletter_title);
            ?>
        </h3>

        <?php if($type_btn_newsletter == 'shortcode'){ ?>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-sub-newsletter">
                <?php _e("Inscreva-se", "bvs-ecos"); ?>
            </button>
        <?php } else{ ?>
            <a href="<?php echo esc_attr($content_newsletter); ?>" class="btn btn-primary">
                <?php _e("Inscreva-se", "bvs-ecos"); ?>
            </a>
        <?php } ?>
    </div>
</section>

<?php if($type_btn_newsletter == 'shortcode'){ ?>
<!-- Modal Newsletter -->
<div class="modal fade" id="modal-sub-newsletter" tabindex="-1" aria-labelledby="modal-sub-newsletter-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-sub-newsletter-label"><?php _e("Boletim da Rede Ecos", "bvs-ecos"); ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">            
            <?php 
                if(!empty($content_newsletter)){
                    echo do_shortcode($content_newsletter); 
                }
            ?>
            </div>
        </div>
    </div>
</div>
<?php } 
} ?>