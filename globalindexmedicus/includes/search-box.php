<!-- Buscador -->
<?php $idioma = pll_current_language();	?>
<section id="busca">
	<div class="container">
		<form action="https://pesquisa.teste.bvsalud.org/gim/?output=site&lang=<?php echo $idioma; ?>&from=0&sort=&format=summary&count=20&fb=&page=1&index=tw&q=" id="formBusca" method="get" >
			<input type="hidden" name="lang" value="<?php echo $idioma ?>"/>
			<input type="hidden" name="_charset_" value="utf-8"/>
			<div class="row">
				<div class="col-md-6">
					<select class="formSelect" name="index">
						<option value=""><?php pll_e('Todos os Índices'); ?></option>
						<option value="ti"><?php pll_e('Título'); ?></option>
						<option value="au"><?php pll_e('Autor'); ?></option>
						<option value="mh"><?php pll_e('Assunto'); ?></option>
					</select>
					<select class="formSelect" name="filter[db][]">
						<option selected="1" value=""><?php pll_e('Todas as Fontes'); ?></option>
						<option value="" disabled=""><?php pll_e('Índices Regionais'); ?></option>
						<option class="subGroup" value="AIM">&nbsp;&nbsp;&nbsp;&nbsp;AIM (AFRO)</option>
						<option class="subGroup" value="LILACS">&nbsp;&nbsp;&nbsp;&nbsp;LILACS (AMRO/PAHO)</option>
						<option class="subGroup" value="IMEMR">&nbsp;&nbsp;&nbsp;&nbsp;IMEMR (EMRO)</option>
						<option class="subGroup" value="IMSEAR">&nbsp;&nbsp;&nbsp;&nbsp;IMSEAR (SEARO)</option>
						<option class="subGroup" value="WPRIM">&nbsp;&nbsp;&nbsp;&nbsp;WPRIM (WPRO)</option>
					</select>
				</div>
				<div class="col-md-6 text-right d-none d-md-block">
					<a href="http://pesquisa.bvsalud.org/ghl/decs-locator/?lang=pt"><?php pll_e('Pesquisa via descritores'); ?></a>
				</div>
				<div class="col-md-12">
					<input type="text" name="q" class="" id="buscaInput" placeholder="<?php pll_e('Digite o que você procura'); ?>">
					<input type="submit"  id="buscaSubmit" class="btn btn-primary" value="<?php pll_e('Pesquisar'); ?>">
				</div>
				<div class="col-md-6 text-right d-sm-block d-md-none">
					<a href="https://pesquisa.teste.bvsalud.org/gim/decs-locator/?lang=<?php echo $idioma; ?>">Pesquisa via descritores DeCS/MeSH</a>
				</div>
			</div>
		</form>
	</div>
</section>