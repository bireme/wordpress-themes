<section id="search" class="padding1" style="margin-bottom:30px;">
	<div class="container">

		<form id="formHome" method="get" action="https://pesquisa.bvsalud.org/mtci">
			<div class="row g-3">
				<div class="col-10 col-md-8 offset-md-2">
					<input type="hidden" name="pt" value="">
					<input name="home_url" type="hidden" value="https://mtci.teste.bvsalud.org" />
					<input name="hidden" type="hidden" value="BVS MTCI" />
					<label for="fieldSearch" style="display: none;">Pesquisa</label>
					<input type="text" id="fieldSearch" class="form-control" placeholder="Buscar" autocomplete="off" name="s" value="<?php echo get_search_query(); ?>">
					<div id="formText" class="">
						<input type="radio" name="engine" class="form-check-input" checked="checked" value="op1" id="search-op1">
						<label for="search-op1"> Todas as bases de dados</label>
						<input type="radio" name="engine" class="form-check-input" value="op2" id="search-op2">
						<label for="search-op2">Páginas do site</label>
						<div class="float-end"><a href="https://pesquisa.bvsalud.org/mtci/advanced/?lang=pt" class="btn btn-sm btn-outline-primary">Busca Avançada</a></div>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
	(function() {
		$ = jQuery;
		$(".search-submit").click(function () {
			$(this).closest("form").submit();
		});
		$("#search-op1").click(function () {
			$("#search-filter").val('RSDM');
		});
		$("#search-op2").click(function () {
			$("#search-filter").val('');
		});
	})();
</script>
