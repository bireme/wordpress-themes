<?php $language = pll_current_language(); ?>
<section id="sectionSearch" class="padding2">
	<div class="container">
		<div class="col-md-12">
			<form id="formHome" method="get" action="<?php bloginfo('home'); ?>" >
				<div class="row g-3">
					<div class="col-9 offset-1 text-right">
						<input type="text" id="fieldSearch" class="form-control" autocomplete="off" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php pll_e('Search'); ?>">
						<input type="hidden" name="post_type" value="post">
						<a id="speakBtn" href="#"><i class="fas fa-microphone-alt"></i></a>
					</div>
					<div class="col-1 float-end">
						<button type="submit" id="submitHome" class="btn btn-warning">
							<i class="fas fa-search"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>