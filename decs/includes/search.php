<?php $ths_plugin_slug=''; ?>

<section class="container" id="main_container">
	<div class="row padding2">
		<div class="col-12">
			<form action="<?php echo real_site_url($ths_plugin_slug) . 'ths'; ?>">
				<fieldset class="fieldset2">
					<legend><?php pll_e('Search'); ?></legend>
					<div class="row">
						<div class="col-12 col-sm-12 col-md-4 col-lg-4">
							<select name="filter" id="filter" class="formSelect">
								<option value="ths_termall" selected><?php pll_e('Any descriptor term'); ?></option>
								<option value="ths_exact_term" ><?php pll_e('Exact descriptor term'); ?></option>
								<option value="ths_regid"><?php pll_e('Unique ID'); ?></option>
								<option value="ths_treenumber"><?php pll_e('Hierarchical Code'); ?></option>
								<option value="ths_qualifall"><?php pll_e('Any qualifier term'); ?></option>


<!-- 
Qualquer descritor
Descritor exato
ID do registro
Código hierárquico
Qualquer qualificador


Cualquier descriptor
Descriptor exacto
ID de registro
Código jerárquico
Cualquier calificador

Tout descripteur
Descripteur exact
ID d'enregistrement
Code hiérarchique
N'importe quel qualificatif
 -->







							</select>
						</div>
						<div class="col-12 col-sm-9 col-md-6 col-lg-7">
							<!-- <input type="text" name="q" placeholder="<?php pll_e('Search'); ?>" id="fieldSearch" autocomplete="off" class="form-control"> -->

							<!-- <input type="text" name="q" id="fieldSearch" autocomplete="off" class="form-control" required> -->

							<input type="text" value="<?php if ($q){ echo $q; } ?>" name="q" id="fieldSearch" autocomplete="off" class="form-control" required>


							<a id="speakBtn" href="#"><i class="fas fa-microphone-alt"></i></a>
						</div>
						<div class="col-12 col-sm-3 col-md-2 col-lg-1 text-right">
							<button type="submit" class="btn btn-success btn-block">
								<i class="fas fa-search"></i>
							</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</section>
