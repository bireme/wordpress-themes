<?php
if (!defined('ABSPATH')) exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>



<header class="site-header" role="banner">
  <!-- TOPBAR: acessibilidade / idiomas -->
  <div class="topbar">
    <div class="container topbar__inner">
      <div class="topbar__left">
        <nav class="top-links" aria-label="Links rápidos">
          <a href="#site-content">Conteúdo Principal</a>
          <a href="#menu">Menu</a>
          <a href="#search">Pesquisa</a>
          <a href="#footer">Rodapé</a>
        </nav>
      </div>

      <div class="topbar__right">
        <div class="accessibility">
          <button class="text-resize" data-action="increase">+A</button>
          <button class="text-resize" data-action="decrease">-A</button>
          <button class="toggle-contrast" title="Alto contraste">Alto Contraste</button>
        </div>

        <div class="lang-switcher" aria-label="Idiomas">
          <a href="<?php echo esc_url( add_query_arg('lang','pt') ); ?>" class="active">Português</a>
          <a href="<?php echo esc_url( add_query_arg('lang','en') ); ?>">English</a>
          <a href="<?php echo esc_url( add_query_arg('lang','es') ); ?>">Español</a>
        </div>
      </div>
    </div>
  </div>

  <!-- AREA DE LOGOS -->
  <div class="brandbar">
    <div class="container brandbar__inner">
      <div class="brand-left">
        <?php
        // Logo BVS - se você tem um logo secundário, troque pelo ACF ou URL fixa
        // Exemplo com imagem estática no tema:
        $bvs_logo = get_template_directory_uri() . '/assets/images/logo-bvs.svg';
        ?>
        <a class="logo-bvs" href="<?php echo esc_url( home_url('/') ); ?>">
          <img src="<?php echo esc_attr($bvs_logo); ?>" alt="BVS Biblioteca Virtual" />
        </a>
        
         <?php
        // LILACS (logo principal) - usa custom logo se disponível, senão imagem de tema
        if ( function_exists('the_custom_logo') && has_custom_logo() ) {
          the_custom_logo();
        } else {
          $lilacs_logo = get_template_directory_uri() . '/assets/images/logo-lilacs.png';
          ?>
          <a class="logo-lilacs" href="<?php echo esc_url( home_url('/') ); ?>">
            <img src="<?php echo esc_attr($lilacs_logo); ?>" alt="<?php bloginfo('name'); ?>" />
          </a>
        <?php } ?>
      </div>

      <div class="brand-center">
       
      </div>

      <div class="brand-right">
        <!-- espaço para ícones/ações (opcional) -->
      </div>
    </div>
  </div>

  <!-- NAV -->
  <div class="navwrap">
    <div class="container navwrap__inner">
      <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="Abrir menu">
        <span class="hamburger"></span>
      </button>

      <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Menu principal">
        <?php
        wp_nav_menu( array(
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'menu menu--primary',
          'fallback_cb'    => 'wp_page_menu',
          'depth'          => 2,
        ) );
        ?>
      </nav>
    </div>
  </div>
</header>

<div id="site-content" class="site-content">
