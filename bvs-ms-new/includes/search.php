<section id="sectionSearch" class="padding2">
	<div class="container">
		<div class="col-md-12">
			<form id="formHome" method="get" action="<?php bloginfo('home'); ?>" >
				<div class="form-row">
					<div class="col-10 col-lg-10 offset-lg-1 text-right">
						<input type="text" id="fieldSearch" class="form-control" autocomplete="off" name="s" value="<?php echo get_search_query(); ?>">
						<input type="hidden" name="pt" value="">
						<a id="speakBtn" href="#"><i class="fas fa-microphone-alt"></i></a>
						<div class="text-left">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="opcao1" checked>
								<label class="form-check-label" for="inlineRadio1"><small>No Portal</small></label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="opcao2">
								<label class="form-check-label" for="inlineRadio2"><small>Na BVS</small></label>
							</div>
						</div>
					</div>
					<div class="col-1 float-right">
						<button type="submit" id="submitHome" class="btn btn-primary">
							<i class="fas fa-search"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>