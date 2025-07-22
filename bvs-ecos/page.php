<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

<section id="primary" class="content-area col-sm-12 col-lg-12">
	<div id="main" class="site-main" role="main">

		<?php while (have_posts()) : the_post(); ?>

			<?php if(function_exists('bbp_is_search') && bbp_is_search() && function_exists('bbp_breadcrumb')){
				bbp_breadcrumb();
			}
			else{ ?>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e("Home", "bvs-ecos"); ?></a></li>
					
					<?php if(function_exists('bp_is_group') && bp_is_group() && function_exists('bp_get_groups_directory_permalink')){ ?>
					<li class="breadcrumb-item"><a href="<?php echo bp_get_groups_directory_permalink(); ?>"><?php _e("Grupos Temáticos", "bvs-ecos"); ?></a></li>
					<?php } ?>
					
					<li class="breadcrumb-item active" aria-current="page"><?php echo get_the_title(); ?></li>
				</ol>
			</nav>
		<?php
			}

			$can_have_related_posts = false;
			if( (function_exists('is_page_from_buddypress') && is_page_from_buddypress()) || (function_exists('bbp_is_search') && bbp_is_search()) ){
				get_template_part('template-parts/content', 'buddypress');
			}
			else if(function_exists('bp_is_groups_directory') && bp_is_groups_directory()){
				get_template_part('template-parts/content-buddypress', 'groups');
			}
			else{
				$can_have_related_posts = true;
				get_template_part('template-parts/content', 'page');
			}

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</div><!-- #main -->

	<?php 
	if($can_have_related_posts){
		get_template_part('template-parts/related', 'posts'); 
	} ?>

</section><!-- #primary -->

<?php
get_footer();
