<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
$mlf_options = get_option('mlf_config');
//print_r($mlf_options);
$current_language = get_bloginfo('language');
?>
<div class="footer">
	<div class="footerArea wrapper">
		<?php if ( is_active_sidebar( 'vhl_footer_' . $current_language ) ) : ?>
            <?php dynamic_sidebar(  'vhl_footer_' . $current_language ); ?>
		<?php endif; ?>
	<div class="spacer"> </div>
	</div>
	<div class="spacer"> </div>
</div><!--/footer-->
</div>  <!-- /container -->

<?php wp_footer(); ?>

</body>
</html>
