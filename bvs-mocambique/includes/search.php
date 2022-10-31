<section id="sectionSearch" class="padding1">
	<div class="container">

		<form id="formHome" method="get"  action="https://mocambique.teste.eportuguese.org/biblio" >
			<div class="row g-3">
				<div class="col-9 offset-1" style="position:relative;">
					<input type="text" id="fieldSearch" class="form-control" autocomplete="off" placeholder="Buscar" autocomplete="off" name="q" value="<?php echo get_search_query(); ?>">
					<input type="hidden" name="post_type" value="post">
					
					<div id="formText" class="d-none">
						<a href="https://pesquisa.bvsalud.org">Pesquisa via formulário iAH</a> |
						<a href="https://pesquisa.bvsalud.org">Como pesquisar</a>
					</div>
				</div>
				<div class="col-1 float-end">
					<button type="submit" id="submitHome" class="btn btn-primary">
						<i class="fas fa-search"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
</section>