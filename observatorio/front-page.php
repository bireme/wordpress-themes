<?php
/**
 * Front page template.
 *
 * @package Observatorio
 */

get_header();
?>

<main id="main-content" class="site-main">
	<?php get_template_part( 'template-parts/home/hero' ); ?>
	<?php get_template_part( 'template-parts/home/publications' ); ?>
	<?php get_template_part( 'template-parts/home/thematic-areas' ); ?>
	<?php get_template_part( 'template-parts/home/thematic-commissions' ); ?>
	<?php get_template_part( 'template-parts/home/news' ); ?>
	<?php get_template_part( 'template-parts/home/events' ); ?>
	<?php get_template_part( 'template-parts/home/preprint' ); ?>
	<?php get_template_part( 'template-parts/home/partners' ); ?>
</main>

<?php
get_footer();
