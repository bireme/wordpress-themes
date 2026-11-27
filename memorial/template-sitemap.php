<?php
/**
 * Template Name: Mapa do site / Sitemap
 * Template Post Type: page
 */

defined('ABSPATH') || exit;

$sitemap_assets = array(
    'css/sitemap-orientation.css' => 'style',
    'js/sitemap-filter.js' => 'script',
);
foreach ($sitemap_assets as $asset => $type) {
    $url = get_template_directory_uri() . '/' . $asset;
    $version = filemtime(get_template_directory() . '/' . $asset);
    if ($type === 'style') {
        wp_enqueue_style('memorial-sitemap-orientation', $url, array('style'), $version);
    } else {
        wp_enqueue_script('memorial-sitemap-filter', $url, array(), $version, true);
    }
}
require_once get_template_directory() . '/includes/sitemap-orientation.php';

get_header('interno');
?>
<main id="main_container" class="container mb-5">
    <?php while (have_posts()) : the_post(); ?>
        <?php if (post_password_required()) : ?>
            <h1 class="title mt-4"><?php echo esc_html(get_the_title()); ?></h1>
            <?php echo get_the_password_form(); ?>
            <?php continue; ?>
        <?php endif; ?>
        <nav class="breadcrumb mt-3" aria-label="<?php echo esc_attr(memorial_sitemap_text('breadcrumb')); ?>">
            <a href="<?php echo esc_url(memorial_sitemap_home_url()); ?>"><?php echo esc_html(memorial_sitemap_text('home')); ?></a>
            <span aria-hidden="true">&nbsp;&gt;&nbsp;</span>
            <span aria-current="page"><?php echo esc_html(get_the_title()); ?></span>
        </nav>
        <h1 class="title mt-4 mb-3" id="memorial-sitemap-title"><?php echo esc_html(get_the_title()); ?></h1>
        <?php $sitemap_tree = memorial_sitemap_tree(); ?>
        <section class="sitemap-intro" aria-labelledby="sitemap-intro-title">
            <h2 id="sitemap-intro-title"><?php echo esc_html(memorial_sitemap_copy('intro')); ?></h2>
            <p><?php echo esc_html(memorial_sitemap_copy('guidance')); ?></p>
            <div class="sitemap-filter" hidden>
                <label class="sr-only" for="sitemap-query"><?php echo esc_html(memorial_sitemap_copy('search')); ?></label>
                <div class="sitemap-filter__controls">
                    <?php memorial_sitemap_icon('search'); ?>
                    <input id="sitemap-query" type="search" autocomplete="off" placeholder="<?php echo esc_attr(memorial_sitemap_copy('placeholder')); ?>" aria-controls="sitemap-navigation" />
                    <button type="button" id="sitemap-clear" hidden aria-label="<?php echo esc_attr(memorial_sitemap_copy('clear')); ?>">
                        <?php memorial_sitemap_icon('close'); ?>
                    </button>
                </div>
            </div>
        </section>
        <div class="sitemap-layout">
            <section class="sitemap-primary">
                <h2 id="sitemap-navigation-title"><?php echo esc_html(memorial_sitemap_copy('navigation')); ?></h2>
                <p id="sitemap-status" role="status" aria-atomic="true"
                    data-empty="<?php echo esc_attr(memorial_sitemap_copy('empty')); ?>"
                    data-found="<?php echo esc_attr(memorial_sitemap_copy('found')); ?>"></p>
                <nav id="sitemap-navigation" aria-labelledby="memorial-sitemap-title">
                    <?php memorial_sitemap_render($sitemap_tree, true); ?>
                </nav>
            </section>
            <?php memorial_sitemap_support($sitemap_tree); ?>
        </div>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
