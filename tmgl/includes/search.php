<?php
if (function_exists('have_rows')) {
	if (have_rows('search')) : 
		while (have_rows('search')) : the_row(); 
			$search_title = get_sub_field('title');
			$search_subtitle = get_sub_field('subtitle');
		endwhile;
	endif;
}
?>
<!-- Search -->
<section id="section-search">
	<div class="slider">
		<div>
			<img src="<?php bloginfo('template_directory'); ?>/img/img-search-1.webp" alt="">
		</div>
		<div>
			<img src="<?php bloginfo('template_directory'); ?>/img/img-search-2.webp" alt="">
		</div>
		<div>
			<img src="<?php bloginfo('template_directory'); ?>/img/img-search-3.webp" alt="">
		</div>
		<div>
			<img src="<?php bloginfo('template_directory'); ?>/img/img-search-4.webp" alt="">
		</div>
		<div>
			<img src="<?php bloginfo('template_directory'); ?>/img/img-search-5.webp" alt="">
		</div>
		<div>
			<img src="<?php bloginfo('template_directory'); ?>/img/img-search-6.webp" alt="">
		</div>
	</div>
	<div class="content-overlay">
		
		<div class="container">
			<div id="box-search">
				<div class="title"><?= esc_html($search_title);?></div>
				<p><?= esc_html($search_subtitle);?></p>
			</div>
			<form class="row" action="https://pesquisa.bvsalud.org/tmgl" method="get">
				<div class="col-7">
					<input type="text" class="form-control form-control-lg" id="search" placeholder="Articles, Evidence, Regulations and Policies, Thesis, Events, Multimedia, Digital resources..." name="q">
				</div>
				<div class="col-2">
					<button type="submit" class="btn btn-primary btn-lg mb-3">SEARCH </button>
				</div>
			</form>
			<div id="box-search-links">
				<a href="https://pesquisa.bvsalud.org/tmgl/advanced/?lang=en"><?php _e( 'How to search', 'tmgl' ); ?></a>
				<a href="https://pesquisa.bvsalud.org/tmgl/decs-locator/?lang=en"><?php _e( 'Advanced search', 'tmgl' ); ?></a>
			</div>
		</div>
	</div>
</section>