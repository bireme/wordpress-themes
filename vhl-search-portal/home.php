<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
get_header();
?>
<div class="middle">
	<div class="searchVHL">
		<?php if ( is_active_sidebar( 'search_vhl_' . $current_language ) ) : ?>
            <?php dynamic_sidebar(  'search_vhl_' . $current_language ); ?>
		<?php endif; ?>
	</div><!--/searchVHL-->
	<div class="slider">
		<div class="sliderInner">
			<?php
			    $recentPosts = new WP_Query();
			    $recentPosts->query('showposts=3');
			?>
			<?php while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
			<div class="sliderItem">
				<div class="sliderImg">
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"> <?php the_post_thumbnail('thumbnail'); ?> </a>
				</div>
				<div class="sliderCaption">
					<strong><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></strong>
					<?php the_excerpt(); ?>
					<a href="<?php the_permalink() ?>" class="readmorelink">Read More</a>
				</div>
			</div>
			<?php endwhile; ?>
		</ul>

		
	</div>
	<div class="browseVHL">
		<div class="collections">
			<?php if ( is_active_sidebar( 'collection_' . $current_language ) ) : ?>
				<?php dynamic_sidebar(  'collection_' . $current_language ); ?>
			<?php endif; ?>
			<div class="spacer">&#160;</div>
		</div>
		<div class="spacer">&#160;</div>
		<div class="collections_3col">
			<?php if ( is_active_sidebar( 'collection3_' . $current_language ) ) : ?>
				<?php dynamic_sidebar(  'collection3_' . $current_language ); ?>
			<?php endif; ?>
			<div class="spacer">&#160;</div>
		</div>
		<div class="spacer">&#160;</div>
	</div><!--/browseVHL-->
</div><!--/middle-->
<?php get_footer();?>
