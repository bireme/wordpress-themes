<?php
/**
 * Template name: Contato
 */

get_header(); the_post(); ?>
	<div class="content">

	    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    	<h1 class="entry-title"><?php the_title(); ?> <?php edit_post_link( __( 'Edit', 'panamazonica' ), '', '' ) ?></h1>
	    	<div class="entry-content">

            <?php
            $options = get_option('panamazonica_contato');
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $mensagem = $_POST['mensagem'];
            $email_enviando = '<b>Autor:</b> <br />' . htmlspecialchars ($nome) . '<br />' . htmlspecialchars($email) . '<br /><br />' . '<b>Mensagem:</b>' . nl2br( htmlspecialchars($mensagem) );
            $new_nome = '';
            $new_email = '';
            $new_mensagem = '';

            $email_do_panamazonica = $options['email'] == '' ? get_option('admin_email') : $options['email'];

            if(isset($_POST['enviar'])):

                $email_s = wp_mail($email_do_panamazonica, __('New message received', 'panamazonica'), $email_enviando, 'Content-Type: text/html; charset=UTF-8;');

                if ($email_s == true) {

                    echo "<p class='accept'>" . __('Email successfully sent!', 'panamazonica') . "</p>";

                }if ($email_s == false) {
                    echo "<p class='error'>" . __('Error sending email, please try again', 'panamazonica') . "</p>";
                    $new_nome = $nome;
                    $new_email = $email;
                    $new_mensagem = $mensagem;
                }
            endif;

            ?>
				<form action="" id="contato-panamazonica" method="post">
					<label for="nome"><?php _e('Name:', 'panamazonica'); ?></label>
					<input type="text" name="nome" value="<?php echo $new_nome;?>" />

					<label for="email"><?php _e('Email:', 'panamazonica'); ?></label>
					<input type="text" name="email" value="<?php echo $new_email;?>" />

					<label for="mensagem"><?php _e('Message:', 'panamazonica'); ?></label>
					<textarea name="mensagem" rows="10"><?php echo $new_mensagem;?></textarea>

					<input type="submit" name="enviar" value="<?php _e('Send', 'panamazonica'); ?>" />
				</form>

	    	</div><!-- /entry-content -->
	    </article><!-- /page-<?php the_ID(); ?> -->

	</div><!-- /content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
