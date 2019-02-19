<?php get_header('full');?>

<?php
$featured_query_args = array(
  	'post_type'  => 'aps',
  	'post_status' => 'publish',
  	'tax_query' => array(
		array(
			'taxonomy' => 'highlight',
			'field'    => 'slug',
			'terms'    => 'destaques',
		),
	)
);
$featured_sofs = new WP_Query( $featured_query_args );

if ( $featured_sofs->have_posts() ) : ?>
<section id="carousel-home">
	<div class="container">
		<div id="sofs-carousel" class="carousel slide" data-ride="carousel" data-interval="5000" data-pause="hover">
			<ol class="carousel-indicators">
		    	<?php for($i = 0; $i < $featured_sofs->post_count; $i++){ ?>
				<li data-target="#sofs-carousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0)? 'active' : ''; ?>"></li>
				<?php } ?>
			</ol>
		  <div class="carousel-inner">
		    <?php $first = true;
			while ( $featured_sofs->have_posts() ) : $featured_sofs->the_post(); ?>
						    
	    	<div class="carousel-item <?php echo ($first)? 'active':''; ?>">
		    	<div class="row align-items-center">
		    		<div class="col-md-4">		    			
		      			<?php
						if( has_post_thumbnail( get_the_ID() ) ){
		        			$img_bg = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
		        		}
		        		else{
		        			$img_bg = get_default_img();
		        		}
						?>
				      	<a href="<?php the_permalink(); ?>">
				      		<div class="img-post" style="background-image: url(<?php echo $img_bg; ?>);"></div>
				      	</a>
		    		</div>
		    		<div class="col-md-8">
		    			<label class="post-type"><?php _e('Segunda Opinião Formativa - SOF', 'bvs_lang'); ?></label>
		    			<h1 class="title-post d-none d-sm-none d-md-block">
		    				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	    				</h1>
	    				<h1 class="title-post d-block d-sm-block d-md-none">
		    				<a href="<?php the_permalink(); ?>"><?php crop_text(get_the_title(), 100); ?></a>
	    				</h1>
		    			<label class="area-tematica">
		    				<?php echo get_the_term_list(get_the_ID(), 'categoria-da-evidencia', '', ' | '); ?>
		    			</label>
		    		</div>
		    	</div>
		    </div>

		    <?php 
				$first = false;
			endwhile; 
			wp_reset_postdata(); ?>

		  </div>
		  <a class="carousel-control-prev" href="#sofs-carousel" role="button" data-slide="prev">
		    <span class="fas fa-chevron-circle-left fa-2x"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#sofs-carousel" role="button" data-slide="next">
		    <span class="fas fa-chevron-circle-right fa-2x"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</div>
</section>
<?php endif; ?>

<section id="pesquisa-bvs">
	<div class="container">
		<?php if ( is_active_sidebar( 'search_frontpage_widget_area' ) ) : ?>
		<div class="row justify-content-center">
			<div class="col-md-6">
            	<?php dynamic_sidebar( 'search_frontpage_widget_area' ); ?>
            </div>
		</div>
        <?php endif; ?>        
	</div>
</section>

<?php
$args_atalhos = array(
	'posts_per_page' => 4,
	'post_type'  => 'atalho',
	'orderby' => 'menu_order',
	'order'   => 'ASC',
);
$atalhos = new WP_Query( $args_atalhos );

if ( $atalhos->have_posts() ) : ?>
<section id="areas">
	<div class="container">
		<div class="row">
		<?php while ( $atalhos->have_posts() ) : $atalhos->the_post(); ?>

			<div class="col-md-3">
	    		<a href="<?php echo get_post_meta( get_the_ID(), 'url', true ); ?>">
					<?php if(has_post_thumbnail(get_the_ID())){ ?>
	    			<img class="icon-area" src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'medium' ); ?>" alt="<?php the_title_attribute(); ?>">
	    			<?php } else{ ?>
					<img class="icon-area" src="<?php echo get_default_icon_img(); ?>" alt="<?php the_title_attribute(); ?>">
	    			<?php } ?>

					<h2 class="title-area"><?php the_title(); ?></h2>
				</a>
	    	</div>

		<?php endwhile; ?>
	    </div>
    </div>
</section>
<?php wp_reset_postdata(); 
endif; ?>

<style type="text/css">
	#ultimas-sofs{
		border-top: none;
		padding-top: 70px;	
		padding-bottom: 60px;	
	}
</style>
<?php get_template_part('template-parts/last', 'sofs'); ?>

<section id="video-duvidas">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-8">
				<?php 
				$url_video_home = get_option('url_video_home', '');
				if( !empty($url_video_home) ){
					global $wp_embed;
					echo $wp_embed->run_shortcode('[embed height="470"]'. $url_video_home .'[/embed]');
				}
				?>
			</div>
			<div class="col-md-4">
				<div id="rede-colaboradores">
					<?php if ( is_active_sidebar( 'send-question' ) ) : ?>
                				<?php dynamic_sidebar( 'send-question' ); ?>
            				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="calculadoras-medicas">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( is_active_sidebar( 'calculators' ) ) : ?>
                        		<?php dynamic_sidebar( 'calculators' ); ?>
            			<?php endif; ?>
			</div>
		</div>

		<div class="row">
			<?php
			$args_calculadoras = array(
				'posts_per_page' => 5,
				'post_type'  => 'calculadora',
				'orderby' => 'menu_order',
				'order'   => 'ASC',
			);
			$calculadoras = new WP_Query( $args_calculadoras );
			?>

			<?php if ( $calculadoras->have_posts() ) : 
				while ( $calculadoras->have_posts() ) : $calculadoras->the_post(); 

					get_template_part('template-parts/item', 'calculadora');

				endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>

		<div class="row">
			<div class="col-md-12 text-center">
				<a href="<?php echo get_post_type_archive_link('calculadora'); ?>" class="btn btn-primary btn-sm">
					<?php _e('Veja outras calculadoras', 'bvs_lang'); ?> <span class="fas fa-arrow-right"></span>
				</a>
			</div>
		</div>
	</div>
</section>

<section id="navegar-sofs">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( is_active_sidebar( 'browse-sof' ) ) : ?>
                                        <?php dynamic_sidebar( 'browse-sof' ); ?>
                                <?php endif; ?>
			</div>
		</div>

		<div class="row justify-content-around">
			<div class="col-md-3">
				<div class="block">
				<img class="icon-block" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icons/areas-tematicas.png'; ?>" alt="<?php _e('Quais as Áreas Temáticas', 'bvs_lang'); ?>?">
				<h2 class="title-block"><?php _e('Quais as Áreas Temáticas', 'bvs_lang'); ?>?</h2>

				<?php 
				$limit_list = 5; //this value controls the number of items that appears in the main list

				$terms = get_terms('categoria-da-evidencia', array(
				    'orderby'    => 'count',
				    'order' => 'DESC',
				    'hide_empty' => true
				));

				$list1 = array_slice($terms, 0, $limit_list);
				$list2 = array_slice($terms, $limit_list);

				if ( !empty( $list1 ) && ! is_wp_error( $list1 ) ){
				    echo '<ul class="list-terms">';
				    foreach ( $list1 as $term ) {
				        echo "<li><a href='".get_term_link($term->term_id)."'>$term->name <span>($term->count)</span></a></li>";
				    }

				    if ( !empty( $list2 ) && ! is_wp_error( $list2 ) ){ ?>
					<li><a data-toggle="collapse" href="#more-areas-tematicas" role="button" aria-expanded="false" aria-controls="more-areas-tematicas">
					    ... <?php _e('mais', 'bvs_lang'); ?>
				  	</a></li>
					<?php
				    }

				    echo '</ul>';
				}

				if ( !empty( $list2 ) && ! is_wp_error( $list2 ) ){
				    echo '<ul id="more-areas-tematicas" class="list-terms collapse">';
				    foreach ( $list2 as $term ) {
				        echo "<li><a href='".get_term_link($term->term_id)."'>$term->name <span>($term->count)</span></a></li>";
				    }
				    echo '</ul>';
				}
				?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="block">
				<img class="icon-block" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icons/quem-perguntou.png'; ?>" alt="<?php _e('Quem Perguntou', 'bvs_lang'); ?>?">
				<h2 class="title-block"><?php _e('Quem Perguntou', 'bvs_lang'); ?>?</h2>				

				<?php 
				$terms = get_terms('tipo-de-profissional', array(
				    'orderby'    => 'count',
				    'order' => 'DESC',
				    'hide_empty' => true
				));

				$list1 = array_slice($terms, 0, $limit_list);
				$list2 = array_slice($terms, $limit_list);

				if ( !empty( $list1 ) && ! is_wp_error( $list1 ) ){
				    echo '<ul class="list-terms">';
				    foreach ( $list1 as $term ) {
				        echo "<li><a href='".get_term_link($term->term_id)."'>$term->name <span>($term->count)</span></a></li>";
				    }

				    if ( !empty( $list2 ) && ! is_wp_error( $list2 ) ){ ?>
					<li><a data-toggle="collapse" href="#more-quem-perguntou" role="button" aria-expanded="false" aria-controls="more-quem-perguntou">
					    ... <?php _e('mais', 'bvs_lang'); ?>
				  	</a></li>
					<?php
				    }

				    echo '</ul>';
				}

				if ( !empty( $list2 ) && ! is_wp_error( $list2 ) ){
				    echo '<ul id="more-quem-perguntou" class="list-terms collapse">';
				    foreach ( $list2 as $term ) {
				        echo "<li><a href='".get_term_link($term->term_id)."'>$term->name <span>($term->count)</span></a></li>";
				    }
				    echo '</ul>';
				}
				?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="block">
				<img class="icon-block" src="<?php echo get_stylesheet_directory_uri().'/assets/img/icons/quem-respondeu.png'; ?>" alt="<?php _e('Quem Respondeu', 'bvs_lang'); ?>?">
				<h2 class="title-block"><?php _e('Quem Respondeu', 'bvs_lang'); ?>?</h2>				

				<?php 
				$terms = get_terms('teleconsultor', array(
				    'orderby'    => 'count',
				    'order' => 'DESC',
				    'hide_empty' => true
				));
				
				$list1 = array_slice($terms, 0, $limit_list);
				$list2 = array_slice($terms, $limit_list);

				if ( !empty( $list1 ) && ! is_wp_error( $list1 ) ){
				    echo '<ul class="list-terms">';
				    foreach ( $list1 as $term ) {
				        echo "<li><a href='".get_term_link($term->term_id)."'>$term->name <span>($term->count)</span></a></li>";
				    }

				    if ( !empty( $list2 ) && ! is_wp_error( $list2 ) ){ ?>
					<li><a data-toggle="collapse" href="#more-quem-respondeu" role="button" aria-expanded="false" aria-controls="more-quem-respondeu">
					    ... <?php _e('mais', 'bvs_lang'); ?>
				  	</a></li>
					<?php
				    }

				    echo '</ul>';
				}

				if ( !empty( $list2 ) && ! is_wp_error( $list2 ) ){
				    echo '<ul id="more-quem-respondeu" class="list-terms collapse">';
				    foreach ( $list2 as $term ) {
				        echo "<li><a href='".get_term_link($term->term_id)."'>$term->name <span>($term->count)</span></a></li>";
				    }
				    echo '</ul>';
				}
				?>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="super-recomendadas">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( is_active_sidebar( 'recommendation' ) ) : ?>
                                        <?php dynamic_sidebar( 'recommendation' ); ?>
                                <?php endif; ?>
			</div>
		</div>

		<?php
        wp_nav_menu(array(
        	'theme_location' => 'recommended_links',
        	'container' => 'div',
        	'items_wrap' => '<ul class="row list-menu">%3$s</ul>'
        ));
        ?>
	</div>
</section>

<?php get_footer('full');?>
