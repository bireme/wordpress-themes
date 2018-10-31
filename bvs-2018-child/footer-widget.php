<?php

if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) {?>
        <div id="footer-widget" class="row m-0 border border-white">

                    <?php if ( is_active_sidebar( 'footer-1' )) : ?>
                        <div class="col-12 col-md-4 p-3 p-md-5 <?php if(!is_theme_preset_active()){ echo 'bg-light'; } ?> border border-white"><?php dynamic_sidebar( 'footer-1' ); ?></div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-2' )) : ?>
                        <div class="col-12 col-md-4 p-3 p-md-5 <?php if(!is_theme_preset_active()){ echo 'bg-light'; } ?> border border-white"><?php dynamic_sidebar( 'footer-2' ); ?></div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-3' )) : ?>
                        <div class="col-12 col-md-4 p-3 p-md-5 <?php if(!is_theme_preset_active()){ echo 'bg-light'; } ?> border border-white"><?php dynamic_sidebar( 'footer-3' ); ?></div>
                    <?php endif; ?>

        </div>

<?php }