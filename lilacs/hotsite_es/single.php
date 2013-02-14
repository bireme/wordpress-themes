<?php $myOptions = get_option('myOptions'); ?>
<?php
get_header(); ?>

<div class="content">
	<div class="single">
		<div class="breadCrumb">
			<a href="<?php echo get_option('home'); ?>/">Home</a> / <?php the_title(); ?>
		</div><!--/breadCrumb-->
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><?php the_title(); ?></h2>
				<div class="postContent">
					<?php the_content(); ?>
				</div><!--/postContent-->
			</div><!--/post-->
			<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>
	</div><!--/single-->
	
	<div class="right">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Coluna_3') ) : ?>
		<?php endif; ?>
	</div><!--/right-->
	<div class="spacer"> </div>
</div><!--/content-->
	<?php get_footer(); ?>
