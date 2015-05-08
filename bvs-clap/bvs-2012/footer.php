<?php
/**
 * The template for displaying the footer.
 *
 */
	$settings = get_option( "wp_bvs_theme_settings" );
	$current_language = strtolower(get_bloginfo('language'));

	if ($current_language != ''){
		$current_language = '_' . $current_language;
	}

        $bottom = "footer";

        if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
                $bottom .= $current_language;

?>
<div class="footer">
	<?php dynamic_sidebar( $bottom ); ?>
	<div class="spacer"></div>
</div>
<div class="siteInfo">
	<ul>
		<li><?php echo '<a href="http://wordpress.org" title="WordPress.org">WordPress</a> version ' . get_bloginfo ( 'version' ); ?></li>
		<li><?php echo '<a href="https://github.com/bireme/bvs-site-wp-plugin" title="plugin repository">BVS-Site Plugin</a> version ' . BVS_VERSION;  ?></li>
	</ul>
</div>
</div><!-- .container -->
<?php wp_footer(); ?>
</body>
</html>
