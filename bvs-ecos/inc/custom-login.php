<?php

add_action('login_enqueue_scripts', 'custom_login_logo');
function custom_login_logo() {
    ?>
    <style type="text/css">
        #login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/inc/assets/imgs/logo/logo-300-dark.png);
            width: 300px;
            background-size: contain;
        }
    </style>
    <?php
}

add_action('login_enqueue_scripts', 'custom_login_css');
function custom_login_css() { ?>
    <style type="text/css">
        /* body.login {
            background-color: #002557;
        }

        body.login,
        .login #nav a,
        .login #backtoblog a,
        .login .privacy-policy-link{
            color: #ffffff !important;
        } */

        .login #loginform,
        .login #lostpasswordform,
        .login .notice{
            color: #000000;
            border-radius: 8px;
        }
    </style>
<?php
}

add_filter('login_headerurl', 'custom_login_url');
function custom_login_url() {
    return home_url();  // Define o link para a página inicial do seu site
}

add_filter('login_headertitle', 'custom_login_title');
function custom_login_title() {
    return get_bloginfo('name');  // Exibe o nome do seu site
}