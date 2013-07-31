<?php get_header();?>

		<div id="content">
			<div class="c-ajusta">
				<section id="main">
					<?php if (have_posts()): while (have_posts()) : the_post();?>
						<span class="s-recents-h3">
						<?php
							//exclude these from displaying
							$exclude = array("featured" , "Banners" , "destaques");

							// Set initial counter to limit display of only one category
							$g = 0;

							//set up an empty categorystring
							$catagorystring = '';

							//loop through the categories for this post
							foreach((get_the_category()) as $category)
							{
								//if not in the exclude array
								if (!in_array($category->cat_name, $exclude) && $g < 2)
								{
									//add category with link to categorystring
									$catagorystring .= '<a href="'.get_bloginfo(url).'/'.'category'.'/'.$category->slug.'">'.$category->name.'</a>, ';

							        // Add to counter after category loop
							        $g++;
								}
							}

							//strip off last comma (and space) and display
							echo substr($catagorystring, 0, strrpos($catagorystring, ','));
						?>
						</span>
						<h1 class="h2-home"><?php the_title();?></h1>
						<span class="s-recents-data"><?php the_time('d/m/Y');?> - <?php the_time('G\hi'); ?></span>

						<div id="single" class="row-fluid margin-top10">
							<?php if ( has_post_thumbnail() ) {
								the_post_thumbnail('medium', array('class' => 'pull-left-img img-single'));
							}else{
								echo "<img src='" . get_stylesheet_directory_uri() . "/Imagens/proj_no_photo.png' class='pull-left-img img-single' alt='No Photo'>";
							} ?>

							<?php the_content();?>

							<div class="comentarios row-fluid">
								<?php comments_template(); ?>
							</div>
						</div>

					<?php endwhile; else:?>
					<?php endif;?> 
				</section>
				
				<?php get_sidebar();?>
			</div>
		</div>

<?php get_footer();?>
