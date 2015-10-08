<?php

require_once("structure.php");

global $default_settings;
$load_gif = get_template_directory_uri() . "/default/load.gif";

$settings = get_option( "wp_bvs_theme_settings");
if ( empty( $settings ) || ! isset( $settings['colors'] ) )
    $settings = $default_settings;
else {
    $diff = array_diff_key($default_settings['colors'], $settings['colors']);
    if ($diff)
        $settings['colors'] = array_merge($default_settings['colors'], $settings['colors']);
}

?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/admin/colorpicker/css/colorpicker.css" type="text/css" />
<script src="<?php bloginfo('stylesheet_directory') ?>/admin/colorpicker/js/colorpicker.js" language="javascript"></script>

<style type="text/css">
	.colorbox{
		width: 20px;
		height: 20px;
		float: left;
		border: 1px solid #666;
		margin: 1px 5px 0 0;
	}
	.td-title {
        font-size: 125% !important;
        text-transform: uppercase;
        text-decoration: underline;
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

<table class="form-table">
	<tbody>
		<?php $currentblock = ""; foreach($settings['colors'] as $key => $item): ?>
			<tr>

				<?php 
					$key_strip = explode("-", $key);

					if($key == "palette" or $key == 'check') continue;

					if($key_strip[0] != $currentblock) {
						$currentblock = $key_strip[0];
					} else {
						continue;
					}
				?>

				<?php if(!empty($currentblock)): ?>
					<th colspan='2'><label><input type='checkbox' name='colors[check][]' value='<?= $currentblock; ?>' <?php if(in_array($currentblock, $settings['colors']['check'])) echo 'checked'; ?>> <?= $color_dict[$currentblock]; ?></label></th>
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<p class="submit" style="clear: both;">
	<input type="submit" name="Submit"  class="button-primary" value="<?php echo __('Update'); ?>" onclick="document.getElementById('imgLoading3').style.display='inline'" />
	<input type="hidden" name="wp_bvs-settings-submit" value="Y" />
	<span id="imgLoading3"><img src="<?php echo get_template_directory_uri() . '/default/load.gif' ?>"/></span>
</p>

<table class="form-table">
	<tbody>
		<?php
		foreach($settings['colors'] as $key => $item): ?>


			<?php
			    // if($item == "bireme_default") $disabled = "disabled";
				if($key == "palette") continue;

				$field = $key;
				$key_strip = explode("-", $key);

				if($key_strip[0] != $currentblock) {
					$currentblock = $key_strip[0];

					print "<tr><th colspan=2 class='td-title'>" . $color_dict[$currentblock] . "</th></tr>";
				}
			?>
			<!-- caso nao tenha sido marcado para ser visualizado, não exibe -->
			<?php  if(!in_array($currentblock, $settings['colors']['check'])) continue; ?>

			<tr>
				<th><label><?php echo $color_dict[$key]; ?>:</label></th>
				<td>
					<input class="colorfield" id="wp_bvs_color_<?php echo $field; ?>" name="colors[<?php echo $field; ?>]" type="text" value="<?php echo esc_html( stripslashes( $item ) ); ?>" <?php echo $disabled; ?>>
					<div class="colorbox" style="background-color: #<?php echo $item; ?>"></div>
				</td>
			</tr>


		<?php endforeach ?>
	</tbody>
</table>
