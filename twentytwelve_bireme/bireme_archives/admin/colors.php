<?php

require_once("structure.php");

global $default_settings;

$colors = $settings['colors'];

//print"<pre>";print_r($settings);

// pegando todas as paletas
$pallete_dir = TEMPLATEPATH . "/bireme_archives/color_pallete/";
$palletes = array();

foreach(glob($pallete_dir . "*.php") as $item) {
	$item = str_replace($pallete_dir, "", $item);
	$item = str_replace(".php", "", $item);
	
	$palletes[] = $item;
}

$colors = $settings["colors"];

?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/bireme_archives/admin/colorpicker/css/colorpicker.css" type="text/css" />
<script src="<?php bloginfo('stylesheet_directory') ?>/bireme_archives/admin/colorpicker/js/colorpicker.js" language="javascript"></script>

<style type="text/css">
		.colorbox{
			width: 20px;
			height: 20px;
			float: left;
			border: 1px solid #666;
			margin: 1px 5px 0 0;
		}
		
		.td-title {
			font-size: 150%;
		}
	</style>

<script language="javascript">
	$ = jQuery;
	$(document).ready(function() {
		
		$('.colorfield').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).ColorPickerHide();
				
				var colorbox = $(el).next('.colorbox');
				colorbox.css('background', "#"+hex);
				
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
		})
		.bind('keyup', function(){
			$(this).ColorPickerSetColor(this.value);
		});
		
		
		
	});
</script>

<h2 class="title" id="title-pallete" >Escolha uma paleta de cores</h2>
<table class="form-table" id="table-pallete">		
	<tr>
		<?php $field = "background"; ?>
		<th><label>Paletas disponíveis: </label> </th>
		<td>
			<select name="colors[pallete]">
				<option value=""></option>
				<?php foreach($palletes as $item): ?>
					<option value="<?php echo $item; ?>"><?php echo $item; ?></option>
				<?php endforeach ?>
			</select>
		</td>
	</tr> 
</table>

<p class="submit" style="clear: both;" id="submit-pallete">
	<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
	<input type="hidden" name="wp_bvs-settings-submit" value="Y" />
</p>

<h2 class="title">ou defina cores para seu BVS Site</h2>
<table class="form-table">
	<tbody>
		<?php 
		$currentblock = ""; 
		foreach($default_settings['colors'] as $key => $item): ?>
		
			<?php
				$field = $key;
				$key_strip = explode("-", $key);
				
				if($key_strip[0] != $currentblock) {
					$currentblock = $key_strip[0];

					print "<tr><th colspan=2 class='td-title'>$color_dict[$currentblock]:</th></tr>";
				}
			?>
			
			<tr>
				<th><label><?php echo $color_dict[$key]; ?>:</label></th>
				<td>
					<input class="colorfield" id="wp_bvs_color_<?php  echo $field; ?>" name="colors[<?php echo $field; ?>]" type="text" value="<?php echo esc_html( stripslashes( $colors[$field] ) ); ?>">
					<div class="colorbox" style="background-color: #<?php  echo $colors[$field]; ?>"></div>
				</td>
			</tr>
		
		
		<?php endforeach ?>
	</tbody>
</table>
