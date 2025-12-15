<?php
if (!defined('ABSPATH')) exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <?php if ( ! function_exists( '_wp_render_title_tag' ) ) : ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
  <?php endif; ?>

  <meta name="description" content="<?php echo esc_attr( get_bloginfo('description') ); ?>">

  <!-- Open Graph básico -->
  <meta property="og:locale" content="<?php echo esc_attr( get_locale() ); ?>">
  <meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo('name') ); ?>">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?php wp_title( '|', true, 'right' ); ?>">

  <!-- Canonical simples  -->
  <?php if ( function_exists( 'wp_get_canonical_url' ) ) : ?>
    <link rel="canonical" href="<?php echo esc_url( wp_get_canonical_url() ); ?>">
  <?php endif; ?>

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const nav = document.getElementById('site-navigation');
  const ul  = document.getElementById('primary-menu');
  const btn = document.querySelector('.menu-toggle');
  const sidebar = document.getElementById('mobile-sidebar');
  const overlay = document.querySelector('.mobile-overlay');
  const closeSidebar = document.querySelector('.close-sidebar');
  
  if(!btn || !sidebar || !overlay) {
    return;
  }

  // abre/fecha menu lateral (mobile)
  btn.addEventListener('click', function(e){
    e.preventDefault();
    e.stopPropagation();
    
    if(window.matchMedia('(max-width: 992px)').matches){
      sidebar.classList.add('is-open');
      overlay.classList.add('is-active');
      document.body.classList.add('sidebar-open');
      btn.setAttribute('aria-expanded', 'true');
    }
  });

  // fecha sidebar
  function closeMobileSidebar() {
    sidebar.classList.remove('is-open');
    overlay.classList.remove('is-active');
    document.body.classList.remove('sidebar-open');
    btn.setAttribute('aria-expanded', 'false');
  }

  // botão de fechar
  if(closeSidebar) {
    closeSidebar.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      closeMobileSidebar();
    });
  }

  // overlay
  if(overlay) {
    overlay.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      closeMobileSidebar();
    });
  }

  // ESC key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && sidebar.classList.contains('is-open')) {
      closeMobileSidebar();
    }
  });

  // submenu toggles no sidebar - aguarda um pouco para garantir que o DOM está pronto
  setTimeout(function() {
    const sidebarParents = sidebar.querySelectorAll('li.menu-item-has-children');
    
    sidebarParents.forEach(li => {
      const a = li.querySelector(':scope > a');
      
      // verificar se já existe um toggle
      if (li.querySelector('.sidebar-submenu-toggle')) {
        return;
      }
      
      // criar botão toggle
      const toggle = document.createElement('button');
      toggle.className = 'sidebar-submenu-toggle';
      toggle.type = 'button';
      toggle.setAttribute('aria-label','<?php echo esc_js(bireme_lilacs_translate('Abrir submenu', 'Navigation')); ?>');
      toggle.innerHTML = '<span class="toggle-icon">+</span>';
      
      if(a) {
        a.parentNode.insertBefore(toggle, a.nextSibling);
      }

      toggle.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        const isOpen = li.classList.toggle('submenu-open');
        const icon = this.querySelector('.toggle-icon');
        icon.textContent = isOpen ? '−' : '+';
        
        // fecha submenus irmãos no mesmo nível
        [...li.parentElement.children].forEach(sib => {
          if(sib !== li && sib.classList.contains('menu-item-has-children')) {
            sib.classList.remove('submenu-open');
            const sibToggle = sib.querySelector('.sidebar-submenu-toggle .toggle-icon');
            if(sibToggle) sibToggle.textContent = '+';
          }
        });
      });
    });
  }, 100);

  // Desktop: comportamento original dos submenus
  if(ul) {
    const desktopParents = ul.querySelectorAll('li.menu-item-has-children');
    desktopParents.forEach(li => {
      const a = li.querySelector(':scope > a');
      a && a.setAttribute('aria-haspopup','true');
    });
  }
});
</script>

<style>/* ====== BARRA E MENU PRINCIPAL ====== */
.navwrap { background:#082b61; position:relative; z-index:50; }
.navwrap__inner { display:flex; align-items:center; justify-content:space-between; min-height:56px; }

.menu--primary {
  list-style:none; margin:0; padding:0;
  display:flex; gap:28px; align-items:center;
}
.menu--primary > li { position:relative; }
.menu--primary > li > a {
  color:#fff; text-decoration:none;
  display:flex; align-items:center; gap:6px;
  padding:18px 0; font-weight:700; line-height:1;
}
.menu--primary > li.menu-item-has-children > a::after {
  content:"▾"; font-size:.8rem; opacity:.8; transform:translateY(-1px);
}

/* ====== SUBMENU (DROPDOWN PRINCIPAL) ====== */
.menu--primary .sub-menu {
  list-style:none; margin:0; padding:16px 20px;
  position:absolute; left:0; top:100%;
  min-width:520px;
  background:#fff; color:#0c1524;
  border-radius:12px; box-shadow:0 12px 24px rgba(0,0,0,.12);
  display:none; opacity:0; transform:translateY(8px);
  transition:opacity .18s ease, transform .18s ease;
  z-index:999;
}

/* Mostrar o dropdown no hover/focus */
.menu--primary > li:hover > .sub-menu,
.menu--primary > li:focus-within > .sub-menu {
  display:block; opacity:1; transform:translateY(0);
}

/* Itens do submenu */
.menu--primary .sub-menu > li {
  position:relative; margin:6px 0;
}
.menu--primary .sub-menu > li > a {
  display:block;
  padding:4px 0;
  font-weight:600;
  color:#0c1524;
  text-decoration:none;
}
.menu--primary .sub-menu > li > a:hover {
  color:#082b61;
}

/* ====== SUBGRUPOS (3º NÍVEL SEMPRE VISÍVEL) ====== */
.menu--primary .sub-menu .sub-menu {
  position:static;
  display:block;
  opacity:1; transform:none;
  background:transparent;
  box-shadow:none; border-radius:0;
  padding:0 0 8px 0;
  margin:4px 0 10px 0;
}

/* Título do grupo */
.menu--primary .sub-menu > li.menu-item-has-children > a {
    display: block;
    padding: 6px 0;
    font-weight: 800;
    font-family: 'Poppins';
    color: #000000;
}

/* Remove setinhas nos grupos */
.menu--primary .sub-menu > li.menu-item-has-children > a::after { content:none; }

/* Links do 3º nível */
.menu--primary .sub-menu .sub-menu > li > a {
  display:block; padding:3px 0;
  font-weight:600; color:#6c7887;
  text-decoration:none;
}
.menu--primary .sub-menu .sub-menu > li > a:hover {
  color:#082b61;
}

/* ====== MOBILE ====== */
.menu-toggle {
  background:transparent; border:0;
  width:40px; height:40px; display:none; color:#fff;
  cursor: pointer;
  position: relative;
  z-index: 10001;
}
.menu-toggle .hamburger {
  position: relative;
  display: block;
  width: 20px;
  height: 2px;
  background: #fff;
  margin: 0 auto;
  transition: .2s;
}
.menu-toggle .hamburger::before,
.menu-toggle .hamburger::after {
  content:"";
  position: absolute;
  left: 0;
  width: 20px;
  height: 2px;
  background:#fff;
  transition:.2s;
}
.menu-toggle .hamburger::before {
  top: -7px;
}
.menu-toggle .hamburger::after {
  top: 7px;
}

/* ====== MOBILE SIDEBAR ====== */
.mobile-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  z-index: 9998;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
  pointer-events: none;
}

.mobile-overlay.is-active {
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
}

.mobile-sidebar {
  position: fixed;
  top: 0;
  left: -320px;
  width: 320px;
  height: 100vh;
  background: #fff;
  z-index: 9999;
  overflow-y: auto;
  transition: left 0.3s ease;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.mobile-sidebar.is-open {
  left: 0;
}

.sidebar-header {
  padding: 20px;
  background: #082b61;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.sidebar-title {
  font-weight: 700;
  font-size: 1.1rem;
  margin: 0;
}

.close-sidebar {
  background: transparent;
  border: none;
  color: white;
  font-size: 1.5rem;
  cursor: pointer;
  padding: 5px;
  line-height: 1;
}

.sidebar-menu {
  list-style: none;
  margin: 0;
  padding: 0;
}

.sidebar-menu li {
  border-bottom: 1px solid #f0f0f0;
}

.sidebar-menu > li > a {
  display: block;
  padding: 15px 20px;
  color: #333;
  text-decoration: none;
  font-weight: 600;
  transition: background 0.2s ease;
}

.sidebar-menu > li > a:hover {
  background: #f8f9fa;
  color: #082b61;
}

.sidebar-menu li.menu-item-has-children {
  position: relative;
}

.sidebar-submenu-toggle {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  background: transparent;
  border: none;
  color: #666;
  font-size: 1.2rem;
  cursor: pointer;
  padding: 5px;
  line-height: 1;
}

.sidebar-submenu-toggle:hover {
  color: #082b61;
}

/* Submenus */
.sidebar-menu .sub-menu {
  list-style: none;
  margin: 0;
  padding: 0;
  background: #f8f9fa;
  display: none;
}

.sidebar-menu .submenu-open > .sub-menu {
  display: block;
}

.sidebar-menu .sub-menu > li > a {
  padding: 12px 20px 12px 40px;
  color: #555;
  font-weight: 600;
  font-size: 0.95rem;
}

.sidebar-menu .sub-menu > li > a:hover {
  background: #e9ecef;
  color: #082b61;
}

/* 3º nível */
.sidebar-menu .sub-menu .sub-menu {
  background: #e9ecef;
}

.sidebar-menu .sub-menu .sub-menu > li > a {
  padding-left: 60px;
  font-weight: 400;
  color: #666;
  font-size: 0.9rem;
}

.sidebar-menu .sub-menu .sub-menu > li > a:hover {
  background: #dee2e6;
  color: #082b61;
}

/* Títulos de grupos no sidebar */
.sidebar-menu .sub-menu > li.menu-item-has-children > a {
  font-weight: 700;
  color: #082b61;
}

/* Prevenir scroll do body quando sidebar aberto */
body.sidebar-open {
  overflow: hidden;
}

@media (max-width:992px){
  .menu-toggle { display:block; }
  
  /* Esconder menu principal no mobile */
  #site-navigation .menu--primary {
    display: none !important;
  }
}

/* Desktop mantém comportamento original */
@media (min-width: 993px) {
  .mobile-overlay,
  .mobile-sidebar {
    display: none;
  }
  
  .menu--primary {
    list-style:none; margin:0; padding:0;
    display:flex; gap:28px; align-items:center;
  }
  .menu--primary > li { position:relative; }
  .menu--primary > li > a {
    color:#fff; text-decoration:none;
    display:flex; align-items:center; gap:6px;
    padding:18px 0; font-weight:700; line-height:1;
  }
  .menu--primary > li.menu-item-has-children > a::after {
    content:"▾"; font-size:.8rem; opacity:.8; transform:translateY(-1px);
  }
}
/* --- FORÇAR 3º NÍVEL SEMPRE VISÍVEL DENTRO DO DROPDOWN (DESKTOP) --- */
.navwrap .menu--primary .sub-menu .sub-menu{
  display:block !important;
  position:static !important;
  opacity:1 !important;
  transform:none !important;
  visibility:visible !important;
  background:transparent;
  box-shadow:none;
  border-radius:0;
  padding:0 0 8px 0;
  margin:4px 0 10px 0;
}

/* quando o 2º nível estiver aberto por hover/focus, garanta que o 3º nível também apareça */
.navwrap .menu--primary > li:hover > .sub-menu .sub-menu,
.navwrap .menu--primary > li:focus-within > .sub-menu .sub-menu{
  display:block !important;
}

/* títulos de grupo não são dropdown */
.navwrap .menu--primary .sub-menu > li.menu-item-has-children > a::after{ content:none; }
.navwrap .menu--primary .sub-menu > li.menu-item-has-children > a{
  font-weight:800;
}

/* estilização dos links do 3º nível */
.navwrap .menu--primary .sub-menu .sub-menu > li > a{
display: block;
    padding: 3px 0;
    font-weight: 400;
    color: #5E5E5E;
    text-decoration: none;
    font-family: 'Poppins';
}
.navwrap .menu--primary .sub-menu .sub-menu > li > a:hover{ color:#082b61; }

/* --- MOBILE: sidebar sempre substitui o menu dropdown --- */
@media (max-width:992px){
  .navwrap .menu--primary { display:none !important; }
}

/* ====== POLYLANG LANGUAGE SWITCHER ====== */
.lang-switcher ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  gap: 8px;
}
  .lang-switcher{
        display: flex
;
  }

.lang-switcher li {
  margin: 0;
  list-style:none;
}

.lang-switcher a {
  color: #666;
  text-decoration: none;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 0.875rem;
  transition: all 0.2s ease;
}

.lang-switcher a:hover,
.lang-switcher .current-lang a {
  background: #f0f0f0;
  color: #082b61;
}

.lang-switcher .current-lang a {
  font-weight: 600;
}

/* ====== TOPBAR STYLES ====== */
.topbar {
  background: #fff !important;
  border: none !important;
  font-size: 0.875rem;
}

.topbar__inner {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
}

.topbar__left .top-links {
  display: flex;
  gap: 16px;
}

.topbar__left .top-links a {
  color: #666;
  text-decoration: none;
  padding: 2px 0;
}

.topbar__left .top-links a:hover {
  color: #082b61;
  text-decoration: underline;
}

.topbar__right {
  display: flex;
  align-items: center;
  gap: 20px;
}

.accessibility {
  display: flex;
  gap: 8px;
}

.accessibility button {
  background: transparent;
  border: 1px solid #ddd;
  padding: 4px 8px;
  font-size: 0.75rem;
  cursor: pointer;
  border-radius: 3px;
  transition: all 0.2s ease;
}

.accessibility button:hover {
  background: #082b61;
  color: white;
  border-color: #082b61;
}

@media (max-width: 768px) {
  .topbar__inner {
    flex-direction: column;
    gap: 8px;
    text-align: center;
  }
  
  .topbar__left .top-links {
    flex-wrap: wrap;
    justify-content: center;
    gap: 12px;
  }
}

/* ====== BRANDBAR STYLES ====== */
.brandbar {
  background: white;
  border-bottom: 1px solid #e9ecef;
  padding: 16px 0;
}

.brandbar__inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.brand-left {
  display: flex;
  align-items: center;
  gap: 20px;
}

.logo-bvs img,
.logo-lilacs img,
.custom-logo-link img {
  max-height: 150px;
  width: auto;
}

/* Estilos específicos para logos por idioma */
.logo-lilacs.lang-pt img,
.logo-lilacs.lang-en img,
.logo-lilacs.lang-es img {
  max-height: 76px;
  width: auto;
  object-fit: contain;
}

@media (max-width: 768px) {
  .brandbar__inner {
    flex-direction: column-reverse;
    gap: 12px;
  }
  
  .logo-bvs img,
  .logo-lilacs img,
  .custom-logo-link img {
    max-height: 50px;
  }
  
  .logo-lilacs.lang-pt img,
  .logo-lilacs.lang-en img,
  .logo-lilacs.lang-es img {
    max-height: 50px;
  }
}

.logo-rede img {
  max-height: 76px;
  width: auto;
  object-fit: contain;
}

.brand-right {
    display: block !important;
    flex: 0 0 30px !important;
}



@media (max-width: 768px) {
  .logo-rede img {
    max-height: 50px;
  }
}


</style>
<header class="site-header" role="banner">

  <!-- AREA DE LOGOS -->
  <div class="brandbar">
    <div class="container brandbar__inner">
      <div class="brand-left">
        <?php
        $current_lang_slug = bireme_lilacs_get_lang_slug();
        $home_lang_url     = bireme_get_lang_home_url();
        
        
         // Logo da REDE BVS por idioma
        $rede_logo = bireme_rede_get_logo();
        $rede_url  = bireme_rede_get_url();

        // Logo BVS por idioma
        $bvs_logo = bireme_bvs_get_logo();
        ?>
        <?php if ( $bvs_logo ) : ?>
          <a class="logo-bvs lang-<?php echo esc_attr( $current_lang_slug ); ?>" href="<?php echo esc_url( $rede_url ); ?>">
            <img src="<?php echo esc_attr( $bvs_logo ); ?>" alt="BVS Biblioteca Virtual" />
          </a>
        <?php endif; ?>

        <?php
        // LILACS (logo principal) - usa logo específico por idioma
        $lilacs_logo = bireme_lilacs_get_logo();
        // Nome do site baseado no idioma
        if ( function_exists('pll__') ) {
          $site_name = pll__('LILACS');
          if ( empty($site_name) ) {
              $site_name = get_bloginfo('name');
          }
        } else {
          $site_name = get_bloginfo('name');
        }
        ?>
        <?php if ( $lilacs_logo ) : ?>
          <!-- LILACS levando para a home no idioma atual -->
          <a class="logo-lilacs lang-<?php echo esc_attr($current_lang_slug); ?>" href="<?php echo esc_url( $home_lang_url ); ?>">
            <img src="<?php echo esc_attr($lilacs_logo); ?>" alt="<?php echo esc_attr($site_name); ?>" />
          </a>
        <?php endif; ?>
      </div>

      <div class="brand-center">
        <!-- espaço caso queira algum selo/texto no centro -->
      </div>

      <div class="brand-right">
          
          <!-- TOPBAR: acessibilidade / idiomas -->
  <div class="topbar">
    <div class="container topbar__inner">
     

      <div class="topbar__right">
       

        <div class="lang-switcher" aria-label="Idiomas">
          <?php 
          if (function_exists('pll_the_languages')) {
            // Usar o switcher nativo do Polylang
            pll_the_languages(array(
              'show_flags' => 0,
              'show_names' => 1,
              'display_names_as' => 'name'
            ));
          } else {
            // Fallback caso o Polylang não esteja ativo
            ?>
            <a href="<?php echo esc_url( add_query_arg('lang','pt') ); ?>" class="active">Português</a>
            <a href="<?php echo esc_url( add_query_arg('lang','en') ); ?>">English</a>
            <a href="<?php echo esc_url( add_query_arg('lang','es') ); ?>">Español</a>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
          
        <?php
        // Logo da REDE BVS por idioma
        $rede_logo = bireme_rede_get_logo();
        $rede_url  = bireme_rede_get_url();

        ?>
        <?php if ( $rede_logo ) : ?>
          <a class="logo-rede lang-<?php echo esc_attr($current_lang_slug); ?>" href="<?php echo esc_url($rede_url); ?>" target="_blank" rel="noopener">
            <img src="<?php echo esc_attr($rede_logo); ?>" alt="Rede BVS" />
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>


  <!-- NAV -->
  <div class="navwrap">
    <div class="container navwrap__inner">
      <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php echo bireme_lilacs_translate('Abrir menu', 'Navigation'); ?>">
        <span class="hamburger"></span>
      </button>

      <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Menu principal">
<?php
// Obter o local do menu baseado no idioma atual (Polylang)
$menu_location = bireme_lilacs_get_menu_location();

wp_nav_menu([
  'theme_location' => $menu_location,
  'container'      => false,
  'menu_class'     => 'menu menu--primary',
  'menu_id'        => 'primary-menu',
  'fallback_cb'    => 'wp_page_menu',
  'depth'          => 3, // precisa do 3º nível para os subgrupos
]);
?>
      </nav>
    </div>
  </div>
</header>

<!-- MOBILE SIDEBAR -->
<div class="mobile-overlay"></div>
<div class="mobile-sidebar" id="mobile-sidebar">
  <div class="sidebar-header">
    <h3 class="sidebar-title"><?php echo bireme_lilacs_translate('Menu', 'Navigation'); ?></h3>
    <button class="close-sidebar" aria-label="<?php echo bireme_lilacs_translate('Fechar menu', 'Navigation'); ?>">×</button>
  </div>
  <nav class="sidebar-navigation">
    <?php
    // Usar o mesmo menu do desktop mas com classes diferentes para o sidebar
    $menu_location = bireme_lilacs_get_menu_location();
    
    wp_nav_menu([
      'theme_location' => $menu_location,
      'container'      => false,
      'menu_class'     => 'sidebar-menu',
      'menu_id'        => 'sidebar-menu',
      'fallback_cb'    => 'wp_page_menu',
      'depth'          => 3,
    ]);
    ?>
  </nav>
</div>

<div id="site-content" class="site-content">

<style>
    .submenu-open {
        padding: 0px !important;
    }

    .submenu-open .menu-item {
        padding: 20px;
    }

    .submenu-open button {
        position: absolute;
        right: 15px;
        top: 10% !important;
        transform: translateY(-60%) !important;
        background: transparent;
        border: none;
        color: #666;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 5px;
        line-height: 1;
    }

    .sub-menu .menu-item button {
        position: absolute;
        right: 15px;
        top: 50% !important;
        transform: translateY(-50%) !important;
        background: transparent;
        border: none;
        color: #666;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 5px;
        line-height: 1;
    }

</style>
