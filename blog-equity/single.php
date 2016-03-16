<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<?php

    $current_language = strtolower(get_bloginfo('language'));

if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
        $top .= $current_language;

if (is_plugin_active('polylang/polylang.php')) {
        $site_lang = pll_current_language();
        $current_language = $site_lang;
}


    $level2 = "level2";

    if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
        $level2 .= $current_language;

?>

<?php

	//Set default variables related to current language when multi-language-framework is not installed
	$top_bar = "top_sidebar";
	$footer_bar = "footer_sidebar";

	if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
        	$top_bar .= $current_language;
        	$footer_bar .= $current_language;
	}

	if ($top_sidebar == true){
?>
	<div class="top_sidebar">
		<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
		<?php dynamic_sidebar( $top_bar ); ?>
	</div>	
<?php	
	}
?>


	<div id="primary" class="site-content">
		<div class="single2column">
              		<?php dynamic_sidebar( $level2 ); ?>
        	</div>
		<div id="content" class="single1column" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php 
	if ($footer_sidebar == true){
	?>
	<div class="footer_sidebar">
		<?php dynamic_sidebar( $footer_bar ); ?>
		<?php wp_nav_menu(array('theme_location' => 'bottom')); ?>
	</div>	
	<div class="spacer"></div>	
	<?php	
	}
?>
<?php get_footer(); ?>
