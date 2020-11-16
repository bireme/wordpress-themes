<?php /* Template Name: Page App */ ?>
<?php get_header('app'); ?>
<main class="padding2 " role="main">
	<div class="container" id="main_container">
		<h1><?php the_title(); ?></h1>
		<hr />
		<?php while(have_posts()) : the_post();
			the_content();
		endwhile;
		?>
<hr>
	</div>
</main>
<?php get_footer('app'); ?>