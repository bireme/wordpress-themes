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
<?php if( !is_front_page() || (isset($_GET['newsletter']) && $_GET['newsletter'] == 'subscribed') ): ?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #content -->
<?php endif; ?>

<?php //get_template_part('footer-widget'); ?>

<footer id="colophon" class="footer site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
	<div class="container">
		<div class="row">
			<!-- Left Column -->
			<div class="col-md-6 site-info">
				<?php 
				$lang = get_current_language(); 
				$footer_title_1 = get_option($lang . '_footer_title_1');
				$footer_title_2 = get_option($lang . '_footer_title_2');
				$footer_subtitle_1 = get_option($lang . '_footer_subtitle_1');
				$footer_subtitle_2 = get_option($lang . '_footer_subtitle_2');
				$footer_description = get_option($lang . '_footer_description');
				?>
				<h5><?php echo esc_html($footer_title_1); ?></h5>
				<h6><?php echo esc_html($footer_subtitle_1); ?></h6>

				<h5><?php echo esc_html($footer_title_2); ?></h5>
				<h6><?php echo esc_html($footer_subtitle_2); ?></h6>

				<?php get_template_part("template-parts/social-media-links"); ?>

				<?php
				if (!empty($footer_description)) {
					$footer_description = stripslashes($footer_description);

					echo wpautop(wp_kses_post($footer_description));
				} ?>
			</div>
			<div class="col-md-6 site-map">
				<?php
				if ( has_nav_menu( 'footer-menu' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer-menu',
							'container' => false,
							'items_wrap' => '%3$s',
							'walker' => new footer_Walker(),
						)
					);
				}
				?>
			</div>
		</div>
	</div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>

</html>