<?php get_header();?>
<?php get_template_part('includes/nav'); ?>
<?php $site_language = strtolower(get_bloginfo('language')); ?>
<?php $lang = substr($site_language,0,2); ?>
<?php $ofsearch = ( $_GET['ofsearch'] ) ? sanitize_text_field($_GET['ofsearch']) : ''; ?>
<?php $ofcategory = ( is_category() ) ? get_queried_object()->slug : ''; ?>
<?php $is_cat = true; ?>
<main id="main_container" class="padding1">
	<div class="container">
		<?php if ( empty($ofcategory) ) : ?>
			<h1 class="title1"><?php pll_e("All Categories"); ?></h1>
		<?php else : ?>
			<h1 class="title1"><?php single_cat_title(); ?></h1>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-9">
				<?php

				$posts = new WP_Query([
			        'post_type'      => 'post',
			        's'              => $ofsearch,
			        'category_name'  => $ofcategory,
			        'posts_per_page' => '-1'
			    ]);
				
    			if ($posts->have_posts()): while ($posts->have_posts()) : $posts->the_post(); ?>
					<?php $thumb = has_post_thumbnail();  ?>
					<article class="row">
						<div class="col-md-2 <?php echo $thumb == "" ? "d-none" : ""; ?>">
							<?php the_post_thumbnail('thumbnail',['class' => 'img-fluid']);?>
						</div>
						<div class="col-md-<?php echo $thumb == ""? "12" : "10"; ?>">
							<a href="<?php permalink_link(); ?>">
								<b><?php the_title(); ?></b> <br>
								<small><?php the_excerpt(); ?></small>
							</a>
						</div>
						<hr>
					</article>
				<?php endwhile; else : ?>
					<div class="container">  
						<div class="alert alert-secondary alert-dismissible text-center fade show" role="alert">
					    	<strong><?php pll_e("No results found"); ?></strong>
					  	</div>
					</div>
				<?php endif;?>
			</div>
			<div class="col-md-3">
				<div class="card text-dark bg-light widgets-category">
					<div class="card-header"><?php pll_e("Filters"); ?></div>

					<?php
				      get_template_part(
				        'searchform',
				        null,
				        array(
				          'is_cat' => $is_cat,
				          'lang'       => $lang,
				          'ofsearch'   => $ofsearch,
				          'ofcategory' => $ofcategory
				        )
				      );
				    ?>
					
					<?php dynamic_sidebar('sidebar-1'); ?>
				</div>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>