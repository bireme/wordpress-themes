<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
$mlf_options = get_option('mlf_config');
$current_language = strtolower(get_bloginfo('language'));
$suffix = ( !defined( 'POLYLANG_VERSION' ) ) ? '_' . $current_language : '';
?>
<div class="footer">
	<div class="footerArea">
		<?php if ( is_active_sidebar( 'vhl_footer' . $suffix ) ) : ?>
            <?php dynamic_sidebar(  'vhl_footer' . $suffix ); ?>
		<?php endif; ?>
		<div class="spacer"></div>
	</div><!--/footer-->
</div>
<div class="InstitutionalInfo">
	<div class="InstitutionalInfoInner">
		<?php if ( is_active_sidebar( 'institutions' . $suffix ) ) : ?>
			<?php dynamic_sidebar(  'institutions' . $suffix ); ?>
		<?php endif; ?>
	</div>
</div>
</div>  <!-- /container -->

<?php wp_footer(); ?>

</body>
</html>
