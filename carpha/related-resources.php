<?php
/**
 * Template Name: Related Resources
 */

global $post;
$lang = '';

if (is_plugin_active('polylang/polylang.php')) {
    $defLang = pll_default_language();
    $curLang = pll_current_language();
    if ($defLang != $curLang) { $lang = $curLang; }
}

// get all the child categories of "Related resources" category
$category = get_category_by_slug($post->post_name);
$args = array(
    'type'         => 'post',
    'child_of'     => $category->term_id,
    'orderby'      => 'name',
    'order'        => 'ASC',
    'hide_empty'   => FALSE,
    'hierarchical' => 1,
    'taxonomy'     => 'category',
); 
$child_categories = get_categories($args);

get_header(); ?>

    <?php
        $breadcrumb = '<div class="breadcrumb"><a href="' . esc_url( home_url( "/".( $lang )."/" ) ) . '" class="home">Home</a> > ' . $category->name . '</div>';
        echo $breadcrumb;
    ?>
    <div id="primary" class="site-content">
        <div id="content" role="main" <?php post_class('related-resources'); ?>>

            <?php
                echo '<h1>'.$category->name.'</h1>';

                // loop through the child categories
                foreach ($child_categories as $child) {
                    // setup the category ID
                    $cat_id= $child->term_id;
                    // make a header for the cateogry
                    echo "<div>";
                    echo "<h2>".$child->name."</h2>";
                    // create a custom wordpress query
                    query_posts("cat=$cat_id");
                    // start the wordpress loop
                    if (have_posts()) : while (have_posts()) : the_post(); ?>
 
                        <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
 
                    <?php endwhile; endif; // done our wordpress loop ?>
                    <?php echo "</div>"; ?>
                <?php } // done the foreach statement ?>

        </div><!-- #content -->
    </div><!-- #primary -->

<?php get_footer(); ?>
