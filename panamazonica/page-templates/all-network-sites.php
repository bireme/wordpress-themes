<?php
/**
 * Template Name: All Network Sites
 *
 * @package WordPress
 * @subpackage Panamazonica
 * @since Panamazonica 0.1
 */

get_header(); the_post(); ?>
	
	<div class="content">
	    			
	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    	<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Read, comment and share &ldquo;%s&rdquo;', 'panamazonica'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link( __( 'Edit', 'panamazonica' ), '', '' ) ?></h1>
	    	<div class="entry-content">
	    	    <?php the_content(); ?>
	    	    <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'panamazonica' ) . '&after=</div>') ?>
	    	</div><!-- /entry-content -->
	    </article><!-- /page-<?php the_ID(); ?> -->
	    
	    <div class="sites-list media-listing">
	    	<?php
	    	if ( $network_sites = wp_get_sites( array( 'sort_column' => 'blogname' ) ) ) :
	    		foreach ( $network_sites as $network_site ) :
		    		// Pula o site principal
		    		if ( $network_site['blog_id'] == 1 )
		    			continue;
		    			
		    		$site = get_blog_details( $network_site['blog_id'] );
		    		$site_description = get_blog_option( $network_site['blog_id'], 'blogdescription' ); 
		    		?>
			    	<div class="network-site media">
			    		<a href="<?php echo $site->siteurl; ?>" title="<?php echo $site->blogname; ?>" class="img">
			    			<?php
			    			switch_to_blog( $network_site['blog_id'] );
			    			
			    			$logo = get_theme_option('logo');

			    			if ( is_int( $logo ) )
			    				echo '<img src="' . wp_get_attachment_thumb_url( $logo ) . '" alt="'. $site->blogname . '" />';
			    			else
			    				echo '<span class="group-name">' . $site->blogname . '</span>';

			    			restore_current_blog(); ?>
			    		</a>
			    		<div class="bd">
			    			<h2 class="network-site-title"><a href="<?php echo $site->siteurl; ?>" title="<?php echo $site->blogname; ?>"><?php echo $site->blogname; ?></a></h2>
			    			<div class="network-site-description"><?php echo $site_description; ?></div>
			    			<a href="<?php echo $site->siteurl; ?>" title="Gestão do conhecimento" class="network-site-url"><?php echo $site->siteurl; ?></a>
			    		</div>
			    	</div>
		    	<?php
		    	endforeach;
	    	endif;
	    	?>
	    </div><!-- /sites-list -->
	
	</div><!-- /content -->		
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>