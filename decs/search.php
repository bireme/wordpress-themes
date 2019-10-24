<?php
/* Template Name: SearchPage*/
?>
<?php get_header(); ?>
<?php get_template_part('includes/nav') ?>
<?php get_template_part('includes/search') ?>
<main id="main_container" class="padding1">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
			</ol>
		</nav>
		<div id="main_container">
			<h3 class="titleMain">Search:</h3>
			<div class="row">
				<div class="col-12">
					<?php while(have_posts()) : the_post();
						the_content();
					endwhile;
					?>
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>