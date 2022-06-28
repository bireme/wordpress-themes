<?php
    $site_language = strtolower(get_bloginfo('language'));
    $lang = substr($site_language,0,2);
?>
    <footer id="footer" class="padding2">
        <div class="container">
	    <div class="row">
<!--
                <div class="col-md-6" id="logoFooter">
                    <img src="<?php bloginfo('template_directory'); ?>/img/logo-footer-<?php echo $lang; ?>.svg" alt="">
                    <img src="<?php bloginfo('template_directory'); ?>/img/120-logo-blanco-<?php echo $lang; ?>.png" alt="">
		</div>
-->
                <?php if ( is_active_sidebar( 'footer_1' ) ) : $class = ( is_active_sidebar( 'footer_2' ) ) ? 'col-md-6' : 'col-md-12'; ?>
                    <nav class="<?php echo $class; ?>">
                        <ul class="list-unstyled"><?php dynamic_sidebar('footer_1') ?></ul>
                    </nav>
                <?php endif; ?>
                <?php if ( is_active_sidebar( 'footer_2' ) ) : $class = ( is_active_sidebar( 'footer_1' ) ) ? 'col-md-6' : 'col-md-12'; ?>
                    <nav class="<?php echo $class; ?>">
                        <ul class="list-unstyled"><?php dynamic_sidebar('footer_2') ?></ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </footer>
    <div id="assFooter" class="text-center padding3 d-print-none">
        <div class="container">
            <!-- <img src="https://logos.bireme.org/img/<?php echo $lang; ?>/h_bir_color.svg" alt="BIREME" class="img-fluid imgBlack"><hr /> -->
            <div class="row" id="footerTermos">
                <div class="col-md-12 text-center">
                    <a href="https://politicas.bireme.org/terminos/<?php echo $lang; ?>/" target="_blank"><?php _e('Terms and Conditions of Use', 'best-practices'); ?></a> | <a href="https://politicas.bireme.org/privacidad/<?php echo $lang; ?>/" target="_blank"><?php _e('Privacy Policy', 'best-practices'); ?></a>
                </div>
                <div class="col-md-12 text-secondary text-center">
                    <?php _e('Regional Office for the Americas of the World Health Organization', 'best-practices'); ?>
                    <br />
                    © <?php _e('Pan American Health Organization. All rights reserved.', 'best-practices'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
