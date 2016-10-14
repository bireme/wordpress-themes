<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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



	<section id="primary" class="site-content">
		<div class="single2column">
          		<?php dynamic_sidebar( $level2 ); ?>
    	</div>
		
		<div id="content" class="single1column" role="main">
		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'twentytwelve' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>

			<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
			<?php endif; ?>
			</header><!-- .archive-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>

				<article <?php post_class($current_post); ?>>
					<?php if (current_theme_supports('post-thumbnails') && has_post_thumbnail()) : ?>
						<div class="entry-image">
							<a href="<?php the_permalink(); ?>" rel="bookmark">
								<?php the_post_thumbnail('thumbnail', array('class' => 'list-img')); ?>
							</a>
						</div>
					<?php endif; ?>


					<div class="r-block">
						<header class="entry-header">
							<div class="entry-meta">
								<time class="published" datetime="<?php echo get_the_time(); ?>"><?php the_time('F j, Y');?> <?php the_time('H:i'); ?></time> | <?php printf( __( 'Post author', 'twentytwelve' )); ?>: <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a>
							</div>
							<strong class="entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark">
				                  <?php the_title(); ?>
				                </a>
							</strong>	
						</header><!-- .entry-header -->
						<div class="entry-summary">
							<p>
								<?php echo get_the_excerpt(); ?>
							</p>
						</div>
					</div>
				</article>
			<?php
			endwhile;

			twentytwelve_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_footer(); ?>
