<?php $ths_plugin_slug=''; ?>
<section id="busca">
	<div class="container" id="">
		<div class="headerSearch" >
			<form action="<?php echo real_site_url($ths_plugin_slug) . 'ths'; ?>">
				<div class="row">
					<div class="col-md-4 col-lg-3 selectBoxSearch">
						<select name="filter" id="filter" class="formSelect">
							<option value="ths_termall"><?php pll_e('All Descriptor Terms'); ?></option>
							<option value="ths_preferredterm"><?php pll_e('Main Heading (Descriptor) Terms'); ?></option>
							<option value="ths_regid"><?php pll_e('Unique ID'); ?></option>
							<option value="ths_conceptui"><?php pll_e('Concept ID'); ?></option>
							<option value="ths_decs_code"><?php pll_e('Thesaurus ID'); ?></option>
							<option value="ths_treenumber"><?php pll_e('Tree number ID'); ?></option>
							<option value="ths_qualifall"><?php pll_e('All Qualifier Terms'); ?></option>
						</select>
					</div>
					<div class="col-md-6 col-lg-8 inputBoxSearch">
						<input type="text" name="q" placeholder="<?php pll_e('Search'); ?>" id="fieldSearch" autocomplete="off" >
						<a id="speakBtn" href="#"><i class="fas fa-microphone-alt"></i></a>
					</div>
					<div class="col-md-2 col-lg-1 btnBoxSearch">

						<button type="submit">
							<i class="fas fa-search"></i>
							<span class="textBTSearch"> <?php pll_e('Search'); ?></span>
						</button>
					</div>
				</div>
			</div>

			<!-- <div class="col-md-12" id="navConsultaAvancada">
				<a href="consultaAvancada.php">Advanced Search</a>
			</div> -->

		</form>
	</div>
</section>
