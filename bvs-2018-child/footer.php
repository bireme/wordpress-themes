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
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #content -->
    <?php get_template_part( 'footer-widget' ); ?>
	<footer id="colophon" class="site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
        <div class="container">
            <div class="row">

                <div class="site-info col-12 col-sm-12 col-md-6">
                    <?php if ( is_active_sidebar( 'footer_widget_area' ) ) : ?>
                        <?php dynamic_sidebar( 'footer_widget_area' ); ?>
                    <?php endif; ?>
                </div><!-- close .site-info -->

                <div class="site-certificate col-12 col-sm-12 col-md-6">
                    <?php if ( is_active_sidebar( 'certificate_widget_area' ) ) : ?>
                        <?php dynamic_sidebar( 'certificate_widget_area' ); ?>
                    <?php else: ?>
                        <img src="<?php echo get_stylesheet_directory_uri().'/assets/img/certificado.png'; ?>" alt="Site Certificate">
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </footer><!-- #colophon -->
<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>