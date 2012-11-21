<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
get_header();
$mlf_options = get_option('mlf_config');
//print_r($mlf_options);
$current_language = get_bloginfo('language');
?>
<div class="middle">
	<div class="firstColumn">
		<?php if ( is_active_sidebar( 'vhl_column_1_' . $current_language ) ) : ?>
            <?php dynamic_sidebar(  'vhl_column_1_' . $current_language ); ?>
		<?php endif; ?>
	</div><!--/firstColumn-->
	<div class="secondColumn">
		<?php if ( is_active_sidebar( 'vhl_column_2_' . $current_language ) ) : ?>
            <?php dynamic_sidebar(  'vhl_column_2_' . $current_language ); ?>
		<?php endif; ?>
	</div><!--/secondColumn-->
	<div class="thirdColumn">
		<?php if ( is_active_sidebar( 'vhl_column_3_' . $current_language ) ) : ?>
            <?php dynamic_sidebar(  'vhl_column_3_' . $current_language ); ?>
		<?php endif; ?>
	</div><!--/thirdColumn-->
	<div class="spacer"> </div>
</div><!--/middle-->
<?php get_footer();?>