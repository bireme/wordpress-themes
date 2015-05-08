<?php $layout = $settings['layout']; ?>
<script>
	$ = jQuery;
	$(function(){
		$("#default_columns").change(function(){
			var selected = $(this).find("option:selected").val();

			if(selected == 1) {
				$("#wp_bvs_column2-width-tr, #wp_bvs_column3-width-tr, #wp_bvs_column4-width-tr").hide();
			}

			if(selected == 2) {
				$(".columns-tr").show();
				$("#wp_bvs_column3-width-tr, #wp_bvs_column4-width-tr").hide();
			}

			if(selected == 3) {
				$(".columns-tr").show();
				$("#wp_bvs_column4-width-tr").hide();
			}

			if(selected == 4) {
				$(".columns-tr").show();
			}
		});
	});
</script>

<h3 class="title"><?php echo __('Theme Background', 'vhl'); ?></h3>
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="wp_bvs_tag_class"><?php echo __('Background image', 'vhl'); ?></label></th>
			<td>
				<input id="layout[background]" name="layout[background]" type="text" class="regular-text code layout-background" value="<?php echo esc_html( stripslashes( $layout["background"] ) ); ?>"></br>
			</td>
		</tr>
	</tbody>
</table>

<h3 class="title"><?php echo __('Site Columns', 'vhl'); ?></h3>
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="wp_bvs_columns"><?php echo __('Columns', 'vhl'); ?></label></th>
			<td>
				<select class="columns" id="default_columns" name="layout[total]">
					<option <?php if($layout['total'] == "1") echo "selected='selected'"; ?> value="1">1 <?php echo __('column', 'vhl'); ?></option>
					<option <?php if($layout['total'] == "2") echo "selected='selected'"; ?> value="2">2 <?php echo __('column', 'vhl'); ?></option>
					<option <?php if($layout['total'] == "3") echo "selected='selected'"; ?> value="3">3 <?php echo __('column', 'vhl'); ?></option>
					<option <?php if($layout['total'] == "4") echo "selected='selected'"; ?> value="4">4 <?php echo __('column', 'vhl'); ?></option>
				</select>
			</td>
		</tr>
	</tbody>
</table>

<h3 class="title"><?php echo __('Column Width','vhl'); ?></h3>
<table class="form-table">
	<tbody>
		<tr id="wp_bvs_column1-width-tr" class="columns-tr">
			<th><label for="wp_bvs_column1-width"><?php echo __('Width of column', 'vhl'); ?> 1</label></th>
			<td><input type="text" class="small-text" value="<?php echo esc_html( stripslashes( $layout[1] ) ); ?>" id="wp_bvs_column1-width" name="layout[1]"> px <?php echo __('ou', 'vhl'); ?> %</td>
		</tr>
		<tr id="wp_bvs_column2-width-tr" <?php if($layout['total'] < 2) echo "style='display: none'"; ?> class="columns-tr">
			<th><label for="wp_bvs_column2-width"><?php echo __('Width of column', 'vhl'); ?> 2</label></th>
			<td><input type="text" class="small-text" value="<?php echo esc_html( stripslashes( $layout[2] ) ); ?>" id="wp_bvs_column2-width" name="layout[2]"> px <?php echo __('ou', 'vhl'); ?> %</td>
		</tr>
		<tr id="wp_bvs_column3-width-tr" <?php if($layout['total'] < 3) echo "style='display: none'"; ?> class="columns-tr">
			<th><label for="wp_bvs_column3-width"><?php echo __('Width of column', 'vhl'); ?> 3</label></th>
			<td><input type="text" class="small-text" value="<?php echo esc_html( stripslashes( $layout[3] ) ); ?>" id="wp_bvs_column3-width" name="layout[3]"> px <?php echo __('ou', 'vhl'); ?> %</td>
		</tr>
		<tr id="wp_bvs_column4-width-tr" <?php if($layout['total'] < 4) echo "style='display: none'"; ?> class="columns-tr">
			<th><label for="wp_bvs_column4-width"><?php echo __('Width of column', 'vhl'); ?> 4</label></th>
			<td><input type="text" class="small-text" value="<?php echo esc_html( stripslashes( $layout[4] ) ); ?>" id="wp_bvs_column4-width" name="layout[4]"> px <?php echo __('ou', 'vhl'); ?> %</td>
		</tr>
	</tbody>
 </table>
<h3 class="title"><?php echo __('Auxiliary SideBars', 'vhl'); ?></h3>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="layout[top-sidebar]"><?php echo __('Header', 'vhl'); ?></label></th>
			<td>
				<input id="layout[top-sidebar]" name="layout[top-sidebar]" type="checkbox" class="" value="true" <?php if($layout['top-sidebar'] == 'true') { echo "checked"; } ?> ></br>
			</td>
		</tr>
		<tr>
			<th><label for="layout[footer-sidebar]"><?php echo __('Footer', 'vhl'); ?></label></th>
			<td>
				<input id="layout[footer-sidebar]" name="layout[footer-sidebar]" type="checkbox" class="" value="true" <?php if($layout['footer-sidebar'] == 'true') { echo "checked"; } ?> ></br>
			</td>
		</tr>
	</tbody>
</table>
