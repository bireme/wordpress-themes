<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Read, comment and share &ldquo;%s&rdquo;', 'panamazonica'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link( __( 'Edit', 'panamazonica' ), '', '' ) ?></h1>	
	    <div class="entry-date"><?php echo the_time( get_option( 'date_format' ) ); ?></div>
	</header>
    
    <?php if( is_search() ) : ?>
        
        <div class="entry-summary">
        	<?php the_excerpt(); ?>
        </div><!-- /entry-summary -->
    
    <?php else : ?>
    
        <div class="entry-content cf">
        	<?php the_content( sprintf( __( '%s Read more', 'panamazonica' ), '<span aria-hidden="true" data-icon="&#x27a6;">') ); ?>
        	<?php wp_link_pages( 'before=<div class="page-link">' . __( 'Pages:', 'panamazonica' ) . '&after=</div>' ) ?>
        </div><!-- /entry-content -->
    
    <?php endif; ?>
    
    <?php if ( ! is_search() && strpos( $post->post_content, '<!--more-->' ) == false ) : ?>
    
		<footer class="entry-footer">
		
			<?php if (is_single()) : 	        
    	    	echo '<div class="post-categories">';
    	    	echo get_the_category_list( ', ');
    	    	echo '</div>';
    	    
    	    	if( get_the_tag_list() )
    	        	echo get_the_tag_list('<ul class="entry-tags"><li>','</li><li>','</li></ul>');	  
    	    endif; ?>
    	            
    	    <div class="entry-share cf">
    	        <div class="share-facebook"><div id="fb-root"></div><script src="http://connect.facebook.net/pt_BR/all.js#appId=500226443341963&amp;xfbml=1"></script><fb:like href="<?php the_permalink() ?>" send="false" layout="button_count" width="90" show_faces="false" font="lucida grande"></fb:like></div>
    	        <div class="share-twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>
    	        <div class="share-plusone"><g:plusone size="medium" count="true" href="<?php the_permalink(); ?>"></g:plusone><script>window.___gcfg = { lang: 'pt-BR' }; (function() { var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s); })();</script></div>
    	    </div>
    	
    	</footer>	
		
		
     <?php endif; ?>
         
</article><!-- /post-<?php the_ID(); ?> -->
