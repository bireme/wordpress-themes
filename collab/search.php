<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
	<?php
                //Set default variables related to current language when multi-language-framework is not installed
                $top_bar = "top_sidebar";
                $footer_bar = "footer_sidebar";
                $column1 = "column-1";
                $column3 = "column-3";
		$level2 = "level2";

                if(is_plugin_active('multi-language-framework/multi-language-framework.php')) {
                        $top_bar .= $current_language;
                        $footer_bar .= $current_language;
                        $column1 .= $current_language;
                        $column3 .= $current_language;
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
		<div class="c1">
                        <?php dynamic_sidebar( $level2 ); ?>
                </div>
		<div id="content" class="single1column" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>



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
            endwhile; ?>
    			<?php if(function_exists('wp_paginate')) { 
                    wp_paginate(); }
                else {
                    twentytwelve_content_nav( 'nav-below' );
                }
            ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>

		</div><!-- #content -->
		
        
	</section><!-- #primary -->
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
<?php get_sidebar(); ?>
<?php get_footer(); ?>
