<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

if ( !is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-sm-12 col-lg-3" role="complementary">
	<div class="row">
		<div class="col-md-12 text-right">
			<br>
			<?php get_template_part('template-parts/share', 'button'); ?>
			<br>
		</div>
	</div>

	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
