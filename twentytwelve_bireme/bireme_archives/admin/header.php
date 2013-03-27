<?php $header = $settings['header']; ?>
<tr>
	<th><label for="wp_bvs_tag_class">Logo URL</label></th>
	<td>
		<input id="header[logo]" name="header[logo]" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["logo"] ) ); ?>"></br>
	</td>
</tr>
<tr>
	<th><label for="header[banner]">Banner URL</label></th>
	<td>
		<input id="header[banner]" name="header[banner]" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["banner"] ) ); ?>"></br>
	</td>
</tr>
<tr>
	<th><label for="header[language]">Exibe Título no Banner?</label></th>
	<td>
		<input id="header[title_view]" name="header[title_view]" type="checkbox" class="" value="true" <?php if($header['title_view'] == 'true') { echo "checked"; } ?> ></br>
	</td>
</tr>

<tr>
	<th><label for="header[language]">Exibe Idiomas disponíveis?</label></th>
	<td>
		<input id="header[language]" name="header[language]" type="checkbox" class="" value="true" <?php if($header['language'] == 'true') { echo "checked"; } ?> ></br>
	</td>
</tr>
<tr>
	<th><label for="header-language-position">Posição da Barra de Idiomas</label></th>
	<td>
		<select class="header-language-position" id="language-position" name="header[language-position]">
			<option <?php if($header['language-position'] == "1") echo "selected='selected'"; ?> value="1">Acima</option>
			<option <?php if($header['language-position'] == "2") echo "selected='selected'"; ?> value="2">Abaixo</option>
		</select>
	</td>
</tr>
