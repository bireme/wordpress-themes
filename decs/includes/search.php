<?php $ths_plugin_slug=''; ?>
<!-- Garante que o valor pequisado passe adiante -->
<?php
	$q = $_GET['q'];
	$filter = $_GET['filter'];
?>

<form action="<?php echo real_site_url($ths_plugin_slug) . 'ths'; ?>">
	<fieldset class="fieldset2">
		<legend><?php pll_e('Search'); ?></legend>
		<div class="row">
			<div class="col-12 col-sm-12 col-md-4 col-lg-4">
				<select name="filter" id="filter" class="form-control">
					<option data-msg="<?php pll_e('Use * or $ for permuted search'); ?>" value="ths_termall" <?php if ($filter == 'ths_termall'){ echo "selected";} ?>><?php pll_e('Any descriptor term'); ?></option>
					<option data-msg="" value="ths_exact_term" <?php if ($filter == 'ths_exact_term'){ echo "selected";} ?>><?php pll_e('Exact descriptor term'); ?></option>
					<option data-msg="" value="ths_regid" <?php if ($filter == 'ths_regid'){ echo "selected";} ?>><?php pll_e('Unique ID'); ?></option>
					<option data-msg="<?php pll_e('Use * or $ for permuted search'); ?>" value="ths_treenumber" <?php if ($filter == 'ths_treenumber'){ echo "selected";} ?>><?php pll_e('Hierarchical Code'); ?></option>
					<option data-msg="<?php pll_e('Use * or $ for permuted search'); ?>" value="ths_qualifall" <?php if ($filter == 'ths_qualifall'){ echo "selected";} ?>><?php pll_e('Any qualifier term'); ?></option>
				</select>
			</div>

			<div class="col-12 col-sm-9 col-md-6 col-lg-7">
				<input type="text" value="<?php if ($q){ echo stripslashes($q); } ?>" name="q" id="fieldSearch" autocomplete="off" class="form-control" placeholder="<?php pll_e('Use * or $ for permuted search'); ?>" required>
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

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript"> 
	$(function(){
		$("#filter").change(function(){
		$("#fieldSearch").attr("placeholder", $(this).find(":selected").data("msg"));
		});
	});
</script> 
