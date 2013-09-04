<?php get_header();?>
	<div id="content" class="row-fluid">
		<div class="ajusta2">
			<?php if (have_posts()): while (have_posts()) : the_post();?>
				<header class="row-fluid">
					<h1 class="h1-header"><?php the_title();?></h1>
				</header>
				
				<div class="ajusta4">
					<div class="row-fluid margintop15">
						<?php the_content();?>
					</div>
				</div>
			<?php endwhile; else:?>
			<?php endif;?> 
		</div>
	</div>
<?php get_footer();?>