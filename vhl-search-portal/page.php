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
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="middle">
    <div class="breadcrumb"><a href="<?php bloginfo('url'); ?>/<?php echo ($site_lang);?>/" title="<?php bloginfo('name'); ?>">Home</a> / </div>

    <h2 class="storytitle"><?php the_title(); ?></a></h2>

    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
         

        <div class="storycontent">
            <?php the_content(__('(more...)')); ?>
        </div>
		<div class="childPages">
			<ul>
			  <?php
				 global $id;
				 $post_type = get_post_type( $id );
				 wp_list_pages("post_type=" . $post_type. "&title_li=&child_of=" . $id);
			  ?>
			</ul>
		</div>

    </div>

    <?php endwhile; else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>

    <?php posts_nav_link(' &#8212; ', __('&laquo; Newer Posts'), __('Older Posts &raquo;')); ?>

</div>
<?php get_footer(); ?>
