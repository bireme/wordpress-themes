<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	<?php if ( is_active_sidebar( 'sidebar-10' ) ) : ?>
		<div id="searchBox" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-10' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-11' ) ) : ?>
		<div id="secondary2" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-11' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>
	<div class="spacer"></div>