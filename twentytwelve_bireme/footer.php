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
<div class="siteInfo">
	<?php 
		echo '<a href="http://wordpress.org" title="WordPress.org">WordPress</a> version ' . get_bloginfo ( 'version' );  
	?>
	 | 
	<?php echo '<a href="https://github.com/bireme/bvs-site-wp-plugin" title="plugin repository">BVS-Site Plugin</a> version ' . BVS_VERSION;  ?>
</div>
</div><!-- .container -->
<?php wp_footer(); ?>
</body>
</html>