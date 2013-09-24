<?php

function add_panamazonica_options(){
    add_menu_page('Contato', 'Contato', 'manage_options', 'panamazonica_contato', 'panamazonica_contato_options');
}
add_action('admin_menu', 'add_panamazonica_options');

function panamazonica_callback_ac( $input ){
	return $input;
}

function panamazonica_contato_options(){

    $options = get_option('panamazonica_contato');

    ?>

    <div class="wrap">
        <h2><?php _e('Contact', 'panamazonica'); ?></h2>
        <form action="options.php" method="post">

        <?php settings_fields('add_panamazonica_options_int'); ?>
            <p>
            <?php _e('Enter the email that will receive the messages sent through the contact form', 'panamazonica'); ?> <br/><br/>
            <?php _e('If you leave this field blak, messages will be sent to the admin email, set in Settings > General', 'panamazonica'); ?>
            </p>
            <table class="form-table">

                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="panamazonica_contato[email]" id="email" class="regular-text" value="<?php echo ($options['email']); ?>" /></td>
                </tr>
                <tr>
                    <td  colspan="2"><p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save'); ?>"></p></td>
                </tr>
            </table>
        </form>
    </div>

    <?php

}

add_action('admin_init', 'add_panamazonica_options_init');

function add_panamazonica_options_init() {
    register_setting('add_panamazonica_options_int', 'panamazonica_contato', 'panamazonica_callback_ac');
}?>
