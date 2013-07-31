<?php get_header();?>

		<div id="content">
			<div class="c-ajusta">
				<section id="main">
					<h2 class="h2-home">Destaques SAA Informa</h2>
					<article class="m-banners">
						<ul class="ui-tabs-nav">
							<?php query_posts('showposts=3&category_name=Banners');?>
							<?php if (have_posts()): while (have_posts()) : the_post();?>
                            <li class="ui-tabs-nav-item ban-news-home" id="nav-fragment-1">
                                <a href="#fragment-1">
                                    <img src="<?php echo get_settings('home');?>/<?php $key="banner-img"; echo get_post_meta($post->ID,$key,true);?>" width="155" height="110" alt="<?php the_title();?>">
                                </a>
                            </li>
                        	<?php endwhile; else:?>
							<?php endif;?>
                    	</ul>
						<?php query_posts('showposts=3&category_name=Banners');?>
						<?php if (have_posts()): while (have_posts()) : the_post();?>
                        <article id="fragment-1" class="ban-img ui-tabs-panel">
                        <a class="effect" href='<?php the_Permalink()?>'>
                            <img src="<?php echo get_settings('home');?>/<?php $key="banner-img"; echo get_post_meta($post->ID,$key,true);?>" width="510" height="330" alt="<?php the_title();?>" />
                            <span class="ban-img-txt">
                            	<span class="ban-img-txt-categoria">
                            		<?php 
                            			foreach((get_the_category()) as $cat) {
											if (!($cat->cat_name=='Banners')) echo $cat->cat_name . ' ';
										} 
									?>
                            	</span>
                            	<span class="ban-img-txt-titulo"><?php the_title();?></span>                               
                                <?php wp_limit_post(140,' [...]',true);?>
                            </span>
                        </a>
                        </article>
                        <?php endwhile; else:?>
						<?php endif;?>
					</article>

					<article class="m-blocs">
						<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Category Left Block') ) : else : ?>
						<?php endif; ?>
					</article>

					<article class="m-blocs pull-right">
						<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Category Right Block') ) : else : ?>
						<?php endif; ?>	
					</article>

					<article class="m-featured">
						<?php query_posts('showposts=1&category_name=featured&meta_key=position&meta_value=1');?>
						<?php if (have_posts()): while (have_posts()) : the_post();?>
						<a href="<?php the_Permalink()?>">
							<h2 class="h2-home"><?php the_title();?></h2>
							<div class="m-featured-part1">
								<?php if ( has_post_thumbnail() ) {
									the_post_thumbnail('medium', array('class' => 'pull-left img-featured'));
								} ?>
								<!--img src="<?php echo get_settings('home');?>/<?php $key="img"; echo get_post_meta($post->ID,$key,true);?>" alt="<?php the_title();?>"-->
								<?php wp_limit_post(540,' [...]',true);?>
							</div>
						</a>
						<?php endwhile; else:?>
						<?php endif;?>

						<div class="m-featured-part2">
							<?php //query_posts('showposts=2&category_name=featured&meta_key=position&meta_value=2&meta_key=position&meta_value=3');?>
							<?php query_posts(array('showposts' => '2', 'category_name' => 'featured', 'meta_key' => 'position', 'meta_value' => array('2','3')));?>
							<?php if (have_posts()): while (have_posts()) : the_post();?>
								<a href="<?php the_Permalink()?>" class="row-fluid margin-bottom10">
									<div class="m-featured-part2-image">
										<img src="<?php echo get_settings('home');?>/<?php $key="img"; echo get_post_meta($post->ID,$key,true);?>" alt="<?php the_title();?>">
									</div>
									<div class="m-featured-part2-txt">
										<h3 class="h3-home"><?php the_title();?></h3>
									</div>
								</a>
							<?php endwhile; else:?>
							<?php endif;?>
							
							<?php query_posts(array('showposts' => '2', 'category_name' => 'featured', 'meta_key' => 'position', 'meta_value' => array('4','5')));?>
							<?php if (have_posts()): while (have_posts()) : the_post();?>
								<a href="<?php the_Permalink()?>" class="row-fluid margin-top10 margin-bottom10">
									<i class="i-list"></i>
									<?php the_title();?>
								</a>
							<?php endwhile; else:?>
							<?php endif;?>
						</div>
					</article>
				</section>
				<?php get_sidebar();?>
			</div>
		</div>

<?php get_footer();?>