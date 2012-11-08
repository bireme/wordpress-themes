<?php $myOptions = get_option('myOptions'); 
get_header(); ?>

<div class="content">
	<div class="single page">
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
		<div class="news widget_rss widget">
		<?php $my_query = new WP_Query('category_name=news&showposts=1'); ?>
			<?php if($my_query->have_posts()) : ?>
				<h2><?php echo $myOptions['theme_newsTitle'];?></h2>
			<?php endif; ?>
				<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
					<div class="post">
						<div class="postContent">
							 <?php the_content(); ?>
						</div>
					</div>
				<?php endwhile; ?>
				<div class="spacer"></div>
		</div><!--/News -->
		<div class="events widget_rss widget">
		<?php $my_query = new WP_Query('category_name=events&showposts=1'); ?>
			<?php if($my_query->have_posts()) : ?>
				<h2><?php echo $myOptions['theme_eventsTitle'];?></h2>
			<?php endif; ?>
				<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
					<div class="post">
						<div class="postContent">
							 <?php the_content(); ?>
						</div>
					</div>
				<?php endwhile; ?>
				<div class="spacer"></div>
		</div><!--/Eventos -->
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Coluna_3') ) : ?>
		<?php endif; ?>
	</div><!--/right-->
	<div class="spacer"> </div>
</div><!--/content-->
	<?php get_footer(); ?>