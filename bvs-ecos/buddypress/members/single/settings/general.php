<?php
/**
 * BuddyPress - Members Single Profile
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 12.0.0
 */

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/settings/profile.php */
do_action( 'bp_before_member_settings_template' ); ?>

<h2 class="bp-screen-reader-text">
	<?php
		/* translators: accessibility text */
		esc_html_e( 'Configurações de Conta', 'bvs-ecos' );
	?>
</h2>

<form action="<?php bp_displayed_user_link( array( bp_get_settings_slug(), 'general' ) ); ?>" method="post" class="" id="settings-form">

	<div class="row">
		<div class="col-12 col-md-6">

			<?php if ( ! is_super_admin() ) : ?>
			<div class="grid-input-group">
				<label for="pwd">
					<?php
					/* translators: %s: the required text information. */
					printf( esc_html__( 'Senha atual %s', 'bvs-ecos' ), '<span>' . esc_html_x( '(necessário atualizar o e-mail ou alterar a senha atual)', 'bvs-ecos' ) . '</span>' );
					?>
				</label>
				<input type="password" name="pwd" id="pwd" size="16" value="" class="settings-input small form-control" <?php bp_form_field_attributes( 'password' ); ?>/> &nbsp;<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Esqueceu sua senha?', 'bvs-ecos' ); ?></a>
			</div>
			<?php endif; ?>

			<div class="grid-input-group">
				<label for="email"><?php esc_html_e( 'Email', 'bvs-ecos' ); ?></label>
				<input type="email" name="email" id="email" value="<?php echo esc_attr( bp_get_displayed_user_email() ); ?>" class="settings-input form-control" <?php bp_form_field_attributes( 'email' ); ?>/>
			</div>

			<div class="grid-input-group">
				<label for="pass1">
					<?php
					/* translators: %s: Information about how to keep password unchanged. */
					printf( esc_html__( 'Mudar senha %s', 'bvs-ecos' ), '<span>' . esc_html__( '(deixe em branco para nenhuma alteração)', 'bvs-ecos' ) . '</span>' );
					?>
				</label>
				<input type="password" name="pass1" id="pass1" size="16" value="" class="settings-input small password-entry form-control" <?php bp_form_field_attributes( 'password' ); ?>/>
				<div id="pass-strength-result"></div>
			</div>

			<div class="grid-input-group">
				<label for="pass2"><?php esc_html_e( 'Repita a nova senha', 'bvs-ecos' );
				?></label>
				<input type="password" name="pass2" id="pass2" size="16" value="" class="settings-input small password-entry-confirm form-control" <?php bp_form_field_attributes( 'password' ); ?>/>
			</div>

			<?php

			/**
			 * Fires before the display of the submit button for user general settings saving.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_core_general_settings_before_submit' ); ?>

			<div class="submit">
				<input type="submit" name="submit" value="<?php esc_attr_e( 'Salvar Alterações', 'bvs-ecos' ); ?>" id="submit" class="auto" />
			</div>

			<?php

			/**
			 * Fires after the display of the submit button for user general settings saving.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_core_general_settings_after_submit' ); ?>

			<?php wp_nonce_field( 'bp_settings_general' ); ?>

		</div>
	</div>
</form>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/settings/profile.php */
do_action( 'bp_after_member_settings_template' );
