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
	<div class="container">
		<div id="box-search">ssss
			<div class="title"><?= esc_html($search_title);?></div>
			<p><?= esc_html($search_subtitle);?></p>
		</div>
		<form class="row" action="http://pesquisa.bvsalud.org/tmgl" method="get">
			<div class="col-7">
				<input type="text" class="form-control form-control-lg" id="search" placeholder="Articles, Evidence, Regulations and Policies, Thesis, Events, Multimedia, Digital resources..." name="q">
			</div>
			<div class="col-2">
				<button type="submit" class="btn btn-primary btn-lg mb-3">SEARCH </button>
			</div>
		</form>
		<div id="box-search-links">
			<a href="https://pesquisa.bvsalud.org/tmgl/advanced/?lang=en">How to search</a>
			<a href="https://pesquisa.bvsalud.org/tmgl/decs-locator/?lang=en">Advanced search</a>
		</div>
	</div>
</section>