<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main div element.
 *
 * @package Odin
 * @since 2.2.0
 */
?>

		</div><!-- .row -->
	</div><!-- #wrapper -->

	<footer id="footer" role="contentinfo">
		<div class="container">
            <?php dynamic_sidebar( 'footer-sidebar' ); ?>
		</div><!-- .container -->
	</footer><!-- #footer -->

	<?php wp_footer(); ?>
</body>
</html>
