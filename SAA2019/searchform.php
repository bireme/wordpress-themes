<form id="formHome" method="get" action="<?php bloginfo('home'); ?>" >
	<div class="form-row">
		<div class="col-10 col-lg-7 offset-lg-4 text-right">
			<input type="text" id="fieldSearch" class="form-control" name="s" value="<?php echo get_search_query(); ?>">
			<input type="hidden" name="post_type" value="post">
			<a id="speakBtn" href="#"><i class="fas fa-microphone-alt"></i></a>
		</div>
		<div class="col-1 float-right">
			<button type="submit"   id="submitHome"  class="btn btn-primary">
				<i class="fas fa-search"></i>
			</button>
		</div>
	</div>
</form>