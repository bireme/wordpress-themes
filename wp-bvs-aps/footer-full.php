<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
<?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
    <?php get_template_part( 'footer-widget' ); ?>
	<footer id="colophon" class="site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
        <div class="container">
            <div class="row align-items-center">

                <div class="site-certificate col-12 col-sm-12 col-md-3">
                    <?php if ( is_active_sidebar( 'certificate_widget_area' ) ) : ?>
                        <?php dynamic_sidebar( 'certificate_widget_area' ); ?>
                    <?php else: ?>
                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/img/certificado.png'; ?>" alt="Site Certificate">
                    <?php endif; ?>
                </div>

                <div class="col-12 col-sm-12 col-md-7 site-support">
                    <a href="https://www.paho.org/bra/" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/img/footer/org-panamericana.png'; ?>" alt="Organização Pan-Americana da Saúde" class="img-fluid"/>
                    </a>

                    <a href="http://www.who.int/eportuguese/countries/bra/pt/" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/img/footer/org-mundial-saude.png'; ?>" alt="Organização Mundial da Saúde" class="img-fluid"/>
                    </a>

                    <a href="http://www.bireme.br/" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/img/footer/bireme.png'; ?>" alt="Bireme" class="img-fluid"/>
                    </a>
                </div>

                <div class="col-12 col-sm-12 col-md-2 text-right site-support">
                    <a href="http://portalms.saude.gov.br/" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/img/footer/ministerio-saude.png'; ?>" alt="Ministério da Saúde" class="img-fluid"/>
                    </a>
                </div>

            </div>

            <?php if ( is_active_sidebar( 'footer_widget_area' ) ) : ?>
            <div class="row">
                <div class="site-info col-12 col-sm-12 col-md-12">                    
                        <?php dynamic_sidebar( 'footer_widget_area' ); ?>                    
                </div><!-- close .site-info -->
            </div>
            <?php endif; ?>
        </div>
    </footer><!-- #colophon -->
<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>