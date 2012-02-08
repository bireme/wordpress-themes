<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
get_header();
?>

<div class="middle">
	<div class="wrapper">
		<div class="firstColumn">
			<div class="post single">
				<div class="breadCrumb"><a href="<?php bloginfo('home'); ?>">Home</a> <span class="active"><?php wp_title(); ?></span></div>
				
				<ul>
				
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li>
						<h3 class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<div class="storycontent">
							<?php the_excerpt(); ?>
						</div>
					</li>
					<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
					<?php endif; ?>
				</ul>
				
				
				
				
				
				
			</div>
		</div><!--/firstColumn-->
		
		<div class="thirdColumn">
			<?php if ( is_active_sidebar( 'vhl_column_3_' . $current_language ) ) : ?>
				<?php dynamic_sidebar(  'vhl_column_3_' . $current_language ); ?>
			<?php endif; ?>
			<div class="spacer"> </div>
		</div><!--/thirdColumn-->
		<div class="spacer"> </div>
	</div>
</div>
<?php get_footer(); ?>
