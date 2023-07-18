<?php
	$site_language = strtolower(get_bloginfo('language'));
	$lang = substr($site_language,0,2);
?>
<section id="search" class="padding1" style="margin-bottom:30px;">
	<div class="container">
		<form id="formHome" method="get" action="https://pesquisa.bvsalud.org/mtci">
			<div class="row g-3">
				<div class="col-10 col-md-8 offset-md-2">
					<input name="lang" type="hidden" value="<?php echo $lang; ?>">
					<input name="home_url" type="hidden" value="<?php echo home_url('/'); ?>" />
					<input name="home_text" type="hidden" value="<?php echo get_bloginfo('name'); ?>" />
					<label for="fieldSearch" style="display: none;"><?php _e('Search', 'mtci'); ?></label>
					<input type="text" id="fieldSearch" class="form-control" placeholder="Buscar" autocomplete="off" name="q" value="<?php echo get_search_query(); ?>">
					<div id="formText" class="">
						<input type="radio" name="engine" class="form-check-input" checked="checked" value="op1">
						<label for="search-op1"> <?php _e('All databases', 'mtci'); ?></label>
						<input type="radio" name="engine" class="form-check-input" value="op2">
						<label for="search-op2"><?php _e('Site pages', 'mtci'); ?></label>
						<div class="float-end"><a href="https://pesquisa.bvsalud.org/mtci/advanced/?lang=<?php echo $lang; ?>" class="btn btn-sm btn-outline-primary"><?php _e('Advanced search', 'mtci'); ?></a></div>
					</div>
				</div>
				<div class="col-1 float-end">
					<button type="submit" id="submitHome" class="btn btn-primary search-submit">
						<i class="fas fa-search"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
</section>