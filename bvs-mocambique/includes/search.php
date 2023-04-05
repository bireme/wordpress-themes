<section id="sectionSearch" class="padding1">
	<div class="container">
		<form id="formHome" method="get"  action="https://pesquisa.teste.bvsalud.org/mocambique" >
			<div class="row g-3">
				<div class="col-9 offset-1 form-text" style="position:relative;">Promovendo o acesso livre à informação em saúde</div>
				<div class="col-9 offset-1" style="position:relative;">
					<input type="hidden" name="lang" value="pt">
					<input type="hidden" name="home_text" value="BVS Moçambique">
					<input type="hidden" name="filter[collection_mocambique][]" value="RSDM" id="search-filter">
					<label for="fieldSearch" style="display: none;">Pesquisa</label>
					<input type="text" id="fieldSearch" class="form-control" autocomplete="off" placeholder="Buscar" autocomplete="off" name="q" value="">
					<div id="formText" class="">
						<span>Buscar em:</span>
						<input type="radio" name="engine" checked="checked" value="op1" id="search-op1"> <label for="search-op1">Base Moçambique</label>
						
						<input type="radio" name="engine" value="op2" id="search-op2"> <label for="search-op2">Todas as bases</label>
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