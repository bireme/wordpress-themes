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
		<?php if ( is_active_sidebar( 'slider_' . $current_language ) ) : ?>
			<?php dynamic_sidebar(  'slider_' . $current_language ); ?>
		<?php endif; ?>
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
