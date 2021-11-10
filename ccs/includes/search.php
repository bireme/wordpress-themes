<section id="sectionSearch" class="padding2">
	<div class="container">
		<div class="col-md-12">
			<form id="formHome" method="get"  action="https://pesquisa.bvsalud.org/cacs" >
				<div class="row g-3">
					<div class="col-9 offset-1" style="position:relative;">
						<input type="text" id="fieldSearch" class="form-control" autocomplete="off" placeholder="Buscar" autocomplete="off" name="q" value="<?php echo get_search_query(); ?>">
						<input type="hidden" name="post_type" value="post">
						<a id="speakBtn" href="#"><i class="fas fa-microphone-alt"></i></a>
					</div>
					<div class="col-1 float-end">
						<button type="submit" id="submitHome" class="btn btn-primary">
							<i class="fas fa-search"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>