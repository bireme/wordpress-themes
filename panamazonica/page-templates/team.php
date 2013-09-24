<?php
/**
 * Template Name: Team
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
		
		<?php 
			$team = panamazonica_get_team();
			
			if ( $team ) : ?>
			    <div class="team-list media-listing">
			        <?php
			            foreach( $team as $team_member ) :
			            	// Verifica se o username digitado existe
			            	if ( username_exists( $team_member ) ) :
			            	    $team_member_data = get_user_by( 'login', $team_member ); ?>
			            	    
			            	    <div class="media team-member">
			            	    	<div class="img team-member-photo">
			            	    		<?php echo get_avatar( $team_member_data->user_email, 200 ); ?>			            	    		
			            	    	</div>
			            	    	<div class="bd">			            	    		
			            	    		<h3 class="team-member-name"><?php echo $team_member_data->display_name; ?></h3>
			            	    		<?php if ( !empty( $team_member_data->description ) ) : ?>
			            	    			<div class="team-member-description">
			            	    			    <?php echo $team_member_data->description; ?>
			            	    			</div>
			            	    		<?php endif; ?>
			            	    		<ul class="team-member-extra-info">
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
			            	    			<?php endif; ?>
			            	    			<?php if ( !empty( $team_member_data->occupation ) ) : ?>
			            	    				<li class="team-member-occupation"><?php printf( __( 'Occupation: %s', 'panamazonica' ), $team_member_data->occupation ); ?></li>
			            	    			<?php endif; ?>
			            	    			<?php if ( !empty( $team_member_data->activity ) ) : ?>
			            	    				<li class="team-member-activity"><?php printf( __( 'Activity: %s', 'panamazonica' ), $team_member_data->activity ); ?></li>
			            	    			<?php endif; ?>
			            	    			<?php if ( !empty( $team_member_data->themes ) ) : ?>
			            	    				<li class="team-member-themes"><?php printf( __( 'Themes of Interest: %s', 'panamazonica' ), $team_member_data->themes ); ?></li>
			            	    			<?php endif; ?>
			            	    		</ul>			            	    		
			            	    	</div>
			            	    </div><!-- /member -->
			            	<?php 
			            	endif; // username exists
			            endforeach; ?>
			        
			    </div><!-- /team -->
		
		<?php endif; // team exists ?>
			
		<?php comments_template('', true); ?>
			
	</div><!-- /content -->		
		
<?php get_sidebar(); ?>	
<?php get_footer(); ?>