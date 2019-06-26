<!-- Formário de Busca -->
<div class="container" id="boxSearch">
	<div id="search">
		<form method="get" action="http://pesquisa.teste.bvsalud.org/medlist/">
			<input type="hidden" name="lang" value="<?php echo pll_current_language();?>"/>
			<input type="hidden" name="where" value="MEDICINES"/>

			<a href="#" class="icon_close"><i class="icon-cancel-fine"></i></a>
			<input type="text" class="inputSearch" name="q" placeholder="<?php echo pll_e('Entre com sua pesquisa'); ?>">

			<button type="submit" class="submit">
				<i class="fas fa-search" style="color: #fff;"></i> <span class="textBtn">&nbsp; <?php echo pll_e('Buscar'); ?></span>
			</button>
		</form>
	</div>
</div>