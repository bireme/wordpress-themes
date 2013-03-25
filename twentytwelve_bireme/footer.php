<?php
/**
 * The template for displaying the footer.
 *
 */
	$settings = get_option( "wp_bvs_theme_settings" );
?>
<style>
	.footer {
		background: #<?php echo $settings['colors']['footer-background'];?>;
		color: #<?php echo $settings['colors']['footer-text'];?>;		
	}
	.footer a {
		color: #<?php echo $settings['colors']['footer-link-active'];?>;
	}
	.footer a:visited {
		color: #<?php echo $settings['colors']['footer-link-visited'];?>;
	}
</style>
<div class="footer">
	<?php dynamic_sidebar('footer'); ?>	
	<div class="spacer"></div>
</div>
</div><!-- .container -->
<?php wp_footer(); ?>
</body>
</html>