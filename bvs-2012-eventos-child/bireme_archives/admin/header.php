<?php

    $header = $settings['header'];
    $current_language = strtolower(get_bloginfo('language'));
    $site_lang = substr($current_language, 0,2);

    if(is_plugin_active('multi-language-framework/multi-language-framework.php'))
        $enabled_langs = mlf_get_option('enabled_languages');
    else
        $enabled_langs = array($site_lang);

?>
<tr>
	<th><?php echo __('Logo','vhl');?></th>
	<th><?php echo __('Image URL','vhl');?></th>
	<th><?php echo __('Link','vhl');?></th>
</tr>
<?php foreach ( $enabled_langs as $lang ) { ?>
<tr>
	<th><label><?php echo strtoupper($lang); ?></label></th>
	<td><input id="header[logo-<?php echo $lang; ?>]" name="header[logo-<?php echo $lang; ?>]" placeholder="<?php echo __('Paste the URL','vhl');?>" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["logo-" . $lang] ) ); ?>"></td>
	<td><input id="header[linkLogo-<?php echo $lang; ?>]" name="header[linkLogo-<?php echo $lang; ?>]" placeholder="<?php echo __('Paste the link','vhl');?>" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["linkLogo-" . $lang] ) ); ?>"><br/></td>
</tr>
<?php } ?>
<tr>
	<td colspan="3"><hr/></td>
</tr>
<tr>
	<th><?php echo __('Banner','vhl');?></th>
	<th><?php echo __('Image URL','vhl');?></th>
	<th><?php echo __('Link','vhl');?></th>
</tr>
<?php foreach ( $enabled_langs as $lang ) { ?>
<tr>
	<th><label><?php echo strtoupper($lang); ?></label></th>
	<td><input id="header[banner-<?php echo $lang; ?>]" name="header[banner-<?php echo $lang; ?>]" placeholder="<?php echo __('Paste the URL','vhl');?>" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["banner-" . $lang] ) ); ?>"></td>
	<td><input id="header[bannerLink-<?php echo $lang; ?>]" name="header[bannerLink-<?php echo $lang; ?>]" placeholder="<?php echo __('Paste the link','vhl');?>" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["bannerLink-" . $lang] ) ); ?>"></td>
</tr>
<?php } ?>
<tr>
	<th></th>
	<td><input id="header[title_view]" name="header[title_view]" type="checkbox" class="" value="true" <?php if($header['title_view'] == 'true') { echo "checked"; } ?> > <label for="header[language]"><?php echo __('Check to display title on banner','vhl');?></label></td>
	<td></td>
</tr>
<tr>
	<td colspan="3"><hr/></td>
</tr>
<tr>
	<th><?php echo __('Languages bar','vhl');?></th>
	<th><?php echo __('Available languages','vhl');?></th>
	<th><?php echo __('Language bar position','vhl');?></th>
</tr>
<tr>
	<th><label></label></th>
	<td><input id="header[language]" name="header[language]" type="checkbox" class="" value="true" <?php if($header['language'] == 'true') { echo "checked"; } ?> ><?php echo __('Check to display available languages','vhl');?></td>
	<td>
		<label for="header-language-position"><?php echo __('Choose language bar position','vhl');?></label>
		<select class="header-language-position" id="language-position" name="header[language-position]">
			<option <?php if($header['language-position'] == "1") echo "selected='selected'"; ?> value="1"><?php echo __('Top','vhl');?></option>
			<option <?php if($header['language-position'] == "2") echo "selected='selected'"; ?> value="2"><?php echo __('Bottom','vhl');?></option>
		</select>
	</td>
</tr>
<tr>
	<td colspan="3"><hr/></td>
</tr>
<?php
// Show contact text field only WP Contact Form 7 Plugin is active.
if(is_plugin_active('contact-form-7/wp-contact-form-7.php')) { ?>
<tr>
	<th><label for="header[contactPage]"><?php echo __('Contact page','vhl');?></label></th>
	<td colspan="2">
		<input id="header[contactPage]" name="header[contactPage]" type="text" class="regular-text code" value="<?php echo esc_html( stripslashes( $header["contactPage"] ) ); ?>"><br/>
		<hr/>
	</td>
</tr>
<?php } ?>
<tr>
	<th><label for="header-extrahead"><?php echo __('Custom CSS and Javascript','vhl');?></label></th>
	<td colspan="2">
		<textarea id="header-extrahead" rows="7" cols="70" name="header[extrahead]"><?= stripslashes( $header['extrahead'] ) ?></textarea>
	</td>
</tr>
