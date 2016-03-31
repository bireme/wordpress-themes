<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<?php dynamic_sidebar( 'aux-top-level2' ); ?>
<?php

    $current_language = strtolower(get_bloginfo('language'));
    $site_lang = substr($current_language, 0,2);

    if ($current_language != ''){
        $current_language = '_' . $current_language;
    }

    $level2 = "level2";

    if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
        $level2 .= $current_language;

?>
	<?php if ( function_exists( 'vhl_breadcrumb' ) ) { vhl_breadcrumb(); } ?>
	<div id="primary" class="site-content">
		<div id="content" class="single1column" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
	</div><!-- #primary -->
	<div class="single-complement">
		<div class="related-content">
			<?php if ( function_exists( "get_yuzo_related_posts" ) ) { get_yuzo_related_posts(); } ?>
		</div>
		<?php dynamic_sidebar( 'single-sidebar' ); ?>
		<div class="spacer"></div>
	</div>
<?php get_footer(); ?>
