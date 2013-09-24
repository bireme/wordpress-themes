	<?php
	$blog_id = get_current_blog_id();
	
	// As listas dos grupos temáticos e dos posts da rede só são mostradas nas internas do site principal e nos subsites
	if ( $blog_id > 1 || ! ( is_front_page() || is_home() ) )
	{
		panamazonica_posts_rede();
		panamazonica_grupos_tematicos();
	}
	?>

</section><!-- /main -->
    		
    		<footer class="site-footer cf over">
		    	<div class="site-info">
		    	    <h1 class="site-title">
		    	    	<?php
	    	    		$network_name = esc_attr( get_blog_details(1)->blogname );
	    	    		
	    	    		$site_url = '<a class="url-rede" href="' . network_site_url() . '" title="'. $network_name . '" rel="home">' . $network_name . '</a>';
	    	    		
	    	    		// Sendo um grupo, mostramos o nome da Rede
	    	    		if ( $blog_id > 1 ) {
	    	    			$blogname = esc_attr( get_bloginfo( 'name' ) );
	    	    			$site_url = $site_url . ' / ' . $oi = '<a class="url-grupo" href="' . get_site_url() . '" title="'. $blogname . '" rel="home">' . $blogname . '</a>';
	    	    		}
	    	    		
	    	    		echo $site_url;
	    	    		?>	
		    	    </h1>
		    	    <?php
		    	    // Não havendo menu secundário definido, chamamos o primário também
		    	    $theme_location = ( has_nav_menu( 'secondary' ) ) ? 'secondary' : 'primary';
		    	    echo wp_nav_menu( array( 'theme_location' => $theme_location, 'container' => 'nav', 'container_id' => 'secondary-menu', 'container_class' => 'wp-menu-container', 'menu_class' => 'menu', 'fallback_cb' => false, 'depth' => '1' ) );
		    	    ?>
		    	</div>
		    	
		    	<ul class="menu social">
		    		<?php switch_to_blog(1); ?>
		    		<?php if ( $facebook = get_theme_option( 'facebook' ) ) : ?><li><a href="<?php echo $facebook; ?>" class="facebook icon-alone"><span aria-hidden="true" data-icon="&#xf301;"></span><span class="assistive-text">Facebook</span></a></li><?php endif; ?>
		    	    <?php if ( $twitter = get_theme_option( 'twitter' ) ) : ?><li><a href="<?php echo $twitter; ?>" class="twitter icon-alone"><span aria-hidden="true" data-icon="&#x54;"></span><span class="assistive-text">Twitter</span></a></li><?php endif; ?>
		    	    <li><a href="<?php bloginfo( 'rss2_url' ); ?>" class="rss icon-alone"><span aria-hidden="true" data-icon="&#xf09e;"></span><span class="assistive-text">RSS</span></a></li>
		    	    <?php restore_current_blog(); ?>
		    	</ul>
    		</footer>
    	</div><!-- /site-wrapper -->
    	
    	<div class="colophon">
    		<?php if ( $footer_text = get_theme_option( 'footer_text' ) ) : ?>
    		    <p class="footer-text"><?php echo $footer_text; ?></p>
    		<?php endif; ?>
    	</div>
    
    	<?php wp_footer(); ?>
	</body>
</html>