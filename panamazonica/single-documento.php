<?php get_header(); ?>

<div class="content">
	<?php
	if ( have_posts() ) :

		while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
				<header class="entry-header">
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('More on &ldquo;%s&rdquo;', 'panamazonica'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link( __( 'Edit', 'panamazonica' ), '', '' ) ?></h1>	
				</header>
			    
			    
		        <div class="entry-content cf">
			        
			        <div class="post-type-meta">
				        <ul class="<?php echo $post->post_type; ?>-meta meta-list">
				        
				        	<ul class="<?php echo $post->post_type; ?>-meta meta-list">
				        	<?php				        	
				        	
				        	$metas = Documentos::$custom_meta_fields;
				        	
				        	if ( $metas )
				        	{
				        		$output = '';
				        		
				        		// Os labels / títulos do meta
				        		$before_label = '<span><strong>';
				        		$after_label = '</strong></span>';
				        		
					        	foreach ( $metas as $meta )
					        	{
						        	
						        	if ( $meta_value = get_post_meta( $post->ID, $meta['id'], true ) )
						        	{
						        	
							        	$output .= '<li class="' . $meta['id'] . '">';
							        	
							        	switch ( $meta['id'] )
							        	{
							        		case '_pan_link' :
							        			$output .= '<a href="' . $meta_value . '" title="' . __( 'Download File', 'panamazonica' ) . '">' . __( 'Download File', 'panamazonica' ) . '</a>';
							        		break;
							        		
							        		case '_pan_idioma' :
							        			$output .= $before_label . $meta['label'] . $after_label . ': ';
							        			switch ( $meta_value )
									        	{
										        	case 'en' : 
										        		$meta_value = 'Inglês';
										        	break;
										        	
										        	case 'pt' : 
										        		$meta_value = 'Português';
										        	break;
										        	
										        	case 'es' : 
										        		$meta_value = 'Espanhol';
										        	break;
									        	}
									        	$output .= $meta_value;
							        		break;
							        	
							        		default:
							        			$output .= $before_label . $meta['label'] . $after_label . ': ';
							        			$output .= $meta_value;
							        		break;
							        	}
							        	
							        	$output .= '</li>';
						        	}
						        		
						        }	
						        
						        echo $output;
				        	}
				        	
				        	?>
					        
				        </ul><!-- /meta-list -->
			        </div><!-- /post-type-meta -->
			    
		        	<?php the_content( sprintf( __( '%s Read more', 'panamazonica' ), '<span aria-hidden="true" data-icon="&#x27a6;">') ); ?>
		        	<?php wp_link_pages( 'before=<div class="page-link">' . __( 'Pages:', 'panamazonica' ) . '&after=</div>' ) ?>
		        </div><!-- /entry-content -->
			    
				<footer class="entry-footer">
		    	            
		    	    <div class="entry-share cf">
		    	        <div class="share-facebook"><div id="fb-root"></div><script src="http://connect.facebook.net/pt_BR/all.js#appId=500226443341963&amp;xfbml=1"></script><fb:like href="<?php the_permalink() ?>" send="false" layout="button_count" width="90" show_faces="false" font="lucida grande"></fb:like></div>
		    	        <div class="share-twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>
		    	        <div class="share-plusone"><g:plusone size="medium" count="true" href="<?php the_permalink(); ?>"></g:plusone><script>window.___gcfg = { lang: 'pt-BR' }; (function() { var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s); })();</script></div>
		    	    </div>
		    	
		    	</footer>	
			         
			</article><!-- /post-<?php the_ID(); ?> -->
			
		<?php
		endwhile;
		
	endif;
	?>
</div><!-- /content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>