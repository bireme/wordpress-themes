<?php

/**
 * User Login Form
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

?>

<form method="post" action="<?php bbp_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="bbp-login-form">
	<fieldset class="bbp-form">
		<legend><?php esc_html_e( 'Log In', 'bbpress' ); ?></legend>

		<div class="bbp-username grid-form-group">
			<label for="user_login"><?php esc_html_e( 'Username', 'bbpress' ); ?>: </label>
			<input type="text" class="form-control" name="log" value="<?php bbp_sanitize_val( 'user_login', 'text' ); ?>" size="20" maxlength="100" id="user_login" autocomplete="off" />
		</div>

		<div class="bbp-password grid-form-group">
			<label for="user_pass"><?php esc_html_e( 'Password', 'bbpress' ); ?>: </label>
			<input type="password" class="form-control" name="pwd" value="<?php bbp_sanitize_val( 'user_pass', 'password' ); ?>" size="20" id="user_pass" autocomplete="off" />
		</div>

		<div class="bbp-remember-me grid-form-group d-flex align-items-center mb-0">
			<input type="checkbox" class="form-check-input" name="rememberme" value="forever" <?php checked( bbp_get_sanitize_val( 'rememberme', 'checkbox' ) ); ?> id="rememberme" />
			<label for="rememberme" class="form-check-label"><?php esc_html_e( 'Keep me signed in', 'bbpress' ); ?></label>
		</div>

		<?php do_action( 'login_form' ); ?>

		<div class="bbp-submit-wrapper">

			<button type="submit" name="user-submit" id="user-submit" class="button submit user-submit btn btn-primary"><?php esc_html_e( 'Log In', 'bbpress' ); ?></button>

			<?php bbp_user_login_fields(); ?>

		</div>
	</fieldset>
</form>
