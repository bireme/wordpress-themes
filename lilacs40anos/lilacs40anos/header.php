<?php
if (!defined('ABSPATH')) exit;
?><!doctype html>
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
<?php wp_body_open(); ?>

<body <?php body_class(); ?>>

<style>
/* ====== BARRA E MENU PRINCIPAL ====== */
.navwrap { background:#082b61; position:relative; z-index:50; }
.navwrap__inner {
  display:flex;
  align-items:center;
  justify-content:space-between;
  min-height:56px;
  position:relative;
}

.menu--primary {
  list-style:none;
  margin:0;
  padding:0;
  display:flex;
  gap:28px;
  align-items:center;
  width:100%;
  justify-content:space-around;
}
.menu--primary > li { position:relative; list-style:none; }
.menu--primary > li > a {
  color:#fff;
  text-decoration:none;
  display:flex;
  align-items:center;
  gap:6px;
  padding:18px 0;
  font-weight:700;
  line-height:1;
  font-family:'Poppins', sans-serif;
  font-size:20px;
}
.menu--primary > li.menu-item-has-children > a::after {
  content:"▾";
  font-size:.8rem;
  opacity:.8;
  transform:translateY(-1px);
}
.menu--primary > li > a:hover,
.menu--primary > li.current-menu-item > a,
.menu--primary > li.current_page_item > a {
  color:#F96A1E;
}

/* ====== SUBMENU (DROPDOWN PRINCIPAL) ====== */
.menu--primary > li > .sub-menu {
  list-style:none;
  margin:0;
  padding:12px 0;
  position:absolute;
  left:0;
  top:100%;
  min-width:280px;
  max-width:min(520px, calc(100vw - 32px));
  background:#fff;
  color:#0c1524;
  border-radius:12px;
  box-shadow:0 12px 28px rgba(0,0,0,.14);
  display:none;
  opacity:0;
  transform:translateY(8px);
  transition:opacity .18s ease, transform .18s ease;
  z-index:999;
}

.menu--primary > li:hover > .sub-menu,
.menu--primary > li:focus-within > .sub-menu {
  display:block;
  opacity:1;
  transform:translateY(0);
}

/* L2 — links e grupos */
.menu--primary > li > .sub-menu > li {
  position:relative;
  margin:0;
  list-style:none;
  border-bottom:1px solid #eef1f5;
}
.menu--primary > li > .sub-menu > li:last-child {
  border-bottom:0;
}
.menu--primary > li > .sub-menu > li > a {
  display:block;
  padding:10px 20px;
  font-weight:600;
  font-size:15px;
  font-family:'Poppins', sans-serif;
  color:#0c1524;
  text-decoration:none;
  line-height:1.35;
}
.menu--primary > li > .sub-menu > li > a:hover {
  color:#082b61;
  background:#f7f9fc;
}

/* L2 com filhos = título de grupo */
.menu--primary > li > .sub-menu > li.menu-item-has-children > a {
  padding:12px 20px 6px;
  font-weight:800;
  font-size:14px;
  letter-spacing:.02em;
  text-transform:none;
  color:#082b61;
  background:transparent;
  pointer-events:auto;
  cursor:default;
}
.menu--primary > li > .sub-menu > li.menu-item-has-children > a:hover {
  background:transparent;
  color:#082b61;
}
.menu--primary > li > .sub-menu > li.menu-item-has-children > a::after {
  content:none;
}

/* L3 — sempre visível, hierarquia mais leve */
.menu--primary > li > .sub-menu .sub-menu {
  list-style:none;
  position:static !important;
  display:block !important;
  opacity:1 !important;
  transform:none !important;
  visibility:visible !important;
  background:transparent;
  box-shadow:none;
  border-radius:0;
  min-width:0;
  max-width:none;
  padding:0 0 10px;
  margin:0;
}
.menu--primary > li > .sub-menu .sub-menu > li {
  border-bottom:0;
  list-style:none;
}
.menu--primary > li > .sub-menu .sub-menu > li > a {
  display:block;
  padding:6px 20px 6px 28px;
  font-weight:400;
  font-size:14px;
  font-family:'Poppins', sans-serif;
  color:#5E5E5E;
  text-decoration:none;
  line-height:1.4;
  max-width:88% !important;
}
.menu--primary > li > .sub-menu .sub-menu > li > a:hover {
  color:#082b61;
  background:transparent !important;
}

/* ====== MOBILE TOGGLE ====== */
.menu-toggle {
  background:transparent;
  border:0;
  width:44px;
  height:44px;
  display:none;
  color:#fff;
  cursor:pointer;
  position:static;
  z-index:10001;
  margin-left:auto;
  padding:0;
  flex-shrink:0;
  align-items:center;
  justify-content:center;
}
.menu-toggle .hamburger {
  position:relative;
  display:block;
  width:22px;
  height:2px;
  background:#fff;
  margin:0 auto;
  transition:.2s;
}
.menu-toggle .hamburger::before,
.menu-toggle .hamburger::after {
  content:"";
  position:absolute;
  left:0;
  width:22px;
  height:2px;
  background:#fff;
  transition:.2s;
}
.menu-toggle .hamburger::before { top:-7px; }
.menu-toggle .hamburger::after { top:7px; }
.menu-toggle[aria-expanded="true"] .hamburger { background:transparent; }
.menu-toggle[aria-expanded="true"] .hamburger::before {
  top:0;
  transform:rotate(45deg);
}
.menu-toggle[aria-expanded="true"] .hamburger::after {
  top:0;
  transform:rotate(-45deg);
}

/* ====== MOBILE OFF-CANVAS ====== */
.mobile-overlay {
  position:fixed;
  inset:0;
  width:100%;
  height:100%;
  background:rgba(0,0,0,.5);
  z-index:9998;
  opacity:0;
  visibility:hidden;
  transition:opacity .3s ease, visibility .3s ease;
  pointer-events:none;
}
.mobile-overlay.is-active {
  opacity:1;
  visibility:visible;
  pointer-events:auto;
}

.mobile-sidebar {
  position:fixed;
  top:0;
  left:0;
  width:min(320px, 88vw);
  height:100%;
  background:#fff;
  z-index:9999;
  overflow-y:auto;
  -webkit-overflow-scrolling:touch;
  transform:translateX(-105%);
  transition:transform .3s ease;
  box-shadow:2px 0 16px rgba(0,0,0,.12);
  display:flex;
  flex-direction:column;
}
.mobile-sidebar.is-open {
  transform:translateX(0);
}

.sidebar-header {
  padding:16px 20px;
  background:#082b61;
  color:#fff;
  display:flex;
  justify-content:space-between;
  align-items:center;
  flex-shrink:0;
}
.sidebar-title {
  font-weight:700;
  font-size:1.05rem;
  margin:0;
  font-family:'Poppins', sans-serif;
}
.close-sidebar {
  background:transparent;
  border:none;
  color:#fff;
  font-size:1.75rem;
  cursor:pointer;
  padding:4px 8px;
  line-height:1;
}

.sidebar-lang {
  padding:12px 16px;
  border-bottom:1px solid #eef1f5;
  flex-shrink:0;
}
.sidebar-lang .lang-switcher ul {
  list-style:none;
  margin:0;
  padding:0;
  display:flex;
  flex-wrap:wrap;
  gap:6px;
}
.sidebar-lang .lang-switcher a {
  display:inline-block;
  padding:6px 10px;
  border-radius:6px;
  font-size:.8rem;
  color:#082b61;
  text-decoration:none;
  background:#f0f4f8;
}
.sidebar-lang .lang-switcher .current-lang a {
  background:#082b61;
  color:#fff;
  font-weight:600;
}

.sidebar-navigation {
  flex:1 1 auto;
}

.sidebar-menu {
  list-style:none;
  margin:0;
  padding:0;
}
.sidebar-menu li {
  list-style:none;
  position:relative;
  border-bottom:1px solid #f0f0f0;
}
.sidebar-menu .sub-menu li {
  border-bottom:0;
}

.sidebar-menu > li > a {
  display:block;
  padding:14px 48px 14px 20px;
  color:#1a1a1a;
  text-decoration:none;
  font-weight:700;
  font-size:15px;
  font-family:'Poppins', sans-serif;
  line-height:1.3;
}
.sidebar-menu > li > a:hover {
  background:#f8f9fa;
  color:#082b61;
}

.sidebar-submenu-toggle {
  position:absolute;
  right:8px;
  top:8px;
  width:36px;
  height:36px;
  display:flex;
  align-items:center;
  justify-content:center;
  background:transparent;
  border:none;
  color:#666;
  font-size:1.25rem;
  cursor:pointer;
  line-height:1;
  z-index:2;
}
.sidebar-submenu-toggle:hover { color:#082b61; }

.sidebar-menu .sub-menu {
  list-style:none;
  margin:0;
  padding:0;
  background:#f8f9fa;
  display:none;
}
.sidebar-menu .submenu-open > .sub-menu {
  display:block;
}

/* L2 no drawer */
.sidebar-menu .sub-menu > li > a {
  display:block;
  padding:12px 48px 12px 28px;
  color:#333;
  font-weight:600;
  font-size:.95rem;
  text-decoration:none;
  font-family:'Poppins', sans-serif;
}
.sidebar-menu .sub-menu > li.menu-item-has-children > a {
  font-weight:700;
  color:#082b61;
  padding-bottom:6px;
}
.sidebar-menu .sub-menu > li > a:hover {
  background:#e9ecef;
  color:#082b61;
}

/* L3 no drawer */
.sidebar-menu .sub-menu .sub-menu {
  background:#eef1f5;
}
.sidebar-menu .sub-menu .sub-menu > li > a {
  padding:10px 20px 10px 44px;
  font-weight:400;
  color:#5E5E5E;
  font-size:.9rem;
}
.sidebar-menu .sub-menu .sub-menu > li > a:hover {
  background:#dee2e6;
  color:#082b61;
}

.sidebar-menu li.menu-item-has-children.submenu-open > .sidebar-submenu-toggle {
  top:8px;
}

body.sidebar-open {
  overflow:hidden;
}

@media (max-width:992px) {
  .menu-toggle { display:flex; margin-left:auto; }
  #site-navigation {
    width:0 !important;
    height:0;
    overflow:hidden;
    flex:0 0 0;
    margin:0;
    padding:0;
  }
  #site-navigation .menu--primary,
  .navwrap .menu--primary {
    display:none !important;
  }
  .navwrap__inner {
    min-height:56px;
    height:auto;
    padding:0 20px;
    align-items:center;
    justify-content:flex-end;
  }
}

@media (min-width:993px) {
  .mobile-overlay,
  .mobile-sidebar {
    display:none !important;
  }
}

/* ====== POLYLANG / TOPBAR / BRAND ====== */
.lang-switcher {
  display:flex;
}
.lang-switcher ul {
  list-style:none;
  margin:0;
  padding:0;
  display:flex;
  gap:8px;
}
.lang-switcher li {
  margin:0;
  list-style:none;
}
.lang-switcher a {
  color:#666;
  text-decoration:none;
  padding:4px 8px;
  border-radius:4px;
  font-size:0.875rem;
  transition:all 0.2s ease;
}
.lang-switcher a:hover,
.lang-switcher .current-lang a {
  background:#f0f0f0;
  color:#082b61;
}
.lang-switcher .current-lang a {
  font-weight:600;
}

.topbar {
  background:#fff !important;
  border:none !important;
  font-size:0.875rem;
}
.topbar__inner {
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:8px 0;
}
.topbar__left .top-links {
  display:flex;
  gap:16px;
}
.topbar__left .top-links a {
  color:#666;
  text-decoration:none;
  padding:2px 0;
}
.topbar__left .top-links a:hover {
  color:#082b61;
  text-decoration:underline;
}
.topbar__right {
  display:flex;
  align-items:center;
  gap:20px;
}

.brandbar {
  background:white;
  border-bottom:1px solid #e9ecef;
  padding:16px 0;
}
.brandbar__inner {
  display:flex;
  align-items:center;
  justify-content:space-between;
}
.brand-left {
  display:flex;
  align-items:center;
  gap:20px;
}
.logo-bvs img,
.logo-lilacs img,
.custom-logo-link img {
  max-height:150px;
  width:auto;
}
.logo-lilacs.lang-pt img,
.logo-lilacs.lang-en img,
.logo-lilacs.lang-es img {
  max-height:76px;
  width:auto;
  object-fit:contain;
}
.logo-rede img {
  max-height:76px;
  width:auto;
  object-fit:contain;
}
.brand-right {
  display:block !important;
  flex:0 0 auto !important;
}

@media (max-width:768px) {
  .brandbar__inner {
    flex-direction:column-reverse;
    gap:12px;
  }
  .logo-bvs img,
  .logo-lilacs img,
  .custom-logo-link img,
  .logo-lilacs.lang-pt img,
  .logo-lilacs.lang-en img,
  .logo-lilacs.lang-es img,
  .logo-rede img {
    max-height:50px;
  }
}

/* ====== BREADCRUMB GLOBAL ====== */
.lilacs-site-breadcrumb {
  background:#fff;
  border-bottom:1px solid rgba(15,23,42,.10);
}
.lilacs-site-breadcrumb__inner {
  max-width:1230px;
  margin:0 auto;
  padding:10px 20px;
}
.lilacs-site-breadcrumb__nav {
  display:flex;
  align-items:center;
  flex-wrap:wrap;
  gap:4px 0;
  font-family:"Noto Sans", system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
  font-size:14px;
  line-height:1.4;
}
.lilacs-site-breadcrumb__nav a,
.lilacs-site-breadcrumb__nav span {
  color:#1d4ed8;
  text-decoration:none;
  font-weight:500;
}
.lilacs-site-breadcrumb__nav a:hover {
  text-decoration:underline;
}
.lilacs-site-breadcrumb__nav .sep {
  color:#1d4ed8;
  opacity:.85;
  margin:0 4px;
}
.lilacs-site-breadcrumb__nav .current {
  color:#334155;
  font-weight:600;
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

        $rede_logo = bireme_rede_get_logo();
        $rede_url  = bireme_rede_get_url();
        $bvs_logo  = bireme_bvs_get_logo();
        ?>
        <?php if ( $bvs_logo ) : ?>
          <a class="logo-bvs lang-<?php echo esc_attr( $current_lang_slug ); ?>" href="<?php echo esc_url( $rede_url ); ?>">
            <img src="<?php echo esc_attr( $bvs_logo ); ?>" alt="BVS Biblioteca Virtual" />
          </a>
        <?php endif; ?>

        <?php
        $lilacs_logo = bireme_lilacs_get_logo();
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
          <a class="logo-lilacs lang-<?php echo esc_attr($current_lang_slug); ?>" href="<?php echo esc_url( $home_lang_url ); ?>">
            <img src="<?php echo esc_attr($lilacs_logo); ?>" alt="<?php echo esc_attr($site_name); ?>" />
          </a>
        <?php endif; ?>
      </div>

      <div class="brand-center"></div>

      <div class="brand-right">
        <div class="topbar">
          <div class="container topbar__inner">
            <div class="topbar__right">
              <div class="lang-switcher" aria-label="Idiomas">
                <?php
                if (function_exists('pll_the_languages')) {
                  pll_the_languages(array(
                    'show_flags' => 0,
                    'show_names' => 1,
                    'display_names_as' => 'name'
                  ));
                } else {
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
      <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Menu principal">
        <?php
        $menu_location = bireme_lilacs_get_menu_location();

        wp_nav_menu([
          'theme_location' => $menu_location,
          'container'      => false,
          'menu_class'     => 'menu menu--primary',
          'menu_id'        => 'primary-menu',
          'fallback_cb'    => 'wp_page_menu',
          'depth'          => 3,
        ]);
        ?>
      </nav>

      <button
        class="menu-toggle"
        type="button"
        aria-controls="mobile-sidebar"
        aria-expanded="false"
        aria-label="<?php echo esc_attr( bireme_lilacs_translate('Abrir menu', 'Navigation') ); ?>"
      >
        <span class="hamburger"></span>
      </button>
    </div>
  </div>
</header>

<!-- MOBILE OFF-CANVAS -->
<div class="mobile-overlay" aria-hidden="true"></div>
<div
  class="mobile-sidebar"
  id="mobile-sidebar"
  role="dialog"
  aria-modal="true"
  aria-label="<?php echo esc_attr( bireme_lilacs_translate('Menu', 'Navigation') ); ?>"
  aria-hidden="true"
>
  <div class="sidebar-header">
    <h3 class="sidebar-title"><?php echo bireme_lilacs_translate('Menu', 'Navigation'); ?></h3>
    <button type="button" class="close-sidebar" aria-label="<?php echo esc_attr( bireme_lilacs_translate('Fechar menu', 'Navigation') ); ?>">×</button>
  </div>

  <div class="sidebar-lang">
    <div class="lang-switcher" aria-label="Idiomas">
      <?php
      if (function_exists('pll_the_languages')) {
        pll_the_languages(array(
          'show_flags' => 0,
          'show_names' => 1,
          'display_names_as' => 'name'
        ));
      }
      ?>
    </div>
  </div>

  <nav class="sidebar-navigation" aria-label="<?php echo esc_attr( bireme_lilacs_translate('Menu', 'Navigation') ); ?>">
    <?php
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

<?php
if ( function_exists( 'bireme_render_site_breadcrumb' ) ) {
  bireme_render_site_breadcrumb();
}
?>

<div id="site-content" class="site-content">
