<?php
/**
 * @package BVS
 * @subpackage Classic_Theme
 */
get_header();
$site_lang = substr($current_language, 0,2);

if ( defined( 'POLYLANG_VERSION' ) ) {
    $default_language = pll_default_language();
    if ( $default_language == $site_lang ) $site_lang = '';
}
echo $category;
?>

<div class="breadcrumb"><a href="<?php bloginfo('url'); ?>/<?php echo ($site_lang);?>/" title="<?php bloginfo('name'); ?>">Home</a> / </div>
<div class="middle">
<div class="meta"><h1><?php echo __("Archives").' - '; ?> <?php the_archive_title(); ?></h1></div>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="article">
    <h2 class="storytitle"><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h2>
    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <div class="storycontent">
            <?php the_excerpt(__('(more...)')); ?>
        </div>
    </div>
</div>

    <?php endwhile; else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>

    <?php posts_nav_link(' &#8212; ', __('&laquo; Newer Posts'), __('Older Posts &raquo;')); ?>

</div>
<?php get_footer(); ?>
