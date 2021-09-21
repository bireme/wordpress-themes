<?php
	$site_language = strtolower(get_bloginfo('language'));
	$lang = substr($site_language,0,2);
	$bp_config = get_option('bp_config');
	$action = get_bloginfo('home');

	if ($bp_config) {
		$action = real_site_url($bp_config['plugin_slug']);
	}
?>
<section id="sectionSearch" class="padding2 d-print-none">
	<div class="container">
		<div class="col-md-12">
			<form id="formHome" method="get" action="<?php echo $action; ?>" >
				<div class="row g-3">
					<div class="col-9 offset-1 text-right">
						<input type="text" id="fieldSearch" class="form-control" autocomplete="off" name="q" value="" placeholder="<?php _e('Enter one or more words', 'bp'); ?>">
						<input type="hidden" name="lang" value="<?php echo $lang; ?>">
						<input type="hidden" name="home_url" value="<?php echo get_bloginfo('home'); ?>">
						<input type="hidden" name="home_text" value="<?php echo get_bloginfo('name'); ?>">
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
