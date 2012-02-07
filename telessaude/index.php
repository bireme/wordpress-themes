<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="middle wrapper">
	<div class="post">
	<div class="breadCrumb"><a href="<?php bloginfo('home'); ?>">Home</a> / <span class="active"><?php the_title(); ?></span></div>
    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
         <h3 class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
        <div class="storycontent">
            <?php the_content(__('(more...)')); ?>
        </div>
        <!--div class="feedback">
            <?php wp_link_pages(); ?>
            <?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
        </div-->
    </div>
	</div>
    <?php endwhile; else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
	<div class="thirdColumn">
		<?php if ( is_active_sidebar( 'vhl_column_3_' . $current_language ) ) : ?>
            <?php dynamic_sidebar(  'vhl_column_3_' . $current_language ); ?>
		<?php endif; ?>
		<div class="spacer"> </div>
	</div><!--/thirdColumn-->
    <?php posts_nav_link(' &#8212; ', __('&laquo; Newer Posts'), __('Older Posts &raquo;')); ?>

	<div class="spacer"> </div>
</div>
<?php get_footer(); ?>
