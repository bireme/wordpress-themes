<?php

require_once("structure.php");

global $default_settings;
$load_gif = get_template_directory_uri() . "/bireme_archives/default/load.gif";

$settings = get_option( "wp_bvs_theme_settings");
if ( empty( $settings ) || ! isset( $settings['colors'] ) ) {
        $settings = $default_settings;
}

//print"<pre>";print_r($settings);

// pegando todas as paletas
$palette_dir = TEMPLATEPATH . "/bireme_archives/color_palette/";
$palettes = array();

foreach(glob($palette_dir . "*.php") as $item) {
	$item = str_replace($palette_dir, "", $item);
	$item = str_replace(".php", "", $item);

	$palettes[] = $item;
}

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

                $('#colors-palette').change(function() {
			$('#imgLoading1').css({'display': "inline"});
                        $('#submit-palette').val('Y');
			$('form').submit();
                });

		$('#restart-palette').click(function() {
			var palette = $("#colors-palette").val();
			palette = palette.split("_");
			for(var i=0; i<palette.length; i++) {
				palette[i] = palette[i].charAt(0).toUpperCase() + palette[i].substring(1);
			}
			palette = palette.join(' ');
			var dialog=confirm('Reiniciar a paleta ' + palette + ' ?');
			if (dialog) {
				$('#imgLoading2').css({'display': "inline"});
				$('#submit-palette').val('R');
                        	$('form').submit();
			}
                });

	});
</script>


<h2 class="title" id="title-palette" >Escolha uma paleta de cores</h2>
<table class="form-table" id="table-palette">
	<tr>
		<?php $field = "background"; ?>
		<th><label>Paletas disponíveis: </label> </th>
		<td>
			<select name="colors[palette]" id="colors-palette">
				<!--option value=""></option-->
				<?php foreach($palettes as $item) {
					$str = str_replace("_", " ", $item);
					$str = ucwords($str);
				?>
					<option value="<?php echo $item; ?>" <?php selected( $item, $settings['colors']['palette'] ); ?>><?php echo $str; ?></option>
				<?php } ?>
			</select>
			<span id="imgLoading1"><img src="<?php echo $load_gif; ?>"/></span>
                        <input type="hidden" id="submit-palette" name="submit-palette" value="N" />
                        <?php if($settings['colors']['palette'] != "bireme_default") { ?>
                                <span><input type="button" id="restart-palette" value="Reiniciar Paleta" style="margin-left: 50px" class="button-primary"></span>
                        <?php } ?>
                        <span id="imgLoading2"><img src="<?php echo $load_gif; ?>"/></span>
		</td>
	</tr>
</table>

<!--p class="submit" style="clear: both;" id="submit-palette">
	<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
	<input type="hidden" name="wp_bvs-settings-submit" value="Y" />
</p>

<h2 class="title">ou defina cores para seu BVS Site</h2-->

<table class="form-table">
	<tbody>
		<?php
		$currentblock = "";
		foreach($settings['colors'] as $key => $item): ?>

			<?php if($item == "bireme_default") $disabled = "disabled"; ?>
                        <?php if($key == "palette") continue; ?>

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
					<input class="colorfield" id="wp_bvs_color_<?php  echo $field; ?>" name="colors[<?php echo $field; ?>]" type="text" value="<?php echo esc_html( stripslashes( $item ) ); ?>" <?php  echo $disabled; ?>>
					<div class="colorbox" style="background-color: #<?php  echo $item; ?>"></div>
				</td>
			</tr>


		<?php endforeach ?>
	</tbody>
</table>
