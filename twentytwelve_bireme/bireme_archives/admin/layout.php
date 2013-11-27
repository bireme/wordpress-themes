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

<h3 class="title">Definir background</h3>
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="wp_bvs_tag_class">Background Image</label></th>
			<td>
				<input id="layout[background]" name="layout[background]" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $layout["background"] ) ); ?>"></br>
			</td>
		</tr>
	</tbody>
</table>

<h3 class="title">Definir Colunas do Site</h3>
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="wp_bvs_columns">Colunas</label></th>
			<td>
				<select class="columns" id="default_columns" name="layout[total]">
					<option <?php if($layout['total'] == "1") echo "selected='selected'"; ?> value="1">1 coluna</option>
					<option <?php if($layout['total'] == "2") echo "selected='selected'"; ?> value="2">2 colunas</option>
					<option <?php if($layout['total'] == "3") echo "selected='selected'"; ?> value="3">3 colunas</option>
					<option <?php if($layout['total'] == "4") echo "selected='selected'"; ?> value="4">4 colunas</option>
				</select>
			</td>
		</tr>
	</tbody>
</table>

<h3 class="title">Definir a largura das colunas</h3>
<table class="form-table">
	<tbody>
		<tr id="wp_bvs_column1-width-tr" class="columns-tr">
			<th><label for="wp_bvs_column1-width">Largura coluna 1</label></th>
			<td><input type="text" class="small-text" value="<?php echo esc_html( stripslashes( $layout[1] ) ); ?>" id="wp_bvs_column1-width" name="layout[1]"> inserir medida em px ou %</td>
		</tr>
		<tr id="wp_bvs_column2-width-tr" <?php if($layout['total'] < 2) echo "style='display: none'"; ?> class="columns-tr">
			<th><label for="wp_bvs_column2-width">Largura coluna 2</label></th>
			<td><input type="text" class="small-text" value="<?php echo esc_html( stripslashes( $layout[2] ) ); ?>" id="wp_bvs_column2-width" name="layout[2]"> inserir medida em px ou %</td>
		</tr>
		<tr id="wp_bvs_column3-width-tr" <?php if($layout['total'] < 3) echo "style='display: none'"; ?> class="columns-tr">
			<th><label for="wp_bvs_column3-width">Largura coluna 3</label></th>
			<td><input type="text" class="small-text" value="<?php echo esc_html( stripslashes( $layout[3] ) ); ?>" id="wp_bvs_column3-width" name="layout[3]"> inserir medida em px ou %</td>
		</tr>
		<tr id="wp_bvs_column4-width-tr" <?php if($layout['total'] < 4) echo "style='display: none'"; ?> class="columns-tr">
			<th><label for="wp_bvs_column4-width">Largura coluna 4</label></th>
			<td><input type="text" class="small-text" value="<?php echo esc_html( stripslashes( $layout[4] ) ); ?>" id="wp_bvs_column4-width" name="layout[4]"> inserir medida em px ou %</td>
		</tr>
	</tbody>
 </table>
<h3 class="title">SideBars Auxiliares</h3>

<table class="form-table">
	<tbody> 
		<tr>
			<th><label for="layout[top-sidebar]">Top</label></th>
			<td>
				<input id="layout[top-sidebar]" name="layout[top-sidebar]" type="checkbox" class="" value="true" <?php if($layout['top-sidebar'] == 'true') { echo "checked"; } ?> ></br>
			</td>
		</tr>
		<tr>
			<th><label for="layout[footer-sidebar]">Footer</label></th>
			<td>
				<input id="layout[footer-sidebar]" name="layout[footer-sidebar]" type="checkbox" class="" value="true" <?php if($layout['footer-sidebar'] == 'true') { echo "checked"; } ?> ></br>
			</td>
		</tr>
	</tbody>
</table>
