<?php get_header(); ?>
<main id="main_container" class="padding1">
	<div class="container">
		<?php get_template_part('includes/breadcrumb') ?>
		<div class="row mt-5">
			<div class="col-lg-8 offset-lg-2">
				<h2 class="font-1 mb-5"><img src="<?php bloginfo('template_directory'); ?>/img/icon-logo.svg" id="title-icon" class="title-icon-sm" alt="">News</h2>
				<h1 class="title1 color-1 mb-3"><?php the_title(); ?></h1>
				
				<div class="news-excerpt">
					<?php the_excerpt(); ?>
				</div>
				<div id="news-date">
					<?php echo get_the_date(); ?> | X | X
   				</div>
				<div class="mb-1 text-center">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'full' );
					}
					?>
				</div>
				<div class="news-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>