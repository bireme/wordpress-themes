<?php

/**
 * New/Edit Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! bbp_is_single_forum() ) : ?>

<div id="bbpress-forums" class="bbpress-wrapper">

	<?php bbp_breadcrumb(); ?>

<?php endif; ?>

<?php if ( bbp_is_topic_edit() ) : ?>

	<?php bbp_topic_tag_list( bbp_get_topic_id() ); ?>

	<?php bbp_single_topic_description( array( 'topic_id' => bbp_get_topic_id() ) ); ?>

	<?php bbp_get_template_part( 'alert', 'topic-lock' ); ?>

<?php endif; ?>

<?php if ( bbp_current_user_can_access_create_topic_form() ) : ?>

	<div id="new-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-form">

		<form id="new-post" name="new-post" method="post">

			<?php do_action( 'bbp_theme_before_topic_form' ); ?>

			<fieldset class="bbp-form">
				<h5 class="title-form">
					<?php
						if ( bbp_is_topic_edit() ) :
							printf( esc_html__( 'Now Editing &ldquo;%s&rdquo;', 'bbpress' ), bbp_get_topic_title() );
						else :
							( bbp_is_single_forum() && bbp_get_forum_title() )
								? printf( esc_html__( 'Create New Topic in &ldquo;%s&rdquo;', 'bbpress' ), bbp_get_forum_title() )
								: esc_html_e( 'Create New Topic', 'bbpress' );
						endif;
					?>
				</h5>

				<?php do_action( 'bbp_theme_before_topic_form_notices' ); ?>

				<?php if ( ! bbp_is_topic_edit() && bbp_is_forum_closed() ) : ?>

					<div class="bbp-template-notice">
						<ul>
							<li><?php esc_html_e( 'This forum is marked as closed to new topics, however your posting capabilities still allow you to create a topic.', 'bbpress' ); ?></li>
						</ul>
					</div>

				<?php endif; ?>

				<?php if ( current_user_can( 'unfiltered_html' ) ) : ?>

					<div class="bbp-template-notice">
						<ul>
							<li><?php esc_html_e( 'Your account has the ability to post unrestricted HTML content.', 'bbpress' ); ?></li>
						</ul>
					</div>

				<?php endif; ?>

				<?php do_action( 'bbp_template_notices' ); ?>

				<div class="grid-form-topic">

					<?php bbp_get_template_part( 'form', 'anonymous' ); ?>
					<div class="row">
						<div class="col-md-6">
							<div class="grid-form-group">
								<?php do_action( 'bbp_theme_before_topic_form_title' ); ?>

								<label for="bbp_topic_title"><?php _e( 'Topic Title:', 'bbpress' ); ?></label>
								<input type="text" class="form-control" id="bbp_topic_title" value="<?php bbp_form_topic_title(); ?>" size="40" name="bbp_topic_title" maxlength="<?php bbp_title_max_length(); ?>" />
								<small><?php printf( esc_html__( 'Maximum Length: %d', 'bbpress' ), bbp_get_title_max_length() ); ?></small>					

								<?php do_action( 'bbp_theme_after_topic_form_title' ); ?>
							</div>					
						</div>
						<div class="col-md-6">
							<?php bbp_get_template_part( 'form', 'allowed-tags' ); ?>					

							<?php if ( bbp_allow_topic_tags() && current_user_can( 'assign_topic_tags', bbp_get_topic_id() ) ) : ?>

								<?php do_action( 'bbp_theme_before_topic_form_tags' ); ?>

								<div class="grid-form-group">
									<label for="bbp_topic_tags"><?php esc_html_e( 'Topic Tags:', 'bbpress' ); ?></label>
									<input type="text" class="form-control" value="<?php bbp_form_topic_tags(); ?>" size="40" name="bbp_topic_tags" id="bbp_topic_tags" <?php disabled( bbp_is_topic_spam() ); ?> />
								</div>

								<?php do_action( 'bbp_theme_after_topic_form_tags' ); ?>

							<?php endif; ?>


							<?php if ( ! bbp_is_single_forum() ) : ?>

								<?php do_action( 'bbp_theme_before_topic_form_forum' ); ?>

								<div class="grid-form-group">
									<label for="bbp_forum_id"><?php esc_html_e( 'Forum:', 'bbpress' ); ?></label>
									<?php
										bbp_dropdown( array(
											'show_none' => esc_html__( '&mdash; No forum &mdash;', 'bbpress' ),
											'selected'  => bbp_get_form_topic_forum()
										) );
									?>
								</div>

								<?php do_action( 'bbp_theme_after_topic_form_forum' ); ?>

							<?php endif; ?>							
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="grid-form-group">
								<?php do_action( 'bbp_theme_before_topic_form_content' ); ?>

								<label for="bbp_topic_content"><?php _e( 'Topic Description:', 'bbpress' ); ?></label>
								<?php bbp_the_content( array( 'context' => 'topic' ) ); ?>

								<?php do_action( 'bbp_theme_after_topic_form_content' ); ?>
							</div>
						</div>
						<div class="col-md-6">
							<?php if ( current_user_can( 'moderate', bbp_get_topic_id() ) ) : ?>
								<div class="row">
									<div class="col-auto">
										<?php do_action( 'bbp_theme_before_topic_form_type' ); ?>

										<div class="grid-form-group">
											<label for="bbp_stick_topic"><?php esc_html_e( 'Topic Type:', 'bbpress' ); ?></label>
											<?php bbp_form_topic_type_dropdown(); ?>
										</div>

										<?php do_action( 'bbp_theme_after_topic_form_type' ); ?>
									</div>
									<div class="col-auto">
										<?php do_action( 'bbp_theme_before_topic_form_status' ); ?>

										<div class="grid-form-group">
											<label for="bbp_topic_status"><?php esc_html_e( 'Topic Status:', 'bbpress' ); ?></label>
											<?php bbp_form_topic_status_dropdown(); ?>
										</div>

										<?php do_action( 'bbp_theme_after_topic_form_status' ); ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( bbp_is_subscriptions_active() && ! bbp_is_anonymous() && ( ! bbp_is_topic_edit() || ( bbp_is_topic_edit() && ! bbp_is_topic_anonymous() ) ) ) : ?>

								<?php do_action( 'bbp_theme_before_topic_form_subscriptions' ); ?>

								<div class="grid-form-group d-flex align-items-center">
									
										<input name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox" value="bbp_subscribe" <?php bbp_form_topic_subscribed(); ?> />

									<?php if ( bbp_is_topic_edit() && ( bbp_get_topic_author_id() !== bbp_get_current_user_id() ) ) : ?>

										<label for="bbp_topic_subscription"><?php esc_html_e( 'Notify the author of follow-up replies via email', 'bbpress' ); ?></label>

									<?php else : ?>

										<label for="bbp_topic_subscription"><?php esc_html_e( 'Notify me of follow-up replies via email', 'bbpress' ); ?></label>

									<?php endif; ?>									
								</div>

								<?php do_action( 'bbp_theme_after_topic_form_subscriptions' ); ?>

							<?php endif; ?>

							<?php if ( bbp_allow_revisions() && bbp_is_topic_edit() ) : ?>

								<?php do_action( 'bbp_theme_before_topic_form_revisions' ); ?>

								<fieldset class="bbp-form">
									<legend>
										<input name="bbp_log_topic_edit" id="bbp_log_topic_edit" type="checkbox" value="1" <?php bbp_form_topic_log_edit(); ?> />
										<label for="bbp_log_topic_edit"><?php esc_html_e( 'Keep a log of this edit:', 'bbpress' ); ?></label>
									</legend>

									<div class="grid-form-group">
										<label for="bbp_topic_edit_reason"><?php printf( esc_html__( 'Optional reason for editing:', 'bbpress' ), bbp_get_current_user_name() ); ?></label>
										<input type="text" class="form-control" value="<?php bbp_form_topic_edit_reason(); ?>" size="40" name="bbp_topic_edit_reason" id="bbp_topic_edit_reason" />
									</div>
								</fieldset>

								<?php do_action( 'bbp_theme_after_topic_form_revisions' ); ?>

							<?php endif; ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php do_action( 'bbp_theme_before_topic_form_submit_wrapper' ); ?>

							<div class="bbp-submit-wrapper">

								<?php do_action( 'bbp_theme_before_topic_form_submit_button' ); ?>

								<button type="submit" id="bbp_topic_submit" name="bbp_topic_submit" class="button submit btn btn-primary"><?php esc_html_e( 'Submit', 'bbpress' ); ?></button>

								<?php do_action( 'bbp_theme_after_topic_form_submit_button' ); ?>

							</div>
						</div>
					</div>

					<?php do_action( 'bbp_theme_after_topic_form_submit_wrapper' ); ?>

				</div>

				<?php bbp_topic_form_fields(); ?>

			</fieldset>

			<?php do_action( 'bbp_theme_after_topic_form' ); ?>

		</form>
	</div>

<?php elseif ( bbp_is_forum_closed() ) : ?>

	<div id="forum-closed-<?php bbp_forum_id(); ?>" class="bbp-forum-closed">
		<div class="bbp-template-notice">
			<ul>
				<li><?php printf( esc_html__( 'The forum &#8216;%s&#8217; is closed to new topics and replies.', 'bbpress' ), bbp_get_forum_title() ); ?></li>
			</ul>
		</div>
	</div>

<?php else : ?>

	<div id="no-topic-<?php bbp_forum_id(); ?>" class="bbp-no-topic">
		<div class="bbp-template-notice">
			<ul>
				<li><?php is_user_logged_in()
					? esc_html_e( 'You cannot create new topics.',               'bbpress' )
					: esc_html_e( 'You must be logged in to create new topics.', 'bbpress' );
				?></li>
			</ul>
		</div>

		<?php if ( ! is_user_logged_in() ) : ?>

			<?php bbp_get_template_part( 'form', 'user-login' ); ?>

		<?php endif; ?>

	</div>

<?php endif; ?>

<?php if ( ! bbp_is_single_forum() ) : ?>

</div>

<?php endif;
