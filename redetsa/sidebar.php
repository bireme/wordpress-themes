<?php
/**
 * This is a fallback sidebar
 *
 * @package panoramic
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<?php dynamic_sidebar( 'rss home' ); ?>