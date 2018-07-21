<?php get_header('full'); ?>

<div id="pesquisa-bvs">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-sm-12">
				
				<?php if ( is_active_sidebar( 'search_frontpage_widget_area' ) ) : ?>
                    <?php dynamic_sidebar( 'search_frontpage_widget_area' ); ?>
                <?php endif; ?>
				<h2 class="slogan-site"><?php bloginfo('description'); ?></h2>

			</div>
		</div>
	</div>
</div>

<div id="fontes-informacao">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="title-section"><?php _e('Fontes de Informação da SES', 'bvs_lang'); ?></h1>
			</div>
		</div>

		<div class="grid-infos">
			<?php
			$args_info_sources = array(
				'posts_per_page' => 7,
				'post_type'  => 'vhl_collection',
				'post_parent' => 0,
				'orderby' => 'menu_order',
				'order'   => 'ASC',
			);
			$info_sources = new WP_Query( $args_info_sources );
			?>

			<?php if ( $info_sources->have_posts() ) : 
				$index = 0;
				while ( $info_sources->have_posts() ) : $info_sources->the_post(); 
					echo ($index == 0 || $index == 3)? '<div class="row info-desktop">' : '';
					?>
					<div class="item-info col-md-<?php echo ($index <= 2)? '3' : '3'; ?>" 
						<?php $the_excerpt = get_the_excerpt();
						echo (!empty($the_excerpt))? 'title="'.$the_excerpt.'" data-toggle="tooltip" data-placement="top"' : ''; ?>>
						
						<?php $url_page = get_post_meta( get_the_ID(), '_links_to', true ); 
						$target = get_post_meta( get_the_ID(), '_links_to_target', true );
						$is_external_url = true;
						if(empty($url_page)){
							$url_page = get_permalink();
							$is_external_url = false;
						}
						?>
						<a href="<?php echo $url_page; ?>" <?php echo ($is_external_url && !empty($target))? 'target="_blank"' : ''; ?>>

						<div class="icon-info">
							<?php $src_img = get_post_meta( get_the_ID(), 'wpcf-icon', true );
							if(empty($src_img)){
								$src_img = get_default_icon_img();
							}
							?>
							<img src="<?php echo $src_img; ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid">
						</div>
						<h2 class="title-info <?php echo (mb_strlen(get_the_title()) > 19)? 'two-lines':'one-line'; ?>">
							<?php the_title(); ?>
						</h2>

						</a>
					</div>
			<?php 
					echo ($index == 2 || $index == 6)? '</div>' : '';
					$index++;
				endwhile; 
				wp_reset_postdata(); ?>

				<div class="row info-mobile">
				<?php while ( $info_sources->have_posts() ) : $info_sources->the_post(); 
					$class = (($info_sources->current_post +1) == ($info_sources->post_count))? 'col-12 col-sm-12':'col-6 col-sm-6';
					?>
				
					<div class="item-info <?php echo $class; ?>" 
						<?php $the_excerpt = get_the_excerpt();
						echo (!empty($the_excerpt))? 'title="'.$the_excerpt.'" data-toggle="tooltip" data-placement="top"' : ''; ?>>
						
						<?php $url_page = get_post_meta( get_the_ID(), '_links_to', true ); 
						$target = get_post_meta( get_the_ID(), '_links_to_target', true );
						$is_external_url = true;
						if(empty($url_page)){
							$url_page = get_permalink();
							$is_external_url = false;
						}
						?>
						<a href="<?php echo $url_page; ?>" <?php echo ($is_external_url && !empty($target))? 'target="_blank"' : ''; ?>>

						<div class="icon-info">
							<?php $src_img = get_post_meta( get_the_ID(), 'wpcf-icon', true );
							if(empty($src_img)){
								$src_img = get_default_icon_img();
							}
							?>
							<img src="<?php echo $src_img; ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid">
						</div>
						<h2 class="title-info <?php echo (mb_strlen(get_the_title()) > 19)? 'two-lines':'one-line'; ?>">
							<?php the_title(); ?>
						</h2>

						</a>
					</div>

				<?php endwhile; ?>
				</div>

				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<div id="eixos-tematicos">
	<div class="container">
		
		<div class="row">
			<div class="col-sm-12">
				<h1 class="title-section"><?php _e('Eixos Temáticos', 'bvs_lang'); ?></h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">

				<?php
				$args_thematic_axis = array(
					'post_type'  => 'eixo-tematico',
					'posts_per_page' => 5,
				);
				$thematic_axis = new WP_Query( $args_thematic_axis );
				
				if ( $thematic_axis->have_posts() ) :
					while ( $thematic_axis->have_posts() ) : $thematic_axis->the_post(); 
						$url = get_post_meta( get_the_ID(), 'wpcf-url', true );
						echo (!empty($url))? '<a href="'.$url.'" target="_blank">' : '';
					?>
				
				<!-- ITEM EIXO -->
				<div class="item-eixo">
					<h2 class="title"><?php the_title(); ?></h2>
					
					<div class="row">
						<div class="col-6 col-sm-6 padding-none">
							<p class="number"><?php echo get_post_meta( get_the_ID(), 'wpcf-numero-1', true ); ?></p>
							<label><?php echo get_post_meta( get_the_ID(), 'wpcf-label-1', true ); ?></label>
						</div>
						<div class="col-6 col-sm-6 padding-none">
							<p class="number"><?php echo get_post_meta( get_the_ID(), 'wpcf-numero-2', true ); ?></p>
							<label><?php echo get_post_meta( get_the_ID(), 'wpcf-label-2', true ); ?></label>
						</div>
					</div>
				</div>
				<!--//ITEM EIXO -->

				<?php 
						echo (!empty($url))? '</a>' : '';
					endwhile; 
					wp_reset_postdata();
				endif; ?>
			</div>
		</div>
	</div>
</div>

<div id="destaques-noticias">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="title-section"><?php _e('Destaques e Notícias', 'bvs_lang'); ?></h1>
			</div>
		</div>

		<div class="row">
			<div class="col-md-7 featured-posts">
				<?php
				$featured_query_args = array(
				  'post_type'  => 'post',
				  'post_status' => 'publish',
				  'meta_key'   => '_is_ns_featured_post',
				  'meta_value' => 'yes',
			  	);
			  	$featured_posts = new WP_Query( $featured_query_args );
				?>
				<div id="posts-carousel" class="carousel slide" data-ride="carousel" data-interval="5000" data-pause="hover">
				  	<div class="carousel-inner">

					<?php if ( $featured_posts->have_posts() ) : 
						$first = true;
						while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
						    
						    <div class="carousel-item <?php echo ($first)? 'active':''; ?>">
								<?php
								if( has_post_thumbnail( get_the_ID() ) ){
				        			$img_bg = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
				        		}
				        		else{
				        			$img_bg = get_default_img();
				        		}
								
								if( get_first_embed_media(get_the_ID()) ){ ?>
								<div class="embed-responsive embed-responsive-16by9">
									<?php echo get_first_embed_media(get_the_ID()); ?>
								</div>
								<?php } else{ ?>
						      	<a href="<?php the_permalink(); ?>">
						      		<div class="img-post" style="background-image: url(<?php echo $img_bg; ?>);"></div>
						      	</a>
						      	<?php } ?>
						      	
						      	<h2 class="title-post">
						      		<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">	<?php crop_text( get_the_title(), 80 ); ?>
						      		</a>
						      	</h2>
						      	<div class="content-preview">
									<?php crop_text( get_the_excerpt(), 130 ); ?>
								</div>
						    </div>
					<?php 
							$first = false;
						endwhile; 
						wp_reset_postdata();
					endif; ?>
				    
				  	</div>
				  	<a class="carousel-control-prev" href="#posts-carousel" role="button" data-slide="prev">
					    <i class="fas fa-chevron-circle-left fa-2x"></i>
					    <span class="sr-only">Previous</span>
				  	</a>
				  	<a class="carousel-control-next" href="#posts-carousel" role="button" data-slide="next">
				    	<i class="fas fa-chevron-circle-right fa-2x"></i>
				    	<span class="sr-only">Next</span>
				  	</a>
				</div>
			</div>
			<div class="col-md-5 secondary-posts">
				<?php
			    $last_posts_args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page'=> 6,
                    'order'=>'DESC',
                    'orderby'=>'date',
                );

			    $last_posts = new WP_Query( $last_posts_args ); 
    			?>
				<div class="row">

					<?php if ( $last_posts->have_posts() ) :
						while ( $last_posts->have_posts() ) : $last_posts->the_post(); ?>
					<div class="col-6 col-sm-6 col-md-4 item-post">

						<?php if( has_post_thumbnail( get_the_ID() ) ){ ?>
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid" />
							</a>
						<?php } else{ ?>
							<a href="<?php the_permalink(); ?>">
								<img src="<?php echo get_default_img(); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid">
							</a>
						<?php } ?>

						<h3 class="title-post">
							<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
								<?php crop_text( get_the_title(), 55 ); ?>
							</a>
						</h3>
						<div class="content-preview">
							<?php crop_text( get_the_excerpt(), 80 ); ?>
						</div>
					</div>
					<?php 
						endwhile; 
						wp_reset_postdata();
					endif; ?>
					
				</div>
			</div>
			<div class="col-md-12 text-right">
				<a href="<?php echo get_post_type_archive_link('post'); ?>" class="btn btn-primary btn-sm">
					<?php _e('Mais notícias', 'bvs_lang'); ?> <i class="fas fa-arrow-right"></i>
				</a>
			</div>
		</div>
	</div>
</div>

<div id="redes">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="title-section"><?php _e('Redes', 'bvs_lang'); ?></h1>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<?php
					if ( has_nav_menu( 'network' ) ) {
					    wp_nav_menu( array( 
					    	'theme_location' => 'network',
					    ) );
					} 
				?>
			</div>
		</div>
	</div>
</div>

<?php get_footer('full'); ?>