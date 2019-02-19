<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
get_header();
?>
<div class="middle">
	<div class="searchVHL">
		<?php if ( is_active_sidebar( 'search_vhl' . $suffix ) ) : ?>
            <?php dynamic_sidebar(  'search_vhl' . $suffix ); ?>
		<?php endif; ?>
	</div><!--/searchVHL-->


	<div class="slider">
		<?php if ( is_active_sidebar( 'slider' . $suffix ) ) : ?>
			<?php dynamic_sidebar(  'slider' . $suffix ); ?>
		<?php endif; ?>
	</div>
	<div class="browseVHL">
		<div class="collections">
			<?php if ( is_active_sidebar( 'collection' . $suffix ) ) : ?>
				<?php dynamic_sidebar(  'collection' . $suffix ); ?>
			<?php endif; ?>
			
		</div>
		<div class="spacer">&#160;</div>
		<div class="collections_3col">
			<?php if ( is_active_sidebar( 'collection3' . $suffix ) ) : ?>
				<?php dynamic_sidebar(  'collection3' . $suffix ); ?>
			<?php endif; ?>
			
		</div>
		<div class="spacer">&#160;</div>
	</div><!--/browseVHL-->
</div><!--/middle-->
<?php get_footer();?>
