<?php $header = $settings['header']; ?>
<tr>
	<th><label for="wp_bvs_tag_class">Logo URL</label></th>
	<td>
		<input id="header[logo]" name="header[logo]" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["logo"] ) ); ?>"></br>
	</td>
</tr>
<tr>
	<th><label for="header[linkLogo]">Logo link</label></th>
	<td>
		<input id="header[linkLogo]" name="header[linkLogo]" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["linkLogo"] ) ); ?>"><br/>
		<hr/>
	</td>
</tr>
<tr>
	<th><label for="header[banner]">Banner URL</label></th>
	<td>
		<input id="header[banner]" name="header[banner]" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["banner"] ) ); ?>"></br>
	</td>
</tr>
<tr>
	<th><label for="header[language]"><?php echo __('Display title on banner?','vhl');?></label></th>
	<td>
		<input id="header[title_view]" name="header[title_view]" type="checkbox" class="" value="true" <?php if($header['title_view'] == 'true') { echo "checked"; } ?> ></br>
	</td>
</tr>
<tr>
	<th><label for="header[bannerLink]">Banner Link</label></th>
	<td>
		<input id="header[bannerLink]" name="header[bannerLink]" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["bannerLink"] ) ); ?>"></br>
		<hr/>
	</td>
</tr>
<tr>
	<th><label for="header[language]"><?php echo __('Display available languages?','vhl');?></label></th>
	<td>
		<input id="header[language]" name="header[language]" type="checkbox" class="" value="true" <?php if($header['language'] == 'true') { echo "checked"; } ?> ></br>
	</td>
</tr>
<tr>
	<th><label for="header-language-position"><?php echo __('Language bar position','vhl');?></label></th>
	<td>
		<select class="header-language-position" id="language-position" name="header[language-position]">
			<option <?php if($header['language-position'] == "1") echo "selected='selected'"; ?> value="1"><?php echo __('Top','vhl');?></option>
			<option <?php if($header['language-position'] == "2") echo "selected='selected'"; ?> value="2"><?php echo __('Bottom','vhl');?></option>
		</select>
		<hr/>
	</td>
</tr>
<tr>
	<th><label for="header[bannerLink]">Contact page</label></th>
	<td>
		<input id="header[contactPage]" name="header[contactPage]" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["contactPage"] ) ); ?>"><br/>
		<hr/>
	</td>
</tr>
<tr>
	<th><label for="header-extrahead"><?php echo __('Custom CSS and Javascript','vhl');?></label></th>
	<td>
		<textarea id="header-extrahead" rows="7" cols="70" name="header[extrahead]"><?= stripslashes( $header['extrahead'] ) ?></textarea>
	</td>
</tr>
