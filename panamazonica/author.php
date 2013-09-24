<?php get_header(); ?>
	
	<div class="content">
	    
	    <?php if ( have_posts() ) the_post(); ?>

	    	<header class="archive-header">
	    		<div class="author-avatar">
	    			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 96 ); ?>
	    		</div><!-- .author-avatar -->
	    		<a href="<?php echo get_author_feed_link( $author ); ?>" title="<?php _e( 'Subscribe to this author', 'panamazonica' )?>" class="icon-alone feed-link"><span aria-hidden="true" data-icon="&#xf09e;"></span><span class="assistive-text"><?php _e( 'Author feed', 'panamazonica' ); ?></span></a>
	    		<h1 class="archive-title vcard">
	    			<a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php esc_attr( get_the_author() ); ?>" rel="me"><?php echo get_the_author() ?></a>
	    		</h1>
	    		<div class="archive-meta author-description">
	    		    <ul class="team-member-extra-info">
	    		    	<?php $team_member_data = get_userdata( $author ); ?>
	    		    	<?php if ( !empty( $team_member_data->user_url ) ) : ?>
	    		    		<li class="team-member-url"><a href="<?php echo $team_member_data->user_url; ?>">Site</a></li>
	    		    	<?php endif; ?>
	    		    	<?php if ( !empty( $team_member_data->lattes ) ) : ?>
	    		    		<li class="team-member-lattes"><a href="<?php echo $team_member_data->user_url; ?>"><?php _e( 'Curriculum Lattes', 'panamazonica' ); ?></a></li>
	    		    	<?php endif; ?>
	    		    	<?php if ( !empty( $team_member_data->phone ) ) : ?>
	    		    		<li class="team-member-phone"><span aria-hidden="true" data-icon="&#x1f4de;"></span> <?php echo $team_member_data->phone; ?></li>
	    		    	<?php endif; ?>
	    		    	<?php if ( !empty( $team_member_data->mobile ) ) : ?>
	    		    		<li class="team-member-mobile"><span aria-hidden="true" data-icon="&#x1f4de;"></span> <?php echo $team_member_data->mobile; ?></li>
	    		    	<?php endif; ?>
	    		    	<?php if ( !empty( $team_member_data->country ) ) : ?>
	    		    		<li class="team-member-country"><?php printf( __( 'Country: %s', 'panamazonica' ), $team_member_data->country ); ?></li>
	    		    	<?php endif; ?>
	    		    	<?php if ( !empty( $team_member_data->institution ) ) : ?>
	    		    		<li class="team-member-institution"><?php printf( __( 'Institution: %s', 'panamazonica' ), $team_member_data->institution ); ?></li>
	    		    	<?php endif; ?><?php if ( !empty( $team_member_data->occupation ) ) : ?>
	    		    		<li class="team-member-occupation"><?php printf( __( 'Occupation: %s', 'panamazonica' ), $team_member_data->occupation ); ?></li>
	    		    	<?php endif; ?>
	    		    	<?php if ( !empty( $team_member_data->activity ) ) : ?>
	    		    		<li class="team-member-activity"><?php printf( __( 'Activity: %s', 'panamazonica' ), $team_member_data->activity ); ?></li>
	    		    	<?php endif; ?>
	    		    	<?php if ( !empty( $team_member_data->themes ) ) : ?>
	    		    		<li class="team-member-themes"><?php printf( __( 'Themes of Interest: %s', 'panamazonica' ), $team_member_data->themes ); ?></li>
	    		    	<?php endif; ?>
	    		    </ul>
	    		    <?php if ( $description = get_the_author_meta( 'description' ) ) : ?>
	    		    	<p><?php echo $description; ?></p>
	    		    <?php endif; ?>
	    		</div><!-- /author-description	-->
	    	</header><!-- /archive-header -->

	    	<?php rewind_posts(); ?>

	    	<?php if ( have_posts() ) : ?>
    
            <?php while ( have_posts() ) : the_post(); ?>
        
            	<?php get_template_part( 'content', get_post_format() ); ?>
        
            <?php endwhile; ?>
        
            <?php panamazonica_content_nav( 'nav-below' ); ?>
        
        <?php else: ?>
        
        	<?php get_template_part( 'content', 'none' ); ?>
        
        <?php endif; ?>
	    
	</div><!-- /content -->
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>