<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<section>
	<div class="container">
		<nav aria-label="breadcrumb" class="d-none">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
          </ol>
        </nav>
        <hr>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
	</div>
</section>
<?php get_footer(); ?>