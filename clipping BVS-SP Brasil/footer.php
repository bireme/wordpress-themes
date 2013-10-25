<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	
		<div id="siteFooter">
			<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-5' ); ?>
			<?php endif; ?>
		</div>
	
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>