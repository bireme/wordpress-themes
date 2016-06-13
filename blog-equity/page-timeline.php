<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
	<?php

		if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
        		$top .= $current_language;

		if (is_plugin_active('polylang/polylang.php')) {
        		$site_lang = pll_current_language();
        		$current_language = $site_lang;
		}

                //Set default variables related to current language when multi-language-framework is not installed
                $top_bar = "top_sidebar";
                $footer_bar = "footer_sidebar";
                $column1 = "column-1";
                $column3 = "column-3";

                if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
                        $top_bar .= $current_language;
                        $footer_bar .= $current_language;
                        $column1 .= $current_language;
                        $column3 .= $current_language;
                }
                $level2 = "level2";
                if ($top_sidebar == true){
        ?>
	<div class="top_sidebar">
                <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
                <?php dynamic_sidebar( $top_bar ); ?>
        </div>
        <?php
                }
        ?>
	<div id="primary" class="site-content timeline">
		
		<div id="content" class="single1column" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
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
