<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
get_header();
$mlf_options = get_option('mlf_config');
//print_r($mlf_options);
$current_language = get_bloginfo('language');
?>
<div class="middle home">
	<div class="wrapper">
		<div class="firstColumn">
		<!--div class="highlights">
			<div class="slider">
				<ul>
					<?php query_posts( 'post_type=any&meta_key=highlight&meta_value=1' ); ?>
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<li>
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('large_highlight'); ?>
						</a>
					</li>
					<?php endwhile; endif; ?>
					<?php wp_reset_query();?>
				</ul>
			</div>
			<div class="spacer"> </div>
		</div-->	
			<?php if ( is_active_sidebar( 'vhl_column_1_' . $current_language ) ) : ?>
	            <?php dynamic_sidebar(  'vhl_column_1_' . $current_language ); ?>
			<?php endif; ?>
			<div class="spacer"> </div>
		</div><!--/firstColumn-->
		<div class="thirdColumn">
			<div class="highlights">
			<div class="slider">
				<ul>
					<?php query_posts( 'post_type=any&meta_key=highlight&meta_value=1' ); ?>
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<li>
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('sidebar_highlight'); ?>
						</a>
					</li>
					<?php endwhile; endif; ?>
					<?php wp_reset_query();?>
				</ul>
			</div>
			<div class="spacer"> </div>
		</div>
			<?php if ( is_active_sidebar( 'vhl_column_3_' . $current_language ) ) : ?>
	            <?php dynamic_sidebar(  'vhl_column_3_' . $current_language ); ?>
			<?php endif; ?>
			<div class="spacer"> </div>
		</div><!--/thirdColumn-->
		<div class="spacer"> </div>
	</div>
</div><!--/middle-->
	<div class="spacer"> </div>
<!--div class="cases">
	<div class="wrapper">
		<?php if ( is_active_sidebar( 'vhl_cases_' . $current_language ) ) : ?>
            <?php dynamic_sidebar(  'vhl_cases_' . $current_language ); ?>
		<?php endif; ?>
		<div class="spacer"> </div>
	</div>
</div-->
<?php get_footer();?>
