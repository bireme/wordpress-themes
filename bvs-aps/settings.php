<?php
function bvs_aps_page_admin() {
    $config = get_option('bvs_aps_config');
    $home_url = ( empty($config['home_url']) ) ? '' : $config['home_url'];
?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"></div>
        <h2><?php _e('VHL APS Settings', 'bvs-aps'); ?></h2>

        <form method="post" action="options.php">

            <?php settings_fields('bvs-aps-settings-group'); ?>

            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php _e('Home URL', 'bvs-aps'); ?>:</th>
                        <td><input type="text" name="config[home_url]" value="<?php echo $home_url; ?>" class="regular-text code"></td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save changes'); ?>" />
            </p>
        </form>
    </div>
<?php
}
?>
