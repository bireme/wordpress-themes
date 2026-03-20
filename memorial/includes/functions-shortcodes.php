<?php

function form_contato_custom_shortcode() {

    ob_start();

    // Mensagem de retorno
    $mensagem_retorno = '';

    // Processa envio
    if (isset($_POST['form_contato_enviado'])) {

        // Verifica nonce
        if (!isset($_POST['form_contato_nonce']) || !wp_verify_nonce($_POST['form_contato_nonce'], 'form_contato_action')) {
            $mensagem_retorno = '<div style="color:red;">Erro de segurança. Tente novamente.</div>';
        } else {

            // Sanitiza dados
            $nome     = sanitize_text_field($_POST['nome']);
            $email    = sanitize_email($_POST['email']);
            $assunto  = sanitize_text_field($_POST['assunto']);
            $mensagem = sanitize_textarea_field($_POST['mensagem']);

            // Validação simples
            if (empty($nome) || empty($email) || empty($mensagem)) {
                $mensagem_retorno = '<div style="color:red;">Preencha os campos obrigatórios.</div>';
            } else {

                // Email destino (troque se quiser)
                $para = 'toni@2wp.com.br';

                $headers = array('Content-Type: text/html; charset=UTF-8');

                $corpo = "
                    <strong>Nome:</strong> {$nome}<br>
                    <strong>Email:</strong> {$email}<br>
                    <strong>Assunto:</strong> {$assunto}<br>
                    <strong>Mensagem:</strong><br>{$mensagem}
                ";

                if (wp_mail($para, $assunto, $corpo, $headers)) {
                    $mensagem_retorno = '<div style="color:green;">Mensagem enviada com sucesso!</div>';
                } else {
                    $mensagem_retorno = '<div style="color:red;">Erro ao enviar. Tente novamente.</div>';
                }
            }
        }
    }

    ?>

    <?php echo $mensagem_retorno; ?>

    <form method="post">

        <?php wp_nonce_field('form_contato_action', 'form_contato_nonce'); ?>

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
            <label for="assunto" class="form-label">Assunto</label>
            <input type="text" class="form-control" name="assunto">
        </div>

        <div class="mb-3">
            <label for="mensagem" class="form-label">Mensagem</label>
            <textarea class="form-control" name="mensagem" rows="4" required></textarea>
        </div>

        <button type="submit" name="form_contato_enviado" class="btn btn-primary">
            Enviar
        </button>

    </form>

    <?php

    return ob_get_clean();
}

add_shortcode('form_contato_custom', 'form_contato_custom_shortcode');