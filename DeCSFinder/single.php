<?php get_header(); ?>
<div id="highlights" class="header-inter m">
	<div class="container">
		<h1><?php the_title() ?></h1>
	</div>
</div>
<main id="main" class="ptb-50">
	<div class="container">
		<?php the_content(); ?>
	</div>
</main>
<?php get_footer(); ?>