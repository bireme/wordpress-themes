jQuery(document).ready(function() {

    jQuery('#contato-panamazonica').validate({

        rules:{
            nome:{
                required: true,
            },
            email:{
                required: true,
                email: true
            },
            mensagem:{
                required: true,
                minlength: 10
            }
        },
        messages:{
            nome:{
                required: "Campo obrigatório",
            },email:{
                required: "É necessário informar um email",
                email: "Informe um email válido"
            },mensagem:{
                required: "Escreve uma mensagem antes de enviar",
                minlength: "Mensagem muito curta"
            }
        }
    });
});