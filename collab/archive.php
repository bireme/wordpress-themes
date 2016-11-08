<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Twelve already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
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
				<h1 class="archive-title"><?php
					if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'twentytwelve' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentytwelve' ) ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentytwelve' ) ) . '</span>' );
					else :
						_e( 'Archives', 'twentytwelve' );
					endif;
				?></h1>
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

<?php get_sidebar(); ?>
<?php get_footer(); ?>
