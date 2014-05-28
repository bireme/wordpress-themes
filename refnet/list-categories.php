<?php
/**
 Template Name: List of Categories
 */
	load_theme_textdomain('refnet', get_stylesheet_directory() . '/languages');
	get_header(); 
	echo create_bread_crumb(get_the_title());
?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
			<h4><?php the_title(); ?></h4>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php 
					$args = array(
						'show_option_all'    => '',
						'orderby'            => 'name',
						'order'              => 'ASC',
						'style'              => 'list',
						'show_count'         => 1,
						'hide_empty'         => 1,
						'use_desc_for_title' => 1,
						'child_of'           => 0,
						'feed'               => '',
						'feed_type'          => '',
						'feed_image'         => '',
						'exclude'            => '',
						'exclude_tree'       => '',
						'include'            => '',
						'hierarchical'       => 1,
						'title_li'           => '', //__( 'Categories' ),
						'show_option_none'   => '',//__( 'No categories' ),
						'number'             => null,
						'echo'               => 1,
						'depth'              => 0,
						'current_category'   => 0,
						'pad_counts'         => 1,
						'taxonomy'           => 'category',
						'walker'             => null
					); 
				?>
				<div class="widget widget_categories">
					<ul>
					<?php
						echo wp_list_categories($args);
					?>
					</ul>
				</div>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
